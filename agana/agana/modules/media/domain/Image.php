<?php

class Media_Domain_Image {

    /**
     *
     * @var Media_Model_Image
     */
    protected $_image = null;

    public function __construct($image = null) {
        if (is_null($image)) {
            $image = new Media_Model_Image();
        }
        $this->setImage($image);
    }

    protected function getBootstrapOptions() {
        $boot = Agana_Util_Bootstrap::getBootstrap('media');
        if (isset($boot)) {
            if (count($boot->getOptions())) {
                return $boot->getOptions();
            }
        }

        return null;
    }

    public function handleUpload($path, $paramOptions = array()) {
        $options = array(
            'UseFileExtension' => true,
            'AllowedExtensions' => array(),
            'SizeLimit' => 10485760,
            'ReturnJson' => false,
            'MinWidth' => 0,
            'MinHeigth' => 0,
            'MaxWidth' => -1,
            'MaxHeigth' => -1,
            'Dimensions' => array(),
        );

        $options = array_merge($options, $paramOptions);

        try {
            $bootOptions = $this->getBootstrapOptions();

            $path = Agana_Util_FileHandle::fixPathSeparator($path);
            $path .= $bootOptions['image']['subfolder'];

            $up = new Agana_FileUploader();

            $up->setAllowedExtensions($options['AllowedExtensions']);
            $up->setSizeLimit($options['SizeLimit']);
            $up->setPath($path);
            $up->setOverwrite(true);
            $up->setRename(true);
            $up->setUseMd5Name(true);
            $up->setUsePathNameDivision(true);
            $up->setUseFileExtension($options['UseFileExtension']);
            $up->setDimensions($options['Dimensions']);

            $result = $up->handleUpload();

            if (!isset($result['error'])) {
                
            }
        } catch (Agana_Exception $e) {
            $result = array('error' => $e->getMessage());
        }

        if ($options['ReturnJson']) {
            // to pass data through iframe you will need to encode all html tags
            return htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        } else {
            return $result;
        }
    }

    /**
     * @return Media_Model_Image
     */
    public function getImage() {
        return $this->_image;
    }

    /**
     * @param Media_Model_Image 
     */
    public function setImage($image) {
        if (!($image instanceof Media_Model_Image) && !is_null($image)) {
            $image = new Media_Model_Image($image);
        }
        $this->_image = $image;
    }

    public function populate($data) {
        Agana_Data_BeanUtil::populate($this->_image, $data);
    }

    public function save() {
        if ($this->_isAllowed()) {
            try {
                $u = new Media_Persist_Dao_Image();
                $i = $u->save($this->_image);

                return $i;
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function create() {
        if ($this->_isAllowed()) {
            try {
                $u = new Media_Persist_Dao_Image();
                return $u->save($this->_image);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function update() {
        if ($this->_isAllowed()) {
            try {
                $u = new Media_Persist_Dao_Image();
                return $u->save($this->_image);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function delete() {
        if ($this->_isAllowed()) {
            try {
                $u = new Media_Persist_Dao_Image();
                return $u->delete($this->_image->getId());
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    public function getById($id) {
        try {
            $u = new Media_Persist_Dao_Image();
            return $u->get($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getByFileName($name) {
        try {
            $u = new Media_Persist_Dao_Image();
            return $u->getByFileName($name);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Searchs persistence and returns a media by its relation with the table name
     * @param string relation table name
     * @param integer id value on relation table
     * @return Media_Model_Image
     * @throws Agana_Exception 
     */
    public function getByRelation($relation, $id) {
        try {
            $u = new Media_Persist_Dao_Image();
            return $u->getByRelation($relation, $id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function _isAllowed() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            throw new Agana_Exception('You don not have permission to access this');
        } else {
            return true;
        }
    }

    public function getRealPath() {
        $options = $this->getBootstrapOptions();
        $levels = $options['image']['folderlevels'];
        $divisionByLevel = explode(',', $options['image']['folderdivisions']);
        $path = APPLICATION_DATA_PATH;
        $path = Agana_Util_FileHandle::fixPathSeparator($path) . $options['image']['subfolder'];
        $path = Agana_Util_FileHandle::fixPathSeparator($path) . Agana_Util_FileHandle::genFolderNameStructure($this->_image->getFile(), $levels, $divisionByLevel);

        return Agana_Util_FileHandle::fixPathSeparator($path);
    }

    /**
     * Loads the file content from disk
     * @param String $size
     * @return string file content 
     */
    public function loadFile($size = '') {
        $path = $this->getRealPath();

        $file = $path . Agana_Util_FileHandle::genFileNameByClassification(
                        $this->getImage()->getFile(), $size
        );

        if (file_exists($file)) {
            if (is_readable($file)) {
                return file_get_contents($file);
            } else {
                throw new Agana_Exception('Image file is nor readable');
            }
        } else {
            throw new Agana_Exception('Image file do not exist');
        }
    }

    public function deleteFile() {
        $path = Agana_Util_FileHandle::fixPathSeparator($this->getRealPath());
        $name = Agana_Util_FileHandle::getFileNameWithoutExtension($this->getImage()->getFile());
        $path = preg_replace('/(\*|\?|\[)/', '[$1]', $path);

        $files = glob($path . $name . '*');
        foreach ($files as $file) {
            unlink($file);
        }
    }

}

