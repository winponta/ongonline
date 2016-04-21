<?php

/**
 * Finger print controller from Person module of Agana fwk
 */
class Persons_PersonFingerprintController extends Agana_Controller_Crud_Action {

    /**
     * @var Zend_Translate
     */
    private $_translate = null;

    /**
     * @var array 
     */
    private $_bootOptions = null;

    public function init() {
        parent::init();

        $this->_translate = Zend_Registry::getInstance()->get('Zend_Translate');

        $this->setDomainClass(new Persons_Domain_PersonFingerprint());
        $this->setViewVarName('fp');
        $this->setViewVarListName('fps');
        $this->setViewListOrderBy('finger_number');
        $this->setFormCRUName('Persons_Form_PersonFingerprint');
        $this->setFormDName('Persons_Form_PersonFingerprintDelete');
    }

    protected function _isUserAllowed($resource, $privilege) {
        parent::_isUserAllowed($resource, $privilege);
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        } else {
            $this->_redirectLogin();
            return false;
        }
    }

    public function listAction() {
        try {
            if ($this->_isUserAllowed(null, null)) {
                $this->view->assign($this->getViewVarListName(), $this->getDomainClass()->getAll($this->getRequest()->getParam('person')));
                $personDomain = new Persons_Domain_Person();
                $this->view->assign('person', $personDomain->getById($this->getRequest()->getParam('person')));
                $this->view->form = new Persons_Form_PersonFingerprint(Persons_Form_PersonFingerprint::ACTION_ADD);
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }

    public function enrollAction() {
        try {
            $request = $this->getRequest();

            if ($this->hasParam("person_id") && $this->hasParam('finger_number')) {
                $id = $this->getParam("person_id");
                $finger = $this->getParam("finger_number");

                $f = $this->getFormCRUName();
                $form = new $f($f::ACTION_EDIT);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if (isset($data['save'])) {
                        if ($form->isValid($request->getPost())) {
                            try {
                                $this->getDomainClass()->delete($id, $finger);
                                $this->_createRecord($form->getValues());
                                $urlSuccess = $this->getUrlRedirectionUpdateSuccess();
                                $urlSuccess['person'] = $request->getParam('person_id');
                                $this->_formSuccess($urlSuccess);
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                            }
                        } else {
                            $this->_addFormValidationMessage();
                        }
                    } else {
                        if ($form->cancel->isChecked()) {
                            $this->_formCancel($this->getUrlRedirectionUpdateCancel());
                        }
                    }
                }

                $this->view->form = $form;
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'Param id missing'));
                $this->_helper->redirector(array(
                    'action' => $this->_redirectActionAfterUpdateCancel, 
                    'controller' => $request->getControllerName(), 
                    'module' => $request->getModuleName()
                ));
                return;
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }

    public function createAction() {
        if ($this->_request->isPost()) {
            $url = array(
                'action' => 'getgm',
                'controller' => 'person',
                'module' => 'persons',
            );

            $this->setUseIdCreatedOnUrl(TRUE);
            $this->setRedirectActionAfterCreateSuccess($url);
        }

        parent::createAction();
    }

}
