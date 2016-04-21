<?php

class Busunit_Domain_Headquarters extends Busunit_Domain_Busunit {

    /**
     *
     * @var Busunit_Model_Headquarters
     */
    protected $_busunit = null;

    public function __construct($model = null) {
        if (is_null($model)) {
            $model = new Busunit_Model_Headquarters();
        }
        $this->setBusunit($model);
    }

    /**
     * @return Busunit_Model_Headquarters
     */
    public function getBusunit() {
        return $this->_busunit;
    }

    /**
     * @param Busunit_Model_Headquarters
     */
    public function setBusunit($unit) {
        if (!($unit instanceof Busunit_Model_Busunit) && !is_null($unit)) {
            $unit = new Busunit_Model_Headquarters($unit);
        }
        $this->_busunit = $unit;
    }

    // TODO terminar o método create
    public function create($accountapp_id) {
        try {
            $dao = new Busunit_Persist_Dao_Busunit();

            // test if already exist an headquarters for this account app
            // if so ignore create and return 
            // else create one default

            $obj = $dao->getByAppAccount($accountapp_id, 1);

            if (!$obj) {
                $this->getBusunit()->defineasHead();
                $this->getBusunit()->setAppaccount_id($appaccount_id);
                return parent::create($accountapp_id);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete() {
        throw new Exception('Not yet implemented Delete in class domain Headquarters');
    }

    /**
     * 
     * @param integer $appaccount_id
     * @return Busunit_Model_Headquarters
     * @throws Exception
     * @throws Agana_Exception
     */
    public function getByAppAccount($appaccount_id) {
        try {
            if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
                Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_HEAD, Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_HEAD_PRIVILEGE_VIEW)) {
                $dao = new Busunit_Persist_Dao_Busunit();
                return $dao->getByAppAccount($appaccount_id, 1);
            } else {
                throw new Agana_Exception('You don not have permission to access this');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

}

