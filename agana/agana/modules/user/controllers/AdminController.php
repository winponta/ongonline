<?php

/**
 * Admin controller from User official module of Agana fwk
 */
class User_AdminController extends Zend_Controller_Action {

    public function init() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    private function _isUserAllowed($resource, $privilege) {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            if (!Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, $resource, $privilege)) {
                Agana_Acl_Service::addNoPermissionFlashMessage();

                if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_LIST)) {
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
        $userDomain = new User_Domain_User($data);
        //$userDomain->populateUser($data);        

        try {
            return $userDomain->add();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    private function _update($data) {
        $userDomain = new User_Domain_User();
        $userDomain->populateUser($data);

        try {
            return $userDomain->update();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    private function _updatePassword($data) {
        $userDomain = new User_Domain_User();
        $userDomain->populateUser($data);

        try {
            return $userDomain->updatePwd();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    private function _delete($data) {
        $userDomain = new User_Domain_User();
        $userDomain->populateUser($data);

        try {
            return $userDomain->delete();
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
                array('error' => 'Problems saving user')
        );
        $this->_helper->flashMessenger->addMessage(
                array('error' => $e->getMessage())
        );
    }

    public function indexAction() {
        $this->_forward('list');
    }

    public function listAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_LIST)) {
            $show = strtolower($this->_getParam('show'));
            if (!$show) {
                $show = User_Domain_User::STATUS_ACTIVE;
            } else if ($show == 'active') {
                $show = User_Domain_User::STATUS_ACTIVE;
            } else if ($show == 'inactive') {
                $show = User_Domain_User::STATUS_INACTIVE;
            } else if ($show == 'blocked') {
                $show = User_Domain_User::STATUS_BLOCKED;
            }
            $users = new User_Domain_User(null);
            $this->view->users = $users->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, $show);
            $this->view->listing = $show;
        }
    }

    public function createForPersonAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_CREATE)) {
            if ($this->_hasParam('id')) {
                try {
                    $ud = new User_Domain_User();
                    $userid = $ud->createForPerson($this->_getParam('id'));
//                    
//                    $lastUri = new Agana_Controller_Action_Helper_LastRequestUri();
//                    $lastUri->setNamespace('user.update');
//                    
//                    $url = new Zend_View_Helper_Url();
//                    
//                    $lastUri->save($url->url(array(
//                        'action'        => 'index',
//                        'controller'    => 'profile',
//                        'module'        => 'user',
//                        'id'            => $userid,
//                    ), 'default', true));
//                    
                    $this->_helper->redirector('update', 'admin', 'user', array('id' => $userid));
                } catch (Exception $e) {
                    throw $e;
                }
            } else {
                $this->_addSavingExceptionMessage('No id parameter passed');
            }
        }
    }

    /**
     * Create a new user, shows a form or ask domain to save data passed by post.
     */
    public function createAction() {
        $this->_forward('add');
    }

    public function addAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_CREATE)) {

            $form = new User_Form_User(User_Form_User::ACTION_ADD);
            $request = $this->getRequest();

            if ($request->isPost()) {
                $data = $request->getPost();
                if (isset($data['save'])) {
                    if ($form->isValid($data)) {
                        try {
                            $data = $form->getValues();
                            $data['appaccount_id'] = Zend_Auth::getInstance()->getIdentity()->appaccount_id;
                            $this->_add($data);
                            $msg = 'New user created';
                            $this->_helper->flashMessenger->addMessage(
                                    array('success' => $msg)
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
                        } catch (Exception $e) {
                            $this->_addSavingExceptionMessage($e);
                        }
                    } else {
                        $this->_addValidationMessage();
                    }
                } else {
                    if (isset($data['cancel'])) {
                        $this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
                    }
                }
            }
            $this->view->form = $form;
        }
    }

    public function updateAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        if ($this->_hasParam("id")) {
            $id = $this->_getParam("id");

            //$update = $this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_UPDATE);
            $update = Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
                    User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_UPDATE);
            
            $isMe = $id == Zend_Auth::getInstance()->getIdentity()->id;

            if ($update || $isMe) {
                $request = $this->getRequest();

                $userDomain = new User_Domain_User(null);
                $user = $userDomain->getById($id);

                $form = new User_Form_User(User_Form_User::ACTION_EDIT, $user);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    if (isset($data['save'])) {
                        if ($form->isValid($data)) {
                            try {
                                /**
                                 * Before save test if the user has permission to change
                                 * GROUP and STATUS
                                 * It only can update this fields if has update privilege
                                 * not only being the profile owner
                                 * We do not want that the users change it's own group
                                 * to another one like Administrator
                                 */
                                if (! $update) {
                                    $data['acl_role_id'] = $user->getAcl_role_id();
                                    $data['status'] = $user->getStatus();
                                }
                                
                                $this->_update($data);
                                $msg = 'User updated';
                                $this->_helper->flashMessenger->addMessage(
                                        array('success' => $msg)
                                );
                                $this->_helper->redirector('index', 'profile', 'user', 
                                    array('id' => $id)
                                );
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                            }
                        } else {
                            $this->_addValidationMessage();
                        }
                    } else {
                        if (isset($data['cancel'])) {
                            $lru = new Agana_Controller_Action_Helper_LastRequestUri();
                            $lru->setNamespace('edituserprofile');
                            $lru->redirect('user/admin/list');
                            //$this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
                        }
                    }
                }

                $this->view->form = $form;
            }
        } else {
            $this->_helper->flashMessenger->addMessage(
                    array('error' => 'Param id missing'));
            $this->_forward('list');
            return;
        }
    }

    public function deleteAction() {
        if ($this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_DELETE)) {
            if ($this->_hasParam("id")) {

                $id = $this->_getParam("id");
                $request = $this->getRequest();

                $user = new User_Domain_User();
                $user = $user->getById($id);

                $form = new User_Form_Delete($user->id);

                if ($request->isPost()) {
                    $form->populate($_POST);
                    if ($form->confirm->isChecked()) {
                        try {
                            $this->_delete($form->getValues());
                            $msg = 'User deleted';
                            $this->_helper->flashMessenger->addMessage(
                                    array('success' => $msg)
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
                        } catch (Exception $e) {
                            $this->_helper->flashMessenger->addMessage(
                                    array('error' => 'Some problem occur when tried to delete the user')
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
                        }
                    } else {
                        $this->_helper->redirector(array('action' => 'list', 'controller' => 'admin', 'module' => 'user'));
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

    public function updatePasswordAction() {
        if ($this->_hasParam("id")) {
            $id = $this->_getParam("id");

            //$update = $this->_isUserAllowed(User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_UPDATE);
            $update = Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
                    User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_UPDATE_PASSWORD);
            $isMe = $id == Zend_Auth::getInstance()->getIdentity()->id;

            if ($update || $isMe) {
                $request = $this->getRequest();

                $userDomain = new User_Domain_User(null);
                $user = $userDomain->getById($id);

                $form = new User_Form_Password(User_Form_User::ACTION_EDIT, $user);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    if (isset($data['save'])) {
                        if ($form->isValid($data)) {
                            try {
                                $this->_updatePassword($data);
                                $msg = 'User updated';
                                $this->_helper->flashMessenger->addMessage(
                                        array('success' => $msg)
                                );

                                $param = null;
                                if ($id) {
                                    $param = array('id'=> $id);
                                }
                                $this->_helper->redirector('index', 'profile', 'user', $param);
                            
                                
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                            }
                        } else {
                            $this->_addValidationMessage();
                        }
                    } else {
                        if (isset($data['cancel'])) {
                            $param = null;
                            if ($id) {
                                $param = array('id'=> $id);
                            }
                            $this->_helper->redirector('index', 'profile', 'user', $param);
                        }
                    }
                }

                $this->view->form = $form;
                $this->view->user = $user;
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'You do not have permission to access this'));
                
                $param = null;
                if ($id) {
                    $param = array('id'=> $id);
                }
                $this->_helper->redirector('index', 'profile', 'user', $param);

                return;
                
            }
        } else {
            $this->_helper->flashMessenger->addMessage(
                    array('error' => 'Param id missing'));
            $this->_helper->redirector('index', 'profile', 'user');

            return;
        }        
    }
}

