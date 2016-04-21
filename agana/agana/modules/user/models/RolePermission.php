<?php

class User_Model_RolePermission extends Agana_Data_Bean {
    private $id;
    private $resource;
    private $privilege;
    private $acl_role_id;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getAcl_role_id() {
        return $this->acl_role_id;
    }

    public function setAcl_role_id($acl_role_id) {
        $this->acl_role_id = $acl_role_id;
    }

    public function getResource() {
        return $this->resource;
    }

    public function setResource($resource) {
        $this->resource = $resource;
    }

    public function getPrivilege() {
        return $this->privilege;
    }

    public function setPrivilege($privilege) {
        $this->privilege = $privilege;
    }

}

