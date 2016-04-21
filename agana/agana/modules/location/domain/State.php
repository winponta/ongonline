<?php

class Location_Domain_State {

    /**
     *
     * @var Location_Model_State
     */
    protected $_state = null;

    public function __construct($stateModel = null) {
        if (is_null($stateModel)) {
            $stateModel = new Location_Model_State();
        }
        $this->setState($stateModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Location_Persist_Dao_State();
            $r = $u->getAll(array('orderby'=>$orderby));
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Location_Model_State
     */
    public function getState() {
        return $this->_state;
    }

    /**
     * @param Location_Model_State 
     */
    public function setState($state) {
        if (!($state instanceof Location_Model_State) && !is_null($state)) {
            $state = new Location_Model_State($state);
        }
        $this->_state = $state;
    }

    public function populate($data) {
        if (isset($data['id'])) {
            $this->_state->setId($data['id']);
        }
        $this->_state->setName($data['name']);
        $this->_state->setAbbreviation($data['abbreviation']);

        if (isset($data['country_id'])) {
            $dc = new Location_Domain_Country();
            $c = $dc->getById($data['country_id']);
            $this->_state->setCountry($c);
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_State();
                return $u->save($this->_state);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_State();
                return $u->save($this->_state);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_State();
                return $u->delete($this->_state->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Location_Persist_Dao_State();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Location_Persist_Dao_State();
            return $u->getByName($name);
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

}

