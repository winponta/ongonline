<?php

/**
 * Expertise area controller from Staff module of Agana fwk
 */
class Staff_ExpertiseareaController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Staff_Domain_Expertisearea());
        $this->setViewVarName('expertise');
        $this->setViewVarListName('expertises');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Staff_Form_Expertisearea');
        $this->setFormDName('Staff_Form_ExpertiseareaDelete');
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

