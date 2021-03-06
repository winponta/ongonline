<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Assistance_Persist_Dao_Event extends Agana_Persist_Dao_Abstract implements Assistance_Persist_Interface_Activity {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'evento_assistencia';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'evento_assistencia_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Assistance_Model_Event';

    /**
     * Prepare data for insert
     * 
     * @param Assistance_Model_Event
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
     * @param Assistance_Model_Event
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        
        $data = array(
            'event_date' => Agana_Util_DateTime::dateToYYMMDD($data->getEvent_date()),
            'task_type_id' => $data->getTask_type_id(),
            'project_id' => $data->getProject_id(),
                //'birthdate' => ($data->getBirthdate()) ? Agana_Util_DateTime::dateToYYMMDD($data->getBirthdate()) : null,
        );

        unset($data['appaccount_id']);
        
        return $data;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Assistance_Model_Event
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    /**
     * Return total count of actitvities of one event
     * 
     * @param int $event_id
     * @return int Count
     */
    public function countActivities($event_id) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('atividade_assistencia', array('total' => 'COUNT(*)'))
                ->where('event_id = ?', $event_id);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return $r[0]['total'];
    }

    /**
     * Retorna as atividades de um evento
     * 
     * @param int $event_id
     * @return array Assistance_Model_Activity
     * @throws Exception
     */
    public function getActivities($event_id, $params = null) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('atividade_assistencia')
                ->where('event_id = ?', $event_id);
        
        $sql = $this->handleOrderByParam($params, $sql);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        
        return $db->fetchAll($sql);
    }

    public function getAll($appaccount_id = 0, $orderby = 'event_date desc', $returnPaginator = true, $params = array()) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
            ->from(array('ea' => 'evento_assistencia'))
            ->join(array('at' => 'atividade_assistencia'), 'at.event_id = ea.id')
            ->join(array('ph' => 'person'), 'at.person_helped_id = ph.id')
            ->where('ph.appaccount_id = ?', $appaccount_id)
            ->order($orderby);

        if (isset($params['filter-keyword'])) {
            $filter = new Agana_Filter_Normalize();
            $sql->where('lower(unaccented(description)) LIKE ?', '%' . $filter->filter($params['filter-keyword']) . '%');
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        if ($returnPaginator) {
            $adapter = new Zend_Paginator_Adapter_DbSelect($sql);
            $paginator = new Zend_Paginator($adapter);

            $page = (isset($params['page'])) ? $params['page'] : 1;
            $paginator->setCurrentPageNumber($page);

            $itemCountPerPage = (isset($params['itemCountPerPage'])) ? $params['itemCountPerPage'] : 20;
            $paginator->setItemCountPerPage($itemCountPerPage);

            $pageRange = (isset($params['pageRange'])) ? $params['pageRange'] : 7;
            $paginator->setPageRange($pageRange);

            return $paginator;
        } else {
            return $this->_prepareReturnData($db->fetchAll($sql));
        }
    }
}
