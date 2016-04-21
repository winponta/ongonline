<?php

class User_Model_Role extends Agana_Data_Bean {
    private $id;
    private $name;
    private $appaccount;
    private $appaccount_id;
    private $permissions;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    /**
     * @return App_Model_Account
     */
    public function getAppAccount() {
        return $this->appaccount;
    }

    public function setAppAccount($appaccount) {
        $this->appaccount = $appaccount;
    }
    
    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
    }
    
    /**
     * 
     * @param array | User_Model_Permissions $permissions
     */
    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }
    
    public function getPermissions() {
        if ($this->permissions == null) {
            $roleDomain = new User_Domain_Role();
            $this->permissions = $roleDomain->getPermissionsByRole($this->id);
        }
        
        return $this->permissions;
    }
}

