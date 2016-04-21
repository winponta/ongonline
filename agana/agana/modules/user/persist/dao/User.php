<?php

/**
 * Persistence logic in database for User
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class User_Persist_Dao_User extends Zend_Db_Table_Abstract implements User_Persist_Interface_User {
    
    private $_useTransaction = true;
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'user';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'user_id_seq';

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
     * Insert or update user
     * 
     * @param User_Model_User $user 
     */
    public function save($user = null) {
        if ($user != null) {
            try {
                if ($this->useTransaction()) {
                    $this->getAdapter()->beginTransaction();
                }
                
                if ($user->getId() > 0) {
                    /*************
                     *  Audit Trail
                     */
                    $oldUser = $this->get($user->getId());
                    $audit = new \User_Module_Audit();
                    foreach ($audit->getTrackFields() as $field) {
                        $oldValues[$field] = $oldUser->$field;
                        $newValues[$field] = $user->$field;
                    }
                    $who['user_id'] = Zend_Auth::getInstance()->getIdentity()->id;
                    $who['appaccount_id'] = Zend_Auth::getInstance()->getIdentity()->appaccount_id;
                    $audit->log(Agana_AuditTrail_Abstract::EVENT_TYPE_UPDATE, 'user', $oldValues, $newValues, $who);
                    
                    /*************
                     * Update
                     */
                    $where = $this->getAdapter()->quoteInto('id = ?', $user->getId());
                    $res = $this->update($this->_prepareUpdateData($user), $where);
                } else {
                    $res = $this->insert($this->_prepareInsertData($user));
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
            throw new Agana_Exception('User cannot be null');
        }
    }

    /**
     * Update user password
     * 
     * @param User_Model_User $user 
     */
    public function savePwd($user = null) {
        if ($user != null) {
            try {
                if ($this->useTransaction()) {
                    $this->getAdapter()->beginTransaction();
                }
                
                $where = $this->getAdapter()->quoteInto('id = ?', $user->getId());
                $res = $this->update($this->_prepareUpdatePwdData($user), $where);
                
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
            throw new Agana_Exception('User cannot be null');
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
     * Update user data
     * @param User_Model_User $user 
     */
    private function _update($user) {
        if ($user != null) {
            try {
                $where = $this->getAdapter()->quoteInto('id = ?', $user->getId());
                return $this->getAdapter()
                                ->update('user', $this->_prepareUpdateData($user), $where);
            } catch (Exception $pdoe) {
                throw new Agana_Exception($pdoe->getMessage());
            }
        }
    }

    /**
     * Returns the result of a database query for all records
     * of users, filtering by show status parameter with the value of the
     * status.
     * The parameter is an array with the values -1 (blocked), 0(inactive), 1(active)
     * to be searched or null meaning query all
     * 
     * @param array $showStatus
     * @return User_Model_User
     */
    public function getAll($appaccount_id, $showStatus = null) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('user')
                ->where('appaccount_id = ?', $appaccount_id)
                ->order('name');


        if ($showStatus != null) {
            $qtosStatus=0;
            $sqlStatus='';
            foreach ($showStatus as $status) {
                $qtosStatus++;
                $sqlStatus = (($qtosStatus > 1) ? ' or ' : '') . $sqlStatus;
                $sqlStatus .= ' status = ' . $status;
            }
            $sql->where($sqlStatus);
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        return $this->_prepareReturnData($db->fetchAll($sql));
    }

    public function get($id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('user')
                ->where('id = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql), false);
    }

    public function getByPersonId($id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('user')
                ->where('person_id = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql), false);
    }

    public function getByName($name, $appaccount_id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
            ->from('user')
            ->where('name = ?', $name);
        /**
         * Do not need to pass appaccount_id cause name is unique in database
         */
            //->where('appaccount_id = ?', $db->quote($appaccount_id));
        
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql), false);
    }

    public function getByEmail($email, $appaccount_id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
            ->from('user')
            ->where('email = ?', $email);
        /**
         * Do not need to pass appaccount_id cause email is unique in database
         */
            //->where('appaccount_id = ?', $db->quote($appaccount_id));
        
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql), false);
    }

    /**
     * Prepare data for insert
     * 
     * @param User_Model_User $user
     * @return Array 
     */
    private function _prepareInsertData($user) {
        
        $data = array(
            //'id' => $user->getId(),
            'name' => $user->getName(),
            'created' => date('Y-m-d H:m:s', $user->getCreated()),
            'status' => $user->getStatus(),
            'pwd' => $user->getPwd(),
            'rnd_salt' => $user->getSalt(),
            'email' => $user->getEmail(),
            //'objid' => Agana_Service_Object::create('user'),
            'person_id' => $user->getPerson()->getId(),
            'acl_role_id' => $user->getAcl_role_id(),
            'appaccount_id' => $user->getAppAccount()->getId(),
        );

        return $data;
    }

    /**
     * Prepare data for update user minus password
     * 
     * @param User_Model_User $user
     * @return Array 
     */
    private function _prepareUpdateData($user) {
        $data = array(
            'name' => $user->getName(),
            'status' => $user->getStatus(),
            'email' => $user->getEmail(),
            'acl_role_id' => $user->getAcl_role_id(),
        );
        
        if ($user->getLastLogin() != null && $user->getLastLogin() != '')  {
            $data['last_login'] = $user->getLastLogin();
        }

        return $data;
    }

    /**
     * Prepare data for update password
     * 
     * @param User_Model_User $user
     * @return Array 
     */
    private function _prepareUpdatePwdData($user) {
        $data = array(
            'pwd' => $user->getPwd(),
            'rnd_salt' => $user->getSalt(),
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
                            ->delete('user', $where);
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
     * @return User_Model_User
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        if (is_array($data)) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }
            
            $col = array();
            foreach ($data as $key => $row) {
                if ($row) {
                    $o = new User_Model_User($row);
                    $o->setLastLogin($row['last_login']);

                    $ad = new App_Domain_Account();
                    $app = $ad->getById($row['appaccount_id']);
                    $o->setAppAccount($app);

                    $pd = new Persons_Domain_Person();
                    $person = $pd->getById($row['person_id']);
                    $o->setPerson($person);

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

}