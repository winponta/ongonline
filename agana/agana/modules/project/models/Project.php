<?php
/**
 * Model for projects
 * 
 * Color constants at http://colorschemedesigner.com/#0042AhWs0g0g0
 * 
 * @author Ademir Mazer Jr <ademir@winponta.com.br>
 * @copywright (c) (2013), Winponta Software <http://www.winponta.com.br>
 */
class Project_Model_Project extends Agana_Data_Bean  {
    
    const PROJECT_STATUS_DRAFT_ID = 0;
    const PROJECT_STATUS_DRAFT_LABEL = 'Draft';
    const PROJECT_STATUS_DRAFT_TAGCLASS = 'label';
    const PROJECT_STATUS_ACTIVE_ID = 1;
    const PROJECT_STATUS_ACTIVE_LABEL = 'Active';
    const PROJECT_STATUS_ACTIVE_TAGCLASS = 'label label-success';
    const PROJECT_STATUS_FINISHED_ID = 2;
    const PROJECT_STATUS_FINISHED_LABEL = 'Finished';
    const PROJECT_STATUS_FINISHED_TAGCLASS = 'label label-info';
    const PROJECT_STATUS_CLOSED_ID = 3;
    const PROJECT_STATUS_CLOSED_LABEL = 'Closed';
    const PROJECT_STATUS_CLOSED_TAGCLASS = 'label label-inverse';
    const PROJECT_STATUS_PAUSED_ID = 4;
    const PROJECT_STATUS_PAUSED_LABEL = 'Paused';
    const PROJECT_STATUS_PAUSED_TAGCLASS = 'label label-warning';

    private $id;
    private $name;
    private $fulldescription;
    private $abstract;
    private $startdateexpected;
    private $startdatereal;
    private $finishdateexpected;
    private $finishdatereal;
    private $appaccount_id;
    private $status;

    public function getFulldescription() {
        return $this->fulldescription;
    }

    public function setFulldescription($fulldescription) {
        $this->fulldescription = $fulldescription;
    }

    public function getAbstract() {
        return $this->abstract;
    }

    public function setAbstract($abstract) {
        $this->abstract = $abstract;
    }

    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
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
    
    public function getStartdateexpected() {
        return $this->startdateexpected;
    }

    public function setStartdateexpected($startdateexpected) {
        $this->startdateexpected = $startdateexpected;
    }

    public function getStartdatereal() {
        return $this->startdatereal;
    }

    public function setStartdatereal($startdatereal) {
        $this->startdatereal = $startdatereal;
    }

    public function getFinishdateexpected() {
        return $this->finishdateexpected;
    }

    public function setFinishdateexpected($finishdateexpected) {
        $this->finishdateexpected = $finishdateexpected;
    }

    public function getFinishdatereal() {
        return $this->finishdatereal;
    }

    public function setFinishdatereal($finishdatereal) {
        $this->finishdatereal = $finishdatereal;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function toArray() {
//        $properties = get_class_vars('Persons_Model_PersonDocs');
//        $result = array();
//        foreach ($properties as $key => $value) {
//            $result[$key] = $this->$key;
//        }

        $result = get_object_vars($this);
        return $result;
    }

}

