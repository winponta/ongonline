<?php

/**
 * RoleForm
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_Role extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var User_Model_Role
     */
    protected $_role;
    protected $_action;

    public function __construct($action, $role = null, $options = null) {
        $this->_action = $action;
        $this->_role = $role;
        parent::__construct($options);
    }

    private function _addElementName() {
        $this->addElement('text', 'name', array(
            'class'         => 'focused',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required' => true,
            'label' => 'Name',
            'value' => ($this->_role) ? $this->_role->name : '',
            'dimension' => 6,
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'acl_role', 'field' => 'name',)
            );
        }
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_role->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("role");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementName();

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
            'name', 
                ), 'userform', array(
        ));

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
