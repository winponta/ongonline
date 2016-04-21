<?php
/**
 * Anaga_Rest_Controller extends Zend_Rest_Controller adding some utils to it.
 *
 * @category   Agana
 * @package    Agana_Controller
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Rest_Controller extends Zend_Rest_Controller {
    /**
     * This protected method sets the response header, code and body
     * to not allowed methods.
     * It is used on GET, POST, DELETE, PUT methods not implemented
     */
    protected function methodNotAllowed() {
        $codeReturn = Agana_Http_StatusCodes::HTTP_METHOD_NOT_ALLOWED;
        $this->getResponse()->setHttpResponseCode($codeReturn);
        $this->getResponse()->setHeader('Message', Agana_Http_StatusCodes::getMessageForCode($codeReturn, true));
        $this->getResponse()->setBody('This method is not allowed to be accessed');
    }

    /**
     * The default indexAction to Agana's Rest controllers should not be called
     * returning a Bad Request.
     * The indexAction may be implemented when is needed a Rest and Tradicional controller 
     */
    public function indexAction() {
        $codeReturn = Agana_Http_StatusCodes::HTTP_BAD_REQUEST;
        $this->getResponse()->setHttpResponseCode($codeReturn);
        $this->getResponse()->setHeader('Message', Agana_Http_StatusCodes::getMessageForCode($codeReturn, true));
        $this->getResponse()->setBody('You should not access this service without a proper HTTP HEADER');
    }

    public function deleteAction() {
        $this->methodNotAllowed();
    }

    public function getAction() {
        $this->methodNotAllowed();
    }

    public function postAction() {
        $this->methodNotAllowed();
    }

    public function putAction() {
        $this->methodNotAllowed();
    }
}
?>
