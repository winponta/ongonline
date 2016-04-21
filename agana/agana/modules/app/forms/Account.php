<?php

/**
 * App Account Type Form
 *
 * @category   Agana
 * @package    Agana_App
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class App_Form_Account extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var App_Model_Account
     */
    protected $_account;
    protected $_action;

    public function __construct($action, $type = null, $options = null) {
        $this->_action = $action;
        $this->_account = $type;
        parent::__construct($options);
    }

    private function _addElementName() {
        $this->addElement('text', 'name', array(
            'class'         => 'focused',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 120)),
            ),
            'required' => true,
            'label' => 'App account name',
            'value' => ($this->_account) ? $this->_account->name : '',
            'dimension' => 2,
            'description' => 'The name of the account, can be the name of the owner or other.',
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'appaccount', 'field' => 'name',)
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
            'value' => ($this->_account) ? $this->_account->email : '',
            'append' => "@",
            'dimension' => 6,
        ));
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_account->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("appaccount");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementName();
        $this->_addElementEmail();

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
            'name', 'email',
                ), 'appaccountform', array(
            //'legend' => 'App Account',
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', 
                array(
                    'disableLoadDefaultDecorators' => true,
                    'decorators' => array('Actions')
                )
        );

    }

}

?>
