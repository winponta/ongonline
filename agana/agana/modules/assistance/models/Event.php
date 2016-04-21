<?php

class Assistance_Model_Event extends Agana_Data_Bean {

    private $id;
    private $event_date;
    private $task_type_id;
    private $project_id;
    private $appaccount_id;
    private $task_type;
    private $project;

    private $totalActivities = null;
    
    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTask_type_id() {
        return $this->task_type_id;
    }

    public function getProject_id() {
        return $this->project_id;
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

    public function setTask_type_id($task_type_id) {
        $this->task_type_id = $task_type_id;
        return $this;
    }

    public function setProject_id($project_id) {
        $this->project_id = $project_id;
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

    public function getEvent_date() {
        return $this->event_date;
    }

    public function setEvent_date($event_date) {
        $this->event_date = $event_date;
        return $this;
    }

    public function getTotalActivities() {
        if (is_null($this->totalActivities)) {
            $evDomain = new Assistance_Domain_Event();
            $this->totalActivities = $evDomain->countActivities($this->getId());
        }
        
        return $this->totalActivities;
    }
}
