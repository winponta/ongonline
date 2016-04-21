<?php

/**
 * Admin controller from Role official module of Agana fwk
 */
class User_RoleController extends Zend_Controller_Action {

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
                    $this->_helper->redirector('list');
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

    private function _add($data) {
        $roleDomain = new User_Domain_Role($data);
        //$userDomain->populateUser($data);        

        try {
            return $roleDomain->add();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    private function _update($data) {
        $roleDomain = new User_Domain_Role();
        $roleDomain->populateRole($data);

        try {
            return $roleDomain->update();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    private function _delete($data) {
        $roleDomain = new User_Domain_Role();
        $roleDomain->populateUser($data);

        try {
            return $roleDomain->delete();
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
                array('error' => 'Problems saving role')
        );
        $this->_helper->flashMessenger->addMessage(
                array('error' => $e->getMessage())
        );
    }

    public function indexAction() {
        $this->_forward('list');
    }

    public function listAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USERROLE, User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_LIST)) {
            $roles = new User_Domain_Role(null);
            $this->view->roles = $roles->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
        }
    }

    /**
     * Create a new role, shows a form or ask domain to save data passed by post.
     */
    public function createAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USERROLE, User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_CREATE)) {

            $form = new User_Form_Role(User_Form_Role::ACTION_ADD);
            $request = $this->getRequest();

            if ($request->isPost()) {
                $data = $request->getPost();
                if (isset($data['save'])) {
                    if ($form->isValid($data)) {
                        try {
                            $data = $form->getValues();
                            $data['appaccount_id'] = Zend_Auth::getInstance()->getIdentity()->appaccount_id;
                            $this->_add($data);
                            $msg = 'New role created';
                            $this->_helper->flashMessenger->addMessage(
                                    array('success' => $msg)
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => 'role', 'module' => 'user'));
                        } catch (Exception $e) {
                            $this->_addSavingExceptionMessage($e);
                        }
                    } else {
                        $this->_addValidationMessage();
                    }
                } else {
                    if (isset($data['cancel'])) {
                        $this->_helper->redirector(array('action' => 'list', 'controller' => 'role', 'module' => 'user'));
                    }
                }
            }
            $this->view->form = $form;
        }
    }

    public function updateAction() {
        if ($this->_isUserAllowed()) {
            if ($this->_hasParam("id")) {

                $id = $this->_getParam("id");
                $request = $this->getRequest();

                $role = new User_Domain_Role(null);
                $role = $role->getById($id);

                $form = new User_Form_Role(User_Form_Role::ACTION_EDIT, $role);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    if (isset($data['save'])) {
                        if ($form->isValid($request->getPost())) {
                            try {
                                $this->_update($form->getValues());
                                $msg = 'Role updated';
                                $this->_helper->flashMessenger->addMessage(
                                        array('success' => $msg)
                                );
                                $this->_helper->redirector(array('action' => 'list', 'controller' => 'role', 'module' => 'user'));
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                            }
                        } else {
                            $this->_addValidationMessage();
                        }
                    } else {
                        if (isset($data['cancel'])) {
                            $lru = new Agana_Controller_Action_Helper_LastRequestUri();
                            $lru->setNamespace('acl_role');
                            $lru->redirect('user/role/list');
                            //$this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
                        }
                    }
                }

                $this->view->form = $form;
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'Param id missing'));
                $this->_forward('list');
                return;
            }
        }
    }

    public function deleteAction() {
        if ($this->_isUserAllowed()) {
            if ($this->_hasParam("id")) {

                $id = $this->_getParam("id");
                $request = $this->getRequest();

                $role = new User_Domain_Role();
                $role = $role->getById($id);

                $form = new User_Form_RoleDelete($role->id);

                if ($request->isPost()) {
                    $form->populate($_POST);
                    if ($form->confirm->isChecked()) {
                        try {
                            $this->_delete($form->getValues());
                            $msg = 'Role deleted';
                            $this->_helper->flashMessenger->addMessage(
                                    array('success' => $msg)
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => 'role', 'module' => 'user'));
                        } catch (Exception $e) {
                            $this->_helper->flashMessenger->addMessage(
                                    array('error' => 'Some problem occur when tried to delete the role')
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => 'role', 'module' => 'user'));
                        }
                    } else {
                        $this->_helper->redirector(array('action' => 'list', 'controller' => 'role', 'module' => 'user'));
                    }
                }

                $this->view->form = $form;
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'Param id missing'));
                $this->_forward('list');
                return;
            }
        }
    }

}

