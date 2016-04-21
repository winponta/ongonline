<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Location_Persist_Dao_CityRegion extends Agana_Persist_Dao_Abstract implements Location_Persist_Interface_CityRegion {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'city_region';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'city_region_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Location_Model_CityRegion';
    
    /**
     * Prepare data for insert
     * 
     * @param Location_Model_CityRegion
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'name' => $data->getName(),
            'city_id' => $data->getCity()->getId(),
            'parent_id' => ($data->getParent_id()) ? $data->getParent_id() : null,
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Location_Model_CityRegion
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'city_id' => ($data->getCity()) ? $data->getCity()->getId() : null,
            'parent_id' => ($data->getParent()) ? $data->getParent()->getId() : null,
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Location_Model_CityRegion
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }


}

