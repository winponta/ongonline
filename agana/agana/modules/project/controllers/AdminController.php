<?php

/**
 * Project controller from Project module of Agana fwk
 */
class Project_AdminController extends Agana_Controller_Crud_Action {

    public function init() {
        parent::init();
        $this->setDomainClass(new Project_Domain_Project());
        $this->setViewVarName('project');
        $this->setViewVarListName('projects');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Project_Form_Project');
        $this->setFormDName('Project_Form_ProjectDelete');
    }

    protected function _isUserAllowed($resource, $privilege) {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    public function getAction() {
        if ($this->_isUserAllowed(null, NULL)) {
            $pd = new Project_Domain_Project();
            $project = $pd->getById($this->_getParam('id'));
            $this->view->project = $project;
        }
    }

    public function pdfProjectAction() {
        if ($this->_isUserAllowed(null, NULL)) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            $pd = new Project_Domain_Project();
            $project = $pd->getById($this->_getParam('id'));
            $this->view->project = $project;

            $content = $this->view->render('admin/pdf-project-cover.phtml');
            
            $pdf = new Agana_Print_Pdf_Report(Zend_Registry::get('Zend_Translate')->_('Project') . ' :: ' . $project->name, 
                    'MELHOR VIVER', 'ONG ONLINE', $this->view->theme_path);
            $pdf->addPage($content);
            
            $fulldescription = $this->view->render('admin/pdf-project-fulldescription.phtml');
            $pdf->addPage($fulldescription);
            $pdf->download('project-'.$project->getName().'.pdf');
        }
    }

}

