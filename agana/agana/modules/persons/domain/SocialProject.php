<?php

class Persons_Domain_SocialProject {

    /**
     *
     * @var Persons_Model_SocialProject
     */
    protected $_sp = null;

    public function __construct($spModel = null) {
        if (is_null($spModel)) {
            $spModel = new Persons_Model_SocialProject();
        }
        $this->setSocialProject($spModel);
    }

    /**
     * @return Persons_Model_SocialProject
     */
    public function getSocialProject() {
        return $this->_sp;
    }

    /**
     * @param Persons_Model_SocialProject
     */
    public function setSocialProject($sp) {
        if (!($sp instanceof Persons_Model_SocialProject) && !is_null($sp)) {
            $sp = new Persons_Model_SocialProject($sp);
        }
        $this->_sp = $sp;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_sp, $data);
    }

    public function create($useTransaction = true) {
    }

    public function update() {
    }

    public function getAll($orderby = '') {
        try {
            $u = new Persons_Persist_Dao_SocialProject();
            $r = $u->getAll(array(
                'orderby'=>$orderby,
                //'appaccount_id' => Zend_Auth::getInstance()->getIdentity()->appaccount_id,
                ));
            $r = is_null($r) ? array() : $r;
            return $r;
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     *
     * @param integer $id
     * @return Persons_Model_SocialProject
     * @throws Exception 
     */
    public function getById($id) {
        if (!is_null($id)) {
            try {
                $u = new Persons_Persist_Dao_SocialProject();
                return $u->get($id);
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            return null;
        }
    }
    
    private function _isAllowed() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Agana_Exception('You don not have permission to access this');
        } else {
            return true;
        }
    }

}

