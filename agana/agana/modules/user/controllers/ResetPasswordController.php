<?php

/**
 * ResetPasswordController
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_ResetPasswordController extends Zend_Controller_Action {

    public function indexAction() {
        $form = new \User_Form_ResetPassword();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->populate($request->getPost());
            if ($form->reset->isChecked()) {
                if ($form->isValid($request->getPost())) {
                    $userDomain = new \User_Domain_User();
                    if ($request->getPost('user')) {
                        $user = $userDomain->getByName($request->getPost('user'));

                        if (is_null($user)) {
                            $user = $userDomain->getByEmail($request->getPost('user'));
                        }
                    }

                    if ($user) {
                        try {
                            $userDomain->sendResetPasswordEmail($user);

                            $this->_helper->flashMessenger->addMessage(
                                array('success' => 'An email with instructions for password reset was sent for this user. Please, check your inbox.')
                            );
                        } catch (Exception $exc) {
                            $this->_helper->flashMessenger->addMessage(
                                array('error' => $exc->getMessage())
                            );
                        }
                    } else {
                        $msg = 'No user matches this name or email';
                        $this->_helper->flashMessenger->addMessage(
                            array('error' => $msg)
                        );
                    }
                } else {
                    $this->_helper->flashMessenger->addMessage(
                        array(
                            'validation' => 'Some problem with fields content.'
                        )
                    );
                }
            } else {
                $this->_helper->redirector('index', 'auth', 'user');
            }
        }

        $this->view->form = $form;
    }

    public function createNewAction() {
        if ($this->_hasParam('id') && $this->_hasParam('key')) {
            $userDomain = new \User_Domain_User();
            $user = $userDomain->getById($this->_getParam('id'));
        
            if ($user) {                
                if ($userDomain->isValidResetPasswordKey($user, $this->_getParam('key'))) {
                    $form = new \User_Form_Password(User_Form_Password::ACTION_EDIT, $user);
                    $this->view->form = $form;

                    $request = $this->getRequest();
                    if ($request->isPost()) {
                        $data = $request->getPost();
                        $form->populate($data);
                        if ($form->save->isChecked()) {
                            if ($form->isValid($data)) {
                                try {
                                    $this->updatePassword($data);
                                    $msg = 'Password updated, please login';
                                    $this->_helper->flashMessenger->addMessage(
                                            array('success' => $msg)
                                    );

                                    $this->_helper->redirector('index', 'auth', 'user');
                                } catch (Exception $e) {
                                    $this->addSavingExceptionMessage($e);
                                }                                
                            } else {
                                $this->_helper->flashMessenger->addMessage(
                                    array(
                                        'validation' => 'Some problem with fields content.'
                                    )
                                );                                
                            }
                        } else {
                            $this->_helper->redirector('index', 'auth', 'user');
                        }
                    }
                } else {
                    $this->redirectInvalidResetLink();
                }                
            } else { // if not $user
                $this->redirectInvalidResetLink();
            }
        } else { // if has param ID
            $msg = 'Param "id" or "key" is missing';
            $this->_helper->flashMessenger->addMessage(
                array('error' => $msg)
            );
            
            $this->_helper->redirector('index', 'reset-password', 'user');            
        }
    }
    
    private function redirectInvalidResetLink() {
        $msg = 'This is not a valid link to reset password';
        $this->_helper->flashMessenger->addMessage(
            array('error' => $msg)
        );

        $this->_helper->redirector('index', 'reset-password', 'user');                            
    }

    private function addSavingExceptionMessage($e) {
        $this->_helper->flashMessenger->addMessage(
                array('error' => 'Problems saving user')
        );
        $this->_helper->flashMessenger->addMessage(
                array('error' => $e->getMessage())
        );
    }

    private function updatePassword($user, $data) {
        $userDomain = new User_Domain_User();
        $userDomain->setUser($user);
        
        try {
            return $userDomain->updatePwd(true);
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

}

