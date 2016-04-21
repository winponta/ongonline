<?php

/**
 * User Profile
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_ProfileController extends Zend_Controller_Action {

    // TODO criar um serviço para o controlador somente chamar

    public function init() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    public function indexAction() {
        if (User_Domain_User::isAllowed()) {
            $domain = new User_Domain_User();
            
            // if there is an id param search for this user
            // else get the authenticated user
            if ($this->_hasParam('id')) {
                $user = $domain->getById($this->_getParam('id'));
            } else {
                $user = $domain->getById(Zend_Auth::getInstance()->getIdentity()->id);
            }
            $this->view->user = $user;
        } else {
            $login = new Agana_Auth_Helper_Login();
            $login->redirectToLoginForm();
        }
    }

}

?>
