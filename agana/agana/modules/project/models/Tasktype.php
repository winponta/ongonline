<?php

class Project_Model_Tasktype extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $description;
    private $parent_id;
    private $parent;
    private $appaccount_id;
    
    public function getParent_id() {
        return $this->parent_id;
    }

    public function setParent_id($parent_id) {
        $this->parent_id = $parent_id;
    }

    public function getParent() {
        if (is_null($this->parent) && trim($this->parent_id) != '') {
            $pd = new Project_Domain_Tasktype();
            $this->parent = $pd->getById($this->parent_id);
        } else {
            $this->parent = new Project_Model_Tasktype();
        }
        
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

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
}

