<?php

class Location_Model_City extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $state;
    private $state_id;
    
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

    /**
     * 
     * @return Location_Model_State
     */
    public function getState() {
        if (is_null($this->state) && !is_null($this->state_id)) {
            $p = new Location_Persist_Dao_State();
            $this->state = $p->get($this->state_id);
        }
        
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }
    
    public function setState_id($id) {
        $this->state_id = $id;
    }

    public function getState_id() {
        return $this->state_id;
    }
}

