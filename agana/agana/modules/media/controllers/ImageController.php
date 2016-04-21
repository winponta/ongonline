<?php

/**
 * Image controller 
 */
class Media_ImageController extends Zend_Controller_Action {

    protected function _isUserAllowed() {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    private function _getImage() {
        $domain = new Media_Domain_Image();
        if ($this->_hasParam('id')) {
            return $domain->getById($this->_getParam('id'));
        } else if ($this->_hasParam('file')) {
            return $domain->getByFileName($this->_getParam('file'));
        } else {
            return false;
        }
    }

    public function getAction() {
        $response = $this->getResponse();

        $this->_helper->viewRenderer->setNoRender(true);
        $layout = Zend_Layout::getMvcInstance();
        $layout->disableLayout();

        if ($image = $this->_getImage()) {
            $domain = new Media_Domain_Image();
            $domain->setImage($image);
            $response->setHeader('Content-Type', $image->getMimetype());
            $size = $this->_hasParam('size') ? $this->_getParam('size') : '';
            $img = $domain->loadFile($size);
            $response->setBody($img);
        } else {
            $response->setHttpResponseCode(Agana_Http_StatusCodes::HTTP_NOT_FOUND);
            $response->setBody(Agana_Http_StatusCodes::getMessageForCode(Agana_Http_StatusCodes::HTTP_NOT_FOUND));
        }
    }

}

