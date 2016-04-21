<?php

/**
 * Description of Acl
 *
 * @author nuno
 */
class App_Module_Acl {

    const ACL_RESOURCE_APPACCOUNT = 'AppAccount';
    const ACL_RESOURCE_APPACCOUNT_PRIVILEGE_VIEW = 'view';
    const ACL_RESOURCE_APPACCOUNT_PRIVILEGE_UPDATE = 'update';

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
                'name'          => self::ACL_RESOURCE_APPACCOUNT,
                'privileges'    => $this->getPrivileges(),
            )
        );
    }

    public function getPrivileges() {
        return array(
            self::ACL_RESOURCE_APPACCOUNT_PRIVILEGE_VIEW,
            self::ACL_RESOURCE_APPACCOUNT_PRIVILEGE_UPDATE,
        );
    }

}

