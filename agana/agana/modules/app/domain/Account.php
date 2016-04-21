<?php

class App_Domain_Account {

    /**
     *
     * @var App_Model_Account
     */
    protected $_account = null;

    public function __construct($accountModel = null) {
        if (is_null($accountModel)) {
            $accountModel = new App_Model_Account();
        }
        $this->setAccount($accountModel);
    }

    public function getAll($orderby = '') {
        try {
            $u = new App_Persist_Dao_Account();
            $r = $u->getAll($orderby);
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return App_Model_Account
     */
    public function getAccount() {
        return $this->_account;
    }

    /**
     * @param App_Model_Account 
     */
    public function setAccount($account) {
        if (!($account instanceof App_Model_Account) && !is_null($account)) {
            $account = new App_Model_Account($account);
        }
        $this->_account = $account;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_account, $data);
    }

    public function createInstall() {
        try {
            $u = new App_Persist_Dao_Account();
            return $u->save($this->_account);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new App_Persist_Dao_Account();
                return $u->save($this->_account);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new App_Persist_Dao_Account();
                return $u->save($this->_account);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new App_Persist_Dao_Account();
                return $u->delete($this->_account->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new App_Persist_Dao_Account();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new App_Persist_Dao_Account();
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

