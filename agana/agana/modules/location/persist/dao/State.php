<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Location_Persist_Dao_State extends Agana_Persist_Dao_Abstract implements Location_Persist_Interface_State {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'state';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'state_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Location_Model_State';
    
    /**
     * Prepare data for insert
     * 
     * @param Location_Model_State
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'name' => $data->getName(),
            'abbreviation' => $data->getAbbreviation(),
            'country_id' => $data->getCountry()->getId(),
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Location_Model_State
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'abbreviation' => $data->getAbbreviation(),
            'country_id' => $data->getCountry()->getId(),
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Location_Model_State
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }


}
