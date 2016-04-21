<?php

/**
 * City controller from Location module of Agana fwk
 */
class Location_CityController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Location_Domain_City());
        $this->setViewVarName('city');
        $this->setViewVarListName('cities');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Location_Form_City');
        $this->setFormDName('Location_Form_CityDelete');
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

