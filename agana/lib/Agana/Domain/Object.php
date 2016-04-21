<?php

/**
 * Agana_Domain_Object
 *
 * controls the identity of objects
 * 
 * @category   Agana
 * @package    Agana_Object
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Domain_Object {

    /**
     *
     * @var Agana_Model_Object  
     */
    protected $_object = null;

    /**
     * Creates the object and instantiate the internal model
     * @param Agana_Model_Object $object 
     */
    public function __construct($object = null) {
        $this->_object = $object;
    }

    /**
     * @return Agana_Model_Object
     */
    public function getObject() {
        return $this->_object;
    }

    /**
     * @param Agana_Model_Object 
     */
    public function setObject($object) {
        $this->_object = $object;
    }

    public function populateObject($data) {
        Agana_Data_BeanUtil::populate($this->_object, $data);
    }

    public function add() {
        try {
            $u = new Agana_Persist_Dao_Object();
            return $u->save($this->_object);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            $user = $this->getObject();

            try {
                $u = new Agana_Persist_Dao_Object();
                return $u->save($this->_object);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        $user = $this->getObject();

        try {
            $u = new Agana_Persist_Dao_Object();
            return $u->delete($this->_object->getId());
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById($id) {
        try {
            $u = new Agana_Persist_Dao_Object();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function _isAllowed() {
        return true;
    }

}

?>
