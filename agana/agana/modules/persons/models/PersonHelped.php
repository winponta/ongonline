<?php

class Persons_Model_PersonHelped extends Agana_Data_Bean {

    /**
     *
     * @var Integer Person id
     */
    private $id;

    /**
     *
     * @var String free 50 chars
     */
    private $religion;

    /**
     * Based on values: Retired, Unemployed, Rural Worker, City Worker, Another (described)
     * @var String 100 chars
     */
    private $professional_occupation;

    /**
     * @var String 400 chars
     */
    private $professional_experience;

    /**
     *
     * @var boolean
     */
    private $live_with_family;

    /**
     * Based on values: Owner, Rent, Mortgage, Present, Invasion, Other(describe)
     * @var String 50 chars
     */
    private $home_situation;

    /**
     * Based on values: City, Rural, Island, Quilombo, Indian
     * @var String 50 chars
     */
    private $home_area;

    /**
     * Based on values: Brick, Adobe, Wood, Another(describe)
     * @var String 50 chars
     */
    private $home_type;

    /**
     *
     * @var Integer
     */
    private $home_pieces_number;

    /**
     * @var Decimal(10,2)
     */
    private $rent_value;

    /**
     * Living in this home sinve
     * @var date
     */
    private $home_since;

    /**
     * @var Integer
     */
    private $born_city_id;

    /**
     * @var Integer
     */
    private $born_state_id;
    private $person;
    private $bornCity;
    /**
     *
     * @var Location_Model_State
     */
    private $bornState;
    
    /**
     *
     * @var String
     */
    private $first_help_date;
    
    /**
     * The projects were this person is helped
     * @var Array of Project_Model_Project 
     */
    private $projects = array();

    /**
     * The total of projects associated to person helped
     * When null then its value is lazy loaded
     * 
     * @var int
     */
    private $projectsTotalCount = null;
    
    /**
     * The social projects were this person is helped by govern
     * @var Array of Project_Model_SocialProject 
     */
    private $socialProjects = array();

    /**
     * The total of social projects associated to person helped
     * When null then its value is lazy loaded
     * 
     * @var int
     */
    private $socialProjectsTotalCount = null;
    
    public function getFirst_help_date() {
        return $this->first_help_date;
    }

    public function setFirst_help_date($first_help_date) {
        $this->first_help_date = $first_help_date;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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
        unset($result['bornCity']);
        unset($result['bornState']);
        unset($result['projectsTotalCount']);
        unset($result['socialProjectsTotalCount']);
        return $result;
    }

    public function getReligion() {
        return $this->religion;
    }

    public function setReligion($religion) {
        $this->religion = $religion;
    }

    public function getProfessional_occupation() {
        return $this->professional_occupation;
    }

    public function setProfessional_occupation($professional_occupation) {
        $this->professional_occupation = $professional_occupation;
    }

    public function getProfessional_experience() {
        return $this->professional_experience;
    }

    public function setProfessional_experience($professional_experience) {
        $this->professional_experience = $professional_experience;
    }

    public function getLive_with_family() {
        return $this->live_with_family;
    }

    public function setLive_with_family($live_with_family) {
        $this->live_with_family = $live_with_family;
    }

    public function getHome_situation() {
        return $this->home_situation;
    }

    public function setHome_situation($home_situation) {
        $this->home_situation = $home_situation;
    }

    public function getHome_area() {
        return $this->home_area;
    }

    public function setHome_area($home_area) {
        $this->home_area = $home_area;
    }

    public function getHome_type() {
        return $this->home_type;
    }

    public function setHome_type($home_type) {
        $this->home_type = $home_type;
    }

    public function getHome_pieces_number() {
        return $this->home_pieces_number;
    }

    public function setHome_pieces_number($home_pieces_number) {
        $this->home_pieces_number = $home_pieces_number;
    }

    public function getRent_value() {
        return $this->rent_value;
        }

    public function setRent_value($rent_value) {
        $this->rent_value = $rent_value;
    }

    public function getHome_since() {
        return $this->home_since;
    }

    public function setHome_since($home_since) {
        $this->home_since = $home_since;
    }

    public function getBorn_city_id() {
        return $this->born_city_id;
    }

    public function setBorn_city_id($born_city_id) {
        $this->born_city_id = $born_city_id;
    }

    public function getBorn_state_id() {
        return $this->born_state_id;
    }

    public function setBorn_state_id($born_state_id) {
        $this->born_state_id = $born_state_id;
    }

    public function getBornCity() {
        if (!$this->bornCity) {
            $domain = new Location_Domain_City();
            $this->bornCity = $domain->getById($this->born_city_id);
        }

        return $this->bornCity;
    }

    public function setBornCity($bornCity) {
        $this->bornCity = $bornCity;
    }

    public function getBornState() {
        if (!$this->bornState) {
            $domain = new Location_Domain_State();
            $this->bornState = $domain->getById($this->born_state_id);
        }

        return $this->bornState;
    }

    public function setBornState($bornState) {
        $this->bornState = $bornState;
    }

    /**
     * Returns an array of projects related to person helped
     * 
     * @return array Persons_Model_PersonHelpedProject
     */
    public function getProjects() {
        if (count($this->projects) == 0) {
            $pd = new Persons_Domain_PersonHelped();
            $this->projects = $pd->getProjects($this->getId());
        }
        
        return $this->projects;
    }

    /**
     * Returns total ammount of projects related to person helped
     * 
     * @return intct
     */
    public function getProjectsTotalCount() {
        if (is_null($this->projectsTotalCount)) {
            $pd = new Persons_Domain_PersonHelped();
            $this->projectsTotalCount = $pd->getProjectsTotalCount($this->getId());
        }
        
        return $this->projectsTotalCount;
    }

    /**
     * Returns an array of social projects related to person helped
     * 
     * @return array Persons_Model_PersonHelpedSocialProject
     */
    public function getSocialProjects() {
        if (count($this->socialProjects) == 0) {
            $pd = new Persons_Domain_PersonHelped();
            $this->socialProjects = $pd->getSocialProjects($this->getId());
        }
        
        return $this->socialProjects;
    }

    /**
     * Returns total ammount of social projects related to person helped
     * 
     * @return intct
     */
    public function getSocialProjectsTotalCount() {
        if (is_null($this->socialProjectsTotalCount)) {
            $pd = new Persons_Domain_PersonHelped();
            $this->socialProjectsTotalCount = $pd->getSocialProjectsTotalCount($this->getId());
        }
        
        return $this->socialProjectsTotalCount;
    }


}

