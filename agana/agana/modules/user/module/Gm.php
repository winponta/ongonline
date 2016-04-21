<?php

/**
 * Agana_User_Module_Gm
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $this->_name = 'Users';

        if (Zend_Auth::getInstance()->hasIdentity()) {
            if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, User_Module_Acl::ACL_RESOURCE_USER, User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_LIST)) {
                $this->_navigation[] = array(
                    'icon' => 'icon-user',
                    'label' => 'Users',
                    'module' => 'user',
                    'controller' => 'admin',
                    'action' => 'index',
                    'route' => 'default',
                    'uri' => '',
                    'title' => '',
                );
            }

            if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id, User_Module_Acl::ACL_RESOURCE_USERROLE, User_Module_Acl::ACL_RESOURCE_USERROLE_PRIVILEGE_LIST)) {
                $this->_navigation[] = array(
                    'icon' => 'icon-group',
                    'label' => 'User roles',
                    'module' => 'user',
                    'controller' => 'role',
                    'action' => 'index',
                    'route' => 'default',
                    'uri' => '',
                    'title' => '',
                );
            }
        }
    }

}
