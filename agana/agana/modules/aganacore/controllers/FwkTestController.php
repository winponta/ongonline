<?php

/**
 * FwkTestController
 *
 * @category   Agana
 * @package    Agana_FwkTestController
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Aganacore_FwkTestController extends Zend_Controller_Action {

    public function flashMessagesAction() {
        $this->_helper->flashMessenger->addMessage(
                array(
                    'notice' => 'This is a NOTICE message ... hey user, this is nice !!!')
                );

        $this->_helper->flashMessenger->addMessage(
                array('error' => 'Watchout! You gota error'));

        $this->_helper->flashMessenger->addMessage(
                array('warning' => 'Keep safe, this is a warning'));

        $this->_helper->flashMessenger->addMessage(
                array('validation' => 'Validation fields message'));

        $this->_helper->flashMessenger->addMessage(
                array('success' => 'SUCCESS. Everething is good!!!!'));

        $this->_helper->flashMessenger->addMessage(
                array('success' => 'Happy path'));

        $this->_helper->flashMessenger->addMessage(
                array(
                    'title' => 'Title test',
                    'error' => 'So much errors')
                );

        $this->_helper->flashMessenger->addMessage(
                array('warning' => 'Half way done :-('));

        $this->_helper->flashMessenger->addMessage(
                array('notice' => 'Hey, do you know there is a live help in this system?'));

        $this->_helper->flashMessenger->addMessage(
                array('error' => 'Errors are the worst'));

        $this->_helper->flashMessenger->addMessage(
                array('success' => 'Success are the best !!!'));
    }

}

?>
