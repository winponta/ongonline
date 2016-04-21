<?php

class Assistance_Domain_Event {

    /**
     *
     * @var Assistance_Model_Event
     */
    protected $_event = null;

    public function __construct($actModel = null) {
        if (is_null($actModel)) {
            $actModel = new Assistance_Model_Event();
        }
        $this->setEvent($actModel);
    }

    public function getAll($orderby = 'event_date desc') {
        try {
            $u = new Assistance_Persist_Dao_Event();
            $r = $u->getAll(array(
                'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                'orderby' => $orderby
            ));
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Assistance_Model_Event
     */
    public function getEvent() {
        return $this->_event;
    }

    /**
     * @param Assistance_Model_Event
     */
    public function setEvent($ev) {
        if (!($ev instanceof Assistance_Model_Event) && !is_null($ev)) {
            $ev = new Assistance_Model_Event($ev);
        }
        $this->_event = $ev;
    }

    public function populate($data) {
        $this->_event = new Assistance_Model_Event($data);

        if (isset($data['id'])) {
            $this->_event->setId($data['id']);
        }
        if (isset($data['project_id']) && !empty($data['project_id'])) {
            $this->_event->setProject_id = $data['project_id'];

            $dc = new Project_Domain_Project();
            $c = $dc->getById($data['project_id']);
            $this->_event->setProject($c);
        } else {
            $this->_event->setProject_id(null);
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Assistance_Persist_Dao_Event();
                $this->_event->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                return $u->save($this->_event);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Assistance_Persist_Dao_Event();
                return $u->save($this->_event);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Assistance_Persist_Dao_Event();
                return $u->delete($this->_event->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Assistance_Persist_Dao_Event();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Return total count of actitvities of one event
     * 
     * @param int $event_id
     * @return int Count
     */
    public function countActivities($event_id) {
        try {
            $u = new Assistance_Persist_Dao_Event();
            return $u->countActivities($event_id);
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
     * Retorna as atividades de um evento
     * 
     * @param int $event_id
     * @return array Assistance_Model_Activity
     * @throws Exception
     */
    public function getActivities($event_id, $params = null) {
        try {
            $u = new Assistance_Persist_Dao_Event();
            return $u->getActivities($event_id, $params);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
