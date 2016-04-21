<?php

class Agana_FileUploader {

//    private $_qqFileUploader;
//
//    public function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
//        $this->_qqFileUploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//    }
//
//    public function handleUpload($path) {
//        $result = $this->_qqFileUploader->handleUpload($path);
//    }

    private $_allowedExtensions = null;
    private $_sizeLimit = 0;

    /**
     * @var Zend_File_Transfer_Adapter_Abstract 
     */
    private $_adapter = null;
    private $_path = '';
    private $_name = '';
    private $_rename = false;
    private $_useFileExtension = true;
    private $_overwrite = false;
    private $_useMd5Name = true;
    private $_usePathNameDivision = true;
    private $_nameDivisionLevels = 3;
    private $_nameDivisionCharsByLevel = array(1, 2, 2);
    private $_dimensions = array();

    public function getUsePathNameDivision() {
        return $this->_usePathNameDivision;
    }

    public function setUsePathNameDivision($usePathNameDivision) {
        $this->_usePathNameDivision = $usePathNameDivision;
    }

    public function getUseMd5Name() {
        return $this->_useMd5Name;
    }

    public function setUseMd5Name($useMd5Name) {
        $this->_useMd5Name = $useMd5Name;
    }

    public function getDimensions() {
        return $this->_dimensions;
    }

    public function setDimensions($dimensions) {
        $this->_dimensions = $dimensions;
    }

    public function getNameDivisionLevels() {
        return $this->_nameDivisionLevels;
    }

    public function setNameDivisionLevels($nameDivisionLevels) {
        $this->_nameDivisionLevels = $nameDivisionLevels;
    }

    public function getNameDivisionCharsByLevel() {
        return $this->_nameDivisionCharsByLevel;
    }

    public function setNameDivisionCharsByLevel($nameDivisionCharsByLevel) {
        $this->_nameDivisionCharsByLevel = $nameDivisionCharsByLevel;
    }

    public function getAllowedExtensions() {
        return $this->_allowedExtensions;
    }

    public function setAllowedExtensions($allowedExtensions) {
        $this->_allowedExtensions = $allowedExtensions;
    }

    public function getSizeLimit() {
        return $this->_sizeLimit;
    }

    public function setSizeLimit($sizeLimit) {
        $this->_sizeLimit = $sizeLimit;
    }

    public function getAdapter() {
        return $this->_adapter;
    }

    public function setAdapter($adapter) {
        $this->_adapter = $adapter;
    }

    public function getPath() {
        return $this->_path;
    }

    public function setPath($path) {
        $this->_path = $path;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getRename() {
        return $this->_rename;
    }

    public function setRename($rename) {
        $this->_rename = $rename;
    }

    public function getUseFileExtension() {
        return $this->_useFileExtension;
    }

    public function setUseFileExtension($useFileExtension) {
        $this->_useFileExtension = $useFileExtension;
    }

    public function getOverwrite() {
        return $this->_overwrite;
    }

    public function setOverwrite($overwrite) {
        $this->_overwrite = $overwrite;
    }

    protected function validateClass() {
        if ($this->_rename) {
            if (!$this->_useMd5Name && ($this->_name) == '') {
                return array('error' => 'No name defined to File Uploader class rename file');
            }
        }

        if (trim($this->_path) == '') {
            return array('error' => 'Path not defined to File Uploader class');
        }

        if ($this->_sizeLimit == 0 || $this->_sizeLimit == null) {
            return array('error' => 'Size limit not defined to File Uploader class');
        }

        return true;
    }

    /**
     * Generates the path based on filename
     * 
     * @param String $filename
     * @return String the path to save file uploaded 
     */
    protected function _genPath($filename) {
        if ($this->_usePathNameDivision) {
            $path = Agana_Util_FileHandle::fixPathSeparator($this->_path) . Agana_Util_FileHandle::genFolderNameStructure($filename, $this->_nameDivisionLevels, $this->_nameDivisionCharsByLevel);
        } else {
            $path = $this->_path;
        }

        $path = Agana_Util_FileHandle::fixPathSeparator($path);
        
        return $path;
    }

    public function handleUpload() {
        $validate = $this->validateClass();
        if ($validate !== true) {
            return $validate;
        }

        $translate = Zend_Registry::get("Zend_Translate"); 
        
        $zft = new Zend_File_Transfer();
        $this->_adapter = $zft->getAdapter('http');

        if ($this->_adapter->isUploaded()) {
            if ($this->_rename) {
                if (!$this->_useMd5Name) {
                    $name = $this->_name;
                } else {
                    $name = $this->_adapter->getHash('md5');
                }

                if ($this->_useFileExtension) {
                    $extension = substr($this->_adapter->getFileName(null, false), strrpos($this->_adapter->getFileName(null, false), '.') + 1);
                    $name .= '.' . strtolower($extension);
                }
            }

            $path = $this->_genPath($name);

            if (Agana_Util_FileHandle::isWritableDir($path)) {
                $this->_adapter->addValidator('ExcludeExtension', false, 'php,exe,so,dll')
                        ->addValidator('Size', false, $this->_sizeLimit)
                        ->addValidator('Extension', false, $this->_allowedExtensions)
                        ->setDestination($path);

                if ($this->_rename) {
                    $this->_adapter->addFilter('Rename', array('target' => $path . $name, 'overwrite' => true));
                }

                if ($this->_adapter->isValid()) {
                    try {
                        $this->_adapter->receive();

                        $this->_adapter->setOptions(array('useByteString' => false));
                        $file = $this->_adapter->getFileInfo();
                        $file = array_shift($file);

                        $result['name'] = $file['name'];
                        $result['type'] = $file['type'];
                        $result['size'] = $file['size'];

                        /**
                         * Resize images based on dimensions options 
                         */
                        //TODO test if the file uploaded is a image
                        foreach ($this->_dimensions as $sizename => $dim) {
                            $wide = WideImage::load($file['tmp_name']);
                            $imgResult = $wide->resize($dim['width'], $dim['height'], 'inside', 'down');

                            $resizedfilename = Agana_Util_FileHandle::genFileNameByClassification(
                                            $file['name'], $sizename
                            );

                            if (strpos(strtolower($file['type']),'png') !== false) {
                                $compression = 8;
                            } else {
                                $compression = 80;
                            }
                            $imgResult->saveToFile($file['destination'] . '/' . $resizedfilename, $compression);
                        }

                        return $result;
                    } catch (Zend_File_Transfer_Exception $e) {
                        return array('error' => $e->getMessage());
                    }
                } else {
                    $error = array();
                    foreach ($this->_adapter->getMessages() as $value) {
                        $error[] = $value;
                    };
                    return array('error' => $translate->_($error));
                }
            } else {
                return array('error' => $translate->_('file could not be created or path is not writable'));
            }
        } else {
            return array('error' => $translate->_('No file uploaded'));
        }
    }

}

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);

        if ($realSize != $this->getSize()) {
            return false;
        }

        $target = fopen($path, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return true;
    }

    function getName() {
        return $_GET['qqfile'];
    }

    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])) {
            return (int) $_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
    }

}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if (!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)) {
            return false;
        }
        return true;
    }

    function getName() {
        return $_FILES['qqfile']['name'];
    }

    function getSize() {
        return $_FILES['qqfile']['size'];
    }

}

class qqFileUploader {

    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings() {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

    private function toBytes($str) {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE) {
        if (!is_writable($uploadDirectory)) {
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->file) {
            return array('error' => 'No files were uploaded.');
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of ' . $these . '.');
        }

        if (!$replaceOldFile) {
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)) {
            return array('success' => true);
        } else {
            return array('error' => 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
    }

}

