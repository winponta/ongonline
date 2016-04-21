<?php

/**
 * Theme Controller perform actions related to Themes
 */
class Aganacore_ThemeController extends Zend_Controller_Action {

    /**
     * Redirector - defined for redirector action after switching to new theme
     * 
     * @var Zend_Controller_Action_Helper_Redirector
     */
    protected $_redirector = null;

    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');
    }

    public function indexAction() {
        $this->view->assign("content", "ACTION INDEX OF THEME CONTROLLER");
    }

    /**
     * Switch the actual theme seting it on session
     * 
     * @todo improve it to persist the theme through sessions
     */
    public function switchAction() {
        if ($this->_hasParam("to")) {
            $themeSession = new Zend_Session_Namespace("theme");
            $themeSession->themeName = $this->_getParam("to");
        }

        $this->_redirector->gotoSimple("index", "index", "aganacore");
    }

}

