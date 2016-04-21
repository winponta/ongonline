<?php

/**
 * This plugin instantiate a global menu navigation object and lets it avaiable to 
 * modules use when they need insert menu options
 * 
 * @author Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * 
 */
class Agana_Controller_Plugin_Navigation_GlobalMenu extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $globalMenu = new Zend_Navigation();
        Zend_Registry::set('Navigation.GlobalMenu', $globalMenu);
    }

}

?>
