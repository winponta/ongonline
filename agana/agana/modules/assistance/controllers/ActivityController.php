<?php

/**
 * Activity controller from Assistance module of Agana fwk
 */
class Assistance_ActivityController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Assistance_Domain_Activity());
        $this->setViewVarName('activity');
        $this->setViewVarListName('activities');
        $this->setViewListOrderBy(array('assistance_date DESC', 'assistance_time DESC'));
        $this->setFormCRUName('Assistance_Form_Activity');
        $this->setFormDName('Assistance_Form_ActivityDelete');
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

        parent::createAction();

        // preenche os campos com os dados da pessoa de usuário que 
        // está usando o sistema
        $id = Zend_Auth::getInstance()->getIdentity()->id;

        $personDomain = new Persons_Domain_Person();
        $person = $personDomain->getById($id);

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

    public function updateAction() {

        parent::updateAction();

        $act = $this->getDomainClass()->getById($this->getParam('id'));

        $this->view->person_recorded = $act->getPerson_recorded();
        $this->view->person_performed = $act->getPerson_performed();
        $this->view->person_helped = $act->getPerson_helped();
    }

    public function listByPersonHelpedAction() {
        try {
            if ($this->_isUserAllowed(null, null)) {
                if (!is_null($this->getDomainClass())) {
                    $id = $this->getParam('person');
                    $this->view->assign(
                            $this->getViewVarListName(), $this->getDomainClass()->getAllByPersonHelped($id, $this->getViewListOrderBy())
                    );

                    $personHelpedDomain = new Persons_Domain_PersonHelped();
                    $this->view->person_helped = $personHelpedDomain->getById($id);
                } else {
                    throw new Agana_Exception('No domain class defined at list action on ' . __CLASS__);
                }
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }

    public function reportByProjectAction() {
        $meta = new Agana_Print_Meta('Atendimentos por projeto', 'Sistema Comercial', 
                    'ONG ONLINE', 'http://www.ongonline.com.br');

        $renderViews['form']        = 'report-by-project-form';
        $renderViews['report']      = 'report-by-project-report';
        $renderViews['summarized']  = 'report-by-project-report-summarized';
        
//        Zend_Debug::dump($this->getRequest());
//        die();
        
        $report = new Agana_Print_Report();
        return $report->handleRequest('Assistance_Domain_Activity', 'getActivitiesByProject', 
                'Assistance_Form_ActivityReportByProject',
                $renderViews, 
                'activity', $meta, $this);
    }

}
