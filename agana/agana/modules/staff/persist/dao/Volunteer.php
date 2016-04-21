<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Staff_Persist_Dao_Volunteer extends Agana_Persist_Dao_Abstract implements Staff_Persist_Interface_Volunteer {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'volunteer';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Staff_Model_Volunteer';

    /**
     * Prepare data for insert
     * 
     * @param Staff_Model_Volunteer
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
     * @param Staff_Model_Volunteer
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataprepared = array(
        );

        return $dataprepared;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Staff_Model_Volunteer
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    public function getAll($params = null) {
        $params['from'] = 'v_Volunteer';
        return parent::getAll($params);
    }

    public function getExpertiseAreas($id) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select();

        $sql->from('volunteer_expertise_area');
        $sql->where('volunteer_id = ?', $id);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $res = $db->fetchAll($sql);
        $areas = array();
        $expdomain = new Staff_Domain_Expertisearea();
        foreach ($res as $exp) {
            $areas[] = $expdomain->getById($exp['expertise_area_id']);
        }
        return $areas;
    }

    public function save($model = null, $forceInsert = false) {
        $this->getAdapter()->beginTransaction();

        $this->setUseTransaction(false);

        if ($forceInsert) {
            parent::save($model, $forceInsert);
        } else {
            $sql = 'DELETE FROM volunteer_expertise_area WHERE volunteer_id=?';

            unset($params);
            $params[] = $model->id;

            $smtp = $this->getDefaultAdapter()->prepare($sql);
            $smtp->execute($params);
        }

        foreach ($model->expertise_areas_id as $key => $exp) {
            $sql = 'INSERT INTO volunteer_expertise_area (volunteer_id, expertise_area_id) VALUES(?,?)';

            unset($params);
            $params[] = $model->id;
            $params[] = $exp;

            $smtp = $this->getDefaultAdapter()->prepare($sql);
            $smtp->execute($params);
        }

        $this->getDefaultAdapter()->commit();
    }

}

