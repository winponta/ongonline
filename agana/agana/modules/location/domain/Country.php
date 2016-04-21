<?php

class Location_Domain_Country {

    /**
     *
     * @var Location_Model_Country
     */
    protected $_country = null;

    public function __construct($countryModel = null) {
        if (is_null($countryModel)) {
            $countryModel = new Location_Model_Country();
        }
        $this->setCountry($countryModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Location_Persist_Dao_Country();
            $r = $u->getAll(array('orderby' => $orderby));
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Location_Model_Country
     */
    public function getCountry() {
        return $this->_country;
    }

    /**
     * @param Location_Model_Country 
     */
    public function setCountry($country) {
        if (!($country instanceof Location_Model_Country) && !is_null($country)) {
            $country = new Location_Model_Country($country);
        }
        $this->_country = $country;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_country, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_Country();
                return $u->save($this->_country);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_Country();
                return $u->save($this->_country);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_Country();
                return $u->delete($this->_country->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Location_Persist_Dao_Country();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Location_Persist_Dao_Country();
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

