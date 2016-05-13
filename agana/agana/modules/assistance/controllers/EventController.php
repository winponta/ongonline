<?php

/**
 * Event controller from Assistance module of Agana fwk
 */
class Assistance_EventController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Assistance_Domain_Event());
        $this->setViewVarName('event');
        $this->setViewVarListName('events');
        $this->setViewListOrderBy(array('event_date DESC'));
        $this->setFormCRUName('Assistance_Form_Event');
        $this->setFormDName('Assistance_Form_EventDelete');
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
        if ($this->getRequest()->isPost()) {
            $url = array(
                'action' => 'create-activity',
                'controller' => 'event',
                'module' => 'assistance',
            );

            $this->setUseIdCreatedOnUrl(true);

            $this->setRedirectActionAfterCreateSuccess($url);
            
        }
        
        parent::createAction();
    }

    protected function _createActivityRecord($data) {
        $actDomain = new Assistance_Domain_Activity();
        $actDomain->populate($data);

        try {
            return $actDomain->create();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    public function createActivityAction() {
        try {
            if ($this->_isUserAllowed(null, null)) {

                if ($this->hasParam('id') == FALSE) {
                    $urlRedirect = $this->getUrlRedirectionCreateCancel();
                    $this->_helper->flashMessenger->addMessage(
                            array('error' => 'Falta id de evento para criar atividade relacionada.'));
                    $this->_formCancel($urlRedirect);
                }

                $form = new Assistance_Form_Activity(Assistance_Form_Activity::ACTION_ADD);

                $request = $this->getRequest();

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if ($form->save->isChecked()) {
                        if ($form->isValid($data)) {
                            try {
                                $id = $this->_createActivityRecord($data);

                                $urlRedirect = array(
                                    'action' => 'create-activity',
                                    'controller' => 'event',
                                    'module' => 'assistance',
                                    'id' => $data['event_id']
                                );

                                if ($this->_useIdCreatedOnUrl && $id) {
                                    $urlRedirect['id'] = $id;
                                }

                                $this->_formSuccess($urlRedirect);
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                            }
                        } else {
                            $this->_addFormValidationMessage();
                        }
                    } else {
                        if ($form->cancel->isChecked()) {
                            $urlRedirect = $this->getUrlRedirectionCreateCancel();
                            $this->_formCancel($urlRedirect);
                        }
                    }
                }
                $this->view->form = $form;

                $id = $this->_getParam('id');

                $evDomain = new Assistance_Domain_Event();
                $event = $evDomain->getById($id);

                $this->view->event = $event;

                $activities = $evDomain->getActivities($id, array(
                    'orderby' => array(
                        'assistance_date DESC',
                        'assistance_time DESC'
                    )
                ));

                $this->view->activities = $activities;

                $id_user = Zend_Auth::getInstance()->getIdentity()->id;

                $personDomain = new Persons_Domain_Person();
                $person = $personDomain->getById($id_user);

                $this->view->person_recorded = $person;
                $this->view->person_performed = $person;
                $this->view->person_helped = new Persons_Model_Person();

                if ($this->getRequest()->isPost()) {
                    $phId = $this->getRequest()->getParam('person_helped_id', 0);
                    if ($phId > 0) {
                        $person = $personDomain->getById($phId);

                        $this->view->person_helped = $person;
                    }

                    $ppId = $this->getRequest()->getParam('person_performed_id', 0);
                    if ($ppId > 0) {
                        $person = $personDomain->getById($ppId);

                        $this->view->person_performed = $person;
                    } else {
                        $this->view->person_performed = new Persons_Model_Person();
                    }
                }
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }

    private function redirectNoId() {
        $urlRedirect = array(
            'action' => 'list',
            'controller' => 'event',
            'module' => 'assistance'
        );

        $this->_helper->flashMessenger->addMessage(
                array('error' => 'Falta id de evento para listar.'));

        $this->_helper->redirector('list', 'event', 'assistance');
    }

    public function listActivitiesAction() {
        try {
            if ($this->_isUserAllowed(null, null)) {

                if ($this->hasParam('id') == FALSE) {
                    $this->redirectNoId();
                }

                $id = $this->_getParam('id');

                $evDomain = new Assistance_Domain_Event();
                $event = $evDomain->getById($id);

                $this->view->event = $event;

                $activities = $evDomain->getActivities($id, array(
                    'orderby' => array(
                        'assistance_date DESC',
                        'assistance_time DESC'
                    )
                ));

                $this->view->activities = $activities;
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }
    
    public function listAction() {
        if ($this->_isUserAllowed(null, null)) {
            $domain = new Assistance_Domain_Event();

            $page = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;

            $params = array('page' => $page);

            $this->view->filter_keyword = '';
            if (trim($this->_getParam('filter-keyword', '')) != '') {
                $params['filter-keyword'] = $this->_getParam('filter-keyword');
                $this->view->filter_keyword = $params['filter-keyword'];
            }

            $paginator = ($this->_hasParam('paginator')) ? filter_var($this->_getParam('paginator'), FILTER_VALIDATE_BOOLEAN) : true;

            $event = $domain->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, 'project', $paginator, $params);

            $this->view->assign('events', $event);
        } else {
            $this->_redirectLogin();
        }
    }
    
}
