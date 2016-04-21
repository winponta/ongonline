<?php

/**
 * The Acl Controller Plugin loads ACL configs
 *  
 * @author Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * 
 */
class Agana_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $acl = Agana_Acl_Service::loadAcl();
    }

}

