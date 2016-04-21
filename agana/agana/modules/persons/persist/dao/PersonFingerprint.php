<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Persons_Persist_Dao_PersonFingerprint extends Agana_Persist_Dao_Abstract implements Persons_Persist_Interface_PersonHelped {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'fingerprint';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'person_id';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Persons_Model_PersonFingerprint';

    /**
     * Prepare data for insert
     * 
     * @param Persons_Model_PersonFingerprint
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        return $dataPrepared;
    }

    /**
     * Prepare data for update 
     * 
     * @param Persons_Model_PersonFingerprint
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataPrepared = $data->toArray();

        return $dataPrepared;
    }

    /**
     * @return array Persons_Model_PersonFingerprint
     */
    public function get($person_id) {

        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from($this->_name)
                ->where('person_id = ?', $person_id)
                ->order('finger_number');

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $res = $this->_prepareReturnData($db->fetchAll($sql));

        if (is_null($res))
            $res = array();

        return $res;
    }

    /**
     * @return array Persons_Model_PersonFingerprint
     */
    public function getByIdFinger($person_id, $finger) {

        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from($this->_name)
                ->where('person_id = ?', $person_id)
                ->where('finger_number = ?', $finger);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $res = $this->_prepareReturnData($db->fetchAll($sql));

        if (is_null($res))
            $res = array();

        return $res;
    }

    public function deleteByIdFinger($id, $finger) {
        try {
            $where = $this->getAdapter()->quoteInto('person_id = ?', $id);
            $where .= ' AND ' . $this->getAdapter()->quoteInto('finger_number = ?', $finger);

            $r = $this->getAdapter()->delete('fingerprint', $where);

            return;
        } catch (Exception $pdoe) {
            throw new Agana_Exception($pdoe->getMessage());
        }

    }

}
