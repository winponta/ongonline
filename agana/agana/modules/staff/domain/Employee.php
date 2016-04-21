<?php

class Staff_Domain_Employee {

    /**
     *
     * @var Staff_Model_Employee
     */
    protected $_employee = null;

    public function __construct($employeeModel = null) {
        if (is_null($employeeModel)) {
            $employeeModel = new Staff_Model_Employee();
        }
        $this->setEmployee($employeeModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Staff_Persist_Dao_Employee();
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
     * @return Staff_Model_Employee
     */
    public function getEmployee() {
        return $this->_employee;
    }

    /**
     * @param Staff_Model_Employee
     */
    public function setEmployee($employee) {
        if (!($employee instanceof Staff_Model_Employee) && !is_null($employee)) {
            $employee = new Staff_Model_Employee($employee);
        }
        $this->_employee = $employee;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_employee, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Employee();
                return $u->save($this->_employee, true);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Employee();
                return $u->save($this->_employee);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Staff_Persist_Dao_Employee();
                return $u->delete($this->_employee->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Staff_Persist_Dao_Employee();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Staff_Persist_Dao_Employee();
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

