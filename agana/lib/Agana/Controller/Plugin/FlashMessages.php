<?php

/**
 * The FlashMessages Controller Plugin inject the messages in the view with ritght format (HTML, XML, JSON).
 *  
 * @author Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * 
 */
class Agana_Controller_Plugin_FlashMessages extends Zend_Controller_Plugin_Abstract {
    /**
     *
     * @var Zend_View
     */
    private $_view;
    
    public function postDispatch(Zend_Controller_Request_Abstract $request) {
        $this->_view = Zend_Controller_Front::getInstance()
                ->getParam('bootstrap')
                ->getResource('view');

        $response = $this->getResponse();
        $body=$response->getBody();
        $messages = new Agana_View_Helper_FlashMessages();
        $messages = $messages->flashMessages();
        $response->setBody($messages);
        $response->appendBody($body);
        
        parent::postDispatch($request);
    }

}

