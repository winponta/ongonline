<?php

/**
 * Agana Controller Action to be extended from others
 * by default the init function disable layout if the
 * request is made by XmlHttpRequest
 */
abstract class Agana_Controller_Action extends Zend_Controller_Action {

    protected function _isUserAllowed($resource, $privilege) {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, 
                    $resource, $privilege
            );
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    protected function _addExceptionMessage($e, $msg = 'Some problem with the action execution') {
        $this->_helper->flashMessenger->addMessage(
                array('error' => $msg)
        );
        $this->_helper->flashMessenger->addMessage(
                array('error' => $e->getMessage())
        );
    }

    protected function _addSavingExceptionMessage($e, $msg = 'Problems saving record') {
        $this->_helper->flashMessenger->addMessage(
                array('error' => $msg)
        );
        $this->_helper->flashMessenger->addMessage(
                array('error' => $e->getMessage())
        );
    }

    /**
     * Add to flash Messenger the default form validation message 
     */
    protected function _addFormValidationMessage() {
        $this->_helper->flashMessenger->addMessage(
                array('validation' => 'Some problem with fields content.'));
    }

    /**
     * Adds the flash messenger message to success in form and, if passed, redirect to another url.
     * The redirectTo parameter must to be an array with the format array(action, controller, module).
     * If no message is explicit passed, it's added the phrase 'Record successfully saved'
     * 
     * @param type array
     * @param type String
     */
    protected function _formSuccess($redirectTo=null, $msg='Record successfully saved') {
        if ($msg) {
            $this->_helper->flashMessenger->addMessage(
                    array('success' => $msg)
            );
        }
        
        if (! is_null($redirectTo)) {
            if (is_array($redirectTo)) {
                $action = $redirectTo['action'];
                unset($redirectTo['action']);
                $controller = $redirectTo['controller'];
                unset($redirectTo['controller']);
                $module = $redirectTo['module'];
                unset($redirectTo['module']);
                
                $this->_helper->redirector($action, $controller, $module, $redirectTo);
            } else {
                $this->_helper->redirector($redirectTo);
            }
        }
    }

    /**
     * Cacnel form and passed redirect to another url.
     * The redirectTo parameter must to be an array with the format array(action, controller, module, keys).
     * 
     * @param type array
     * @param type String
     */
    protected function _formCancel($redirectTo=null) {
        if (! is_null($redirectTo)) {
            if (is_array($redirectTo)) {
                $action = $redirectTo['action'];
                unset($redirectTo['action']);
                $controller = $redirectTo['controller'];
                unset($redirectTo['controller']);
                $module = $redirectTo['module'];
                unset($redirectTo['module']);
                
                $this->_helper->redirector($action, $controller, $module, $redirectTo);
            } else {
                $this->_helper->redirector($redirectTo);
            }
        }
    }

    /**
     * Redirect the request to login form, showing a message about permission access
     * The deafult message is = 'You do not have permission to access this'
     * @param String $msg 
     */
    protected function _redirectLogin($msg = 'You do not have permission to access this') {
        $this->_helper->flashMessenger->addMessage(array('warning' => $msg));
        $login = new Agana_Auth_Helper_Login();
        $login->redirectToLoginForm();
    }

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

}
