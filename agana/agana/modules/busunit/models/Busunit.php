<?php

class Busunit_Model_Busunit extends Agana_Data_Bean  {
    private $id;
    private $name;
    private $tradename;
    private $doctaxnumber;
    private $phone;
    private $address;
    private $addressnumber;
    private $addressdetails;
    private $district;
    private $city;
    private $city_id;
    private $postalcode;
    private $website;
    private $appaccount;
    private $appaccount_id;
    private $head;
    
    public function getDistrict() {
        return $this->district;
    }

    public function setDistrict($district) {
        $this->district = $district;
    }

        public function getHead() {
        return $this->head;
    }

    public function setHead($head) {
        if ($head) {
            $head = 1;
        } else {
            $head = 0;
        }
        
        $this->head = $head;
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

    public function getTradename() {
        return $this->tradename;
    }

    public function setTradename($tradename) {
        $this->tradename = $tradename;
    }

    public function getDoctaxnumber() {
        return $this->doctaxnumber;
    }

    public function setDoctaxnumber($doctaxnumber) {
        $this->doctaxnumber = $doctaxnumber;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getAddressnumber() {
        return $this->addressnumber;
    }

    public function setAddressnumber($addressnumber) {
        $this->addressnumber = $addressnumber;
    }

    public function getAddressdetails() {
        return $this->addressdetails;
    }

    public function setAddressdetails($addressdetails) {
        $this->addressdetails = $addressdetails;
    }

    public function getCity() {
        if (is_null($this->city) && !is_null($this->city_id) && trim($this->city_id) != '') {
            $p = new Location_Persist_Dao_City();
            $this->city = $p->get($this->city_id);
        }
        
        if (is_null($this->city)) {
            $this->city = new Location_Model_City();
        }
        
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getPostalcode() {
        return $this->postalcode;
    }

    public function setPostalcode($postalcode) {
        $this->postalcode = $postalcode;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function getAppaccount() {
        return $this->appaccount;
    }

    public function setAppaccount($appaccount) {
        $this->appaccount = $appaccount;
    }

    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
    }

    public function getCity_id() {
        return $this->city_id;
    }

    public function setCity_id($city_id) {
        $this->city_id = $city_id;
    }


}

