<?php

class Persons_Model_Person extends Agana_Data_Bean implements JsonSerializable {

    private $id;
    private $name;
    private $gender;
    private $created;
    private $media;
    private $phone;
    private $mobilephone;
    private $address;
    private $addressnumber;
    private $addressdetails;
//    private $district;
    private $postalcode;
    private $city_id;
    private $website;
    private $city;
    private $email;
    private $birthdate;
    private $appaccount_id;
    private $city_region_id;
    private $city_region;
    private $marital_status;
    private $user;
    
    private $identitycard;
    private $individualdoctaxnumber;
    private $birthcertificate;
    private $professionalcard;
    private $driverslicense;
    private $voterregistration;
    private $militaryregistration;
    private $healthsystemcard;
    private $pis;

    /**
     * App account object
     * @var App_Model_Account
     */
    private $appaccount = null;
 
    function getIdentitycard() {
        return $this->identitycard;
    }

    function getIndividualdoctaxnumber() {
        return $this->individualdoctaxnumber;
    }

    function getBirthcertificate() {
        return $this->birthcertificate;
    }

    function getProfessionalcard() {
        return $this->professionalcard;
    }

    function getDriverslicense() {
        return $this->driverslicense;
    }

    function getVoterregistration() {
        return $this->voterregistration;
    }

    function getMilitaryregistration() {
        return $this->militaryregistration;
    }

    function getHealthsystemcard() {
        return $this->healthsystemcard;
    }

    function getPis() {
        return $this->pis;
    }

    function setIdentitycard($identitycard) {
        $this->identitycard = $identitycard;
    }

    function setIndividualdoctaxnumber($individualdoctaxnumber) {
        $this->individualdoctaxnumber = $individualdoctaxnumber;
    }

    function setBirthcertificate($birthcertificate) {
        $this->birthcertificate = $birthcertificate;
    }

    function setProfessionalcard($professionalcard) {
        $this->professionalcard = $professionalcard;
    }

    function setDriverslicense($driverslicense) {
        $this->driverslicense = $driverslicense;
    }

    function setVoterregistration($voterregistration) {
        $this->voterregistration = $voterregistration;
    }

    function setMilitaryregistration($militaryregistration) {
        $this->militaryregistration = $militaryregistration;
    }

    function setHealthsystemcard($healthsystemcard) {
        $this->healthsystemcard = $healthsystemcard;
    }

    function setPis($pis) {
        $this->pis = $pis;
    }
    
    public function getAppaccount() {
        if ($this->appaccount == null) {
            $appDomain = new App_Domain_Account();
            $this->appaccount = $appDomain->getById($this->appaccount_id);
        }

        return $this->appaccount;
    }

    public function getMarital_status() {
        return $this->marital_status;
    }

    public function setMarital_status($marital_status) {
        $this->marital_status = $marital_status;
    }

    public function getCity_region_id() {
        return $this->city_region_id;
    }

    public function setCity_region_id($city_region_id) {
        $this->city_region_id = $city_region_id;
    }

    public function getCityRegion() {
        if (is_null($this->city_region) && is_numeric($this->city_region_id)) {
            $d = new Location_Domain_CityRegion();
            $this->city_region = $d->getById($this->city_region_id);
        }

        if (is_null($this->city_region)) {
            $this->city_region = new Location_Model_CityRegion();
        }

        return $this->city_region;
    }

    public function setCityRegion($city_region) {
        $this->city_region = $city_region;
    }

    public function existUser() {
        return !is_null($this->getUser()->getName());
    }

    public function getUser() {
        if (is_null($this->user)) {
            $d = new User_Domain_User();
            $this->user = $d->getByPersonId($this->id);

            if (is_null($this->user)) {
                $this->user = new User_Model_User();
            }
        }

        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setBirthdate($birthday) {
        $this->birthdate = $birthday;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getAppaccount_id() {
        return $this->appaccount_id;
    }

    public function setAppaccount_id($appaccount_id) {
        $this->appaccount_id = $appaccount_id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCity() {
        if (is_null($this->city_id) || !is_numeric($this->city_id)) {
            $this->city = new Location_Model_City();
        } else if (is_null($this->city)) {
            $domain = new Location_Domain_City();
            $this->city = $domain->getById($this->city_id);
        }

        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function getCity_id() {
        return $this->city_id;
    }

    public function setCity_id($city_id) {
        $this->city_id = $city_id;
    }

    public function getPostalcode() {
        return $this->postalcode;
    }

    public function setPostalcode($postalcode) {
        $this->postalcode = $postalcode;
    }

//    public function getDistrict() {
//        return $this->district;
//    }
//
//    public function setDistrict($district) {
//        $this->district = $district;
//    }


    public function getAddressdetails() {
        return $this->addressdetails;
    }

    public function setAddressdetails($addressdetails) {
        $this->addressdetails = $addressdetails;
    }

    public function getAddressnumber() {
        return $this->addressnumber;
    }

    public function setAddressnumber($addressnumber) {
        $this->addressnumber = $addressnumber;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getMobilephone() {
        return $this->mobilephone;
    }

    public function setMobilephone($mobilephone) {
        $this->mobilephone = $mobilephone;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return Media_Model_Image
     */
    public function getMedia() {
        if (is_null($this->media)) {
            $md = new Media_Domain_Image();
            $this->media = $md->getByRelation('person', $this->id);

            if (is_null($this->media)) {
                $this->media = new Media_Model_Image();
            }
        }

        return $this->media;
    }

    public function setMedia($media) {
        $this->media = $media;
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

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getAge($atDate = null) {
        if ($atDate) {
            $zd = new Zend_Date($atDate);
        } else {
            $zd = new Zend_Date(Zend_Date::now());
        }

        if ($this->getBirthdate()) {
            $from = new Zend_Date($this->getBirthdate());
            return $zd->subYear($from)->get(zend_Date::YEAR);
        } else {
            return -1;
        }
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
