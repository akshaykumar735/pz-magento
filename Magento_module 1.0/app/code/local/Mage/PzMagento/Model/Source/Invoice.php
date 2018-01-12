<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission.

Magento version 1.9.0.1                 PzMagento Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
*/


class Mage_PzMagento_Model_Source_Invoice
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mage_PzMagento_Model_Method_Abstract::ACTION_AUTHORIZE_CAPTURE,
                'label' => Mage::helper('core')->__('Yes')
            ),
            array(
                'value' => '',
                'label' => Mage::helper('core')->__('No')
            ),
        );
    }
}
