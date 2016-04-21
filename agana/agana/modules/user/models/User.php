<?php

class User_Model_User extends Agana_Data_Bean implements Zend_Acl_Role_Interface {

    private $id;
    private $name;
    private $email;
    private $pwd;
    private $created;
    private $last_login;
    private $status;
    private $salt;

    /**
     *
     * @var Persons_Model_Person
     */
    private $person;
    private $media;
    private $appaccount;
    private $appaccount_id;
    private $person_id;

    /**
     *
     * @var User_Model_Role
     */
    private $role;
    private $acl_role_id;

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

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getLastLogin() {
        return $this->last_login;
    }

    public function setLastLogin($lastLogin) {
        $this->last_login = $lastLogin;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * @return Person_Model_Person
     */
    public function getPerson() {
        if (is_null($this->person) || is_null($this->person->getId())) {
            $pd = new Persons_Domain_Person();
            $this->person = $pd->getById($this->person_id);
        }

        if (is_null($this->person)) {
            $this->person = new Persons_Model_Person();
        }

        return $this->person;
    }

    public function setPerson($person) {
        $this->person = $person;
    }

    /**
     * @return App_Model_Account
     */
    public function getAppAccount() {
        return $this->appaccount;
    }

    public function setAppAccount($appaccount) {
        $this->appaccount = $appaccount;
    }

    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
    }

    public function getPerson_id() {
        return $this->person_id;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
    }

    public function getRole() {
        if ($this->acl_role_id && $this->role == null) {
            $roleDomain = new User_Domain_Role();
            $this->role = $roleDomain->getById($this->acl_role_id);
        }

        if (!is_a($this->role, 'User_Model_Role')) {
            $this->role = new \User_Model_Role();
        }

        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getAcl_role_id() {
        return ($this->acl_role_id) ? $this->acl_role_id : null;
    }

    public function setAcl_role_id($acl_role_id) {
        $this->acl_role_id = $acl_role_id;
    }

// override Zend_Acl_Role_Interface
    public function getRoleId() {
        return 'user'; //"user:" . $this->name;
    }

}

