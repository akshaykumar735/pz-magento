<?php
/**
*************************************************************************************
 Please Do not edit or add any code in this file without permission.

Magento version 1.9.0.1                 PzMagento Version 1.0
                              
Module Version. pz-1.0                 Module release: May 2017
**************************************************************************************
*/


class Mage_PzMagento_Model_Session extends Mage_Core_Model_Session_Abstract
{
    public function __construct()
    {
        $this->init('PzMagento');
    }
}