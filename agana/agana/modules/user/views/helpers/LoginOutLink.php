<?php

/**
 * LoginOutLink view helper decides if mounts the login ou logout url
 *
 * @category   Agana
 * @package    Agana_View_Helper_FlashMessages
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_LoginOutLink extends Zend_View_Helper_Abstract {

    public function loginOutLink($labelIn = 'Login', $labelOut = 'Logout', $showInLoginPage = true, 
            $prependLabelLogin = '', $appendLabelLogin = '',
            $prependLabelLogout = '', $appendLabelLogout = '',
            $decorator = '', $tooltip = ''
            ) {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $label = $this->view->translate($labelOut);
            
            $logoutUrl = $this->view->url(
                array(
                    'module' => 'user',
                    'controller' => 'auth',
                    'action' => 'logout'
                ), null, true
            );
            return '<a href="' . $logoutUrl . '" '.$decorator.' rel="tooltip" data-placement="bottom" title="'.$tooltip.'">'.$prependLabelLogout.$label.$appendLabelLogout.'</a>';
        }

        if (!$showInLoginPage) {
            $request = Zend_Controller_Front::getInstance()->getRequest();
            $controller = $request->getControllerName();
            $action = $request->getActionName();
            if ($controller == 'auth' && $action == 'index') {
                return '';
            }
        }
        
        $label = $this->view->translate($labelIn);
        
        $loginUrl = $this->view->url(
            array(
                'module' => 'user',
                'controller' => 'auth', 
                'action' => 'login'
            )
        );
        return '<a href="' . $loginUrl . '" '.$decorator.'>'.$prependLabelLogin.$label.$appendLabelLogin.'</a>';
    }

}

