<?php

/**
 * UserForm UPdate Password
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_Password extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_EDIT = 'edit';

    /**
     *
     * @var User_Model_User
     */
    protected $_user;
    protected $_action;

    public function __construct($action, $user = null, $options = null) {
        $this->_action = $action;
        $this->_user = $user;
        parent::__construct($options);
    }

    private function _addElementsPwd() {
        $this->addElement(
            'password', 'pwd', 
            array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    array('StringLength', false, array(0, 32)),
                ),
                'required' => true,
                'label' => 'New password',
                'append' => '#',
            )
        );

        $this->addElement(
            'password', 'pwdconfirm', 
            array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    array('StringLength', false, array(0, 32)),
                    array('identical', false, array('token' => 'pwd')),
                ),
                'required' => true,
                'label' => 'Confirm password',
                'title' => 'Retype your password to avoid mistakes',
                'description' => 'Retype your password to avoid mistakes',
                'append' => '= #'
            )
        );
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_user->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("userpwd");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementsPwd();

        $this->addElement(
            'submit', 'save', 
            array(
                'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
                'label' => 'Save',
                'icon' => 'icon-ok-circle',
            )
        );

        $this->addElement(
            'submit', 'cancel', 
            array(
                'label' => 'Cancel',
                'value' => 'cancel',
            )
        );

        $this->addDisplayGroup(
            array(
                'pwd', 'pwdconfirm',
            ), 'userpwdform' //array('legend' => 'User data',)
        );

        $this->addDisplayGroup(
            array('save', 'cancel'), 'actions-end', 
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
