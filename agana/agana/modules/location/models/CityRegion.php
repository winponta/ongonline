<?php

class Location_Model_CityRegion extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $city;
    private $city_id;
    private $parent;
    private $parent_id;
    
    public function getCity_id() {
        return $this->city_id;
    }

    public function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    /**
     * 
     * @return Location_Model_CityRegion
     */
    public function getParent() {
        if (is_null($this->parent) && (!is_null($this->parent_id) && !empty($this->parent_id))) {
            $p = new Location_Persist_Dao_CityRegion();
            $this->parent = $p->get($this->parent_id);
        }
        
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getParent_id() {
        return $this->parent_id;
    }

    public function setParent_id($parent_id) {
        $this->parent_id = $parent_id;
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

    /**
     * 
     * @return Location_Model_City
     */
    public function getCity() {
        if (is_null($this->city) && !is_null($this->city_id)) {
            $p = new Location_Persist_Dao_City();
            $this->city = $p->get($this->city_id);
        }
        
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }
   
}

