<?php

abstract class Busunit_Domain_Busunit {

    /**
     *
     * @var Busunit_Model_Busunit
     */
    protected $_busunit = null;

    /**
     * @return Busunit_Model_Busunit
     */
    abstract public function getBusunit();

    /**
     * @param Busunit_Model_Busunit
     */
    abstract public function setBusunit($unit);

    public function populate($data) {
        if (is_null($this->_busunit)) {
            $this->_busunit = new Busunit_Model_Busunit();
        }

        Agana_Data_BeanUtil::populate($this->_busunit, $data);

        if (isset($data['id'])) {
            $this->_busunit->setId($data['id']);
        }

        if (isset($data['city_id'])) {
            $dc = new Location_Domain_City();
            $c = $dc->getById($data['city_id']);
            $this->_busunit->setCity($c);
        }
    }

    protected function create($appaccount_id) {
        try {
            $dao = new Busunit_Persist_Dao_Busunit();
            $this->getBusunit()->setAppaccount_id($appaccount_id);
            return $dao->save($this->_busunit);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update() {        
        if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
            Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_HEAD, Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_HEAD_PRIVILEGE_UPDATE)
                ||
            Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
                Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH, Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_UPDATE)) {

            try {
                $dao = new Busunit_Persist_Dao_Busunit();
                return $dao->save($this->_busunit);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    abstract public function delete();

    public function getById($id) {
        try {
            $dao = new Busunit_Persist_Dao_Busunit();
            return $dao->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $dao = new Busunit_Persist_Dao_Busunit();
            return $dao->getByName($name, array(
                Zend_Auth::getInstance()->getIdentity()->appaccount_id,
            ));
        } catch (Exception $e) {
            throw $e;
        }
    }

}

