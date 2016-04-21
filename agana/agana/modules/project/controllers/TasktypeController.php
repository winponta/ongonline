<?php

/**
 * Task type controller from Project module of Agana fwk
 */
class Project_TasktypeController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Project_Domain_Tasktype());
        $this->setViewVarName('tasktype');
        $this->setViewVarListName('tasktypes');
        $this->setViewListOrderBy(array('parent_id', 'name'));
        $this->setFormCRUName('Project_Form_Tasktype');
        $this->setFormDName('Project_Form_TasktypeDelete');
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

