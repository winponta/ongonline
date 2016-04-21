<?php

class Persons_Domain_PersonFingerprint {

    /**
     *
     * @var Person_Model_PersonFingerprint
     */
    protected $_personFingerprint = null;

    public function __construct($model = null) {
        if (is_null($model)) {
            $model = new Persons_Model_PersonFingerprint();
        }
        $this->setPersonFingerprint($model);
    }

    /**
     * @return Person_Model_PersonFingerprint
     */
    public function getPersonFingerprint() {
        return $this->_personFingerprint;
    }

    /**
     * @param Person_Model_PersonFingerprint
     */
    public function setPersonFingerprint($model) {
        if (!($model instanceof Persons_Model_PersonFingerprint) && !is_null($model)) {
            $model = new Persons_Model_PersonFingerprint($model);
        }
        $this->_personFingerprint = $model;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_personFingerprint, $data);
    }

    public function create($useTransaction = true) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonFingerprint();
                $u->setUseTransaction($useTransaction);
                return $u->save($this->_personFingerprint, TRUE);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonHelped();
                return $u->save($this->_personFingerprint);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     *
     * @param integer $id
     * @return Persons_Model_PersonDocs
     * @throws Exception 
     */
    public function getById($id) {
        if (!is_null($id)) {
            try {
                $u = new Persons_Persist_Dao_PersonFingerprint();
                return $u->get($id);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return null;
        }
    }

    /**
     * 
     * @param int $id person id
     * @param int $finger finger number
     * @return Persons_Model_PersonFingerprint
     * @throws Exception
     */
    public function getByIdFinger($id, $finger) {
        if (!is_null($id) && !is_null($finger)) {
            try {
                $u = new Persons_Persist_Dao_PersonFingerprint();
                return $u->getByIdFinger($id, $finger);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return null;
        }
    }

    /**
     * 
     * @param int $id person id
     * @param int $finger finger number
     * @return bool
     * @throws Exception
     */
    public function delete($id, $finger) {
        if (!is_null($id) && !is_null($finger)) {
            try {
                $u = new Persons_Persist_Dao_PersonFingerprint();
                return $u->deleteByIdFinger($id, $finger);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return null;
        }
    }

    private function _isAllowed() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Agana_Exception('You don not have permission to access this');
        } else {
            return true;
        }
    }

    public function getAll($person_id) {
        try {
            $u = new Persons_Persist_Dao_PersonFingerprint();

            $r = $u->get($person_id);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw new Agana_Exception($e->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
            ;
        }
    }

    /**
     * Returns the projects related to a person helped
     * 
     * @param int $id person helped id
     * @return Persons_Model_PersonHelpedProject
     * @throws Agana_Exception
     */
    public function getProjects($id) {
        try {
            $phdao = new Persons_Persist_Dao_PersonHelped();

            $r = $phdao->getProjectsByPerson($id);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw new Agana_Exception($e->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
            ;
        }
    }

    /**
     * Returns the total amount of projects related to a person helped
     * 
     * @param int $id person helped id
     * @return int
     * @throws Agana_Exception
     */
    public function getProjectsTotalCount($id) {
        try {
            $phdao = new Persons_Persist_Dao_PersonHelped();

            $r = $phdao->getProjectsTotalCountByPerson($id);
            return $r;
        } catch (Exception $e) {
            throw new Agana_Exception($e->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
        }
    }

    /**
     * Returns the total amount of social projects related to a person helped
     * 
     * @param int $id person helped id
     * @return int
     * @throws Agana_Exception
     */
    public function getSocialProjectsTotalCount($id) {
        try {
            $phdao = new Persons_Persist_Dao_PersonHelped();

            $r = $phdao->getSocialProjectsTotalCountByPerson($id);
            return $r;
        } catch (Exception $e) {
            throw new Agana_Exception($e->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
        }
    }

    /**
     * Returns an array with all persons associated to projects, grouped by project
     * or only from the project id passed by parameter
     */
    public function getPersonsByProject($appaccount_id, $projectId = null) {
        try {
            $phdao = new Persons_Persist_Dao_PersonHelped();

            $r = $phdao->getPersonsByProject($appaccount_id, $projectId);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $ex) {
            throw new Agana_Exception($ex->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
        }
    }

    /**
     * Returns the social projects related to a person helped
     * 
     * @param int $id person helped id
     * @return Persons_Model_PersonHelpedSocialProject
     * @throws Agana_Exception
     */
    public function getSocialProjects($id) {
        try {
            $phdao = new Persons_Persist_Dao_PersonHelped();

            $r = $phdao->getSocialProjectsByPerson($id);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw new Agana_Exception($e->getMessage(), Agana_Exception::EXCEPTION_APP_WARNING, $e);
            ;
        }
    }

    /**
     * Create a new relationship between federal social project and person helped
     * @param array $data Person_id, Pfs_id and number
     * @param type $useTransaction
     * @return true
     * @throws Exception
     */
    public function associateSocialProject($data, $useTransaction = true) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonHelped();
                $u->setUseTransaction($useTransaction);
                return $u->associateSocialProject($data);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

}
