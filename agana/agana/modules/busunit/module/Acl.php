<?php

/**
 * Description of Acl
 *
 * @author nuno
 */
class Busunit_Module_Acl {

    const ACL_RESOURCE_BUSUNIT_HEAD = 'BusinessUnitHeadquarters';
    const ACL_RESOURCE_BUSUNIT_HEAD_PRIVILEGE_VIEW = 'view';
    const ACL_RESOURCE_BUSUNIT_HEAD_PRIVILEGE_UPDATE = 'update';

    const ACL_RESOURCE_BUSUNIT_BRANCH = 'BusinessUnitBranchs';
    const ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_VIEW = 'view';
    const ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_LIST = 'list';
    const ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_CREATE = 'create';
    const ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_UPDATE = 'update';
    const ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_DELETE = 'delete';

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
                'name'          => self::ACL_RESOURCE_BUSUNIT_HEAD,
                'privileges'    => array(
                    self::ACL_RESOURCE_BUSUNIT_HEAD_PRIVILEGE_VIEW,
                    self::ACL_RESOURCE_BUSUNIT_HEAD_PRIVILEGE_UPDATE,
                ),
            ),
            array(
                'name'          => self::ACL_RESOURCE_BUSUNIT_BRANCH,
                'privileges'    => array(
                    self::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_VIEW,
                    self::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_LIST,
                    self::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_CREATE,
                    self::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_UPDATE,
                    self::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_DELETE,
                ),
            )
        );
    }

}

