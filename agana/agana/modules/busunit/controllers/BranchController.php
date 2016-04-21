<?php

/**
 * Branch admin controller from Busunit module of Agana fwk
 */
class Busunit_BranchController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Busunit_Domain_Branch());
        $this->setViewVarName('branch');
        $this->setViewVarListName('branches');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Busunit_Form_Branch');
        $this->setFormDName('Busunit_Form_BranchDelete');
    }

    public function getAction() {
        
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

