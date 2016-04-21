<?php

/**
 * Organization admion controller from Organizaton module of Agana fwk
 */
class Organization_OrganizationController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Organization_Domain_Organization());
        $this->setViewVarName('organization');
        $this->setFormCRUName('Organization_Form_Organization');
    }

    public function getAction() {
        $user = Zend_Auth::getInstance()->getIdentity();

        $domain = new Organization_Domain_Organization();
        $org = $domain->getByAppAccount($user->appaccount_id);

        // if there is no organization for this appaccount, create the only one allowed
        if (is_null($org)) {
            $translate = Zend_Registry::get('Zend_Translate');

            $org = new Organization_Model_Organization();
            $org->setName($translate->_('Default value'));
            $org->setAppaccount_id($user->appaccount_id);
            $domain->setBusunit($org);

            try {
                $org = $domain->create($user->appaccount_id);
                $org = $domain->getById($org);
            } catch (Exception $exc) {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => $exc->getMessage()));
            }
        }
        $this->view->organization = $org;
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

    protected function _isUserAllowed() {
        return Organization_Domain_Organization::isAllowed(null,null,null);
    }

}

