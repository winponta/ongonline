<?php

class Calendar_Model_Agenda extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $person_id;
    private $module_id;
    private $system;
    private $color;
    
    /**
     *
     * @var Persons_Model_Person
     */    
    private $person;

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

    public function getPerson_id() {
        return $this->person_id;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
    }

    public function getPerson() {
        if (is_null($this->person) && $this->person_id) {            
            $pd = new Persons_Domain_Person();
            $this->person = $pd->getById($this->person_id);
        }
        
        return $this->person;
    }

    public function setPerson($person) {
        $this->person = $person;
    }

    public function getModule_id() {
        return $this->module_id;
    }

    public function setModule_id($module_id) {
        $this->module_id = $module_id;
    }

    /**
     * Is this Agenda a system agenda? 
     * If is, should not be deleted
     * @return boolean
     */
    public function isSystem() {
        return $this->system;
    }

    public function setSystem($system) {
        $this->system = $system;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }


}

