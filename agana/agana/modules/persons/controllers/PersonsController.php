<?php

class Persons_PersonsController extends Zend_Controller_Action {

    /**
     * Redirect the request to login form, showing a message about permission access
     * The deafult message is = 'You do not have permission to access this'
     * @param String $msg 
     */
    protected function _redirectLogin($msg = 'You do not have permission to access this') {
        $this->_helper->flashMessenger->addMessage(array('warning' => $msg));
        $login = new Agana_Auth_Helper_Login();
        $login->redirectToLoginForm();
    }

    /**
     * Disable layout if request is made by XmlHttpRequest 
     */
    public function init() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
        }
    }

    protected function _isUserAllowed($resource, $privilege) {
        return Zend_Auth::getInstance()->hasIdentity();
    }

    public function listAction() {
        if ($this->_isUserAllowed(null, null)) {
            $domain = new Persons_Domain_Person();

            $page = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;
            
            $params = array('page' => $page);
        
            $this->view->filter_keyword = '';
            if (trim($this->_getParam('filter-keyword', '')) != '') {
                $params['filter-keyword'] = $this->_getParam('filter-keyword');
                $this->view->filter_keyword = $params['filter-keyword'];
            }
            
            $paginator = ($this->_hasParam('paginator')) ? filter_var($this->_getParam('paginator'), FILTER_VALIDATE_BOOLEAN) : true;
            
            $persons = $domain->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, 'name', $paginator, $params);

            $this->view->assign('persons', $persons);
        } else {
            $this->_redirectLogin();
        }
    }
    
    public function widgetTodayAnniversariesAction() {
        $domain = new Persons_Domain_Person();
        $date = new Zend_Date();
        $this->view->persons = $domain->getAnniversaries($date);
    }
    
    public function pdfAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->getRequest()->setParam('paginator', false);
        $content = $this->view->action('list', 'persons', 'persons', $this->_getAllParams());

        $pdf = new Agana_Print_Pdf_Report('CADASTRO DE PESSOAS', 'MELHOR VIVER', 'ONG ONLINE', $this->view->theme_path);
        $pdf->addPage($content);
        $pdf->addPage($content);
        
        $pdf->download();
        
    }

    public function searchExistRegisterAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $pd = new Persons_Domain_Person();
        $registers = $pd->searchBySimilarity($this->_getParam('name'));
        
        $res = array(
            'found' => count($registers) > 0,
            'registers' => $registers
        );
        
        $out = json_encode($res);
        echo $out;
    }
}
