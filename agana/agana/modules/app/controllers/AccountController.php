<?php

/**
 * Admin controller from App module of Agana fwk
 */
class App_AccountController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new App_Domain_Account());
        $this->setViewVarName('account');
        $this->setViewVarListName('accounts');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('App_Form_Account');
        $this->setFormDName('App_Form_AccountDelete');
        $this->setRedirectActionAfterUpdateSuccess('show');
        $this->setRedirectActionAfterUpdateCancel('show');
    }

    public function indexAction() {
        $this->_forward('show');
    }

    public function updateAction() {
        if ($this->_isUserAllowed(App_Module_Acl::ACL_RESOURCE_APPACCOUNT, App_Module_Acl::ACL_RESOURCE_APPACCOUNT_PRIVILEGE_UPDATE)) {
            $this->setRedirectActionAfterUpdateSuccess('show');
            $this->setRedirectActionAfterUpdateCancel('show');
            parent::updateAction();
        }
    }

    public function showAction() {
        if ($this->_isUserAllowed(App_Module_Acl::ACL_RESOURCE_APPACCOUNT, App_Module_Acl::ACL_RESOURCE_APPACCOUNT_PRIVILEGE_VIEW)) {
            $account = new App_Model_Account();

            if ($this->_hasParam('id')) {
                $id = $this->_getParam('id');

                if (!$id) {
                    $id = Zend_Auth::getInstance()->getIdentity()->appaccount_id;
                }
            } else {
                $id = Zend_Auth::getInstance()->getIdentity()->appaccount_id;
            }

            $domain = new App_Domain_Account();
            $account = $domain->getById($id);

            $this->view->account = $account;
        }
    }

    protected function _isUserAllowed($resource, $privilege) {
        if (parent::_isUserAllowed($resource, $privilege)) {
            return true;
        } else {
            $this->_helper->flashMessenger->addMessage(
                    array('warning' => 'You don\'t have permission to access this')
            );
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper("redirector");
            $redirector->gotoUrl("/");
        }
    }

}

