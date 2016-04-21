<?php

/**
 * User guide controller from Agana core module
 */
class Aganacore_UserguideController extends Agana_Controller_Action {

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

    public function initView() {
        parent::initView();

        $view->setFilter('Shortcode');
    }

    public function indexAction() {
        $this->_forward('get');
    }

    public function getAction() {
        if ($this->_hasParam('page')) {
            $ug = new Agana_Domain_Userguide($this->_getParam('page'));

            $this->view->isEditAllowed = $ug->isEditAllowed();

            if ($ug->pageExists()) {
                $this->view->page = $ug->render();
            } else {
                $page['name'] = $this->_getParam('page');
                $this->view->page = $page;
                $this->renderScript('userguide/pagenotfound.phtml');
            }
        } else {
            $this->view->page['content'] = 'ERROR - "page" param not found';
        }
    }

    public function createAction() {
        if ($this->_hasParam('page')) {
            $ug = new Agana_Domain_Userguide($this->_getParam('page'));

            $this->view->page = $this->_getParam('page');

            if ($ug->pageExists()) {
                $this->_forward('update');
            } else {
                try {
                    if ($ug->isEditAllowed()) {

                        $model = new Agana_Model_Userguide();
                        $model->setPage($this->_getParam('page'));

                        $form = new Agana_Form_Userguide(Agana_Form_Userguide::ACTION_ADD, $model);

                        $request = $this->getRequest();

                        if ($request->isPost()) {
                            $data = $request->getPost();
                            $form->populate($data);
                            if ($form->save->isChecked()) {
                                if ($form->isValid($data)) {
                                    try {
                                        $model->setPage($request->getParam('page'));
                                        $model->setTitle($request->getParam('title'));
                                        $model->setContent($request->getParam('content'));

                                        $ug->create($model);

                                        $this->_formSuccess(array(
                                            'action' => 'get', 'controller' => 'userguide', 'module' => 'aganacore',
                                            'page' => $model->page));
                                    } catch (Exception $e) {
                                        $this->_addSavingExceptionMessage($e);
                                    }
                                } else {
                                    $this->_addFormValidationMessage();
                                }
                            } else {
                                if ($form->cancel->isChecked()) {
                                    $this->_helper->redirector(array('action' => 'list', 'controller' => $request->getControllerName(), 'module' => $request->getModuleName()));
                                }
                            }
                        }
                        $this->view->form = $form;
                    }
                } catch (Exception $e) {
                    $this->_addExceptionMessage($e);
                }
            }
        } else {
            $this->view->guideContent = 'ERROR - "page" param not found';
        }
    }

    public function updateAction() {
        if ($this->_hasParam('page')) {
            $ug = new Agana_Domain_Userguide($this->_getParam('page'));

            if ($ug->pageExists()) {
                try {
                    if ($ug->isEditAllowed()) {
                        $model = new Agana_Model_Userguide($ug->loadPage());
                        $model->setPage($this->_getParam('page'));
                        $this->view->page = $model->toArray();

                        if ($ug->isWritable()) {
                            $form = new Agana_Form_Userguide(Agana_Form_Userguide::ACTION_ADD, $model);

                            $request = $this->getRequest();

                            if ($request->isPost()) {
                                $data = $request->getPost();
                                $form->populate($data);
                                if ($form->save->isChecked()) {
                                    if ($form->isValid($data)) {
                                        try {
                                            $model->setTitle($request->getParam('title'));
                                            $model->setContent($request->getParam('content'));
                                            $this->view->page = $model->toArray();

                                            $ug->update($model);

                                            $this->_formSuccess(array('action' => 'get', 'controller' => 'userguide', 'module' => 'aganacore'));
                                        } catch (Exception $e) {
                                            $this->_addSavingExceptionMessage($e);
                                        }
                                    } else {
                                        $this->_addFormValidationMessage();
                                    }
                                } else {
                                    if ($form->cancel->isChecked()) {
                                        $this->_helper->redirector(array('action' => 'list', 'controller' => $request->getControllerName(), 'module' => $request->getModuleName()));
                                    }
                                }
                            }
                            $this->view->form = $form;
                        } else {
                            $this->view->guideContent = 'ERROR - "page" is not writable';
                        }
                    }
                } catch (Exception $e) {
                    $this->_addExceptionMessage($e);
                }
            }
        } else {
            $this->view->guideContent = 'ERROR - "page" param not found';
        }
    }

    protected function _isUserAllowed($resource, $privilege) {
        
    }

}

