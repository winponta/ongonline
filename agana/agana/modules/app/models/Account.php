<?php

class App_Model_Account extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $email;
    private $created;
    private $objid;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }
    
    public function getObjid() {
        return $this->objid;
    }

    public function setObjid($objid) {
        $this->objid = $objid;
    }

}

