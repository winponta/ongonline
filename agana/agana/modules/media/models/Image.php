<?php

class Media_Model_Image extends Agana_Data_Bean  {
    private $id;
    private $title;
    private $file;
    private $filesize;
    private $mimetype;
    
    public function getFile() {
        return $this->file;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function getFilesize() {
        return $this->filesize;
    }

    public function setFilesize($filesize) {
        $this->filesize = $filesize;
    }

    public function getMimetype() {
        return $this->mimetype;
    }

    public function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
}

