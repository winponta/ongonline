<?php

/**
 * Model VO with Person helped and projects related to it
 */
class Persons_Model_PersonHelpedProject extends Agana_Data_Bean {

    /**
     * @var int Person id
     */
    private $person_id;

    /**
     * @var int project id
     */
    private $project_id;

    private $date_in;
    private $date_out;
    
    private $person = null;
    private $project = null;

    public function getPerson_id() {
        return $this->person_id;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
        return $this;
    }

    public function getProject_id() {
        return $this->project_id;
    }

    public function setProject_id($project_id) {
        $this->project_id = $project_id;
        return $this;
    }

    public function getDate_in() {
        return $this->date_in;
    }

    public function setDate_in($date_in) {
        $this->date_in = $date_in;
        return $this;
    }

    public function getDate_out() {
        return $this->date_out;
    }

    public function setDate_out($date_out) {
        $this->date_out = $date_out;
        return $this;
    }

    public function getPerson() {
        if ($this->person == null) {
            $pd = new Persons_Domain_Person();
            $this->person = $pd->getById($this->person_id);
        }
        
        return ($this->person == null) ? new Persons_Model_Person() : $this->person;
    }

    public function getProject() {
        if ($this->project == null) {
            $prjd = new Project_Domain_Project();
            $this->project = $prjd->getById($this->project_id);
        }
        return ($this->project == null) ? new Project_Model_Project() : $this->project;
    }
}

