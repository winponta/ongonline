<?php

/**
 * Helped controller to associate with federal social projects from Person module of Agana fwk
 */
class Persons_PersonHelpedSocialProjectController extends Agana_Controller_Crud_Action {

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

        $this->setDomainClass(new Persons_Domain_PersonHelped());
        $this->setViewVarName('helped');
        $this->setViewVarListName('hgroup');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Persons_Form_PersonHelpedSocialProject');
        $this->setFormDName('Persons_Form_PersonHelpedSocialProjectDelete');
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
                'action' => 'get',
                'controller' => 'person-helped-social-project',
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

                $domain = new Persons_Domain_PersonHelped();
                $reg = $domain->getById($id);
                $this->view->helped = $reg;
            }
        }
    }

    public function listAction() {
        if ($this->_isUserAllowed(null, null)) {
            $domain = new Persons_Domain_PersonHelped();

            $page = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;

            $params = array('page' => $page);

            $this->view->filter_keyword = '';
            if (trim($this->_getParam('filter-keyword', '')) != '') {
                $params['filter-keyword'] = $this->_getParam('filter-keyword');
                $this->view->filter_keyword = $params['filter-keyword'];
            }

            $persons_helped = $domain->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, 'name', true, $params);

            $this->view->assign('hgroup', $persons_helped);
        } else {
            $this->_redirectLogin();
        }
    }

    private function _associateSocialProject($data) {
        try {
            return $this->getDomainClass()->associateSocialProject($data);
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    public function associateAction() {
        $hasException = false;

        // setting the url to be redirected after create record with success
        // or cancel
        if ($this->_hasParam('id') || $this->_hasParam('person')) {
            $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');
            $urlRedirect = array(
                'action' => 'get',
                'controller' => 'person-helped',
                'module' => 'persons',
                'id' => $this->_getParam('id'),
            );

            $this->setRedirectActionAfterCreateSuccess($urlRedirect);

            $this->setRedirectActionAfterCreateCancel($urlRedirect);
        }

        try {
            if ($this->_isUserAllowed(null, null)) {

                $f = 'Persons_Form_PersonHelpedSocialProject';
                $form = new $f($f::ACTION_ADD);

                $request = $this->getRequest();

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if ($form->save->isChecked()) {
                        if ($form->isValid($data)) {
                            try {
                                $id = $this->_associateSocialProject($form->getValues());

                                $urlRedirect = $this->getUrlRedirectionCreateSuccess();

                                if ($this->_useIdCreatedOnUrl && $id) {
                                    $urlRedirect['id'] = $id;
                                }

                                $this->_formSuccess($urlRedirect);
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                                $hasException = true;
                            }
                        } else {
                            $this->_addFormValidationMessage();
                            $hasException = true;
                        }
                    } else {
                        if ($form->cancel->isChecked()) {
                            $urlRedirect = $this->getUrlRedirectionCreateCancel();
                            $this->_formCancel($urlRedirect);
                        }
                    }
                }
                $this->view->form = $form;
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
            $hasException = true;
        }

        // fill the id and name person of the form when is calling with a person's id
        $enterIF = $this->_hasParam('id') || $this->_hasParam('person');
        $enterIF = $enterIF && (!$this->getRequest()->isPost() ||
                ($this->getRequest()->isPost() && $this->view->form->isErrors())
                );

        if ($enterIF || $hasException) {
            $id = $this->_hasParam('id') ? $this->_getParam('id') : $this->_getParam('person');

            $f = $this->view->form;
            $elname = $f->getElement('person_name');
            $elid = $f->getElement('person_id');

            $ph = new Persons_Domain_PersonHelped();
            $personHelped = $ph->getById($id);
            $person = $personHelped->getPerson();

            if ($person) {
                $elname->setValue($person->name);
                $elid->setValue($person->id);
                $this->view->helped = $personHelped;
            }
        }
    }

}
