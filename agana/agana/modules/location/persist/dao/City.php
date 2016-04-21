<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Location_Persist_Dao_City extends Agana_Persist_Dao_Abstract implements Location_Persist_Interface_City {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'city';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'city_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Location_Model_City';
    
    /**
     * Prepare data for insert
     * 
     * @param Location_Model_City
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'name' => $data->getName(),
            'state_id' => $data->getState()->getId(),
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Location_Model_City
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'state_id' => $data->getState()->getId(),
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Location_Model_City
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    public function getByState($state) {
        
    }


}
