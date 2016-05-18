<?php

/**
 * Abstract Dao Persistence
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
abstract class Agana_Persist_Dao_Abstract extends Zend_Db_Table_Abstract {

    /**
     * Defines if use transactions when performing saves
     * @var Boolean
     */
    private $_useTransaction = true;

    /**
     * Defines if should track in audit trail the update record
     * @var Boolean
     */
    private $_trackUpdateAuditTrail = false;

    /**
     * The name of class to instantiate when tracking audit trail
     * @var String
     */
    private $_auditTrailClassName = '';

    public function getTrackUpdateAuditTrail() {
        return $this->_trackUpdateAuditTrail;
    }

    public function setTrackUpdateAuditTrail($_trackUpdateAuditTrail) {
        $this->_trackUpdateAuditTrail = $_trackUpdateAuditTrail;
    }

    public function getAuditTrailClassName() {
        return $this->_auditTrailClassName;
    }

    public function setAuditTrailClassName($_auditTrailClassName) {
        $this->_auditTrailClassName = $_auditTrailClassName;
    }

        /**
     * Prepare data for return from a persistent search
     *
     * @param array The array of data to be converted in model type
     * @param String The name of the model class
     * @return Agana_Model
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        if (is_array($data) && count($data) > 0) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }

            $col = array();
            foreach ($data as $key => $row) {
                if ($row) {
                    try {
                        $o = new $this->_modelClass($row);
                    } catch (Exception $e) {
                        throw $e;
                    }

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
     * Prepare data for persist
     * 
     * @param Agana_Model
     * @return Array 
     */
    abstract protected function _prepareInsertData($modelObject);

    /**
     * Prepare data for persist
     * 
     * @param Agana_Model
     * @return Array 
     */
    abstract protected function _prepareUpdateData($modelObject);

    protected function getNowTimestamp() {
        return date('Y-m-d H:m:s', time());
    }

    /**
     * Insert the object data in database
     * 
     * @param Agana_Model_Object
     */
    private function _insert($object) {
        //return $this->_insert($object);
        $res = $this->insert($this->_prepareInsertData($object));
        return $res;
    }

    private function _saveAuditTrail($object, $eventName) {
        try {
            $oldObjectData = $this->get($object->getId());
            $audit = new $this->_auditTrailClassName();
            $oldValues = array();
            $newValues = array();
            foreach ($audit->getTrackFields() as $field) {
                $oldValues[$field] = $oldObjectData->$field;
                $newValues[$field] = $object->$field;
            }
            $who['user_id'] = Zend_Auth::getInstance()->getIdentity()->id;
            $who['appaccount_id'] = Zend_Auth::getInstance()->getIdentity()->appaccount_id;
            $audit->log(Agana_AuditTrail_Abstract::EVENT_TYPE_UPDATE, $audit->getTrackTable(), $oldValues, $newValues, $who);
        } catch (Exception $e) {
            throw new Agana_Exception($e->getMessage(), 0, $e);
        }
    }

    /**
     * Insert or update object
     * 
     * @param Agana_Model_Object
     */
    public function save($object = null, $forceInsert = false) {
        if ($object != null) {
            try {
                if ($this->useTransaction()) {
                    $this->getAdapter()->beginTransaction();
                }

                if ($forceInsert) {
                    $res = $this->_insert($object);
                } else {
                    // Calls update metthod if the id id > 0 else calls insert
                    if ($object->getId() > 0) {
                        //return $this->_update($object);

                        if ($this->_trackUpdateAuditTrail) {
                            $this->_saveAuditTrail($object, Agana_AuditTrail_Abstract::EVENT_TYPE_UPDATE);
                        }

                        $where = $this->getAdapter()->quoteInto($this->_primary . ' = ?', $object->getId());
                        $res = $this->update($this->_prepareUpdateData($object), $where);
                    } else {
                        $res = $this->_insert($object);
                    }
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
            throw new Agana_Exception('Cannont persist a null object');
        }
    }

    /**
     * Search a persisted objectidentity in database
     * @param int $id
     * @return Agana_Model
     */
    public function get($id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->where($this->_primary . ' = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql), false);
    }

    /**
     * Execute an sql query to return all records in a table or view
     * Possible params:
     * from         : the table or view from where the query is executed
     * orderby      : the field name to order by tye result
     * appaccount_id: the id of app account (tenant) associated with the records
     * 
     * @param Array $params The array with params to be used in 
     * @return stdClass
     */
    public function getAll($params = null) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select();

        if (isset($params['from'])) {
            $sql->from($params['from']);
        } else {
            $sql->from($this->_name);
        }

        $sql = $this->handleOrderByParam($params, $sql);
        
        if (isset($params['status'])) {
            $sql->where('status = ?', $params['status']);
        }

        if (isset($params['appaccount_id'])) {
            $sql->where('appaccount_id = ?', $params['appaccount_id']);
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        return $this->_prepareReturnData($db->fetchAll($sql));
    }

    public function getAllChildrenTasks($params = null) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select();

        if (isset($params['from'])) {
            $sql->from($params['from']);
        } else {
            $sql->from($this->_name);
        }

        $sql = $this->handleOrderByParam($params, $sql);

        $sql->where('parent_id is not null');

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        return $this->_prepareReturnData($db->fetchAll($sql));
    }

    public function getByName($name, $params = null) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->where('name = ?', $name);

        if (isset($params['appaccount_id'])) {
            $sql->where('appaccount_id = ?', $params['appaccount_id']);
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql));
    }

    /**
     * Delete the record by its id
     * 
     * @param int $id 
     */
    public function delete($id) {
        try {
            if ($this->useTransaction()) {
                $this->getAdapter()->beginTransaction();
            }

            $tmp = $this->get($id);
            //$objid = $tmp->objid;

            $where = $this->getAdapter()->quoteInto($this->_primary . ' = ?', $id);

            $r = parent::delete($where);
//            $do = new Agana_Domain_Object();
//            $o = $do->getById($objid);
//            $do->setObject($o);
//            $do->delete();

            if ($this->useTransaction()) {
                $this->getAdapter()->commit();
            }
            return;
        } catch (Exception $pdoe) {
            if ($this->useTransaction()) {
                $this->getAdapter()->rollBack();
            }
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
     * 
     * @param array $paramArray
     * @param Zend_Db_Adapter_Abstract  $sql
     */
    public function handleOrderByParam($paramsArray, $sql) {
         if (isset($paramsArray['orderby'])) {
            if (is_array($paramsArray['orderby'])) {
                foreach ($paramsArray['orderby'] as $order) {
                    $sql->order($order);
                }
            } else {
                $sql->order($paramsArray['orderby']);
            }
        }
        
        return $sql;
    }
}