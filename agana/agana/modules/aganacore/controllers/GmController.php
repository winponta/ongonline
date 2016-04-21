<?php
/**
 * Gui Manager controller from Agana core module
 */
class Aganacore_GmController extends Zend_Controller_Action {


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
    
    public function indexAction() {
        if ($this->_hasParam('id')) {
            $gm = new Agana_Domain_Gm();
            $gm->loadGroup($this->_getParam('id'));
            
            $this->view->gm = $gm;
            
            $view = 'index-nav-';
            
            if ($this->hasParam('direction')) {
                $view .= $this->getParam('direction');
            } else {
                $view .= 'top';
            }
            
            return $this->render($view);
        } else {
            throw new Agana_Exception("Missing group in gm module call");
        }
    }
    
    public function reportAction() {
        if ($this->_hasParam('id')) {
            $gm = new Agana_Domain_Gm();
            $gm->loadReport($this->_getParam('id'));
            
            $this->view->gm = $gm;
            
            $view = 'index-nav-';
            
            if ($this->hasParam('direction')) {
                $view .= $this->getParam('direction');
            } else {
                $view .= 'top';
            }
            
            return $this->render($view);
        } else {
            throw new Agana_Exception("Missing id in gm module call");
        }        
    }

}

