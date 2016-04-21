<?php

/**
 * Description of Acl
 *
 * @author nuno
 */
class User_Module_Acl {

    const ACL_RESOURCE_USER = 'User';
    const ACL_RESOURCE_USER_PRIVILEGE_VIEW = 'view';
    const ACL_RESOURCE_USER_PRIVILEGE_LIST = 'list';
    const ACL_RESOURCE_USER_PRIVILEGE_CREATE = 'create';
    const ACL_RESOURCE_USER_PRIVILEGE_UPDATE = 'update';
    const ACL_RESOURCE_USER_PRIVILEGE_UPDATE_PASSWORD = 'update-pwd';
    const ACL_RESOURCE_USER_PRIVILEGE_DELETE = 'delete';

    const ACL_RESOURCE_USERROLE = 'UserRole';
    const ACL_RESOURCE_USERROLE_PRIVILEGE_VIEW = 'view';
    const ACL_RESOURCE_USERROLE_PRIVILEGE_LIST = 'list';
    const ACL_RESOURCE_USERROLE_PRIVILEGE_CREATE = 'create';
    const ACL_RESOURCE_USERROLE_PRIVILEGE_UPDATE = 'update';
    const ACL_RESOURCE_USERROLE_PRIVILEGE_DELETE = 'delete';

    public function initResources() {
        $acl = Agana_Acl_Service::getInstance();

        $resources = $this->getResources();
        foreach ($resources as $res) {
            if (!$acl->has($res['name'])) {
                $acl->addResource($res['name']);
            }
        }
    }

    public function getResources() {
        return array(
            array(
                'name'          => self::ACL_RESOURCE_USER,
                'description'   => 'User resource defines the privileges for management of user ' .
                                    'data. Users are allowed to login the application ' .
                                    'and use it.',
                'privileges'    => array(
                    self::ACL_RESOURCE_USER_PRIVILEGE_VIEW,
                    self::ACL_RESOURCE_USER_PRIVILEGE_LIST,
                    self::ACL_RESOURCE_USER_PRIVILEGE_CREATE,
                    self::ACL_RESOURCE_USER_PRIVILEGE_UPDATE,
                    self::ACL_RESOURCE_USER_PRIVILEGE_UPDATE_PASSWORD,
                    self::ACL_RESOURCE_USER_PRIVILEGE_DELETE,
                ),
                'privileges_label' => array(
                    4   => 'update password',
                ),
            ),
            array(
                'name'          => self::ACL_RESOURCE_USERROLE,
                'name_label'    => 'User role',
                'privileges'    => array(
                    self::ACL_RESOURCE_USERROLE_PRIVILEGE_VIEW,
                    self::ACL_RESOURCE_USERROLE_PRIVILEGE_LIST,
                    self::ACL_RESOURCE_USERROLE_PRIVILEGE_CREATE,
                    self::ACL_RESOURCE_USERROLE_PRIVILEGE_UPDATE,
                    self::ACL_RESOURCE_USERROLE_PRIVILEGE_DELETE,
                ),
            )
        );
    }

}

