<?php

class Location_Domain_City {

    /**
     *
     * @var Location_Model_City
     */
    protected $_city = null;

    public function __construct($cityModel = null) {
        if (is_null($cityModel)) {
            $cityModel = new Location_Model_City();
        }
        $this->setCity($cityModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Location_Persist_Dao_City();
            $r = $u->getAll(array('orderby'=>$orderby));
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Location_Model_City
     */
    public function getCity() {
        return $this->_city;
    }

    /**
     * @param Location_Model_City
     */
    public function setCity($city) {
        if (!($city instanceof Location_Model_City) && !is_null($city)) {
            $city = new Location_Model_City($city);
        }
        $this->_city = $city;
    }

    public function populate($data) {
        if (isset($data['id'])) {
            $this->_city->setId($data['id']);
        }
        $this->_city->setName($data['name']);

        if (isset($data['state_id'])) {
            $dc = new Location_Domain_State();
            $c = $dc->getById($data['state_id']);
            $this->_city->setState($c);
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_City();
                return $u->save($this->_city);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_City();
                return $u->save($this->_city);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_City();
                return $u->delete($this->_city->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Location_Persist_Dao_City();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Location_Persist_Dao_City();
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

