<?php

/**
 * Role permission controller from User official module of Agana fwk
 */
class User_RolePermissionController extends Zend_Controller_Action {

    public function init() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    private function _isUserAllowed($resource, $privilege) {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            if (! Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, $resource, $privilege)) {
                Agana_Acl_Service::addNoPermissionFlashMessage();
                
                if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, 
                        User_Module_Acl::ACL_RESOURCE_USERROLE, 
                        User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_LIST)) {
                    $this->_helper->redirector('list', 'role');
                } else {
                    $this->_helper->redirector('index', 'index', 'aganacore');
                }
                return false;
            } else {
                return true;
            }
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    private function _redirectLogin($msg = 'You do not have permission to access this') {
        $this->_helper->flashMessenger->addMessage(array('warning' => $msg));
        $login = new Agana_Auth_Helper_Login();
        $login->redirectToLoginForm();
    }

    private function _update($data) {
        try {
            $roleDomain = new User_Domain_Role();
            $role = $roleDomain->getById($data['id']);

            $permissions = array();

            foreach ($data['resource'] as $resource => $privilege) {
                foreach ($privilege as $priv) {

                    $permModel = new \User_Model_RolePermission();
                    $permModel->setResource($resource);
                    $permModel->setPrivilege($priv);

                    $permissions[] = $permModel;
                }
            }

            $role->setPermissions($permissions);
            $roleDomain->setRole($role);
            
            return $roleDomain->updatePermissions();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    private function _addValidationMessage() {
        $this->_helper->flashMessenger->addMessage(
                array('validation' => 'Some problem with fields content.'));
    }

    private function _addSavingExceptionMessage($e) {
        $this->_helper->flashMessenger->addMessage(
                array('error' => 'Problems saving role permissions')
        );
        $this->_helper->flashMessenger->addMessage(
                array('error' => $e->getMessage())
        );
    }

    public function indexAction() {
        $this->_forward('list');
    }

    public function listAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USERROLE, User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_CREATE)) {
            if ($this->_hasParam('id')) {
                $roleDomain = new User_Domain_Role(null);
                $role = $roleDomain->getById($this->_getParam('id'));

                if ($role) {
                    $this->view->role = $role;
                    $this->view->modulesResources = Agana_Acl_Service::getResources();
                } else {
                    $this->_helper->flashMessenger->addMessage(
                            array('error' => 'Could not found any role with this id'));
                    return;
                }
                //$this->view->roles = $roleDomain->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'Param id missing'));
                return;
            }
        }
    }

    public function updateAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USERROLE, User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_CREATE)) {
            if ($this->_hasParam("id")) {

                $id = $this->_getParam("id");
                $request = $this->getRequest();

                $role = new User_Domain_Role(null);
                $role = $role->getById($id);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $data['id'] = $id;
                    if (isset($data['save'])) {
                        try {
                            $this->_update($data);
                            $msg = 'Role permissions updated';
                            $this->_helper->flashMessenger->addMessage(
                                    array('success' => $msg)
                            );
                        } catch (Exception $e) {
                            $this->_addSavingExceptionMessage($e);
                            $this->_forward('list');
                            return;
                        }
                    }
                }
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'Param id missing'));
            }
        }
        $this->_helper->redirector('list', 'role', 'user');
    }

}

