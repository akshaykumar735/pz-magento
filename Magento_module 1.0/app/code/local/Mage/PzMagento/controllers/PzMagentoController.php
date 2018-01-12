<?php

/**
 * ************************************************************************************
  Please Do not edit or add any code in this file without permission.

  Magento version 1.9.0.1                 PzMagento Version 1.0

  Module Version. pz-1.0                 Module release: May 2017
 * *************************************************************************************
 */

class Mage_PzMagento_PzMagentoController extends Mage_Core_Controller_Front_Action {

    protected $_order;

    public function getOrder() {
        if ($this->_order == null) {
            
        }
        return $this->_order;
    }

    protected function _expireAjax() {
        if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1', '403 Session Expired');
            exit;
        }
    }

    public function getStandard() {
        return Mage::getSingleton('PzMagento/standard');
    }

    public function redirectAction() {

        $session = Mage::getSingleton('checkout/session');
        $session->setPzMagentoStandardQuoteId($session->getQuoteId());
        $order = Mage::getModel('sales/order');
        $order->load(Mage::getSingleton('checkout/session')->getLastOrderId());
        $order->sendNewOrderEmail();
        $order->save();

        $this->getResponse()->setBody($this->getLayout()->createBlock('PzMagento/form_redirect')->toHtml());
        $session->unsQuoteId();
    }

    public function cancelAction() {
        $session = Mage::getSingleton('checkout/session');
        $session->setQuoteId($session->getPzMagentoStandardQuoteId(true));


        if ($session->getLastRealOrderId()) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
            if ($order->getId()) {
                $order->cancel()->save();
            }
        }


        Mage::getSingleton('checkout/session')->addError("Payment has been cancelled and the transaction has been declined.");
        $this->_redirect('checkout/cart');
    }

    public function successAction() {
        $status = true;
        $authDesc = "N";

        if (!$this->getRequest()->isPost()) {
            $this->cancelAction();
            return false;
        }

        $response = $this->getRequest()->getPost();
        if (empty($response)) {
            $status = false;
        }

        
        if (isset($response["amount"]))
            $amount = $response["amount"];
        if (isset($response["desc"]))
            $order_Id = $response["desc"];
        if (isset($response["newchecksum"]))
            $checksum = $response["newchecksum"];
        if (isset($response["status"]))
            $authDesc = $response["status"];

        $order = Mage::getModel('sales/order')->loadByIncrementId($order_Id);
        if (!$order) {
            return;
        }

        if ($authDesc == "Y") {
            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Payment Success.');
            $order->save();
        } else if ($authDesc == "N") {
            $this->getCheckout()->setPzMagentoErrorMessage('Payment Failed');
            $this->cancelAction();
            return false;
        }

        $f_passed_status = Mage::getStoreConfig('payment/PzMagento/payment_success_status');
        $message = Mage::helper('PzMagento')->__('Your payment is authorized.');

        $payment_confirmation_mail = Mage::getStoreConfig('payment/PzMagento/payment_confirmation_mail');
        if ($payment_confirmation_mail == "1") {
            $order->sendOrderUpdateEmail(true, 'Your payment is authorized.');
        }

        $order->save();
        $session = Mage::getSingleton('checkout/session');
        $session->addError("Thank you for shopping with us. Your account has been charged and your transaction is successful. We will be shipping your order to you soon.");
        $session->setQuoteId($session->getPzMagentoStandardQuoteId(true));

        Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();
        $this->_redirect('checkout/onepage/success', array('_secure' => true));
        
       
        
    }

    public function errorAction() {
        $this->_redirect('checkout/onepage/');
    }

    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

}
