<?php

class Location_Domain_CityRegion {

    /**
     *
     * @var Location_Model_CityRegion
     */
    protected $_region = null;

    public function __construct($regionModel = null) {
        if (is_null($regionModel)) {
            $regionModel = new Location_Model_CityRegion();
        }
        $this->setRegion($regionModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Location_Persist_Dao_CityRegion();
            $r = $u->getAll(array('orderby' => $orderby));
            return is_null($r) ? array() : $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Location_Model_CityRegion
     */
    public function getRegion() {
        return $this->_region;
    }

    /**
     * @param Location_Model_CityRegion
     */
    public function setRegion($region) {
        if (!($region instanceof Location_Model_CityRegion) && !is_null($region)) {
            $region = new Location_Model_CityRegion($region);
        }
        $this->_region = $region;
    }

    public function populate($data) {
        if (isset($data['id'])) {
            $this->_region->setId($data['id']);
        }
        $this->_region->setName($data['name']);

        if (isset($data['city_id'])) {
            $dc = new Location_Domain_City();
            $c = $dc->getById($data['city_id']);
            $this->_region->setCity($c);

            $this->_region->setCity_id($data['city_id']);
        }

        if (isset($data['parent_id'])) {
            if (is_numeric($data['parent_id'])) {
                $dc = new Location_Domain_CityRegion();
                $c = $dc->getById($data['parent_id']);
                $this->_region->setParent($c);

                $this->_region->setParent_id($data['parent_id']);
            }
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_CityRegion();
                return $u->save($this->_region);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_CityRegion();
                return $u->save($this->_region);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Location_Persist_Dao_CityRegion();
                return $u->delete($this->_region->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Location_Persist_Dao_CityRegion();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Location_Persist_Dao_CityRegion();
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

