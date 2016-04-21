<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Persons_Persist_Dao_PersonHelped extends Agana_Persist_Dao_Abstract implements Persons_Persist_Interface_PersonHelped {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'person_helped';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Persons_Model_PersonHelped';

    /**
     * Prepare data for insert
     * 
     * @param Persons_Model_PersonHelped
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['id'] = $data->getId();

        return $dataPrepared;
    }

    /**
     * Prepare data for update 
     * 
     * @param Persons_Model_PersonHelped
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataPrepared = $data->toArray();

        $dataPrepared['home_since'] = ($dataPrepared['home_since']) ? Agana_Util_DateTime::dateToYYMMDD($dataPrepared['home_since']) : null;
        $dataPrepared['rent_value'] = is_numeric($dataPrepared['rent_value']) ? $dataPrepared['rent_value'] : null;
        $dataPrepared['home_pieces_number'] = is_numeric($dataPrepared['home_pieces_number']) ? $dataPrepared['home_pieces_number'] : null;
        $dataPrepared['first_help_date'] = ($dataPrepared['first_help_date']) ? Agana_Util_DateTime::dateToYYMMDD($dataPrepared['first_help_date']) : null;

        unset($dataPrepared['id']);
        unset($dataPrepared['projects']);
        unset($dataPrepared['socialProjects']);

        return $dataPrepared;
    }

    /**
     * Returns the result of a database query for all records
     * of persons helped, associated with user name and id
     * 
     * @return Persons_Model_Person
     */
    public function getAll($params = array(
        'from' => 'v_person_helped',
        'appaccount_id' => 0,
        'orderby' => 'name',
        'paginator' => true)
    ) {

        $db = $this->getDefaultAdapter();

//        var_dump($params['from']);
//        die();
        $sql = $db->select()
                ->from($params['from'])
                ->where('appaccount_id = ?', $params['appaccount_id'])
                ->order($params['orderby']);

        if (isset($params['filter-keyword'])) {
            $normalize = new Agana_Filter_Normalize();
            $sql->where('lower(unaccented(name)) LIKE ?', '%' .$normalize->filter($params['filter-keyword']) . '%');
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        if ($params['paginator']) {
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

    /**
     * 
     * @param integer $id The person helped id
     * @return array Persons_Model_PersonHelpedProject
     */
    public function getProjectsByPerson($id) {

        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('person_helped_project')
                ->where('person_id = ?', $id)
                ->order('date_in');

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        $projects = array();

        foreach ($r as $person_prj) {
            $p = new Persons_Model_PersonHelpedProject();
            $p->setPerson_id($id);
            $p->setProject_id($person_prj['project_id']);
            $p->setDate_in($person_prj['date_in']);
            $p->setDate_out($person_prj['date_out']);
            $projects[] = $p;
        }

        return $projects;
    }

    /**
     * 
     * @param integer $id The person helped id
     * @return int
     */
    public function getProjectsTotalCountByPerson($id) {

        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('person_helped_project', array('total' => 'COUNT(*)'))
                ->where('person_id = ?', $id);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return $r[0]['total'];
    }

    /**
     * 
     * @param integer $id The person helped id
     * @return int
     */
    public function getSocialProjectsTotalCountByPerson($id) {

        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('person_programa_federal_social', array('total' => 'COUNT(*)'))
                ->where('person_id = ?', $id);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return $r[0]['total'];
    }

    /**
     * 
     * @param integer $id The person helped id
     * @return array Persons_Model_PersonHelpedSocialProject
     */
    public function getSocialProjectsByPerson($id) {

        $db = $this->getDefaultAdapter();

        $sql = $db->select('numero, nome, sigla, pfs_id, person.id')
                ->from('person_programa_federal_social')
                ->joinInner('person', 'person_programa_federal_social.person_id = person.id')
                ->joinInner('programa_federal_social', 'person_programa_federal_social.pfs_id = programa_federal_social.id')
                ->where('person_id = ?', $id)
                ->order('programa_federal_social.nome');

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        $socialProjects = array();

        foreach ($r as $person_sprj) {
            $p = new Persons_Model_PersonHelpedSocialProject();
            $p->setPerson_id($id);
            $p->setPfs_id($person_sprj['pfs_id']);
            $p->setNome($person_sprj['nome']);
            $p->setSigla($person_sprj['sigla']);
            $p->setNumero($person_sprj['numero']);
            $socialProjects[] = $p;
        }

        return $socialProjects;
    }

    /**
     * Test if the association of project and this person is allowed, based on
     * primary key and date out information
     * 
     * @param integer $personId
     * @param integer $projectId
     * @return boolean True for allowed, False for not allowed
     */
    function isProjectAssociationAllowed($personId, $projectId) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('person_helped_project')
                ->where('person_id = ?', $personId)
                ->where('project_id = ?', $projectId)
                ->where('date_out IS NULL');

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return empty($r);
    }

    /**
     * Associate a project to a helped person
     * 
     * @param array $data
     */
    public function associateProject($data) {
        if ($data != null) {
            // test if the project is already related and has no date out information
            if (!$this->isProjectAssociationAllowed($data['person_id'], $data['project_id'])) {
                $msg = 'This project is already related to this person without date out information.';
                $msg = Zend_Registry::get('Zend_Translate')->_($msg);
                throw new Agana_Exception($msg);

                return false;
            }

            try {
                $adapter = $this->getAdapter();
                if ($this->useTransaction()) {
                    $adapter->beginTransaction();
                }

                $dataPrepared['person_id'] = $data['person_id'];
                $dataPrepared['project_id'] = $data['project_id'];
                $dataPrepared['date_in'] = $data['date_in'];

                $res = $adapter->insert('person_helped_project', $dataPrepared);

                if ($this->useTransaction()) {
                    $adapter->commit();
                }

                return $res;
            } catch (Exception $e) {
                if ($this->useTransaction()) {
                    $adapter->rollBack();
                }
                throw $e;
            }
        } else {
            throw new Agana_Exception('Cannont persist a null object');
        }
    }

    /**
     * Test if the association of social project and this person is allowed, based on
     * primary key information
     * 
     * @param integer $personId
     * @param integer $pfsId
     * @return boolean True for allowed, False for not allowed
     */
    function isSocialProjectAssociationAllowed($personId, $pfsId) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from('person_programa_federal_social')
                ->where('person_id = ?', $personId)
                ->where('pfs_id = ?', $pfsId);

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return empty($r);
    }

    /**
     * Associate a social project to a helped person
     * 
     * @param array $data
     */
    public function associateSocialProject($data) {
        if ($data != null) {
            // test if the social project is already related 
            if (!$this->isSocialProjectAssociationAllowed($data['person_id'], $data['pfs_id'])) {
                $msg = 'Este programa social federal já está associado a este assistido.';
                //$msg = Zend_Registry::get('Zend_Translate')->_($msg);
                throw new Agana_Exception($msg);

                return false;
            }

            try {
                $adapter = $this->getAdapter();
                if ($this->useTransaction()) {
                    $adapter->beginTransaction();
                }

                $dataPrepared['person_id'] = $data['person_id'];
                $dataPrepared['pfs_id'] = $data['pfs_id'];
                $dataPrepared['numero'] = $data['numero'];

                $res = $adapter->insert('person_programa_federal_social', $dataPrepared);

                if ($this->useTransaction()) {
                    $adapter->commit();
                }

                return $res;
            } catch (Exception $e) {
                if ($this->useTransaction()) {
                    $adapter->rollBack();
                }
                throw $e;
            }
        } else {
            throw new Agana_Exception('Cannont persist a null object');
        }
    }

    /**
     * Update in database the date out information for project related
     * 
     * @param array $data
     */
    public function updateDateOut($data) {
        if ($data != null) {
            try {
                $adapter = $this->getAdapter();
                if ($this->useTransaction()) {
                    $adapter->beginTransaction();
                }

                $dataPrepared['date_out'] = $data['date_out'];

                $where[] = $this->getAdapter()->quoteInto('project_id = ?', $data['project_id']);
                $where[] = $this->getAdapter()->quoteInto('person_id = ?', $data['person_id']);
                $where[] = $this->getAdapter()->quoteInto('date_in = ?', $data['date_in']);
                $res = $adapter->update('person_helped_project', $dataPrepared, $where);

                if ($this->useTransaction()) {
                    $adapter->commit();
                }

                return $res;
            } catch (Exception $e) {
                if ($this->useTransaction()) {
                    $adapter->rollBack();
                }
                throw $e;
            }
        } else {
            throw new Agana_Exception('Cannont persist a null object');
        }
    }

    /**
     * Returns an array with all persons associated to projects, grouped by project
     * or only from the project id passed by parameter
     * <br/>
     * <p>Params:</p>
     * project_id
     * status =0,1,2,3,4
     */
    public function getPersonsByProject($appaccount_id, $params = null) {
        $db = $this->getDefaultAdapter();

        $sql = $db->select()
                ->from(array('proj' => 'project'), array('project_name' => 'name',
                    'project_startdatereal' => 'startdatereal',
                    'project_finishdatereal' => 'finishdatereal',
                    'project_status' => 'status'))
                ->joinLeft(array('phd' => 'person_helped_project'), 'proj.id = phd.project_id')
                ->joinLeft(array('p' => 'person'), 'phd.person_id = p.id', array('person_name' => 'name'))
                ->order(array('proj.name', 'p.name'));

        $sql->where('proj.appaccount_id = ?', $appaccount_id);
        
        /**
         * TRATAMENTO DOS PARAMETROS 
         * */
        $projectId = isset($params['project_id']) ? $params['project_id'] : -1;
        if ((int) $projectId > 0) {
            $sql->where('project_id = ?', $projectId);
        }

        $status = isset($params['status']) ? $params['status'] : -1;
        if ((int) $status > 0) {
            $sql->where('status = ?', $status);
        }

        $dateInStart = isset($params['date_in_start']) ? $params['date_in_start'] : '';
        $dateInEnd = isset($params['date_in_end']) ? $params['date_in_end'] : '';

        if (trim($dateInStart) !== '') {
            $test_arr = explode('/', $dateInStart);
            if (Agana_Util_DateTime::validate($dateInStart)) {
                $sql->where('date_in >= ?', $dateInStart);
            }
        }

        if (trim($dateInEnd) !== '') {
            $test_arr = explode('/', $dateInEnd);
            if (Agana_Util_DateTime::validate($dateInStart)) {
                $sql->where('date_in <= ?', $dateInEnd);
            }
        }

        $dateOutStart = isset($params['date_out_start']) ? $params['date_out_start'] : '';
        $dateOutEnd = isset($params['date_out_end']) ? $params['date_out_end'] : '';

        if (trim($dateOutStart) !== '') {
            $test_arr = explode('/', $dateOutStart);
            if (Agana_Util_DateTime::validate($dateOutStart)) {
                $sql->where('date_out >= ?', $dateOutStart);
            }
        }

        if (trim($dateOutEnd) !== '') {
            $test_arr = explode('/', $dateOutEnd);
            if (Agana_Util_DateTime::validate($dateOutStart)) {
                $sql->where('date_out <= ?', $dateOutEnd);
            }
        }

        $db->setFetchMode(Zend_DB::FETCH_ASSOC);

        $r = $db->fetchAll($sql);

        return $r;
    }

}
