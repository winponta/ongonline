<?php

class Busunit_Model_Headquarters extends Busunit_Model_Busunit {
    function __construct() {
        $this->defineasHead();
    }
    
    function defineasHead() {
        parent::setHead(1);
    }    
}

