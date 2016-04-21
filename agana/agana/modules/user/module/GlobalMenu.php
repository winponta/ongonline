<?php

/**
 * Agana_User_Module_GlobalMenu
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Module_GlobalMenu extends Zend_Controller_Plugin_Abstract implements Agana_Module_Menu_Interface {

    public function injectGlobalMenu() {
        //TODO ACL
        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

        $menuAdm = $globalMenu->findOneBy('id', 'menu-adm');

        if ($menuAdm === null) {
            $menuAdm = new Zend_Navigation_Page_Uri(
                array(
                    'label' => '{{i class=||icon-cog||}}{{/i}} {{translate}}Administration{{/translate}}',
                    'id' => 'menu-adm',
                    'uri' => '#',
                    'order' => 999,
                )
            );
        }

//        $newPage = new Zend_Navigation_Page_Mvc(
//            array(
//                'label' => '{{i class=||icon-user||}}{{/i}} {{translate}}Users{{/translate}}',
//                'id' => 'menu-adm-users',
//                'parent' => $menuAdm,
//                'module' => 'user',
//                'controller' => 'admin',
//                'action' => 'index',
//            ));
//        
        if (Zend_Auth::getInstance()->hasIdentity()) {
            if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_LIST) ||
                    Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, User_Module_Acl::ACL_RESOURCE_USERROLE, User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_LIST)) {

                $newPage = new Zend_Navigation_Page_Mvc(
                    array(
                        'label' => '{{i class=||icon-user||}}{{/i}} {{translate}}Users{{/translate}}',
                        'id' => 'menu-adm-users',
                        'parent' => $menuAdm,
                        'load-in' => 'content-container',
                        'action' => 'index',
                        'controller' => 'gm',
                        'module' => 'aganacore',
                        'params' => array(
                            'id' => 'user_acl',
                        ),
                        //'route' => 'gmRoute',
                        'order' => 999,
                    )
                );
            }
        }
        $globalMenu->addPage($menuAdm);
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}
