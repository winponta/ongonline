<?php

/**
 * Audit trail controller from Agana core module
 */
class Aganacore_AudittrailController extends Agana_Controller_Action {

    /**
     * Disable layout if request is made by XmlHttpRequest 
     */
    public function init() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    public function indexAction() {
        $this->_forward('searchForm');
    }

    public function searchAction() {
        
    }

    public function searchFormAction() {
        $this->view->form = new Persons_Form_PersonSearch();
    }

    protected function _isUserAllowed() {
        
    }

}