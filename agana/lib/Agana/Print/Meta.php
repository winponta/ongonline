<?php
class Agana_Print_Meta {
    protected $title = 'DEFAULT TITLE OF AGANA REPORTS';
    protected $accountName = 'AGANA REPORTS ACCOUNT NAME';
    protected $systemName = 'AGANA FRAMEWORK';
    protected $systemUrl = 'http://www.winponta.com.br';

    public function __construct($title, $accountName, $systemName, $systemUrl) {
        $this->setTitle($title);
        $this->setAccountName($accountName);
        $this->setSystemName($systemName);
        $this->setSystemUrl($systemUrl);
    }
   
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getAccountName() {
        return $this->accountName;
    }

    public function setAccountName($accountName) {
        $this->accountName = $accountName;
        return $this;
    }

    public function getSystemName() {
        return $this->systemName;
    }

    public function setSystemName($systemName) {
        $this->systemName = $systemName;
        return $this;
    }
    
    public function getSystemUrl() {
        return $this->systemUrl;
    }

    public function setSystemUrl($systemUrl) {
        $this->systemUrl = $systemUrl;
        return $this;
    }
        
}