<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Staff_Persist_Dao_Jobfunction extends Agana_Persist_Dao_Abstract implements Staff_Persist_Interface_Jobfunction {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'job_function';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'job_function_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Staff_Model_Jobfunction';
    
    /**
     * Prepare data for insert
     * 
     * @param Staff_Model_Jobfunction
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
     * @param Staff_Model_Jobfunction
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
     * @return Staff_Model_Jobfunction
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }
    
}

