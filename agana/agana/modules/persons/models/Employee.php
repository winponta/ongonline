<?php

class Persons_Model_Employee extends Agana_Data_Bean implements JsonSerializable {

    private $id;
    private $registration_number;
    private $busunit_id;
    private $job_function_id;

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

//    public function getAppaccount_id() {
//        return $this->appaccount_id;
//    }
//
//    public function setAppaccount_id($appaccount_id) {
//        $this->appaccount_id = $appaccount_id;
//    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    function getRegistration_number() {
        return $this->registration_number;
    }

    function getBusunit_id() {
        return $this->busunit_id;
    }

    function getJob_function_id() {
        return $this->job_function_id;
    }

    function setRegistration_number($registration_number) {
        $this->registration_number = $registration_number;
    }

    function setBusunit_id($busunit_id) {
        $this->busunit_id = $busunit_id;
    }

    function setJob_function_id($job_function_id) {
        $this->job_function_id = $job_function_id;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
