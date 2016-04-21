<?php

/**
 * Helped controller to associate with projects from Person module of Agana fwk
 */
class Persons_PersonHelpedProjectController extends Agana_Controller_Crud_Action {

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
        $this->setFormCRUName('Persons_Form_PersonHelpedProject');
        $this->setFormDName('Persons_Form_PersonHelpedProjectDelete');
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
                'controller' => 'person-helped-project',
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

    private function _associateProject($data) {
        try {
            return $this->getDomainClass()->associateProject($data);
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    /**
     * Updates the date out information only
     */
    public function updateDateOutAction() {
        $this->_helper->viewRenderer->setNoRender(true);

        $jsonArray['success'] = true;
        $jsonArray['msg'] = '';

        try {
            if ($this->hasParam('project_id') && $this->hasParam('person_id') && $this->hasParam('date_in')) {
                $this->getDomainClass()->updateDateOut($this->getAllParams());
                $jsonArray['msg'] = Zend_Registry::get('Zend_Translate')->_('Date out successfully updated');
            } else {
                $jsonArray['status'] = 'error';
                $jsonArray['success'] = false;
                $jsonArray['msg'] = 'Missing project_id and/or person_id parameter and/or date_in';
            }
        } catch (Exception $ex) {
            $jsonArray['status'] = 'error';
            $jsonArray['success'] = false;
            $jsonArray['msg'] = $ex->getMessage();
        }
        echo json_encode($jsonArray);
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

                $f = 'Persons_Form_PersonHelpedProject';
                $form = new $f($f::ACTION_ADD);

                $request = $this->getRequest();

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if ($form->save->isChecked()) {
                        if ($form->isValid($data)) {
                            try {
                                $id = $this->_associateProject($form->getValues());

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

    public function reportByProjectAction() {
        $meta = new Agana_Print_Meta('Assistidos fixos por projeto', 'Sistema Comercial', 
                    'ONG ONLINE', 'http://www.ongonline.com.br');

        $renderViews['form']        = 'report-by-project-form';
        $renderViews['report']      = 'report-by-project-report';
        $renderViews['summarized']  = 'report-by-project-report-summarized';
        
//        Zend_Debug::dump($this->getRequest());
//        die();
        
        $report = new Agana_Print_Report();
        return $report->handleRequest('Persons_Domain_PersonHelped', 'getPersonsByProject', 
                'Persons_Form_PersonHelpedReportByProject',
                $renderViews, 
                'person-helped-project', $meta, $this);
    }
//    public function reportByProjectAction() {
//        $request = $this->getRequest();
//
//        $this->view->records = null;
//
//        if ($this->hasParam('format')) {
//            $layout = Zend_Layout::getMvcInstance();
//            $layout->setLayout('report.layout');
//
//            $domain = new Persons_Domain_PersonHelped();
//
////            var_dump( $request->getParams());
////            die();
//            
//            $this->view->records = $domain->getPersonsByProject(
//                    Zend_Auth::getInstance()->getIdentity()->appaccount_id, $request->getParams());
//
//            if ($this->getParam('summarized')) {
//                $viewToRender = 'report-by-project-report-summarized';
//            } else {
//                $viewToRender = 'report-by-project-report';
//            }
//            
//            $this->view->format = $this->getParam('format');
//
//            $personDomain = new Persons_Domain_Person();
//            $person = $personDomain->getById(Zend_Auth::getInstance()->getIdentity()->person_id);
//            $appAccount = $person->getAppaccount();
//
//            $report = new Agana_Print_Pdf_Report('Assistidos fixos por projeto', $appAccount->getName(), 
//                    'ONG ONLINE', 'http://www.ongonline.com.br', $this->view->theme_path);
//
//            $this->view->assign('report', $report);
//
//            if ($this->getParam('format') == 'pdf') {
//                $this->_helper->layout->disableLayout();
//                $this->_helper->viewRenderer->setNoRender(true);
//
//                $content = $this->view->render('person-helped-project/' . $viewToRender . '.phtml');
//
//                $report->addPage($content);
//                $report->download();
//            }
//        } else {
//            $this->view->form = new Persons_Form_PersonHelpedReportByProject();
//            $viewToRender = 'report-by-project-form';
//        }
//
//        return $this->render($viewToRender);
//    }

}
