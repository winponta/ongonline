<?php

/**
 * Index controller from Agana core module
 */
class Aganacore_IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    /**
     * executes the defult url if it is configured at agana.ini file
     * with agana.defaulturl parameter
     */
    public function indexAction() {
        $options = Agana_Util_Bootstrap::getOption('agana');

        //Zend_Debug::dump(Agana_Api_Util_Bootstrap::getBootstrap()->getOptions());

        if (isset($options['defaultdispatch'])) {
            if (strtolower(trim($options['defaultdispatch'])) == 'redirect') {
                if (trim($options['defaulturl']) != '') {
                    $this->_redirect($options['defaulturl']);
                } else {
                    $redirect = new Zend_Controller_Action_Helper_Redirector();
                    $redirect->gotoSimpleAndExit($options['defaultaction'], $options['defaultcontroller'], $options['defaultmodule']);
                }
            } else if (strtolower(trim($options['defaultdispatch'])) == 'forward') {
                $this->_forward($options['defaultaction'], $options['defaultcontroller'], $options['defaultmodule']);
            }

        }
    }

    public function aboutAction() {
        if ($this->_request->isXmlHttpRequest()) {
            $layout = Zend_Layout::getMvcInstance();
            $layout->disableLayout();
        }
    }

}

