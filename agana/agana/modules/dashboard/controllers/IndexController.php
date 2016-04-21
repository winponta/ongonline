<?php

/**
 * Dashboard 
 * 
 * @author (nuno) Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * @version 0.1
 */

/**
 *  
 * @author (nuno) Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 */
class Dashboard_IndexController extends Zend_Controller_Action {

    public function init() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            if ($this->_request->isXmlHttpRequest()) {
                $layout = Zend_Layout::getMvcInstance();
                $view = $layout->getView();
                $layout->disableLayout();
            }
        } else {
            $this->_redirectLogin('Please login to access this feature');
            return false;
        }
    }

    function _redirectLogin($msg = 'You do not have permission to access this') {
        $this->_helper->flashMessenger->addMessage(array('warning' => $msg));
        $login = new Agana_Auth_Helper_Login();
        $login->redirectToLoginForm();
    }

    public function indexAction() {
        $domain = new Dashboard_Domain_Dashboard();
        
        $domain->loadModulesWidgets();
        $this->view->widgets = $domain->getWidgets();
    }

}

