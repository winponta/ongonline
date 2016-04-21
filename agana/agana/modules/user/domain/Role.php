<?php

class User_Domain_Role {

    /**
     *
     * @var User_Model_Role
     */
    protected $_role = null;

    public function __construct($roleModel = null) {
        if (is_null($roleModel)) {
            $roleModel = new User_Model_Role();
        }
        $this->setRole($roleModel);
    }

    public function getAll($appaccount_id, $show = null) {
        if ($this->_isAllowed()) {
            try {
                if ($show != null) {
                    if (!is_array($show)) {
                        $show = explode(',', $show);
                    }
                }
                $u = new User_Persist_Dao_Role();
                return $u->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, $show);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * @return User_Model_Role
     */
    public function getRole() {
        return $this->_role;
    }

    /**
     * @param User_Model_Role $role 
     */
    public function setRole($role) {
        if (is_array($role)) {
            $this->populateRole($role);
        } else {
            if ($role && $role->appaccount_id && !$role->getAppAccount()) {
                $ad = new App_Domain_Account();
                $app = $ad->getById($role->appaccount_id);
                $role->setAppAccount($app);
            }

            $this->_role = $role;
        }
    }

    public function populateRole($data) {
        if (is_array($data)) {
            if ($this->_role == null) {
                $this->_role = new User_Model_Role();
            }
            Agana_Data_BeanUtil::populate($this->_role, $data);            
        } else {
            $this->setRole($data);
        }

        $ad = new App_Domain_Account();
        if (!is_null($this->_role->appaccount_id)) {
            $app = $ad->getById($this->_role->appaccount_id);
        } else {
            $app = $ad->getById(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
        }
        $this->_role->setAppAccount($app);

        return $this->_role;
    }

    /**
     * This function is used to perform the add new user in database. It's necessary
     * because the createAdmin function does not need to test if user is allowed
     * 
     * @return User_Model_Role
     * @throws Exception 
     */
    private function _add() {
        try {
            $u = new User_Persist_Dao_Role();
            $u->beginTransaction();

            $app = $this->_role->getAppAccount();
            if (!isset($app) || !$app->getId()) {
                throw new Agana_Exception('An App Account must be provided to include a new role');
            }

            $u->setUseTransaction(false);
            $res = $u->save($this->_role);
            $u->commit();
            return $res;
        } catch (Exception $e) {
            $u->rollback();
            throw $e;
        }
    }

    public function add() {
        if ($this->_isAllowed()) {
            return $this->_add();
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            $role = $this->getRole();

            try {
                $u = new User_Persist_Dao_Role();
                return $u->save($this->_role);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function updatePermissions() {
        if ($this->_isAllowed()) {
            $role = $this->getRole();

            try {
                $u = new User_Persist_Dao_Role();
                return $u->savePermissions($this->_role);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            $role = $this->getRole();

            try {
                $u = new User_Persist_Dao_Role();
                return $u->delete($this->_role->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        if (!is_null($id)) {
            try {
                $u = new User_Persist_Dao_Role();
                return $u->get($id);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return $id;
        }
    }

    public function getPermissionsByRole($id) {
        if (!is_null($id)) {
            try {
                $u = new User_Persist_Dao_Role();
                return $u->getPermissionsByRole($id);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return $id;
        }        
    }
    
    public function getByName($name) {
        try {
            $u = new User_Persist_Dao_Role();
            return $u->getByName($name);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function _isAllowed() {
        return $this->isAllowed();
    }

    static public function isAllowed() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Agana_Exception('You don not have permission to access this');
        } else {
            return true;
        }
    }
    
}

