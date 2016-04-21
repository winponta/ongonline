<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Project_Persist_Dao_Project extends Agana_Persist_Dao_Abstract implements Project_Persist_Interface_Project {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'project';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'project_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Project_Model_Project';
    
    /**
     * Prepare data for insert
     * 
     * @param Project_Model_Project
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['appaccount_id'] = $data->getAppaccount_id();
        $dataPrepared['id'] = $data->getId();

        return $dataPrepared;        

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Project_Model_Project
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataPrepared = $data->toArray();

        $dataPrepared['startdateexpected'] = ($dataPrepared['startdateexpected']) ? Agana_Util_DateTime::dateToYYMMDD($dataPrepared['startdateexpected']) : null;
        $dataPrepared['finishdateexpected'] = ($dataPrepared['finishdateexpected']) ? Agana_Util_DateTime::dateToYYMMDD($dataPrepared['finishdateexpected']) : null;
        $dataPrepared['startdatereal'] = ($dataPrepared['startdatereal']) ? Agana_Util_DateTime::dateToYYMMDD($dataPrepared['startdatereal']) : null;
        $dataPrepared['finishdatereal'] = ($dataPrepared['finishdatereal']) ? Agana_Util_DateTime::dateToYYMMDD($dataPrepared['finishdatereal']) : null;
        unset($dataPrepared['appaccount_id']);
        unset($dataPrepared['id']);

        return $dataPrepared;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Project_Model_Project
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    public function searchByName($term, $appaccountId, $orderby) {
        
    }


}