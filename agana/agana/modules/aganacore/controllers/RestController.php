<?php

/**
 * 
 * @author Ademir Mazer Jr (Nuno) <ademir.mazer.jr@gmail.com>
 */
class Aganacore_RestController extends Zend_Rest_Controller {

    public function init() {
        $layout = Zend_Layout::getMvcInstance();

        $view = $layout->getView();

        $layout->disableLayout();

        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        $server = new Zend_Json_Server();
        $x = new Agana_Service_Test();
        $server->setClass('Agana_Service_Test');
        echo $server->getServiceMap();
        exit;
    }

    public function postAction() {
        
    }

    public function getAction() {        
        $front = Zend_Controller_Front::getInstance();

        Zend_Debug::dump($front->getRequest());
        
        $d = $front->getDispatcher();
        Zend_Debug::dump($front->getRequest()->getParams(), 'PARAMS: ');
        Zend_Debug::dump($front->getRequest()->getUserParams(), 'USER PARAMS: ');
    }

    public function putAction() {
        
    }

    public function deleteAction() {
        
    }

}

