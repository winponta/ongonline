<?php

class Busunit_Domain_Branch extends Busunit_Domain_Busunit {

    /**
     *
     * @var Busunit_Model_Branch
     */
    protected $_busunit = null;

    public function __construct($model = null) {
        if (is_null($model)) {
            $model = new Busunit_Model_Branch();
        }
        $this->setBusunit($model);
    }

    /**
     * @return Busunit_Model_Branch
     */
    public function getBusunit() {
        return $this->_busunit;
    }

    /**
     * @param Busunit_Model_Branch
     */
    public function setBusunit($unit) {
        if (!($unit instanceof Busunit_Model_Busunit) && !is_null($unit)) {
            $unit = new Busunit_Model_Branch($unit);
        }
        $this->_busunit = $unit;
    }

    public function create($appaccount_id) {
        if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
            Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH, Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_CREATE)) {
            try {
                $user = Zend_Auth::getInstance()->getIdentity();

                $this->getBusunit()->defineasBranch(0);
                $this->getBusunit()->setAppaccount_id($user->appaccount_id);

                if (! $appaccount_id) {
                    $appaccount_id = $user->appaccount_id;
                }
                
                return parent::create($appaccount_id);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
            Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH, Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_DELETE)) {
            try {
                $u = new Busunit_Persist_Dao_Busunit();
                return $u->delete($this->_busunit->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }
    
    public function getAll($orderby = '') {
        try {
            $user = Zend_Auth::getInstance()->getIdentity();
            
            $u = new Busunit_Persist_Dao_Busunit();
            $params['orderby'] = $orderby;
            $params['excludeHead'] = true;
            $params['appaccount_id'] = $user->appaccount_id;
            
            $r = $u->getAll($params);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 
     * @param integer $appaccount_id
     * @return Busunit_Model_Branch
     * @throws Exception
     * @throws Agana_Exception
     */
    public function getByAppAccount($appaccount_id) {
        try {
            if (Agana_Acl_Service::isAllowed(Zend_Auth::getInstance()->getIdentity()->acl_role_id,
                Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH, Busunit_Module_Acl::ACL_RESOURCE_BUSUNIT_BRANCH_PRIVILEGE_LIST)) {
                $dao = new Busunit_Persist_Dao_Busunit();
                return $dao->getByAppAccount($appaccount_id, 0, array('returnArray' => true));
            } else {
                throw new Agana_Exception('You don not have permission to access this');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}

