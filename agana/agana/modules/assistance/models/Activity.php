<?php

class Assistance_Model_Activity extends Agana_Data_Bean {

    private $id;
    private $assistance_date;
    private $assistance_time;
    private $person_helped_id;
    private $person_performed_id;
    private $person_recorded_id;
    private $description;
    private $appaccount_id;
    private $task_type_id;
    private $project_id;
    private $event_id;
    
    /**
     * Indica se a identificacao da pessoa foi feita 
     * pelo uso de biometria com finger key
     * @var boolean
     */
    private $id_by_finger_key;
    private $person_helped;
    private $person_performed;
    private $person_recorded;
    private $task_type;
    private $project;

    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
        return $this;
    }
        
    public function getPerson_recorded_id() {
        return $this->person_recorded_id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setPerson_recorded_id($person_recorded_id) {
        $this->person_recorded_id = $person_recorded_id;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPerson_helped_id() {
        return $this->person_helped_id;
    }

    public function getPerson_performed_id() {
        return $this->person_performed_id;
    }

    public function getTask_type_id() {
        return $this->task_type_id;
    }

    public function getProject_id() {
        return $this->project_id;
    }

    public function getAssistance_time() {
        return $this->assistance_time;
    }

    public function getAssistance_date() {
        return $this->assistance_date;
    }

    /**
     * @return Persons_Model_PersonHelped
     */
    public function getPerson_helped() {
        if (is_null($this->person_helped) && !is_null($this->person_helped_id)) {
            $p = new Persons_Domain_Person();
            $this->person_helped = $p->getById($this->person_helped_id);
        }

        return $this->person_helped;
    }

    /**
     * @return Persons_Model_Person
     */
    public function getPerson_performed() {
        if (is_null($this->person_performed) && !is_null($this->person_performed_id)) {
            $p = new Persons_Domain_Person();
            $this->person_performed = $p->getById($this->person_performed_id);
        }

        return $this->person_performed;
    }

    /**
     * @return Persons_Model_Person
     */
    public function getPerson_recorded() {
        if (is_null($this->person_recorded) && !is_null($this->person_recorded_id)) {
            $p = new Persons_Domain_Person();
            $this->person_recorded = $p->getById($this->person_recorded_id);
        }

        return $this->person_recorded;
    }

    /**
     * @return Project_Model_Tasktype
     */
    public function getTask_type() {
        if (is_null($this->task_type) && !is_null($this->task_type_id)) {
            $p = new Project_Domain_Tasktype();
            $this->task_type = $p->getById($this->task_type_id);
        }

        return $this->task_type;
    }

    /**
     * @return Project_Model_Project
     */
    public function getProject() {
        if (is_null($this->project) && !empty($this->project_id)) {
            $p = new Project_Domain_Project();
            $this->project = $p->getById($this->project_id);
        } else {
            $this->project = new Project_Model_Project();
        }

        return $this->project;
    }

    public function setPerson_helped_id($person_helped_id) {
        $this->person_helped_id = $person_helped_id;
        return $this;
    }

    public function setPerson_performed_id($person_performed_id) {
        $this->person_performed_id = $person_performed_id;
        return $this;
    }

    public function setTask_type_id($task_type_id) {
        $this->task_type_id = $task_type_id;
        return $this;
    }

    public function setProject_id($project_id) {
        $this->project_id = $project_id;
        return $this;
    }

    public function setAssistance_time($assistance_time) {
        $this->assistance_time = $assistance_time;
        return $this;
    }

    public function setAssistance_date($assistance_date) {
        $this->assistance_date = $assistance_date;
        return $this;
    }

    public function setPerson_helped($person_helped) {
        $this->person_helped = $person_helped;
        return $this;
    }

    public function setPerson_performed($person_performed) {
        $this->person_performed = $person_performed;
        return $this;
    }

    public function setTask_type($task_type) {
        $this->task_type = $task_type;
        return $this;
    }

    public function setProject($project) {
        $this->project = $project;
        return $this;
    }

    public function getId_by_finger_key() {
        return $this->id_by_finger_key;
    }

    public function setId_by_finger_key($id_by_finger_key) {
        $this->id_by_finger_key = $id_by_finger_key;
        return $this;
    }

    public function getEvent_id() {
        return $this->event_id;
    }

    public function setEvent_id($event_id) {
        $this->event_id = $event_id;
        return $this;
    }


}
