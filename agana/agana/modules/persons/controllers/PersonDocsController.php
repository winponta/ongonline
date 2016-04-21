<?php

/**
 * Docs controller from Person module of Agana fwk
 */
class Persons_PersonDocsController extends Agana_Controller_Crud_Action {

    /**
     * @var Zend_Translate
     */
    private $_translate = null;

    /**
     * @var array 
     */
    private $_bootOptions = null;

    public function init() {
        parent::init();

        $this->_translate = Zend_Registry::getInstance()->get('Zend_Translate');

        $this->setDomainClass(new Persons_Domain_PersonDocs());
        $this->setViewVarName('doc');
        $this->setViewVarListName('docs');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Persons_Form_PersonDocs');
        $this->setFormDName('Persons_Form_PersonDocsDelete');
    }

    protected function _isUserAllowed($resource, $privilege) {
        parent::_isUserAllowed($resource, $privilege);
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    public function updateAction() {
        // setting the url to be redirected after create record with success
        // or cancel
        if ($this->_hasParam('id') || $this->_hasParam('person')) {
            $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');
            $urlRedirect = array(
                'action' => 'getgm',
                'controller' => 'person',
                'module' => 'persons',
                'id' => $id,
            );

            $this->setRedirectActionAfterUpdateSuccess($urlRedirect);

            $this->setRedirectActionAfterUpdateCancel($urlRedirect);
        }

        parent::updateAction();

        // fill the id and name person of the form when is calling with a person's id
        if (($this->_hasParam('id') || $this->_hasParam('person')) && 
                (!$this->getRequest()->isPost() || 
                    ($this->getRequest()->isPost() && $this->view->form->isErrors())
                )
            ) {
            $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');

            $f = $this->view->form;
            $elname = $f->getElement('person_name');
            $elid = $f->getElement('id');

            $personDomain = new Persons_Domain_Person();
            $person = $personDomain->getById($id);

            if ($person) {
                $elname->setValue($person->name);
                $elid->setValue($person->id);
            }
        }
    }

    public function getAction() {
        if ($this->_isUserAllowed(null, null)) {
            if ($this->_hasParam('id') || $this->_hasParam('person')) {
                $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');
                $domain = new Persons_Domain_Person();
                $person = $domain->getById($id);
                $this->view->person = $person;

                $domain = new Persons_Domain_PersonDocs();
                $docs = $domain->getById($id);
                $this->view->docs = $docs;
            }
        }
    }

    public function listAction() {
        $this->_forward('get');
    }

    public function createAction() {
        // setting the url to be redirected after create record with success
        // or cancel
        if ($this->_hasParam('id') || $this->_hasParam('person')) {
            $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');
            $urlRedirect = array(
                'action' => 'getgm',
                'controller' => 'person',
                'module' => 'persons',
                'id' => $this->_getParam('id'),
            );

            $this->setRedirectActionAfterCreateSuccess($urlRedirect);

            $this->setRedirectActionAfterCreateCancel($urlRedirect);
        }

        parent::createAction();

        // fill the id and name person of the form when is calling with a person's id
        if (($this->_hasParam('id') || $this->_hasParam('person')) && 
                (!$this->getRequest()->isPost() || 
                    ($this->getRequest()->isPost() && $this->view->form->isErrors())
                )
            ) {
            $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');

            $f = $this->view->form;
            $elname = $f->getElement('person_name');
            $elid = $f->getElement('id');

            $personDomain = new Persons_Domain_Person();
            $person = $personDomain->getById($id);

            if ($person) {
                $elname->setValue($person->name);
                $elid->setValue($person->id);
            }
        }
    }

    public function pdfRecordAction() {
        if ($this->_isUserAllowed(null, null)) {
            if ($this->_hasParam('id') || $this->_hasParam('person')) {
                $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');
                $domain = new Persons_Domain_Person();
                $person = $domain->getById($id);
                $this->view->person = $person;

                $domain = new Persons_Domain_PersonDocs();
                $docs = $domain->getById($id);
                $this->view->docs = $docs;
            }
        }
    }

}

