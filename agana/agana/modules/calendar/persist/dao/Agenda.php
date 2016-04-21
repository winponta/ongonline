<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 * @copyright (c) 2013, Winponta Software
 */
class Calendar_Persist_Dao_Agenda extends Agana_Persist_Dao_Abstract implements Agana_Calendar_Persist_Interface_Agenda {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'agenda';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'agenda_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Agana_Calendar_Model_Agenda';

    /**
     * Prepare data for insert
     * 
     * @param Agana_Calendar_Model_Agenda
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        return $dataPrepared;
    }

    /**
     * Prepare data for update 
     * 
     * @param Agana_Calendar_Model_Agenda
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataPrepared = array(
            'name' => $data->getName(),
            'module_id' => $data->getModule_id(),
            'system' => $data->getSystem(),
            'person_id' => $data->getPerson_id(),
            'color' => $data->getColor(),
        );

        return $dataPrepared;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Agana_Calendar_Model_Agenda
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    public function getByPerson($person_id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->where('person_id = ?', $person_id)
                ->order('name');
        
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        
        $returnArray = (isset($params['returnArray'])) ? $params['returnArray'] : false;
        return $this->_prepareReturnData($db->fetchRow($sql), $returnArray);
    }

    /**
     * 
     * @param array $params <br>
     *          $orderby String : The name of column to order the query. Empty string is the default <br>
     * @return stdClass
     */
    public function getAll($params = null) {
        //, $excludeHead = false, $appaccount_id) {
        
        $orderby = (isset($params['orderby'])) ? $params['orderby'] : '';
        
        try {
            $db = $this->getDefaultAdapter();
            $sql = $db->select()
                    ->from($this->_name)
                    ->order($orderby);

            $db->setFetchMode(Zend_DB::FETCH_ASSOC);

            return $this->_prepareReturnData($db->fetchAll($sql));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByModule($module_id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->where('module_id = ?', $module_id)
                ->order('name');
        
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        
        $returnArray = (isset($params['returnArray'])) ? $params['returnArray'] : false;
        return $this->_prepareReturnData($db->fetchRow($sql), $returnArray);        
    }

}
