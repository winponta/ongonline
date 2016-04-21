<?php

/**
 * Agana core Calendar Domain class is responsible for manage calendar events
 * in Agana framework providing services to modules.
 * This is Agenda class
 *
 * @author Ademir Mazer Jr <ademir@winponta.com.br>
 * @copyright (c) 2013, Winponta Software <http://www.winponta.com.br>
 */
class Calendar_Domain_Agenda {
    
    /**
     *
     * @var Customer_Model_Customer
     */
    protected $_customer = null;

    public function __construct($customerModel = null) {
        if (is_null($customerModel)) {
            $customerModel = new Customer_Model_Customer();
        }
        $this->setCustomer($customerModel);
    }

    public static function isControllerEnabled($options = null) {
        if ($options === null)  {
            $boot = Agana_Util_Bootstrap::getBootstrap('customer');
            $boot = $boot->getOptions();
        } else {
            $boot = $options;
        }

        if (isset($boot['module']['controller']['admin']['enabled'])) {
            return $boot['module']['controller']['admin']['enabled'];
        } else {
            return true;
        }
    }

    public function getAll($orderby = '') {
        try {
            $u = new Customer_Persist_Dao_Customer();
            $r = $u->getAll(array(
                'orderby' => $orderby,
                'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                    ));
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Customer_Model_Customer
     */
    public function getCustomer() {
        return $this->_customer;
    }

    /**
     * @param Customer_Model_Customer
     */
    public function setCustomer($customer) {
        if (!($customer instanceof Customer_Model_Customer) && !is_null($customer)) {
            $customer = new Customer_Model_Customer($customer);
        }
        $this->_customer = $customer;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_customer, $data);
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Customer_Persist_Dao_Customer();
                return $u->save($this->_customer, true);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Customer_Persist_Dao_Customer();
                return $u->save($this->_customer);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Customer_Persist_Dao_Customer();
                return $u->delete($this->_customer->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Customer_Persist_Dao_Customer();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByName($name) {
        try {
            $u = new Customer_Persist_Dao_Customer();
            return $u->getByName($name, array(
                'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
            ));
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

?>
