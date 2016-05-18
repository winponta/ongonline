<?php

/**
 * Persist person data using PDO
 * 
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 * @copyright (c) 2011-2013, Winponta Software <http://www.winponta.com.br>
 */
class Persons_Persist_Dao_Person extends Agana_Persist_Dao_Abstract implements Persons_Persist_Interface_Person {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'person';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'person_id_seq';

    /**
     * Prepare data for insert
     * 
     * @param Person_Model_Person
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['created'] = $this->getNowTimestamp();
        $dataPrepared['appaccount_id'] = $data->getAppaccount_id();

        return $dataPrepared;

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Person_Model_Person
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'gender' => $data->getGender(),
            'phone' => $data->getPhone(),
            'mobilephone' => $data->getMobilephone(),
            'address' => $data->getaddress(),
            'addressnumber' => $data->getAddressnumber(),
            'addressdetails' => $data->getAddressdetails(),
            //'district' => $data->getDistrict(),
            'postalcode' => $data->getPostalcode(),
            'website' => $data->getWebsite(),
            'email' => $data->getEmail(),
            'birthdate' => ($data->getBirthdate()) ? Agana_Util_DateTime::dateToYYMMDD($data->getBirthdate()) : null,
            'city_id' => $data->getCity_id(),
            'city_region_id' => is_numeric($data->getCity_region_id()) ? $data->getCity_region_id() : null,
            'marital_status' => $data->marital_status,
            'identitycard' => $data->getIdentitycard(),
            'individualdoctaxnumber' => $data->getIndividualdoctaxnumber(),
            'birthcertificate' => $data->getBirthcertificate(),
            'professionalcard' => $data->getProfessionalcard(),
            'driverslicense' => $data->getDriverslicense(),
            'voterregistration' => $data->getVoterregistration(),
            'militaryregistration' => $data->getMilitaryregistration(),
            'healthsystemcard' => $data->getHealthsystemcard(),
            'pis' => $data->getPis()
        );

        return $data;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Person_Model_Person
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        if (is_array($data)) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }

            $col = array();
            foreach ($data as $row) {
                if ($row) {
                    $o = new Persons_Model_Person($row);

                    $md = new Media_Domain_Image();
                    $media = $md->getByRelation('person_media', $row['id']);
                    $o->setMedia($media);

                    $col[] = $o;
                }
            }

            if ($returnArray) {
                return $col;
            } else {
                return $col[0];
            }
        } else {
            return null;
        }
    }

    /**
     * returns the user name from person id
     * @param integer $id 
     * @return User_Model_User
     */
    public function getUser($id) {
        $userDao = new User_Persist_Dao_User();
        $user = $userDao->getByPersonId($id);

        return $user;
    }

    /**
     * Returns the result of a database query for all records
     * of persons, associated with user name and id
     * 
     * @return Persons_Model_Person
     */
    public function getAll($appaccount_id = 0, $orderby = 'name', $returnPaginator = true, $params = array()) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from(array('p' => 'person'))
                ->where('appaccount_id = ?', $appaccount_id)
                ->joinLeft(array('e' => 'employee'), 'p.id = e.id', 'e.id AS id_employee')
                ->joinLeft(array('v' => 'volunteer'), 'p.id = v.id', 'v.id AS id_volunteer')
                ->joinLeft(array('ph' => 'person_helped'), 'p.id = ph.id', 'ph.id AS id_ph')
                ->order($orderby);
//$sql = $db->select("SELECT \"p\".id AS id, \"p\".*, \"e\".*, \"v\".*, \"ph\".* FROM \"person\" AS \"p\" LEFT JOIN \"employee\" AS \"e\" ON p.id = e.id LEFT JOIN \"volunteer\" AS \"v\" ON p.id = v.id LEFT JOIN \"person_helped\" AS \"ph\" ON p.id = ph.id WHERE (appaccount_id = 1) ORDER BY \"name\" ASC");
//        echo $sql;
////
//        die();

        if (isset($params['filter-keyword'])) {
            $filter = new Agana_Filter_Normalize();
            $sql->where('lower(unaccented(name)) LIKE ?', '%' . $filter->filter($params['filter-keyword']) . '%');
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        if ($returnPaginator) {
            $adapter = new Zend_Paginator_Adapter_DbSelect($sql);
            $paginator = new Zend_Paginator($adapter);

            $page = (isset($params['page'])) ? $params['page'] : 1;
            $paginator->setCurrentPageNumber($page);

            $itemCountPerPage = (isset($params['itemCountPerPage'])) ? $params['itemCountPerPage'] : 20;
            $paginator->setItemCountPerPage($itemCountPerPage);

            $pageRange = (isset($params['pageRange'])) ? $params['pageRange'] : 7;
            $paginator->setPageRange($pageRange);

            return $paginator;
        } else {
            return $this->_prepareReturnData($db->fetchAll($sql));
        }
    }

    public function get($id) {
        $person = parent::get($id, false);

//        $db = $this->getDefaultAdapter();
//        $sql = $db->select()
//                ->from('person_media')
//                ->where('person_id = ?', $id);
//        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
//        $mediaRow = $db->fetchRow($sql);
//
//        $media = null;
//        if ($mediaRow) {
//            $mediaDao = new Media_Persist_Dao_Image();
//            $media = $mediaDao->get($mediaRow['media_id']);
//        }
//        $person->setMedia($media);

        return $person;
    }

    /**
     *
     * @param integer $personId
     * @param integer $mediaId
     * @return array 
     */
    protected function getPersonMedia($personId = null, $mediaId = null) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from('person_media');

        if ($personId) {
            $sql->where('person_id = ?', $personId);
        }

        if ($mediaId) {
            $sql->where('media_id = ?', $mediaId);
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        $mediaRow = $db->fetchRow($sql);

        return $mediaRow;
    }

    /**
     *
     * @param Persons_Model_Person $person
     * @return integer Person Id
     * @throws Exception
     * @throws Agana_Exception 
     */
    public function createImageRelation($person = null) {
        if ($person != null && $person->getMedia() != null) {
            try {
                $data = array(
                    'person_id' => $person->getId(),
                    'media_id' => $person->getMedia()->getId(),
                );
                $res = $this->getDefaultAdapter()->insert('person_media', $data);

                return $res;
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Agana_Exception('Cannont persist a null object');
        }
    }

    public function searchByName($term, $appaccount_id, $orderby) {
        try {
            $f = new Agana_Filter_Normalize();
            $term = $f->filter($term);

            $db = $this->getDefaultAdapter();
            $sql = $db->select()
                    ->from('person')
                    ->where('appaccount_id = ?', $appaccount_id)
                    //->where($db->quoteInto('lower(normalize_utf8(name)) LIKE ?', '%' . $term . '%'))
                    ->where($db->quoteInto('lower(unaccented(name)) LIKE ?', '%' . $term . '%'))
                    ->order($orderby);


            $db->setFetchMode(Zend_DB::FETCH_ASSOC);

            return $this->_prepareReturnData($db->fetchAll($sql));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Search and return the persons that do anniversarie in date passed
     * 
     * @param int $appaccount_id
     * @param Zend_Date $date
     * @return array
     * @throws Exception
     */
    public function getAnniversaries($appaccount_id, Zend_Date $date) {
        try {
            $db = $this->getDefaultAdapter();

            $birthWhere = "extract(MONTH FROM birthdate)";
            $birthWhere .= " || '-' || ";
            $birthWhere .= "extract(DAY FROM birthdate) = ? ";

            $dateWhere = $date->get('M') . '-' . $date->get('d');

            $sql = $db->select()
                    ->from($this->_name)
                    ->where('appaccount_id = ?', $appaccount_id)
                    ->where($birthWhere, $dateWhere)
                    ->order('name');

            $db->setFetchMode(Zend_Db::FETCH_ASSOC);

            return $this->_prepareReturnData($db->fetchAll($sql));
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    /**
     * Search persons by similarity in theirs names
     * 
     * @param string $name
     * @return array
     * @throws Exception
     */
    public function searchBySimilarity($appaccount_id, $name) {
        try {
            $db = $this->getDefaultAdapter();

            $partials = explode(' ', $name);

            $queryRes = array();
            $sqlArray = array();
            // build each sql with the first word and the next one in sequence
            $normalize = new Agana_Filter_Normalize();
            $queryRes = array();

            if (count($partials) == 1) {
                $sql = $db->select()
                        ->from('person')
                        ->where('appaccount_id = ?', $appaccount_id)
                        //->where('unaccented(name) LIKE ?', '%' . $normalize->filter($partials[0]) . '%' . $normalize->filter($partials[$i]) . '%')
                        ->where($db->quoteInto('lower(unaccented(name)) LIKE ?', '%' . $normalize->filter(trim($partials[0])) . '%'));
                //->order('name');
            } else {
                for ($i = 1; $i < count($partials); $i++) {
                    $sql = $db->select()
                            ->from('person')
                            ->where('appaccount_id = ?', $appaccount_id)
                            //->where('unaccented(name) LIKE ?', '%' . $normalize->filter($partials[0]) . '%' . $normalize->filter($partials[$i]) . '%')
                            ->where($db->quoteInto('lower(unaccented(name)) LIKE ?', '%' . $normalize->filter(trim($partials[0])) . '%' . $normalize->filter(trim($partials[$i])) . '%'));
                    //->order('name');

                    $sqlArray[] = $sql;
                }

                // build each sql with the actual word and the next one
                for ($i = 0; $i < count($partials) - 1; $i++) {
                    $sql = $db->select()
                            ->from('person')
                            ->where('appaccount_id = ?', $appaccount_id)
                            ->where($db->quoteInto('lower(unaccented(name)) LIKE ?', '%' . $normalize->filter(trim($partials[$i])) . '%' . $normalize->filter(trim($partials[$i + 1])) . '%'));
                    //->order('name');

                    $sqlArray[] = $sql;
                }

                $sql = $db->select()->union($sqlArray);
            }


            //return $sql->__toString();

            $db->setFetchMode(Zend_Db::FETCH_ASSOC);

            $queryRes = array_merge($queryRes, $this->_prepareReturnData($db->fetchAll($sql)));
            return $queryRes;
        } catch (Exception $e) {
            throw $e;
        }
    }

}
