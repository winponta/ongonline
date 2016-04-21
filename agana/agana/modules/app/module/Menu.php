<?php

/**
 * Agana_App_Module_Menu
 *
 * @category   Agana
 * @package    Agana_App
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class App_Module_Menu implements Agana_Module_Menu_Interface {

    public function injectGlobalMenu() {
        //TODO ACL

        if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, 
                App_Module_Acl::ACL_RESOURCE_APPACCOUNT, 
                App_Module_Acl::ACL_RESOURCE_APPACCOUNT_PRIVILEGE_VIEW)) {
            return array(
                array(
                    'label' => '{{i class=||icon-cog||}}{{/i}} {{translate}}Administration{{/translate}}',
                    'id' => 'menu-adm',
                    'uri' => '#',
                    'order' => 999,
                ),
                array(
                    'label' => '{{i class=||icon-user||}}{{/i}} {{translate}}Persons{{/translate}}',
                    'id' => 'menu-person',
                    'parent' => 'menu-adm',
                    //                'uri' => 'gm/basetables',
                    'load-in' => 'content-container',
                    'action' => 'index',
                    'controller' => 'gm',
                    'module' => 'aganacore',
                    'params' => array(
                        'id' => 'persons',
                    ),
                    //'route' => 'gmRoute',
                    'order' => 999,
                ),
                    //            array(
                    //                'type' => 'mvc',
                    //                'label' => '{{i class=||icon-phone||}}{{/i}} {{translate}}Phone types{{/translate}}',
                    //                'action' => 'list',
                    //                'controller' => 'type',
                    //                'module' => 'phone',
                    //                'id' => 'menu-adm-phones',
                    //                'parent' => 'menu-base-tables',
                    //            ),
            );
        }
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}
