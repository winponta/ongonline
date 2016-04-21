<?php

/**
 * Index controller from User official module of Agana fwk
 */
class User_IndexController extends Zend_Controller_Action {
    public function indexAction() {
        $this->_forward('index', 'profile', 'user');
    }
}

