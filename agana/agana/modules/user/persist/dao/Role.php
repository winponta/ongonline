<?php

/**
 * Persistence logic in database for Role
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class User_Persist_Dao_Role extends Zend_Db_Table_Abstract implements User_Persist_Interface_Role {
    
    private $_useTransaction = true;
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'acl_role';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'acl_role_id_seq';

    public function beginTransaction() {
        $this->getAdapter()->beginTransaction();
    }
    
    public function commit() {
        $this->getAdapter()->commit();        
    }
    
    public function rollback() {
        $this->getAdapter()->rollBack();        
    }
    
    /**
     * Insert or update role
     * 
     * @param User_Model_Role $role
     */
    public function save($role = null) {
        if ($role != null) {
            try {
                if ($this->useTransaction()) {
                    $this->getAdapter()->beginTransaction();
                }
                
                if ($role->getId() > 0) {
                    $where = $this->getAdapter()->quoteInto('id = ?', $role->getId());
                    $res = $this->update($this->_prepareUpdateData($role), $where);
                } else {
                    $res = $this->insert($this->_prepareInsertData($role));
                }
                
                if ($this->useTransaction()) {
                    $this->getAdapter()->commit();
                }
                
                return $res;
            } catch (Exception $e) {
                if ($this->useTransaction()) {
                    $this->getAdapter()->rollBack();
                }
                throw $e;
            }
        } else {
            throw new Agana_Exception('Role cannot be null');
        }
    }

    /**
     * Insert or update role permissions
     * 
     * @param User_Model_Role $role
     */
    public function savePermissions($role = null) {
        if ($role != null) {
            try {
                if ($this->useTransaction()) {
                    $this->getAdapter()->beginTransaction();
                }
                
                $where = $this->getAdapter()->quoteInto('acl_role_id = ?', $role->getId());
                
                // delete all permission for this role
                $res = $this->getAdapter()->delete('acl_role_permission', $where);

                $permissions = $role->getPermissions();
                foreach ($permissions as $permission) {
                    unset($data);
                    $data['acl_role_id'] = $role->id;
                    $data['resource'] = $permission->resource;
                    $data['privilege'] = $permission->privilege;
                    $res = $this->getAdapter()->insert('acl_role_permission', $data);
                }
                
                if ($this->useTransaction()) {
                    $this->getAdapter()->commit();
                }
                
                return $res;
            } catch (Exception $e) {
                if ($this->useTransaction()) {
                    $this->getAdapter()->rollBack();
                }
                throw $e;
            }
        } else {
            throw new Agana_Exception('Role cannot be null');
        }
    }

//    private function _insert($user) {
//        if ($user != null) {
//            try {
//
//                return Zend_Db_Table::getDefaultAdapter()
//                                ->insert('user', $this->_prepareInsertData($user));
//            } catch (Exception $pdoe) {
//                throw new Agana_Exception($pdoe->getMessage());
//            }
//        }
//    }

    /**
     * Update role data
     * @param User_Model_Role $role
     */
    private function _update($role) {
        if ($role != null) {
            try {
                $where = $this->getAdapter()->quoteInto('id = ?', $role->getId());
                return $this->getAdapter()
                                ->update('user', $this->_prepareUpdateData($role), $where);
            } catch (Exception $pdoe) {
                throw new Agana_Exception($pdoe->getMessage());
            }
        }
    }

    /**
     * Returns the result of a database query for all records
     * 
     * @return User_Model_Role
     */
    public function getAll($appaccount_id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('acl_role')
                ->where('appaccount_id = ?', $appaccount_id)
                ->order('name');


        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        return $this->_prepareReturnData($db->fetchAll($sql));
    }

    public function get($id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('acl_role')
                ->where('id = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql), false);
    }

    public function getByName($name, $appaccount_id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('acl_role')
                ->where('name = ?', $name)
                ->where('appaccount_id = ?', $appaccount_id);
        
        $db->setFetchMode(Zend_DB::FETCH_OBJ);
        return $db->fetchRow($sql);
    }

    /**
     * Prepare data for insert
     * 
     * @param User_Model_Role $role
     * @return Array 
     */
    private function _prepareInsertData($role) {
        
        $data = array(
            //'id' => $user->getId(),
            'name' => $role->getName(),
            'appaccount_id' => $role->getAppAccount()->getId(),
        );

        return $data;
    }

    /**
     * 
     * @param User_Model_Role $role
     * @return Array 
     */
    private function _prepareUpdateData($role) {
        $data = array(
            'name' => $role->getName(),
        );
        
        return $data;
    }

    /**
     * Delete the user record by its id
     * 
     * @param int $id 
     */
    public function delete($id) {
        try {
            $where = $this->getAdapter()->quoteInto('id = ?', $id);
            return $this->getAdapter()
                            ->delete('role', $where);
        } catch (Exception $pdoe) {
            throw new Agana_Exception($pdoe->getMessage());
        }
    }

    public function useTransaction() {
        return $this->_useTransaction;
    }

    public function setUseTransaction($_useTransaction) {
        $this->_useTransaction = $_useTransaction;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return User_Model_Role
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        if (is_array($data)) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }
            
            $col = array();
            foreach ($data as $key => $row) {
                if ($row) {
                    $o = new User_Model_Role($row);

                    $ad = new App_Domain_Account();
                    $app = $ad->getById($row['appaccount_id']);
                    $o->setAppAccount($app);

                    $col[] = $o;
                }
            }

            if ($returnArray) {
                return $col;
            } else {
                return $col[0];
            }
        } else {
            return null;
        }
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return User_Model_RolePermission
     */
    protected function _preparePermissionsReturnData($data, $returnArray = true) {
        if (is_array($data)) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }
            
            $col = array();
            foreach ($data as $key => $row) {
                if ($row) {
                    $o = new User_Model_RolePermission($row);

                    $col[] = $o;
                }
            }

            if ($returnArray) {
                return $col;
            } else {
                return $col[0];
            }
        } else {
            return null;
        }
    }

    public function getPermissionsByRole($id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('acl_role_permission')
                ->where('acl_role_id = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_preparePermissionsReturnData($db->fetchRow($sql), false);
    }


}
