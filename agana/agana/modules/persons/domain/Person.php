<?php

/**
 * Business domain class for Person individual in app
 * 
 * @author Ademir Mazer Jr <ademir@winponta.com.br>
 * @copyright (c) 2013, Winponta Software <http://www.winponta.com.br>
 */
class Persons_Domain_Person {

    /**
     *
     * @var Person_Model_Person
     */
    protected $_person = null;

    public function __construct($personModel = null) {
        if (is_null($personModel)) {
            $personModel = new Persons_Model_Person();
        }
        $this->setPerson($personModel);
    }

    /**
     * Returns an array registered as Person-Dependency-Domain or empty array
     * to control the dependencies of persons and other modules
     * 
     * @return array
     */
    public static function getDepencyDomain() {
        if (Zend_Registry::isRegistered('Person-Dependency-Domain')) {
            $p = Zend_Registry::get('Person-Dependency-Domain');
        } else {
            $p = array();
        }
        
        return $p;
    }
       
    /**
     * Returns all the persons persisted in database for a tenant based on 
     * appaccount_id
     * 
     * @param int $appaccount_id
     * @param String $orderby
     * @param boolean $paginator
     * @param array $params
     * @return array<Persons_Model_Person>
     * @throws Exception
     */
    public function getAll($appaccount_id, $orderby = 'name', $paginator = true, $params = array()) {
        try {
            $u = new Persons_Persist_Dao_Person();
            $r = $u->getAll($appaccount_id, $orderby, $paginator, $params);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchByName($term, $appaccount_id, $orderby = 'name') {
        try {
            $u = new Persons_Persist_Dao_Person();
            $r = $u->searchByName($term, $appaccount_id, $orderby);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Person_Model_Person
     */
    public function getPerson() {
        return $this->_person;
    }

    /**
     * @param Person_Model_Person 
     */
    public function setPerson($person) {
        if (!($person instanceof Persons_Model_Person) && !is_null($person)) {
            $person = new Persons_Model_Person($person);
        }
        $this->_person = $person;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_person, $data);
    }

    public function createInstall() {
        try {
            $u = new Persons_Persist_Dao_Person();
            $u->setUseTransaction(false);
            return $u->save($this->_person);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function create($useTransaction = true) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_Person();
                $this->_person->setAppaccount_id(Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                $u->setUseTransaction($useTransaction);
                return $u->save($this->_person);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_Person();
                return $u->save($this->_person);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function createImageRelation() {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_Person();
                $m = $u->createImageRelation($this->_person);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_Person();
                return $u->delete($this->_type->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     *
     * @param integer $id
     * @return Persons_Model_Person
     * @throws Exception 
     */
    public function getById($id) {
        if (!is_null($id)) {
            try {
                $u = new Persons_Persist_Dao_Person();
                return $u->get($id);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return null;
        }
    }

    public function getByName($name) {
        try {
            $u = new Persons_Persist_Dao_Person();
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

    public function getAnniversaries(Zend_Date $date = null) {
        $date = ($date) ? $date : new Zend_Date();

        try {
            $dao = new Persons_Persist_Dao_Person();
            return $dao->getAnniversaries(
                            Zend_Auth::getInstance()->getIdentity()->appaccount_id, $date
            );
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    /**
     * Search persons by similarity in theirs names
     * 
     * @param string $name
     * @return array
     * @throws Exception
     */
    public function searchBySimilarity($name) {
        try {
            $u = new Persons_Persist_Dao_Person();
            $res =  $u->searchBySimilarity(
                    Zend_Auth::getInstance()->getIdentity()->appaccount_id, 
                    $name
                    );
            return $res;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}

