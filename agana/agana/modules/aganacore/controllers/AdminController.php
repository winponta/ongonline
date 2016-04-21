<?php

// TODO: melhorar ou adicionar o controle de acesso no controlador ADMIN

/**
 * Controls the main workflow of admin services
 */
class Aganacore_AdminController extends Zend_Controller_Action {

    public function init() {
        parent::init();

        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayout('admin.layout');
    }

    public function indexAction() {
        $this->forward('dashboard');
    }

    public function dashboardAction() {
        if ($this->hasParam('pwd') && $this->getParam('pwd') == 'eeaspaoswp') {
            
        } else {
            throw new Exception('You can\'t access admin dashboard');
        }
    }

    public function appLogErrorAction() {
        if (!$this->hasParam('do')) {
            $this->forward('app-log-error-list');
        }
    }

    public function appLogErrorListAction() {
        $logFile = Agana_Util_Log::getSystemLogPath();

        $logErrors = file_get_contents($logFile);
        
        $logErrors = '<logFile>'.trim($logErrors).'</logFile>';
        
        //$logErrors = simplexml_load_string($logErrors);
        $logErrors = json_decode(json_encode((array) simplexml_load_string($logErrors)),1);
        
        $this->view->logErrors = $logErrors['logEntry'];
    }

    /**
     * Shows informations about Agana Framework: version, Zend Framework Version, 
     * Php info, etc ..
     */
    public function frameworkInfoAction() {
        
    }

    /**
     * returns the Zend Framework Version in JSon format
     * 
     * @return JSON
     */
    public function zfVersionAction() {
        $zf = array();
        $zf['version'] = Zend_Version::VERSION;
        $json = Zend_Json::encode($zf);
        $this->_helper->json($json);
    }

    /**
     * shows PHPInfo function inside the layout
     */
    public function phpInfoAction() {
        
    }

}
