<?php

/**
 * Login
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_AuthController extends Zend_Controller_Action {
    /**
     * @var Zend_Translate
     */
    protected $_translate = NULL;

    public function init() {
        $this->_translate = Zend_Registry::getInstance()->get('Zend_Translate');

        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    protected function _getAuthAdapter() {
        $d = new User_Domain_User();
        
        return $d->getAuthAdapter();
    }

    protected function _processAuthentication($values) {
        $d = new User_Domain_User();
        $result = $d->authenticate($values['name'], $values['pwd']);
        return $result;
    }

    public function indexAction() {
        $this->_forward('login', 'auth', 'user');
    }

    public function loginAction() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $name = Zend_Auth::getInstance()->getIdentity()->name;
            $msg = 'You are already logged as <strong>%1$s</strong>. <br/>' .
                    ' If you are not this user, ' . 
                    'please logout and then reconect.';
            $this->_helper->flashMessenger->addMessage(
                array('info' => $msg, 'params' => $name)
            );

            $this->_helper->redirector('index', 'profile', 'user');
        } else {
            $form = new User_Form_Login();
            $request = $this->getRequest();
            if ($request->isPost()) {
                if ($form->isValid($request->getPost())) {
                    try {
                        $user = $this->_processAuthentication($form->getValues());
                    
                        $userName = $user->name;
                        $msg = 'You are now logged as <strong>%1$s</strong>';
                        $this->_helper->flashMessenger->addMessage(
                            array('title'=>'Success authentication','success' => $msg, 'params' => $userName)
                        );

                        $login = new Agana_Auth_Helper_Login();
                        $login->redirectAfterLogin('user/profile');
                    } catch (Exception $e) {
                        $this->_helper->flashMessenger->addMessage(
                            array('title'=>'Entry form validation', 'validation' => $e->getMessage())
                        );
                    }
                } else {
                    $this->_helper->flashMessenger->addMessage(
                        array('title'=>'Entry form validation', 'validation' => 'Some problem with fields content.')
                    );
                }
            }
            $this->view->form = $form;
        }
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('login', 'auth', 'user'); // back to login page
    }

}

