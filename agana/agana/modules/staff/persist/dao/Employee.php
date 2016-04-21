<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Staff_Persist_Dao_Employee extends Agana_Persist_Dao_Abstract implements Staff_Persist_Interface_Employee {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'employee';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Staff_Model_Employee';
    
    /**
     * Prepare data for insert
     * 
     * @param Staff_Model_Employee
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['id'] = $data->getId();

        return $dataPrepared;

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Staff_Model_Jobfunction
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataprepared = array(
            'registration_number' => $data->getRegistration_number(),
            'busunit_id' => $data->getBusunit_id(),
            'job_function_id' => $data->getJob_function_id(),
        );
        
        return $dataprepared;
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

    public function getByBusunit($buid) {
        
    }


    public function getAll($params = null) {
        $params['from'] = 'v_Employee';
        return parent::getAll($params);
    }
}

