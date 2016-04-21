<?php

/**
 * Volunteer controller from Staff module of Agana fwk
 */
class Staff_VolunteerController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Staff_Domain_Volunteer());
        $this->setViewVarName('volunteer');
        $this->setViewVarListName('volunteers');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Staff_Form_Volunteer');
        $this->setFormDName('Staff_Form_VolunteerDelete');
    }

    public function getAction() {
        if ($this->_isUserAllowed(null, null)) {
            if ($this->_hasParam('id') || $this->_hasParam('person')) {
                $id = ($this->_getParam('id')) ? $this->_getParam('id') : $this->_getParam('person');
                $domain = new Staff_Domain_Volunteer();
                $emp = $domain->getById($id);
                $this->view->volunteer = $emp;
            }
        }
    }

    protected function _isUserAllowed($resource, $privilege) {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    public function createAction() {
        // setting the url to be redirected after create record with success
        // or cancel
        if ($this->_hasParam('id') || $this->_hasParam('person')) {
            $id = ($this->_getParam('id')) ? $this->_getParam('id') : $this->_getParam('person');
            $urlRedirect = array(
                'action'        => 'getgm',
                'controller'    => 'person',
                'module'        => 'persons',
                'id'            => $id,
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
            $id = ($this->_getParam('id')) ? $this->_getParam('id') : $this->_getParam('person');

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

    public function updateAction() {
        // setting the url to be redirected after create record with success
        // or cancel
        if ($this->_hasParam('id') || $this->_hasParam('person')) {
            $id = ($this->_getParam('id')) ? $this->_getParam('id') : $this->_getParam('person');

            $urlRedirect = array(
                'action'        => 'get',
                'controller'    => 'volunteer',
                'module'        => 'staff',
                'id'            => $id,
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
            $id = $this->_getParam('id');

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

}    