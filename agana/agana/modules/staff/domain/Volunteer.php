<?php

class Staff_Domain_Volunteer {

    /**
     *
     * @var Staff_Model_Volunteer
     */
    protected $_volunteer = null;

    public function __construct($volunteerModel = null) {
        if (is_null($volunteerModel)) {
            $volunteerModel = new Staff_Model_Volunteer();
        }
        $this->setVolunteer($volunteerModel);
    }

    public static function isControllerEnabled($options = null) {
        if ($options === null)  {
            $boot = Agana_Util_Bootstrap::getBootstrap('staff');
            $boot = $boot->getOptions();
        } else {
            $boot = $options;
        }

        if (isset($boot['module']['controller']['volunteer']['enabled'])) {
            return $boot['module']['controller']['volunteer']['enabled'];
        } else {
            return true;
        }
    }

    public function getAll($orderby = '') {
        try {
            $u = new Staff_Persist_Dao_Volunteer();
            $r = $u->getAll(array(
                'orderby' => $orderby,
                'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                    ));
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getExpertiseAreas($id) {
        try {
            $u = new Staff_Persist_Dao_Volunteer();
            $r = $u->getExpertiseAreas($id);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Staff_Model_Volunteer
     */
    public function getVolunteer() {
        return $this->_volunteer;
    }

    /**
     * @param Staff_Model_Volunteer
     */
    public function setVolunteer($volunteer) {
        if (!($volunteer instanceof Staff_Model_Volunteer) && !is_null($volunteer)) {
            $volunteer = new Staff_Model_Volunteer($volunteer);
        }
        $this->_volunteer = $volunteer;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_volunteer, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Volunteer();
                return $u->save($this->_volunteer, true);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Volunteer();
                return $u->save($this->_volunteer);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Volunteer();
                return $u->delete($this->_volunteer->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Staff_Persist_Dao_Volunteer();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Staff_Persist_Dao_Volunteer();
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

