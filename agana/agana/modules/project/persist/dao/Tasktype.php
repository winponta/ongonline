<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Project_Persist_Dao_Tasktype extends Agana_Persist_Dao_Abstract implements Project_Persist_Interface_Tasktype {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'task_type';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'task_type_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Project_Model_Tasktype';
    
    /**
     * Prepare data for insert
     * 
     * @param Project_Model_Tasktype
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'name' => $data->getName(),
            'description' => $data->getDescription(),
            'parent_id' => ($data->getParent_id()) ? $data->getParent_id() : null,
            'appaccount_id' => $data->getAppaccount_id(),
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Project_Model_Tasktype
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'description' => $data->getDescription(),
            'parent_id' => ($data->getParent_id()) ? $data->getParent_id() : null,
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Project_Model_Tasktype
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    public function searchByName($term, $appaccountId, $orderby) {
        
    }


}