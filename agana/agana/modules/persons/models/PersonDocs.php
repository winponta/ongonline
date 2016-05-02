<?php

class Persons_Model_PersonDocs extends Agana_Data_Bean  {
    private $id;
    private $identitycard;
    private $individualdoctaxnumber;
    private $birthcertificate;
    private $professionalcard;
    private $driverslicense;
    private $voterregistration;
    private $militaryregistration;
    private $healthsystemcard;
    private $pis;

    private $person;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdentitycard() {
        return $this->identitycard;
    }

    public function setIdentitycard($identitycard) {
        $this->identitycard = $identitycard;
    }

    public function getIndividualdoctaxnumber() {
        return $this->individualdoctaxnumber;
    }

    public function setIndividualdoctaxnumber($individualdoctaxnumber) {
        $this->individualdoctaxnumber = $individualdoctaxnumber;
    }

    public function getBirthcertificate() {
        return $this->birthcertificate;
    }

    public function setBirthcertificate($birthcertificate) {
        $this->birthcertificate = $birthcertificate;
    }

    public function getProfessionalcard() {
        return $this->professionalcard;
    }

    public function setProfessionalcard($professionalcard) {
        $this->professionalcard = $professionalcard;
    }

    public function getDriverslicense() {
        return $this->driverslicense;
    }

    public function setDriverslicense($driverslicense) {
        $this->driverslicense = $driverslicense;
    }

    public function getVoterregistration() {
        return $this->voterregistration;
    }

    public function setVoterregistration($voterregistration) {
        $this->voterregistration = $voterregistration;
    }

    public function getMilitaryregistration() {
        return $this->militaryregistration;
    }

    public function setMilitaryregistration($militaryregistration) {
        $this->militaryregistration = $militaryregistration;
    }

    public function getHealthsystemcard() {
        return $this->healthsystemcard;
    }

    public function setHealthsystemcard($healthsystemcard) {
        $this->healthsystemcard = $healthsystemcard;
    }
    
    public function getPis() {
        return $this->healthsystemcard;
    }

    public function setPis($pis) {
        $this->pis = $pis;
    }

    public function getPerson() {
        if (!$this->person) {
            $domain = new Persons_Domain_Person();
            $this->person = $domain->getById($this->id);
        }
        
        return $this->person;
    }
    
    public function toArray() {
//        $properties = get_class_vars('Persons_Model_PersonDocs');
//        $result = array();
//        foreach ($properties as $key => $value) {
//            $result[$key] = $this->$key;
//        }
        
        $result = get_object_vars($this);
        unset($result['person']);
        return $result;
    }
}

