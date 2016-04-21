<?php

/**
 * User Profile
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_InstallController extends Zend_Controller_Action {

    // TODO criar um serviço para o controlador somente chamar

    public function init() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    public function indexAction() {
        // TODO implementar configuração para saber se pode ser chamado este install

        try {            
            $ad = new App_Domain_Account();
            $app = new App_Model_Account();
            $appName = 'Winponta Software';
            $app = $ad->getByName($appName);

            if (! $app->getId()) {
                $app->setName($appName);
                $app->setEmail('admin@winponta.com.br');
                $ad->setAccount($app);
                $app->setId($ad->createInstall());
            }
            
            $ud = new User_Domain_User();
            $ud->createSuperAdmin(null, $app);

            $login = new Agana_Auth_Helper_Login();
            $login->redirectToLoginForm();
        } catch (Exception $ae) {
            $this->_helper->flashMessenger->addMessage(
                    array('error' => $ae->getMessage())
            );
        }
    }

}

?>
