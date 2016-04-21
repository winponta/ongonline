<?php

/**
 * Admin controller from Person module of Agana fwk
 */
class Persons_PersonController extends Agana_Controller_Crud_Action {

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

        $this->setDomainClass(new Persons_Domain_Person());
        $this->setViewVarName('person');
        $this->setViewVarListName('persons');
        $this->setViewListOrderBy('name');
        $this->setFormCRUName('Persons_Form_Person');
        $this->setFormDName('Persons_Form_PersonDelete');
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

    protected function _getBootstrapOptions() {
        // get bootstrap options
        if ($this->_bootOptions === null) {
            $return = array();

            $boot = Agana_Util_Bootstrap::getBootstrap('persons');
            if (isset($boot)) {
                if (count($boot->getOptions())) {
                    $options = $boot->getOptions();

                    $return['allowedExtensions'] = explode(',', $options['upload']['image']['extensions']);
                    $return['maxSize'] = $options['upload']['image']['maxsize'];
                    $return['path'] = $options['upload']['image']['path'];
                    $return['dimensions'] = array();
                    if (isset($options['upload']['image']['origin']['width'])) {
                        $return['dimensions']['origin']['width'] = $options['upload']['image']['origin']['width'];
                    }
                    if (isset($options['upload']['image']['origin']['height'])) {
                        $return['dimensions']['origin']['height'] = $options['upload']['image']['origin']['height'];
                    }
                    if (isset($options['upload']['image']['large']['width'])) {
                        $return['dimensions']['large']['width'] = $options['upload']['image']['large']['width'];
                    }
                    if (isset($options['upload']['image']['large']['height'])) {
                        $return['dimensions']['large']['height'] = $options['upload']['image']['large']['height'];
                    }
                    if (isset($options['upload']['image']['medium']['width'])) {
                        $return['dimensions']['medium']['width'] = $options['upload']['image']['medium']['width'];
                    }
                    if (isset($options['upload']['image']['medium']['height'])) {
                        $return['dimensions']['medium']['height'] = $options['upload']['image']['medium']['height'];
                    }
                    if (isset($options['upload']['image']['small']['width'])) {
                        $return['dimensions']['small']['width'] = $options['upload']['image']['small']['width'];
                    }
                    if (isset($options['upload']['image']['small']['height'])) {
                        $return['dimensions']['small']['height'] = $options['upload']['image']['small']['height'];
                    }
                    if (isset($options['upload']['image']['tiny']['width'])) {
                        $return['dimensions']['tiny']['width'] = $options['upload']['image']['tiny']['width'];
                    }
                    if (isset($options['upload']['image']['tiny']['height'])) {
                        $return['dimensions']['tiny']['height'] = $options['upload']['image']['tiny']['height'];
                    }
                }
            }

            $this->_bootOptions = $return;
        }

        return $this->_bootOptions;
    }

    private function _updateImage() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = Zend_Layout::getMvcInstance();
        $layout->disableLayout();

        $return = array(
            'msg' => '',
            'file' => array(
                'name' => '',
                'size' => '',
                'url' => '',
            ),
        );

        if ($this->getRequest()->isPost()) {
            $allowedExtensions = null;
            $maxSize = 999999;
            $path = '';

            $options = $this->_getBootstrapOptions();

            // UPLOAD of image
            $domainImage = new Media_Domain_Image();
            $title = 'person_' . $this->_getParam('id');
            $file = $domainImage->handleUpload(
                    APPLICATION_DATA_PATH, array(
                'AllowedExtensions' => $options['allowedExtensions'],
                'SizeLimit' => $options['maxSize'],
                'Dimensions' => $options['dimensions'],
                    )
            );

            if (isset($file['error'])) {
                $return['error'] = $file['error'];
            } else {
                // MEDIA MODEL
                $image = new Media_Model_Image();
                $image->setFile($file['name']);
                $image->setFilesize($file['size']);
                $image->setMimetype($file['type']);
                $image->setTitle($title);

                // RECOVER Media from Person
                $domainPerson = new Persons_Domain_Person();
                $person = $domainPerson->getById($this->_getParam('id'));
                $mp = $person->getMedia();

                $createPersonMedia = !isset($mp) || $mp->getId() == null;
                if (!$createPersonMedia) {
                    $image->setId($mp->getId());
                }

                $domainImage->setImage($image);
                // DELETE previous image file from disk, only if they are not the same
                if (!$createPersonMedia) {
                    if ($mp->getFile() != $image->getFile()) {
                        $domainImage->setImage($mp);
                        $domainImage->deleteFile();
                        $domainImage->setImage($image);
                    }
                }

                try {
                    // persisting media
                    $imgId = $domainImage->save();

                    // persisting person media
                    $image->setId($imgId);
                    $person->setMedia($image);
                    $domainPerson->setPerson($person);

                    if ($createPersonMedia) {
                        $domainPerson->createImageRelation();
                    }

                    $return['msg'] = $this->_translate->_('File successfully uploaded');
                    $return['file'] = $file;
                } catch (Exception $e) {
                    echo json_encode(array('error' => $e->getMessage()));
                }
            }
            echo json_encode($return);
        }
    }

    public function updateAction() {
        try {
            if ($this->_hasParam('image')) {
                if ($this->_isUserAllowed(null, null)) {
                    return $this->_updateImage();
                }
            } else {
                $url = array(
                    'action' => 'getgm',
                    'controller' => 'person',
                    'module' => 'persons',
                );

                if ($this->_hasParam('id')) {
                    $url['id'] = $this->_getParam('id');
                }
                $this->setRedirectActionAfterUpdateSuccess($url);
                $this->setRedirectActionAfterUpdateCancel($url);
                parent::updateAction();
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

    public function getAction() {
        if ($this->_isUserAllowed(null, null)) {
            if ($this->_hasParam('id') || $this->_hasParam('person')) {
                $id = $this->_getParam('id') ? $this->_getParam('id') : $this->_getParam('person');
                $domain = new Persons_Domain_Person();
                $person = $domain->getById($id);

                if ($person) {
                    $this->view->person = $person;
                } else {
                    $this->_redirectWithMsg(
                            'Id ' . $this->_getParam('id') . ' not found', 'error', 'list', 'person', 'persons'
                    );
                }
            }
        }
    }
    
    public function getgmAction() {
        $this->getAction();
    }

    public function imageUrlAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $personDomain = new Persons_Domain_Person();
        
        $person = new Persons_Model_Person();
        $person = $personDomain->getById($this->getRequest()->getParam('id'));
        
        $urlImg = $this->view->baseUrl() . $this->view->path_img . '/no-picture.jpg';
        if ( ! is_null($person->getMedia()->getFile())) {
            $urlImg = $this->view->url(array(
                'module' => 'media', 'controller' => 'image', 'action' => 'get',
                'file' => $person->getMedia()->getFile(),
            ), null, true);
        }
        echo $urlImg;
    }

    public function uploadImageAction() {
        $domain = new Persons_Domain_Person();
        $person = $domain->getById($this->_request->getParam('id'));
        $this->view->person = $person;
    }

    public function listAction() {
        $this->_forward('list', 'persons');
    }

    public function searchFormAction() {
        $this->view->form = new Persons_Form_PersonSearch();
    }

    public function searchAction() {
        $translate = Zend_Registry::get('Zend_Translate');

        if ($this->getRequest()->isPost()) {
            $term = trim($this->getRequest()->getParam('term'));
            if ($term == '') {
                $this->view->msg = $translate->_('Please enter some term to do the search');
                $this->view->persons = array();
            } else {

                $pd = new Persons_Domain_Person();

                $this->view->persons = $pd->searchByName($term, Zend_Auth::getInstance()->getIdentity()->appaccount_id);
                if (count($this->view->persons) == 0) {
                    $this->view->msg = $translate->_('No match found');
                } else {
                    $this->view->msg = $translate->_('Click on image to select');
                }
            }
        } else {
            $this->view->msg = $translate->_('This function must be accessed by a post method');
        }
    }

    public function pdfRecordAction() {
        if ($this->_isUserAllowed(null, null)) {
            if ($this->_hasParam('id') || $this->_hasParam('person')) {
                $id = $this->_getParam('id') ? $this->_getParam('id') : $this->_getParam('person');
                $domain = new Persons_Domain_Person();
                $person = $domain->getById($id);

                if ($person) {
                    $this->view->person = $person;
                } else {
                    $this->_redirectWithMsg(
                            'Id ' . $this->_getParam('id') . ' not found', 'error', 'list', 'person', 'persons'
                    );
                }
            }
        }
    }

    public function pdfFullRecordAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        //$content = $this->view->action('get', 'person', 'persons', $this->_getAllParams());

        $personDomain = new Persons_Domain_Person();
        $person = $personDomain->getById($this->_getParam('id'));
        $appAccount = $person->getAppaccount();
        
        $pdf = new Agana_Print_Pdf_Report('FICHA PESSOAL', $appAccount->getName(), 'ONG ONLINE', $this->view->theme_path);
        
        $content = '';
        $allModules = Zend_Registry::getInstance()->get('Person-Dependency-Domain');
        foreach ($allModules as $module) {
            /**
             * get class and method to call to verifie person record reference
             */
            $domain = new $module['domain']['class'];
            $method = (isset($module['domain']['method'])) ? $module['domain']['method'] : 'getById';

            /**
             * if there is at least a record  for this module
             * builds the get navigation menu entry
             */
            $params = $this->_getAllParams();
            $params['person'] = $this->_getParam('id');
            $hasReference = $domain->$method($this->_getParam('id'));
            if ($hasReference) {
                if (isset($module['pdf']['action'])) {
                    $content .= $this->view->action(
                            $module['pdf']['action'], 
                            $module['pdf']['controller'],
                            $module['pdf']['module'],
                            $params
                        );

                }
            }
        }
        
        $pdf->addPage($content);
        $pdf->download();
    }

}

