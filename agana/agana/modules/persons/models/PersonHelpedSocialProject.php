<?php

/**
 * Model VO with Person helped and federal social projects related to it
 */
class Persons_Model_PersonHelpedSocialProject extends Agana_Data_Bean {

    /**
     * @var int Person id
     */
    private $person_id;

    /**
     * @var int project id
     */
    private $pfs_id;

    /**
     *
     * @var string
     */
    private $numero;
    
    private $person = null;
    private $socialProject = null;

    public function getPerson_id() {
        return $this->person_id;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
        return $this;
    }

    public function getPfs_id() {
        return $this->pfs_id;
    }

    public function setPfs_id($pfs_id) {
        $this->pfs_id = $pfs_id;
        return $this;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
        return $this;
    }

    public function getPerson() {
        if ($this->person == null) {
            $pd = new Persons_Domain_Person();
            $this->person = $pd->getById($this->person_id);
        }
        
        return ($this->person == null) ? new Persons_Model_Person() : $this->person;
    }

    public function getSocialProject() {
        if ($this->socialProject == null) {
            $prjd = new Persons_Domain_SocialProject();
            $this->socialProject = $prjd->getById($this->pfs_id);
        }
        return ($this->socialProject == null) ? new Project_Model_SocialProject() : $this->socialProject;
    }
}

