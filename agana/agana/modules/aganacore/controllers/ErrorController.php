<?php

class Aganacore_ErrorController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $layout->disableLayout();
            $this->getRequest()->setParam('format', 'json'); 
            $this->_response->setHeader('Content-Type', 'application/json'); 
            $this->view->ContentType = 'application/json';
        }
    }

    public function errorAction() {
        $errors = $this->_getParam('error_handler');

        if (!$errors) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;
            default:
                // application error

                switch ($errors->exception->getCode()) {
                    case Agana_Exception::EXCEPTION_APP_WARNING:
                        $this->getResponse()->setHttpResponseCode(500);
                        $priority = Zend_Log::INFO;
                        
                        $this->view->message = $errors->exception->getMessage();
                        $this->view->code = $errors->exception->getCode();
                        
                        break;
                    default:
                        $this->getResponse()->setHttpResponseCode(500);
                        $priority = Zend_Log::CRIT;
                        $this->view->message = 'Application error';
                        break;
                }
        }

        // Log exception, if logger available
        //if ($log = $this->getLog()) {
        if ($log = $this->getLogger()) {
            //$log->log('MESSAGE ERROR ================', $priority);
            $log->setEventItem('exception', $errors->exception);
            $log->setEventItem('dump', print_r($errors->request->getParams(), true));
            $log->log($this->view->message, $priority);

            //$log->log(' ', $priority);
            
            //$log->log('EXCEPTION ==================== ', $priority);
            //$log->log($errors->exception, $priority);
            
            //$log->log(' ', $priority);
            //$log->log('DUMP OF PARAMETERS ', $priority);
            //$log->log('Request Parameters', $priority, $errors->request->getParams());
            //$log->log('DUMP', $priority,$errors->request->getParams());
            //$log->log(Zend_Debug::dump($errors->request->getParams(), '', false), $priority);

            //$log->log('<<<<< ERROR END >>>>>', $priority);
            //$log->log(' ', $priority);
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

    /**
     * Returns the Zend_Log object puted in global register
     * 
     * @return Zend_Log
     */
    public function getLogger() {
        return Zend_Registry::get(Bootstrap::APP_ERROR_LOGGER);
    }

}

