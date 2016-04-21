<?php

/**
 * UserForm
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_User extends Twitter_Bootstrap_Form_Horizontal {

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

    private function _addElementName() {
        $this->addElement('text', 'name', array(
            'class' => 'focused',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 64)),
            ),
            'required' => true,
            'label' => 'User name',
            'value' => ($this->_user) ? $this->_user->name : '',
            'dimension' => 6,
            'append' => '<i class="icon-user"></i>'
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'user', 'field' => 'name',)
            );
        }
    }

    /**
     * used to save and relate to an person record
     */
    private function _addElementPersonName() {
        $this->addElement('text', 'personname', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 120)),
            ),
            'label' => 'Real name',
            'value' => ($this->_user) ? $this->_user->personname : '',
            'dimension' => 6,
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'user', 'field' => 'name',)
            );
        }
    }

    private function _addElementEmail() {
        $this->addElement('text', 'email', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('EmailAddress'),
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'E-mail',
            'title' => 'Format: local-part@hostname.com',
            'value' => ($this->_user) ? $this->_user->email : '',
            'append' => "@",
            'dimension' => 6,
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('email')->addValidator('Db_NoRecordExists', false, array('table' => 'user', 'field' => 'email',)
            );
        }
    }

    private function _addElementsPwd() {
        $this->addElement('password', 'pwd', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 32)),
            ),
            'required' => true,
            'label' => 'Password',
            'append' => '#',
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
            'description' => 'Retype your password to avoid mistakes',
            'append' => '= #'
        ));
    }

    /**
     * Teste if cant edit. If can NOT return TRUE
     * to be used in disabled attrib
     * @return boolean
     */
    private function cantEdit() {
        $cantEdit = false;
        
        if ($this->_action == self::ACTION_EDIT) {
            $cantEdit = ! Agana_Acl_Service::isAllowed(
                    Zend_Auth::getInstance()->getIdentity()->acl_role_id, 
                    User_Module_Acl::ACL_RESOURCE_USER, 
                    User_Module_Acl::ACL_RESOURCE_USER_PRIVILEGE_UPDATE);
        }
        
        return $cantEdit;

    }    
    
    private function _addElementStatus() {
        $this->addElement('select', 'status', array(
            'multiOptions' => array(
                '1' => 'Active',
                '0' => 'Inactive',
                '-1' => 'Blocked',
            ),
            'value' => ($this->_user) ? ($this->_user->status != '') ? $this->_user->status : '1'  : '',
            'required' => true,
            'label' => 'Status',
            'Description' => '[ Active ] = users that can use the system [ Inactive ] = users that can authenticate, acces it\'s own data profile, but cannot use the system [ Bloqued ] = users that cannot use the system at all.',
            'dimension' => 6,
            //'disabled' => $this->cantEdit(),
        ));
    }

    private function _addElementRole() {
        $this->addElement('select', 'acl_role_id', array(
            'required' => true,
            'label' => 'User role',
            'dimension' => 6,
            //'disabled' => $this->cantEdit(),
        ));

        $el = $this->getElement('acl_role_id');

        $roleDomain = new User_Domain_Role();
        $roles = $roleDomain->getAll(Zend_Auth::getInstance()->getIdentity()->appaccount_id);

        foreach ($roles as $r) {
            $el->addMultiOption($r->getId(), $r->getName());
        }

        if ($this->_model && $this->_model->getAcl_role_id()) {
            $el->setValue($this->_model->acl_role_id);
        }
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
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementName();

        $this->_addElementEmail();
        if (!$this->cantEdit()) {
            $this->_addElementRole();
            $this->_addElementStatus();
        }

        /**
         * should edit the password in its own form
         */
        if ($this->_user == null) {
            $this->_addElementsPwd();
        }

        $this->addElement('submit', 'save', array(
            'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
            'label' => 'Save',
            'icon' => 'icon-ok-circle',
        ));

        $this->addElement('submit', 'cancel', array(
            'label' => 'Cancel',
            'value' => 'cancel',
        ));

        $this->addDisplayGroup(array(
            'name', 'email', 'acl_role_id', 'status', 'pwd', 'pwdconfirm',
                ), 'userform', array(
            //'legend' => 'User data',
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
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
