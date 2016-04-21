<?php

/**
 * Job function controller from Staff module of Agana fwk
 */
class Staff_JobfunctionController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Staff_Domain_Jobfunction());
        $this->setViewVarName('function');
        $this->setViewVarListName('functions');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Staff_Form_Jobfunction');
        $this->setFormDName('Staff_Form_JobfunctionDelete');
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

