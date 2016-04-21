<?php

/**
 * Agana Controller Crud Action to be extended from others CRUD MVC controllers
 */
abstract class Agana_Controller_Crud_Action extends Agana_Controller_Action {

    /**
     * The wrap for domain class in crud controller
     * @var Agana_Domain
     */
    protected $_domainClass = null;

    /**
     * The name of form class to Create, Update and Recover (Details) in crud controller
     * @var Agana_Form
     */
    protected $_formCRUName = null;

    /**
     * The name of form class to Delete in crud controller
     * @var Agana_Form
     */
    protected $_formDName = null;

    /**
     * The name of variable that will be assigned to view with the crud 
     * @var String
     */
    protected $_viewVarName = 'record';

    /**
     * The name of variable that will be assigned to view with the list results
     * @var String
     */
    protected $_viewVarListName = 'list';
    
    /**
     * The name of action to be redirected after create action is performed
     * @var String Default = list
     */
    protected $_redirectActionAfterCreateSuccess = 'list';

    /**
     * The name of action to be redirected if create action is canceled in form
     * @var String Default = list
     */
    protected $_redirectActionAfterCreateCancel = 'list';

    /**
     * The name of action to be redirected after update action is performed
     * @var String Default = list
     */
    protected $_redirectActionAfterUpdateSuccess = 'list';

    /**
     * The name of action to be redirected if update action is canceled in form
     * @var String Default = list
     */
    protected $_redirectActionAfterUpdateCancel = 'list';
    
    /**
     * If this is seted true then in create action the id returned
     * from inser is used on url
     * @var boolean
     */
    protected $_useIdCreatedOnUrl = false;

    /**
     * The field name to order by sql in list view
     * @var String
     */
    protected $_viewListOrderBy = '';
    protected $_usePaginator = true;

    public function getUseIdCreatedOnUrl() {
        return $this->_useIdCreatedOnUrl;
    }

    /**
     * 
     * @param boolean $_userIdCreatedOnUrl
     */
    public function setUseIdCreatedOnUrl($_userIdCreatedOnUrl) {
        $this->_useIdCreatedOnUrl = $_userIdCreatedOnUrl;
    }

    public function getUsePaginator() {
        return $this->_usePaginator;
    }

    public function setUsePaginator($usePaginator) {
        $this->_usePaginator = $usePaginator;
    }

    public function setDomainClass($c) {
        $this->_domainClass = $c;
    }

    public function getDomainClass() {
        return $this->_domainClass;
    }

    public function getViewVarName() {
        return $this->_viewVarName;
    }

    public function setViewVarName($_viewVarName) {
        $this->_viewVarName = $_viewVarName;
    }

    public function getViewVarListName() {
        return $this->_viewVarListName;
    }

    public function setViewVarListName($_viewVarListName) {
        $this->_viewVarListName = $_viewVarListName;
    }

    public function getFormCRUName() {
        return $this->_formCRUName;
    }

    public function setFormCRUName($_formCRUName) {
        $this->_formCRUName = $_formCRUName;
    }

    public function getFormDName() {
        return $this->_formDName;
    }

    public function setFormDName($_formDName) {
        $this->_formDName = $_formDName;
    }

    public function getViewListOrderBy() {
        return $this->_viewListOrderBy;
    }

    public function setViewListOrderBy($_viewListOrderBy) {
        $this->_viewListOrderBy = $_viewListOrderBy;
    }

    public function getRedirectActionAfterUpdateSuccess() {
        return $this->_redirectActionAfterUpdateSuccess;
    }

    public function setRedirectActionAfterUpdateSuccess($_redirectActionAfterUpdateSuccess) {
        $this->_redirectActionAfterUpdateSuccess = $_redirectActionAfterUpdateSuccess;
    }

    public function getRedirectActionAfterUpdateCancel() {
        return $this->_redirectActionAfterUpdateCancel;
    }

    public function setRedirectActionAfterUpdateCancel($_redirectActionAfterUpdateCancel) {
        $this->_redirectActionAfterUpdateCancel = $_redirectActionAfterUpdateCancel;
    }

    public function getRedirectActionAfterCreateSuccess() {
        return $this->_redirectActionAfterCreateSuccess;
    }

    public function setRedirectActionAfterCreateSuccess($_redirectActionAfterCreateSuccess) {
        $this->_redirectActionAfterCreateSuccess = $_redirectActionAfterCreateSuccess;
    }

    public function getRedirectActionAfterCreateCancel() {
        return $this->_redirectActionAfterCreateCancel;
    }

    public function setRedirectActionAfterCreateCancel($_redirectActionAfterCreateCancel) {
        $this->_redirectActionAfterCreateCancel = $_redirectActionAfterCreateCancel;
    }
    
    protected function getUrlRedirectionCreateSuccess() {
        if (is_array($this->_redirectActionAfterCreateSuccess)) {
            $urlRedirect['action'] = $this->_redirectActionAfterCreateSuccess['action'];
            unset($this->_redirectActionAfterCreateSuccess['action']);

            $urlRedirect['controller'] = (isset($this->_redirectActionAfterCreateSuccess['controller'])) ? 
                $this->_redirectActionAfterCreateSuccess['controller'] : $request->getControllerName();
            unset($this->_redirectActionAfterCreateSuccess['controller']);

            $urlRedirect['module'] = (isset($this->_redirectActionAfterCreateSuccess['module'])) ? 
                $this->_redirectActionAfterCreateSuccess['module'] : $request->getModuleName();                                    
            unset($this->_redirectActionAfterCreateSuccess['module']);

            foreach ($this->_redirectActionAfterCreateSuccess as $key => $value) {
                $urlRedirect[$key] = $value;
            }
        } else {
            $urlRedirect['action'] = (isset($this->_redirectActionAfterCreateSuccess)) ?
                $this->_redirectActionAfterCreateSuccess : 'index';
            $urlRedirect['controller'] = $this->getRequest()->getControllerName();
            $urlRedirect['module'] = $this->getRequest()->getModuleName();
        }
        
        return $urlRedirect;
    }
    
    public function getUrlRedirectionCreateCancel() {
        if (is_array($this->_redirectActionAfterCreateCancel)) {
            $urlRedirect['action'] = $this->_redirectActionAfterCreateCancel['action'];
            unset($this->_redirectActionAfterCreateCancel['action']);

            $urlRedirect['controller'] = (isset($this->_redirectActionAfterCreateCancel['controller'])) ? 
                $this->_redirectActionAfterCreateCancel['controller'] : $request->getControllerName();
            unset($this->_redirectActionAfterCreateCancel['controller']);

            $urlRedirect['module'] = (isset($this->_redirectActionAfterCreateCancel['module'])) ? 
                $this->_redirectActionAfterCreateCancel['module'] : $request->getModuleName();                                    
            unset($this->_redirectActionAfterCreateCancel['module']);

            foreach ($this->_redirectActionAfterCreateCancel as $key => $value) {
                $urlRedirect[$key] = $value;
            }

        } else {
            $urlRedirect['action'] = (isset($this->_redirectActionAfterCreateCancel)) ?
                $this->_redirectActionAfterCreateCancel : 'index';
            $urlRedirect['controller'] = $this->getRequest()->getControllerName();
            $urlRedirect['module'] = $this->getRequest()->getModuleName();
        }
        
        return $urlRedirect;
    }
    
    protected function getUrlRedirectionUpdateSuccess() {
        if (is_array($this->_redirectActionAfterUpdateSuccess)) {
            $urlRedirect['action'] = $this->_redirectActionAfterUpdateSuccess['action'];
            unset($this->_redirectActionAfterUpdateSuccess['action']);

            $urlRedirect['controller'] = (isset($this->_redirectActionAfterUpdateSuccess['controller'])) ? 
                $this->_redirectActionAfterUpdateSuccess['controller'] : $request->getControllerName();
            unset($this->_redirectActionAfterUpdateSuccess['controller']);

            $urlRedirect['module'] = (isset($this->_redirectActionAfterUpdateSuccess['module'])) ? 
                $this->_redirectActionAfterUpdateSuccess['module'] : $request->getModuleName();                                    
            unset($this->_redirectActionAfterUpdateSuccess['module']);

            foreach ($this->_redirectActionAfterUpdateSuccess as $key => $value) {
                $urlRedirect[$key] = $value;
            }
        } else {
            $urlRedirect['action'] = (isset($this->_redirectActionAfterUpdateSuccess)) ?
                $this->_redirectActionAfterUpdateSuccess : 'index';
            $urlRedirect['controller'] = $this->getRequest()->getControllerName();
            $urlRedirect['module'] = $this->getRequest()->getModuleName();
        }
        
        return $urlRedirect;
    }
    
    public function getUrlRedirectionUpdateCancel() {
        if (is_array($this->_redirectActionAfterUpdateCancel)) {
            $urlRedirect['action'] = $this->_redirectActionAfterUpdateCancel['action'];
            unset($this->_redirectActionAfterUpdateCancel['action']);

            $urlRedirect['controller'] = (isset($this->_redirectActionAfterUpdateCancel['controller'])) ? 
                $this->_redirectActionAfterUpdateCancel['controller'] : $request->getControllerName();
            unset($this->_redirectActionAfterUpdateCancel['controller']);

            $urlRedirect['module'] = (isset($this->_redirectActionAfterUpdateCancel['module'])) ? 
                $this->_redirectActionAfterUpdateCancel['module'] : $request->getModuleName();                                    
            unset($this->_redirectActionAfterUpdateCancel['module']);

            foreach ($this->_redirectActionAfterUpdateCancel as $key => $value) {
                $urlRedirect[$key] = $value;
            }

        } else {
            $urlRedirect['action'] = (isset($this->_redirectActionAfterUpdateCancel)) ?
                $this->_redirectActionAfterUpdateCancel : 'index';
            $urlRedirect['controller'] = $this->getRequest()->getControllerName();
            $urlRedirect['module'] = $this->getRequest()->getModuleName();
        }
        
        return $urlRedirect;
    }
    
    public function indexAction() {
        $this->_forward('list');
    }

    public function listAction() {
        try {
            if ($this->_isUserAllowed(null, null)) {
                if (!is_null($this->getDomainClass())) {
                    $this->view->assign($this->getViewVarListName(), $this->getDomainClass()->getAll($this->getViewListOrderBy()));
                } else {
                    throw new Agana_Exception('No domain class defined at list action on ' . __CLASS__);
                }
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }

    protected function _createRecord($data) {
        $this->getDomainClass()->populate($data);

        try {
            return $this->getDomainClass()->create();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    public function createAction() {
        try {
            if ($this->_isUserAllowed(null, null)) {

                $f = $this->getFormCRUName();
                $form = new $f($f::ACTION_ADD);

                $request = $this->getRequest();

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if ($form->save->isChecked()) {
                        if ($form->isValid($data)) {
                            try {
                                $id = $this->_createRecord($form->getValues());
                                
                                $urlRedirect = $this->getUrlRedirectionCreateSuccess();
                                
                                if ($this->_useIdCreatedOnUrl && $id) {
                                    $urlRedirect['id'] = $id;
                                }
                                
                                $this->_formSuccess($urlRedirect);
                            } catch (Exception $e) {
                                $this->_addSavingExceptionMessage($e);
                            }
                        } else {
                            $this->_addFormValidationMessage();
                        }
                    } else {
                        if ($form->cancel->isChecked()) {
                            $urlRedirect = $this->getUrlRedirectionCreateCancel();
                            $this->_formCancel($urlRedirect);
                        }
                    }
                }
                $this->view->form = $form;
            }
        } catch (Exception $e) {
            $this->_addExceptionMessage($e);
        }
    }

    protected function _updateRecord($data) {
        $this->getDomainClass()->populate($data);

        try {
            return $this->getDomainClass()->update();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    public function updateAction() {
        try {
            $request = $this->getRequest();

            if ($this->_hasParam("id")) {

                $id = $this->_getParam("id");

                $record = $this->getDomainClass()->getById($id);

                $f = $this->getFormCRUName();
                $form = new $f($f::ACTION_EDIT, $record);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if ($form->save->isChecked()) {
                        if ($form->isValid($request->getPost())) {
                            try {
                                $this->_updateRecord($form->getValues());
                                $this->_formSuccess($this->getUrlRedirectionUpdateSuccess());
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

    protected function _deleteRecord($data) {
        $this->getDomainClass()->populate($data);

        try {
            return $this->getDomainClass()->delete();
        } catch (Agana_Exception $ae) {
            throw $ae;
        }
    }

    public function deleteAction() {
        if ($this->_isUserAllowed(null, null)) {
            if ($this->_hasParam("id")) {

                $id = $this->_getParam("id");
                $request = $this->getRequest();

                $record = $this->getDomainClass()->getById($id);

                $f = $this->getFormDName();
                $form = new $f($record);

                if ($request->isPost()) {
                    $data = $request->getPost();
                    $form->populate($data);
                    if ($form->confirm->isChecked()) {
                        try {
                            $this->_deleteRecord($form->getValues());
                            $this->_formSuccess(array('action' => 'list', 'controller' => $request->getControllerName(), 'module' => $request->getModuleName()), 'Record deleted');
                        } catch (Exception $e) {
                            $this->_helper->flashMessenger->addMessage(
                                    array('error' => 'Some problem occur when tried to delete the record')
                            );
                            $this->_helper->redirector(array('action' => 'list', 'controller' => $request->getControllerName(), 'module' => $request->getModuleName()));
                        }
                    } else {
                        $this->_helper->redirector(array('action' => 'list', 'controller' => $request->getControllerName(), 'module' => $request->getModuleName()));
                    }
                }

                $this->view->form = $form;
            } else {
                $this->_helper->flashMessenger->addMessage(
                        array('error' => 'Param id missing'));
                $this->_helper->redirector(array('action' => 'list', 'controller' => $request->getControllerName(), 'module' => $request->getModuleName()));
                return;
            }
        }
    }

}