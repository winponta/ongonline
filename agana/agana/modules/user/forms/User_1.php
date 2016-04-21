<?php

/**
 * UserForm
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_User extends Zend_Form {
    const ACTION_ADD = 'add';
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

    private function _getNameElement() {
        $element = $this->createElement('text', 'name', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 64)),
            ),
            'required' => true,
            'label' => 'User name',
            'value' => ($this->_user) ? $this->$this->_account->name : '',
                ));

        if ($this->_action == self::ACTION_ADD) {
            $element->addValidator('Db_NoRecordExists', false, array('table' => 'user', 'field' => 'name',)
            );
        }
        return $element;
    }

    private function _getEmailElement() {
        $element = $this->createElement('text', 'email', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('EmailAddress'),
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'E-mail',
            'title' => 'Format: local-part@hostname.com',
            'value' => ($this->_user) ? $this->_user->email : '',
                ));

        if ($this->_action == self::ACTION_ADD) {
            $element->addValidator('Db_NoRecordExists', false, array('table' => 'user', 'field' => 'email',)
            );
        }

        return $element;
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_user->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("user");
        $this->setMethod('post');

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->addElement($this->_getNameElement());

        $this->addElement($this->_getEmailElement());

        /**
         * should edit the password in its own form
         */
        if ($this->_user == null) {
            $this->addElement('password', 'pwd', array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    array('StringLength', false, array(0, 32)),
                ),
                'required' => true,
                'label' => 'Password',
            ));

            $this->addElement('password', 'pwdconfirm', array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    array('StringLength', false, array(0, 32)),
                    array('identical', false, array('token' => 'pwd')),
                ),
                'required' => true,
                'label' => 'Confirm password',
                'title' => 'Retype your password to avoid mistakes',
            ));
        }

        $status = $this->createElement('select', 'status', array(
            'multiOptions' => array(
                '1' => 'Active',
                '0' => 'Inactive',
                '-1' => 'Blocked',
            ),
            'value' => ($this->_user) ? ($this->_user->status != '') ? $this->_user->status : '1' : '',
            'required' => true,
            'label' => 'Status',
        ));
        $this->addElement($status);

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore' => true,
            'label' => 'Save',
            'decorators' => array(
                'ViewHelper',
            ), 
        ));

        $this->addElement('submit', 'cancel', array(
            'required' => false,
            'ignore' => true,
            'label' => 'Cancel',
            'decorators' => array(
                'ViewHelper',
            ), 
        ));

        $this->addDisplayGroup(array(
            'name', 'email', 'pwd', 'pwdconfirm', 'status', 
                ), 'userform', array(
            'legend' => 'User data',            
        ));

        $this->addDisplayGroup(array('save', 'cancel'), 'submitButtons', array(
            'decorators' => array(
                'FormElements',
                array('HtmlTag', array('tag' => 'div', 'class' => 'element')),
            ),
        )); 
    

//        $token = new Zend_Form_Element_Hash('token');
//        $token->setSalt(md5(uniqid(rand(), TRUE)));
//        $token->setTimeout(30);
//        $this->addElement($token);
    }

}

?>
