<?php

class Assistance_Domain_Activity {

    /**
     *
     * @var Assistance_Model_Activity
     */
    protected $_activity = null;

    public function __construct($actModel = null) {
        if (is_null($actModel)) {
            $actModel = new Assistance_Model_Activity();
        }
        $this->setActivity($actModel);
    }

    public function getAll($orderby = 'assistance_date, assistance_time') {
        try {
            $u = new Assistance_Persist_Dao_Activity();
            $r = $u->getAll(array(
                'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                'orderby'       => $orderby
            ));
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllByPersonHelped($id, $orderby = array('assistance_date', 'assistance_time')) {
        try {
            $u = new Assistance_Persist_Dao_Activity();
            $r = $u->getAllByPersonHelped(
                $id,
                Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                $orderby
              );
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Assistance_Model_Activity
     */
    public function getActivity() {
        return $this->_activity;
    }

    /**
     * @param Assistance_Model_Activity
     */
    public function setActivity($activity) {
        if (!($activity instanceof Assistance_Model_Activity) && !is_null($activity)) {
            $activity = new Assistance_Model_Activity($activity);
        }
        $this->_activity = $activity;
    }

    public function populate($data) {
        $this->_activity = new Assistance_Model_Activity($data);
        
        if (isset($data['id'])) {
            $this->_activity->setId($data['id']);
        }
        if (isset($data['project_id']) && !empty($data['project_id'])) {
            $this->_activity->setProject_id = $data['project_id'];
            
            $dc = new Project_Domain_Project();
            $c = $dc->getById($data['project_id']);
            $this->_activity->setProject($c);
        } else {
            $this->_activity->setProject_id(null);
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Assistance_Persist_Dao_Activity();
                $this->_activity->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                return $u->save($this->_activity);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Assistance_Persist_Dao_Activity();
                return $u->save($this->_activity);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Assistance_Persist_Dao_Activity();
                return $u->delete($this->_activity->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Assistance_Persist_Dao_Activity();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function _isAllowed() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Agana_Exception('You don not have permission to access this');
        } else {
            return true;
        }
    }

    /**
     * Returns an array with all assistances activities grouped by project
     * or only from the project id passed by parameter
     */
    public function getActivitiesByProject($appaccount_id, $params = null) {
        try {
            $acdao = new Assistance_Persist_Dao_Activity();

            $r = $acdao->getActivitiesByProject($appaccount_id, $params);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $ex) {
            throw new Agana_Exception($ex->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
        }
    }


}

