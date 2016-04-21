<?php

class Staff_Domain_Expertisearea {

    /**
     *
     * @var Staff_Model_Expertisearea
     */
    protected $_expertise = null;

    public function __construct($expertiseModel = null) {
        if (is_null($expertiseModel)) {
            $expertiseModel = new Staff_Model_Expertisearea();
        }
        $this->setExpertiseArea($expertiseModel);
    }

    public static function isControllerEnabled($options = null) {
        if ($options === null)  {
            $boot = Agana_Util_Bootstrap::getBootstrap('staff');
            $boot = $boot->getOptions();
        } else {
            $boot = $options;
        }

        if (isset($boot['module']['controller']['expertisearea']['enabled'])) {
            return $boot['module']['controller']['expertisearea']['enabled'];
        } else {
            return true;
        }
    }

    public function getAll($orderby = '') {
        try {
            $u = new Staff_Persist_Dao_Expertisearea();
            $r = $u->getAll(array(
                'orderby'=>$orderby,
                'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                ));
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Staff_Model_Expertisearea
     */
    public function getExpertiseArea() {
        return $this->_expertise;
    }

    /**
     * @param Staff_Model_Expertisearea
     */
    public function setExpertiseArea($expertise) {
        if (!($expertise instanceof Staff_Model_Expertisearea) && !is_null($expertise)) {
            $expertise = new Staff_Model_Expertisearea($expertise);
        }
        $this->_expertise = $expertise;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_expertise, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Expertisearea();
                $this->_expertise->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                return $u->save($this->_expertise);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Expertisearea();
                return $u->save($this->_expertise);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Expertisearea();
                return $u->delete($this->_expertise->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Staff_Persist_Dao_Expertisearea();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Staff_Persist_Dao_Expertisearea();
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

