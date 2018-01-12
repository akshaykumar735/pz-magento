<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission.


Magento version 1.9.0.1                 PzMagento Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
*/



class Mage_PzMagento_Block_Info_PzMagento extends Mage_Payment_Block_Info
{
    
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('PzMagento/info/PzMagento.phtml');
    }

    
    public function getPzMagentoTypeName()
    {
        $types = Mage::getSingleton('PzMagento/config')->getPzMagentoTypes();
        if (isset($types[$this->getInfo()->getPzMagentoType()])) {
            return $types[$this->getInfo()->getPzMagentoType()];
        }
        return $this->getInfo()->getPzMagentoType();
    }

   
}
 ?>