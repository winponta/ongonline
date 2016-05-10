<?php

class Project_Domain_Tasktype {

    /**
     *
     * @var Project_Model_Tasktype
     */
    protected $_tasktype = null;

    public function __construct($tasktypeModel = null) {
        if (is_null($tasktypeModel)) {
            $tasktypeModel = new Project_Model_Tasktype();
        }
        $this->setTaskType($tasktypeModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Project_Persist_Dao_Tasktype();
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

    public function getAllChildrenTask($orderby = '') {
        try {
            $u = new Project_Persist_Dao_Tasktype();
            $r = $u->getAllChildrenTasks(array(
                'orderby'=>$orderby
            ));
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Project_Model_Tasktype
     */
    public function getTaskType() {
        return $this->_tasktype;
    }

    /**
     * @param Project_Model_Tasktype
     */
    public function setTaskType($tasktype) {
        if (!($tasktype instanceof Project_Model_Tasktype) && !is_null($tasktype)) {
            $tasktype = new Project_Model_Tasktype($tasktype);
        }
        $this->_tasktype = $tasktype;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_tasktype, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Project_Persist_Dao_Tasktype();
                $this->_tasktype->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                return $u->save($this->_tasktype);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Project_Persist_Dao_Tasktype();
                return $u->save($this->_tasktype);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Project_Persist_Dao_Tasktype();
                return $u->delete($this->_tasktype->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Project_Persist_Dao_Tasktype();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Project_Persist_Dao_Tasktype();
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

