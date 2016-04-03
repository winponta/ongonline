<?php

class Persons_Model_Volunteer extends Agana_Data_Bean implements JsonSerializable {

    private $id;

    /**
     * App account object
     * @var App_Model_Account
     */
    private $appaccount = null;

    public function getAppaccount() {
        if ($this->appaccount == null) {
            $appDomain = new App_Domain_Account();
            $this->appaccount = $appDomain->getById($this->appaccount_id);
        }

        return $this->appaccount;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
