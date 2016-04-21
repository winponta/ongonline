<?php

class Persons_Domain_PersonHelped {

    /**
     *
     * @var Person_Model_PersonHelped
     */
    protected $_personHelped = null;

    public function __construct($model = null) {
        if (is_null($model)) {
            $model = new Persons_Model_PersonHelped();
        }
        $this->setPersonHelped($model);
    }

    public static function isControllerEnabled($options = null) {
        if ($options === null) {
            $boot = Agana_Util_Bootstrap::getBootstrap('persons');
            $boot = $boot->getOptions();
        } else {
            $boot = $options;
        }

        if (isset($boot['module']['controller']['helped']['enabled'])) {
            return $boot['module']['controller']['helped']['enabled'];
        } else {
            return true;
        }
    }

    /**
     * @return Person_Model_PersonHelped
     */
    public function getPersonHelped() {
        return $this->_personHelped;
    }

    /**
     * @param Person_Model_PersonHelped
     */
    public function setPersonHelped($model) {
        if (!($model instanceof Persons_Model_PersonHelped) && !is_null($model)) {
            $model = new Persons_Model_PersonHelped($model);
        }
        $this->_personHelped = $model;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_personHelped, $data);
    }

    public function updateDateOut($data) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonHelped();
                return $u->updateDateOut($data);
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }

    /**
     * Create a new relationship between project and person helped
     * @param array $data Person_id, Project_id and date_in
     * @param type $useTransaction
     * @return true
     * @throws Exception
     */
    public function associateProject($data, $useTransaction = true) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonHelped();
                $u->setUseTransaction($useTransaction);
                return $u->associateProject($data);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function create($useTransaction = true) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonHelped();
                $u->setUseTransaction($useTransaction);
                return $u->save($this->_personHelped, TRUE);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonHelped();
                return $u->save($this->_personHelped);
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
                $u = new Persons_Persist_Dao_PersonHelped();
                return $u->get($id);
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

    /**
     * Returns all the helped persons persisted in database for a tenant based on 
     * appaccount_id
     * 
     * @param int $appaccount_id
     * @param String $orderby
     * @param boolean $paginator
     * @param array $params
     * @return array<Persons_Model_PersonHelped>
     * @throws Exception
     */
    public function getAll($appaccount_id, $orderby = 'name', $paginator = true, $params = array()) {
        try {
            $u = new Persons_Persist_Dao_PersonHelped();

            $params['from'] = 'v_person_helped';
            $params['appaccount_id'] = $appaccount_id;
            $params['orderby'] = $orderby;
            $params['paginator'] = $paginator;

            $r = $u->getAll($params);
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
    public function getPersonsByProject($appaccount_id, $params = null) {
        try {
            $phdao = new Persons_Persist_Dao_PersonHelped();

            $r = $phdao->getPersonsByProject($appaccount_id, $params);
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
