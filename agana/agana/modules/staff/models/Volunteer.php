<?php

class Staff_Model_Volunteer extends Agana_Data_Bean  {
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
    private $expertise_areas_id = array();
    /** 
     *
     * @var Staff_Model_Expertisearea
     */
    private $expertisearea = array();
    
    /**
     * 
     * @return array
     */
    public function getExpertise_areas_id() {
        return $this->expertise_areas_id;
    }

    public function setExpertise_areas_id($expertise_areas_id) {
        $this->expertise_areas_id = $expertise_areas_id;
    }

    public function getExpertisearea() {
        if (count($this->expertisearea) == 0) {            
            $exp = new Staff_Domain_Volunteer();            
            $this->expertisearea = $exp->getExpertiseAreas($this->id);
        }
        
        return $this->expertisearea;
    }

    public function setExpertisearea($expertisearea) {
        $this->expertisearea = $expertisearea;
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

}