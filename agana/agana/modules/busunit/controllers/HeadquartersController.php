<?php

/**
 * Headquarters admin controller from Busunit module of Agana fwk
 */
class Busunit_HeadquartersController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Busunit_Domain_Headquarters());
        $this->setViewVarName('headquarters');
        $this->setFormCRUName('Busunit_Form_Headquarters');
    }

    public function getAction() {
        try {
            $head = new Busunit_Model_Headquarters();

            $user = Zend_Auth::getInstance()->getIdentity();

            $domain = new Busunit_Domain_Headquarters();
            $head = $domain->getByAppAccount($user->appaccount_id);

            // if there is no organization for this appaccount, create the only one allowed
            // TODO move this logic to domain class
            if (is_null($head)) {
                $translate = Zend_Registry::get('Zend_Translate');

                $head = new Busunit_Model_Headquarters();
                $head->setName($translate->_('Default value - please change it'));
                $head->setAppaccount_id($user->appaccount_id);
                $domain->setBusunit($head);

                $head = $domain->create($user->appaccount_id);
                $head = $domain->getById($head);
            }
        } catch (Exception $exc) {
            $this->_helper->flashMessenger->addMessage(
                    array('error' => $exc->getMessage()));
        }

        $this->view->headquarters = $head;
    }

    public function createAction() {
        $this->_forward('get');
    }

    public function deleteAction() {
        $this->_forward('get');
    }

    public function listAction() {
        $this->_forward('get');
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

