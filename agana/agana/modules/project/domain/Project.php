<?php

class Project_Domain_Project {
    const REPORT_GROUP_ID       = 'Project';
    const REPORT_GROUP_LABEL    = 'Projects';

    /**
     *
     * @var Project_Model_Project
     */
    protected $_project = null;

    public function __construct($projectModel = null) {
        if (is_null($projectModel)) {
            $projectModel = new Project_Model_Project();
        }
        $this->setProject($projectModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new Project_Persist_Dao_Project();
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

    public function getByStatus($status = Project_Model_Project::PROJECT_STATUS_ACTIVE_ID, $orderby='name') {
        try {
            $u = new Project_Persist_Dao_Project();
            $r = $u->getAll(array(
                'status'=> $status,
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
     * @return Project_Model_Project
     */
    public function getProject() {
        return $this->_project;
    }

    /**
     * @param Project_Model_Project
     */
    public function setProject($project) {
        if (!($project instanceof Project_Model_Project) && !is_null($project)) {
            $project = new Project_Model_Project($project);
        }
        $this->_project = $project;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_project, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Project_Persist_Dao_Project();
                $this->_project->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                return $u->save($this->_project);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Project_Persist_Dao_Project();
                return $u->save($this->_project);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Project_Persist_Dao_Project();
                return $u->delete($this->_project->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Project_Persist_Dao_Project();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Project_Persist_Dao_Project();
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

