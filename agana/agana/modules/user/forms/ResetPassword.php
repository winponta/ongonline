<?php

/**
 * ResetPasswordForm
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_ResetPassword extends Twitter_Bootstrap_Form_Vertical {

    private function _getEmailName() {
        $element = $this->createElement(
            'text', 'name', array(
                'filters' => array('StringTrim', 'StringToLower'),
                'label' => 'Name',
                'title' => 'User name',
            )
        );

        return $element;
    }

    private function _getEmailElement() {
        $element = $this->createElement(
            'text', 'email', array(
                'filters' => array('StringTrim', 'StringToLower'),
                'validators' => array(
                    array('EmailAddress'),
                ),
                'label' => 'E-mail',
                'title' => 'Format: local-part@hostname.com',
            )
        );

        return $element;
    }

    private function _getEntryElement() {
        $element = $this->createElement(
            'text', 'user', array(
                'filters' => array('StringTrim', 'StringToLower'),
                'label' => 'User name or e-mail',
                'required' => true,
                'description' => 'Please, enter your user name or e-mail to 
                    ask for password reset.',
                'dimension' => 5,
            )
        );

        return $element;
    }

    public function init() {
        $this->setName("resetpassword");
        $this->setMethod('post');

//        $this->addElement($this->_getEmailName());
//        $this->addElement($this->_getEmailElement());
        $this->addElement($this->_getEntryElement());

        $this->addElement(
            'submit', 'reset', array(
                'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
                'required' => false,
                'ignore' => true,
                'label' => 'Send',
            )
        );

        $this->addElement(
            'submit', 'cancel', array(
                'required' => false,
                'ignore' => true,
                'label' => 'Cancel',
            )
        );

        $this->addDisplayGroup(
            array('user'), 'resetpasswordform'
            //array('legend' => 'User reset password')
        );

        $this->addDisplayGroup(
                array('reset', 'cancel'), 'actions-end', 
                array(
                    'disableLoadDefaultDecorators' => true,
                    'decorators' => array('Actions')
                )
        );    

//        $token = new Zend_Form_Element_Hash('token');
//        $token->setSalt(md5(uniqid(rand(), TRUE)));
//        $token->setTimeout(30);
//        $this->addElement($token);
    }

}
