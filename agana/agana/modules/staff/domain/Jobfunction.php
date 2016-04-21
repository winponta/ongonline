<?php

class Staff_Domain_Jobfunction {

    /**
     *
     * @var Staff_Model_Jobfunction
     */
    protected $_function = null;

    public function __construct($functionModel = null) {
        if (is_null($functionModel)) {
            $functionModel = new Staff_Model_Jobfunction();
        }
        $this->setJobFunction($functionModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Staff_Persist_Dao_Jobfunction();
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
     * @return Staff_Model_Jobfunction
     */
    public function getJobFunction() {
        return $this->_function;
    }

    /**
     * @param Staff_Model_Jobfunction
     */
    public function setJobFunction($function) {
        if (!($function instanceof Staff_Model_Jobfunction) && !is_null($function)) {
            $function = new Staff_Model_Jobfunction($function);
        }
        $this->_function = $function;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_function, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Jobfunction();
                $this->_function->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                return $u->save($this->_function);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Jobfunction();
                return $u->save($this->_function);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Jobfunction();
                return $u->delete($this->_function->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Staff_Persist_Dao_Jobfunction();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Staff_Persist_Dao_Jobfunction();
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

