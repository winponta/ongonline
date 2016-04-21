<?php

/**
 * Description of Object_Interface
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Agana_Persist_Dao_Object extends Zend_Db_Table_Abstract implements Agana_Persist_Interface_Object {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'objectidentity';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'objid';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'objectidentity_objid_seq';
    
    /**
     * Insert or update object
     * 
     * @param Agana_Model_Object
     */
    public function save($object = null) {
        if ($object != null) {
            try {
                if ($object->getId() > 0) {
                    //return $this->_update($object);
                    $where = $this->getAdapter()->quoteInto('objid = ?', $object->getId());
                    return $this->update($this->_preparePersistData($object), $where);
                } else {
                    //return $this->_insert($object);
                    return $this->insert($this->_preparePersistData($object));
                }
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Agana_Exception('Cannont persist a null object');
        }
    }

//    private function _insert($object) {
//        if ($object != null) {
//            try {
//
//                return Zend_Db_Table::getDefaultAdapter()
//                                ->insert('objectidentity', $this->_preparePersistData($object));
//            } catch (Exception $pdoe) {
//                throw new Agana_Exception($pdoe->getMessage());
//            }
//        }
//    }

    /**
     * Update object data
     * @param Agana_Model_Object
     */
//    private function _update($object) {
//        if ($object != null) {
//            try {
//                $where = $this->getAdapter()->quoteInto('objid = ?', $object->getId());
//                return $this->getAdapter()
//                                ->update('objectidentity', $this->_preparePersistData($object), $where);
//            } catch (Exception $pdoe) {
//                throw new Agana_Exception($pdoe->getMessage());
//            }
//        }
//    }

    /**
     * Search a persisted objectidentity in database
     * @param int $id
     * @return Agana_Model_Object
     */
    public function get($id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $db->select()
                ->from('objectidentity')
                ->where('objid = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql));
    }

    /**
     * Prepare data for return from a persistent search
     *
     * @param array
     * @return Agana_Model_Object
     */
    private function _prepareReturnData($data) {
        $o = new Agana_Model_Object($data);
        $o->setId($data['objid']);
        $o->setTableName($data['tablename']);
        return $o;
    }

    /**
     * Prepare data for persist
     * 
     * @param Agana_Model_Object
     * @return Array 
     */
    private function _preparePersistData($obj) {
        $data = array(
            //'objid' => $obj->getId(), It's not necessary because should be an autoincrement in database
            'tablename' => $obj->getTableName(),
        );

        return $data;
    }

    /**
     * Delete the object record by its object id
     * 
     * @param int $id 
     */
    public function delete($id) {
        try {
            $where = $this->getAdapter()->quoteInto('objid = ?', $id);
            return $this->getAdapter()
                            ->delete('objectidentity', $where);
        } catch (Exception $pdoe) {
            throw new Agana_Exception($pdoe->getMessage());
        }
    }

}

?>
