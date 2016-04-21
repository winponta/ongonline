<?php

/**
 * City Region controller from Location module of Agana fwk
 */
class Location_CityRegionController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Location_Domain_CityRegion());
        $this->setViewVarName('region');
        $this->setViewVarListName('regions');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Location_Form_CityRegion');
        $this->setFormDName('Location_Form_CityRegionDelete');
    }
    
    protected function _isUserAllowed($resource, $privilege) {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        } else {
            $this->_redirectLogin();
            return false;
        }
    }


}

