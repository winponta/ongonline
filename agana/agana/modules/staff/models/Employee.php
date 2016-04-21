<?php

class Staff_Model_Employee extends Agana_Data_Bean  {
    /**
     * Same as Person Id
     * @var integer
     */
    private $id;

    /**
     *
     * @var Persons_Model_Person
     */
    private $person;
    private $registration_number;
    private $job_function_id;
    /** 
     *
     * @var Staff_Model_Jobfunction
     */
    private $jobfunction;
    
    private $busunit_id;

    /**
     *
     * @var Busunit_Model_Busunit
     */
    private $busunit;
    
    public function getBusunit_id() {
        return $this->busunit_id;
    }

    public function setBusunit_id($busunit_id) {
        $this->busunit_id = $busunit_id;
    }

    public function getBusunit() {
        if (is_null($this->busunit) && $this->busunit_id) {            
            $bud = new Busunit_Domain_Branch();
            $this->busunit = $bud->getById($this->busunit_id);
        }
        
        return $this->busunit;
    }

    public function setBusunit($busunit) {
        $this->busunit = $busunit;
    }

        
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPerson() {
        if (is_null($this->person) && $this->id) {            
            $pd = new Persons_Domain_Person();
            $this->person = $pd->getById($this->id);
        }
        
        return $this->person;
    }

    public function setPerson($person) {
        $this->person = $person;
    }

    public function getRegistration_number() {
        return $this->registration_number;
    }

    public function setRegistration_number($registration_number) {
        $this->registration_number = $registration_number;
    }

    public function getJob_function_id() {
        return $this->job_function_id;
    }

    public function setJob_function_id($job_function_id) {
        $this->job_function_id = $job_function_id;
    }

    public function getJobfunction() {
        if (is_null($this->jobfunction) && $this->job_function_id) {            
            $jfd = new Staff_Domain_Jobfunction();
            $this->jobfunction = $jfd->getById($this->job_function_id);
        }
        
        return $this->jobfunction;
    }

    public function setJobfunction($jobfunction) {
        $this->jobfunction = $jobfunction;
    }


}

