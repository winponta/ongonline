<?php

/**
 * Country controller from Location module of Agana fwk
 */
class Location_CountryController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Location_Domain_Country());
        $this->setViewVarName('country');
        $this->setViewVarListName('countries');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Location_Form_Country');
        $this->setFormDName('Location_Form_CountryDelete');
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

