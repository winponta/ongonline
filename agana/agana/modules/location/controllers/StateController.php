<?php

/**
 * State controller from Location module of Agana fwk
 */
class Location_StateController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Location_Domain_State());
        $this->setViewVarName('state');
        $this->setViewVarListName('states');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Location_Form_State');
        $this->setFormDName('Location_Form_StateDelete');
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

