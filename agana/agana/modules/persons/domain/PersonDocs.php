<?php

class Persons_Domain_PersonDocs {

    /**
     *
     * @var Person_Model_PersonDocs
     */
    protected $_docs = null;

    public function __construct($docsModel = null) {
        if (is_null($docsModel)) {
            $docsModel = new Persons_Model_PersonDocs();
        }
        $this->setDocs($docsModel);
    }

    /**
     * @return Person_Model_PersonDocs
     */
    public function getDocs() {
        return $this->_docs;
    }

    /**
     * @param Person_Model_PersonDocs
     */
    public function setDocs($docs) {
        if (!($docs instanceof Persons_Model_PersonDocs) && !is_null($docs)) {
            $docs = new Persons_Model_PersonDocs($docs);
        }
        $this->_docs = $docs;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_docs, $data);
    }

    public function create($useTransaction = true) {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonDocs();
                $u->setUseTransaction($useTransaction);
                return $u->save($this->_docs, TRUE);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Persons_Persist_Dao_PersonDocs();
                return $u->save($this->_docs);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     *
     * @param integer $id
     * @return Persons_Model_PersonDocs
     * @throws Exception 
     */
    public function getById($id) {
        if (!is_null($id)) {
            try {
                $u = new Persons_Persist_Dao_PersonDocs();
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

