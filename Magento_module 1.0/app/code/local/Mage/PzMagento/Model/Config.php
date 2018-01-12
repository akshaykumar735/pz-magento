<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission.

Magento version 1.9.0.1                 PzMagento Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
*/


class Mage_PzMagento_Model_Config
{
    protected static $_methods;

    
    public function getActiveMethods($store=null)
    {
        $methods = array();
        $config = Mage::getStoreConfig('PzMagento', $store);
        foreach ($config as $code => $methodConfig) {
            if (Mage::getStoreConfigFlag('PzMagento/'.$code.'/active', $store)) {
                $methods[$code] = $this->_getMethod($code, $methodConfig);
            }
        }
        return $methods;
    }

    
    public function getAllMethods($store=null)
    {
        $methods = array();
        $config = Mage::getStoreConfig('PzMagento', $store);
        foreach ($config as $code => $methodConfig) {
            $methods[$code] = $this->_getMethod($code, $methodConfig);
        }
        return $methods;
    }

    protected function _getMethod($code, $config, $store=null)
    {
        if (isset(self::$_methods[$code])) {
            return self::$_methods[$code];
        }
        $modelName = $config['model'];
        $method = Mage::getModel($modelName);
        $method->setId($code)->setStore($store);
        self::$_methods[$code] = $method;
        return self::$_methods[$code];
    }

	 
   
    public function getMonths()
    {
        $data = Mage::app()->getLocale()->getTranslationList('month');
        foreach ($data as $key => $value) {
            $monthNum = ($key < 10) ? '0'.$key : $key;
            $data[$key] = $monthNum . ' - ' . $value;
        }
        return $data;
    }

   
    public function getYears()
    {
        $years = array();
        $first = date("Y");

        for ($index=0; $index <= 10; $index++) {
            $year = $first + $index;
            $years[$year] = $year;
        }
        return $years;
    }

    
    static function comparePzMagentoTypes($a, $b)
    {
        if (!isset($a['order'])) {
            $a['order'] = 0;
        }

        if (!isset($b['order'])) {
            $b['order'] = 0;
        }

        if ($a['order'] == $b['order']) {
            return 0;
        } else if ($a['order'] > $b['order']) {
            return 1;
        } else {
            return -1;
        }

    }
	public function getPzMagentoServerUrl()
	{   if(Mage::getStoreConfig('payment/PzMagento/test')){
		
		$url=Mage::getStoreConfig('payment/PzMagento/testurl');
		return $url;
	} else
	    
		 $urllive = Mage::getStoreConfig('payment/PzMagento/liveurl');
		
         return $urllive;
	}
	
	public function getPzMagentoRedirecturl()
	{
		  $url= Mage::getUrl('PzMagento/PzMagento/success',array('_secure' => true));
	
		 return $url;
	}
}
		
 