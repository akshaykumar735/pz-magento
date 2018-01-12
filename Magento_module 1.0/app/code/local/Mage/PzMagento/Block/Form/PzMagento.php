<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission.

Magento version 1.9.0.1                 PzMagento Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
*/


class Mage_PzMagento_Block_Form_PzMagento extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
		        $this->setTemplate('PzMagento/form/PzMagento.phtml');
    }

    
    protected function _getPzMagentoConfig()
    {
        return Mage::getSingleton('PzMagento/config');
    }
	

   
	
    public function getPzMagentoServiceTypes()
    {
		 
		
         $types = $this->_getPzMagentoConfig()->getPzMagentoServiceTypes();
        if ($method = $this->getMethod()) {
            $availableTypes = $method->getConfigData('PzMagentotypes');
            if ($availableTypes) {
                $availableTypes = explode(',', $availableTypes);
                foreach ($types as $code=>$name) {
                    if (!in_array($code, $availableTypes)) {
                        unset($types[$code]);
                    }
                }
            }
        }
		
        return $types;
    }
	
    
    public function getPzMagentoMonths()
    {
        $months = $this->getData('PzMagento_months');
        if (is_null($months)) {
            $months[0] =  $this->__('Month');
            $months = array_merge($months, $this->_getPzMagentoConfig()->getMonths());
            $this->setData('PzMagento_months', $months);
        }
        return $months;
    }

   
    public function getPzMagentoYears()
    {
        $years = $this->getData('PzMagento_years');
        if (is_null($years)) {
            $years = $this->_getPzMagentoConfig()->getYears();
            $years = array(0=>$this->__('Year'))+$years;
            $this->setData('PzMagento_years', $years);
        }
        return $years;
    }

    
    public function hasVerification()
    {
        if ($this->getMethod()) {
            $configData = $this->getMethod()->getConfigData('useccv');
            if(is_null($configData)){
                return true;
            }
            return (bool) $configData;
        }
        return true;
    }
	public function getQuoteData()
    {
		return $this->getMethod()->getQuoteData();
	}
	public function getBillingAddress()
	{
		if ($this->getMethod())
		{
			$this->getMethod()->getQuote();
			$aa= $this->getMethod()->getQuote()->getBillingAddress()->getCountry();
		}
	}
}
