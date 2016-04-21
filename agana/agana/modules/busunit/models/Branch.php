<?php

class Busunit_Model_Branch extends Busunit_Model_Busunit {
    function __construct() {
        $this->defineasBranch();
    }
    
    function defineasBranch() {
        parent::setHead(0);
    }    
}

