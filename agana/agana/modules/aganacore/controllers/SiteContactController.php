<?php

/**
 * The Site Contact controller parsers post request and send mail contact message from web site
 * The post requests come from a RESTFul route defined in aganacore Bootstrap class
 * 
 * @author Ademir Mazer Jr (Nuno) <ademir.mazer.jr@gmail.com>
 */
class Aganacore_SiteContactController extends Agana_Rest_Controller {

    /**
     *@var Agana_Form_SiteContact
     */
    protected $_form = null;
    
    /**
     * Default address to send the email contact
     * @var String
     */
    protected $_toAdrress = "";
    
    /**
     * Default subject to send the email contact
     * @var String
     */
    protected $_subjectLabel = "Site Contact";

    public function init() {
        $layout = Zend_Layout::getMvcInstance();

        $view = $layout->getView();

        $layout->disableLayout();

        $this->_helper->viewRenderer->setNoRender(true);

        // get the config options
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
        $options = $bootstrap->getOption('agana');

        if (isset($options['contact']['toAddress'])) {
            $this->_toAdrress = $options['contact']['toAddress'];
        }

        if (isset($options['contact']['subjectLabel'])) {
            $this->_subjectLabel = $options['contact']['subjectLabel'];
        }

        $this->_form = new Agana_Form_SiteContact();
    }

    /**
     * Index action does all the work. It parsers post parameter, if the method is not POST
     * then an 'error' message is returned.
     * 
     * Configurations are done int the agana.ini file. The configurations parameters are:
     * - agana.contact.subjectLabel = "[Subject Label]"
     * - agana.contact.toAddress  = "mail@address.com"
     * 
     * @author Ademir Mazer Jr (Nuno) <ademir.mazer.jr@gmail.com>
     * @todo handle if it is the POST method and validate parameters
     * @todo internationalization
     * @param String name 
     * @param String email
     * @param String message
     * @param String subject
     */
    public function indexAction() {
        $this->getAction();
    }

    private function _renderForm() {
        $this->view->form = $this->_form;
        echo $this->view->render('site-contact/get.phtml');
    }

    public function getAction() {
        if (! $this->_request->isXmlHttpRequest()) {
            $this->_helper->layout->enableLayout();
        }
        $this->_renderForm();
    }

    /**
     * sends the contact email
     */
    public function postAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->_form->isValid($request->getPost())) {
                try {
                    $cm = new Agana_Model_ContactMail($_POST);
                    $cm->setTo($this->_toAdrress);
                    $cm->setSubject($this->_subjectLabel . " " . $cm->getSubject());

                    $contactMail = new Agana_Domain_ContactMail($cm);
                    $contactMail->send();

                    $msg = "Contact mail sent";
                    if ($this->_request->isXmlHttpRequest()) {
                        // returning 200 Ok code if the mail has been sent with no exception
                        $this->getResponse()->setHttpResponseCode(200);
                        // TODO translate
                        $this->getResponse()->appendBody($msg);
                    } else {
                        $this->_helper->flashMessenger->addMessage(
                            array('success' => $msg));
                            $this->_helper->layout->enableLayout();
                            $this->_renderForm();
                    }
                } catch (Exception $e) {
                    $translate = Zend_Registry::get('Zend_Translate');
                    $msg = $translate->_('Sending contact mail problems');
                    $msg = $msg . ' <br/> ' . $e->getMessage();

                    if ($this->_request->isXmlHttpRequest()) {
                        $this->getResponse()->setHttpResponseCode(500);
                        // TODO translate
                        $this->getResponse()->appendBody($msg);
                    } else {
                    $this->_helper->flashMessenger->addMessage(
                        array('error' => $msg));
                        $this->_helper->layout->enableLayout();
                        $this->_renderForm();
                    }
                }
            } else { // Form POST not valid
                if (! $this->_request->isXmlHttpRequest()) {
                    $this->_helper->flashMessenger->addMessage(
                        array('validation' => 'Some problem with fields content.'));

                    $this->_helper->layout->enableLayout();

                    $this->_renderForm();
                }
            }
        }
    }

}

