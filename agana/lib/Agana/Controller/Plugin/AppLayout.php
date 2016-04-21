<?php

/**
 * The AppLayout Controller Plugin sets the correct layout based on
 * agana ini configurations.
 *  
 * If agana.app.ria = on then the agana.app.layout.ria will be seted as correct
 * 
 * @author Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * 
 */
class Agana_Controller_Plugin_AppLayout extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
        $options = $bootstrap->getOption('agana');
        if (strtolower($options['layout']['several']) == 'on') {
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout($options['layout']['default']);

            if (Zend_Auth::getInstance()->hasIdentity()) {
                $layout->setLayout($options['layout']['authenticated']);
            }
        }
    }

}

