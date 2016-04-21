<?php

/**
 * Login helper with functions to ease auth throughout application
 *
 * @category   Agana
 * @package    Agana_Auth
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Auth_Helper_Login {
    protected $_namespace = 'login';

    public function redirectToLoginForm($lastRequestUri = '') {
        // save the last requestUri to call after login
        $lru = new Agana_Controller_Action_Helper_LastRequestUri();
        $lru->setNamespace($this->_namespace);
        $lru->save($lastRequestUri);

        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper("redirector");
        $redirector->direct("login", "auth", "user");
    }

    public function redirectAfterLogin($defaultUri = '') {
        $lru = new Agana_Controller_Action_Helper_LastRequestUri();
        $lru->setNamespace($this->_namespace);
        $lru->redirect('user/profile');
    }

}

?>
