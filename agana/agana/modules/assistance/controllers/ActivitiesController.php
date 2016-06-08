<?php

class Assistance_ActivitiesController extends Zend_Controller_Action {

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
            $domain = new Assistance_Domain_Activity();
            
            $page = ($this->_hasParam('page')) ? $this->_getParam('page') : 1;

            $params = array('page' => $page);

            $this->view->filter_keyword = '';
            if (trim($this->_getParam('filter-keyword', '')) != '') {
                $params['filter-keyword'] = $this->_getParam('filter-keyword');
                $this->view->filter_keyword = $params['filter-keyword'];
            }

            $paginator = ($this->_hasParam('paginator')) ? filter_var($this->_getParam('paginator'), FILTER_VALIDATE_BOOLEAN) : true;

            $activities = $domain->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id, 'description', $paginator, $params);

            $this->view->assign('activities', $activities);
        } else {
            $this->_redirectLogin();
        }
    }

    public function searchExistRegisterAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $pd = new Assistance_Domain_Activity();
        $registers = $pd->searchBySimilarity($this->_getParam('description'));

        $res = array(
            'found' => count($registers) > 0,
            'registers' => $registers
        );

        $out = json_encode($res);
        echo $out;
    }
}
