<?php

/**
 * Description of Service
 *
 * @author nuno
 */
class Agana_Acl_Service {

    private function __construct() {
        
    }

    /**
     * 
     * @return \Zend_Acl
     */
    public static function getInstance() {
        if (Zend_Registry::isRegistered('acl')) {
            $acl = Zend_Registry::get('acl');
        } else {
            /**
             * must create a new Zend_Acl object and set it as a instance before
             * call load Acl because the modules loading acl resources will need
             * to manipulate the ACL saved in registry
             */
            $acl = new Zend_Acl();
            self::setInstance($acl);

            $acl = self::loadAcl();
        }

        return $acl;
    }

    public static function setInstance($acl) {
        Zend_Registry::set("acl", $acl);
    }

    /**
     * 
     * @param Zend_Db_Table $db
     */
    private static function loadAcl($db = null) {
        $acl = self::getInstance();

        if ($db == null) {
            $db = Zend_Db_Table::getDefaultAdapter();

            if ($db == null) {
                throw new Agana_Exception('No default database found when loading Acl');
            }
        }

        // Resources
        $modules = Agana_Util_Bootstrap::getModulesNames();

        foreach ($modules as $mod) {
            $mod = ucfirst($mod);
            $class = $mod . '_Module_Acl';

            if (class_exists($class)) {
                $moduleAcl = new $class;

                $moduleAcl->initResources();
            }
        }

        $roles = array();
        $permissions = array();

        if (Zend_Auth::getInstance()->hasIdentity()) {
            // Roles
            $select = $db->select()
                    ->from('acl_role')
                    ->where('appaccount_id = ?', Zend_Auth::getInstance()->getIdentity()->appaccount_id);

            $roles = $db->fetchAll($select);

            // Permissions
            $select = $db->select()
                    ->from('acl_role', array('acl_role.name as role', 'id as acl_role_id'))
                    ->joinInner('acl_role_permission', 'acl_role.id = acl_role_permission.acl_role_id', array('resource', 'privilege'));
            
            if (Zend_Auth::getInstance()->getIdentity()->acl_role_id) {
                $select->where('acl_role.id = ?', Zend_Auth::getInstance()->getIdentity()->acl_role_id);
            }

            $permissions = $db->fetchAll($select);
        }

        foreach ($roles as $r) {
            $acl->addRole(new Zend_Acl_Role($r['id']));
        }

        foreach ($permissions as $per) {
            if ($acl->has($per['resource'])) {
                $acl->allow($per['acl_role_id'], $per['resource'], $per['privilege']);
            }
        }

        self::setInstance($acl);

        return $acl;
    }

    public static function isAllowed($role = null, $resource = null, $privilege = null) {
        $acl = self::getInstance();

        return $acl->isAllowed($role, $resource, $privilege);
    }

    public static function getResources() {
        // Resources
        $modules = Agana_Util_Bootstrap::getModulesNames();

        $resources = array();

        foreach ($modules as $mod) {
            $mod = ucfirst($mod);
            $class = $mod . '_Module_Acl';

            if (class_exists($class)) {
                $moduleAcl = new $class;

                $resources[$mod] = $moduleAcl->getResources();
            }
        }

        return $resources;
    }

    public static function getPrivileges() {
        // Resources
        $modules = Agana_Util_Bootstrap::getModulesNames();

        $privileges = array();

        foreach ($modules as $mod) {
            $mod = ucfirst($mod);
            $class = $mod . '_Module_Acl';

            if (class_exists($class)) {
                $moduleAcl = new $class;

                $privileges[$mod] = $moduleAcl->getPrivileges();
            }
        }

        return $privileges;
    }

    static public function addNoPermissionFlashMessage() {
        $msg = new Zend_Controller_Action_Helper_FlashMessenger();
        $msg->addMessage(                    
                array('error' => "You don't have permission to access this !")
        );
    }
}