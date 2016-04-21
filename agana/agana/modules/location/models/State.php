<?php

class Location_Model_State extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $abbreviation;
    private $country;
    
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
    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getAbbreviation() {
        return $this->abbreviation;
    }
    
    public function setAbbreviation($abbreviation) {
        $this->abbreviation = $abbreviation;
    }
}

