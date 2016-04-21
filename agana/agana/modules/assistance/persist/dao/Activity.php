<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Assistance_Persist_Dao_Activity extends Agana_Persist_Dao_Abstract implements Assistance_Persist_Interface_Activity {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'atividade_assistencia';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'atividade_assistencia_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Assistance_Model_Activity';

    /**
     * Prepare data for insert
     * 
     * @param Assistance_Model_Activity
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['appaccount_id'] = $data->getAppaccount_id();
        
        return $dataPrepared;
    }

    /**
     * Prepare data for update 
     * 
     * @param Assistance_Model_Activity
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'assistance_time' => $data->getAssistance_time(),
            'assistance_date' => Agana_Util_DateTime::dateToYYMMDD($data->getAssistance_date()),
            'description' => $data->getDescription(),
            'person_helped_id' => $data->getPerson_helped_id(),
            'person_performed_id' => $data->getPerson_performed_id(),
            'person_recorded_id' => $data->getPerson_recorded_id(),
            'event_id' => $data->getEvent_id(),
            'task_type_id' => $data->getTask_type_id(),
            'project_id' => $data->getProject_id(),
            'id_by_finger_key' => $data->getId_by_finger_key(),
                //'birthdate' => ($data->getBirthdate()) ? Agana_Util_DateTime::dateToYYMMDD($data->getBirthdate()) : null,
        );
        
        unset($data['appaccount_id']);
        
        return $data;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Assistance_Model_Activity
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    /**
     * Returns an array with all assistances for a person helped 
     */
    public function getAllByPersonHelped($id, $appaccount_id, $orderby) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()                
                ->from(array('at' => 'atividade_assistencia'))
                
                ->join(array('ph'=>'person'),
                        'at.person_helped_id = ph.id')
                ->order($orderby);

        $sql->where('person_helped_id = ?', $id);
        $sql->where('ph.appaccount_id = ?', $appaccount_id);
        
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return $r;
    }

    /**
     * Returns an array with all activities associated to projects, grouped by project
     * or only from the project id passed by parameter
     * <br/>
     * <p>Params:</p>
     * project_id
     * status =0,1,2,3,4
     */
    public function getActivitiesByProject($appaccount_id, $params = null) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from(array('proj' => 'project'), array('project_id' => 'id','project_name' => 'name',                    
                    'project_status' => 'status'))
                ->join(array('act' => 'atividade_assistencia'), 'act.project_id = proj.id', array('assistance_id' => 'id', 'assistance_date', 'assistance_time', 'id_by_finger_key'))
                ->join(array('task' => 'task_type'), 'act.task_type_id = task.id', array('task_id' => 'id', 'task_name' => 'name'))
                ->join(array('p' => 'person'), 'act.person_helped_id = p.id', array('person_id' => 'id', 'person_name' => 'name'))
                ->joinLeft(array('task_parent' => 'task_type'), 'task.parent_id = task_parent.id', array('task_parent_id' => 'id', 'task_parent_name' => 'name'))
                ->order(array('proj.name', 'task_parent.name', 'task.name', 'act.assistance_date','p.name'));

        $sql->where('proj.appaccount_id = ?', $appaccount_id);

        /**
         * TRATAMENTO DOS PARAMETROS 
         * */
        $projectId = isset($params['project_id']) ? $params['project_id'] : -1;
        if ((int) $projectId > 0) {
            $sql->where('project_id = ?', $projectId);
        }

        $status = isset($params['status']) ? $params['status'] : -1;
        if ((int) $status > 0) {
            $sql->where('status = ?', $status);
        }

        $dateFrom = isset($params['date_from']) ? $params['date_from'] : '';
        $dateTo = isset($params['date_to']) ? $params['date_to'] : '';

        if (trim($dateFrom) !== '') {
            if (Agana_Util_DateTime::validate($dateFrom)) {
                $sql->where('assistance_date >= ?', $dateFrom);
            } else {
                
            }
        }

        if (trim($dateTo) !== '') {
            if (Agana_Util_DateTime::validate($dateTo)) {
                $sql->where('assistance_date <= ?', $dateTo);
            }
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return $r;
    }

   }
