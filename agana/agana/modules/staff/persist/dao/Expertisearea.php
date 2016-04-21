<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Staff_Persist_Dao_Expertisearea extends Agana_Persist_Dao_Abstract implements Staff_Persist_Interface_Expertisearea {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'expertise_area';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'expertise_area_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Staff_Model_Expertisearea';
    
    /**
     * Prepare data for insert
     * 
     * @param Staff_Model_Expertisearea
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'name' => $data->getName(),
            'description' => $data->getDescription(),
            'appaccount_id' => $data->getAppaccount_id(),
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Staff_Model_Expertisearea
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'description' => $data->getDescription(),
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Staff_Model_Expertisearea
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }


}

