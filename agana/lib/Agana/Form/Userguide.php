<?php

/**
 * Userguide Form
 *
 * @category   Agana
 * @package    Agana_Userguide
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Form_Userguide extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Agana_Model_Userguide
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _addElementPage() {
        $this->addElement('text', 'page', array(
            'class'         => 'focused',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Page',
            'value' => ($this->_model) ? $this->_model->page : '',
            'description' => 'The file name of the page. Must have the format: modulename.part.part. Ex: user.profile.create',
            'dimension' => 6,
        ));
    }
    
    private function _addElementTitle() {
        $this->addElement('text', 'title', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required' => true,
            'label' => 'Title',
            'value' => ($this->_model) ? $this->_model->title : '',
            'description' => 'The title of the guide page',
            'dimension' => 6,
        ));
    }
    
    private function _addElementContent() {
        $this->addElement('textarea', 'content', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Content',
            'value' => ($this->_model) ? $this->_model->content : '',
            'description' => 'The  of the guide page',
            'dimension' => 6,
        ));
    }

    public function init() {
        $this->setName("userguide");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementPage();
        $this->_addElementTitle();
        $this->_addElementContent();

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
            'page', 'title', 'content', 
                ), 'userguideform', array(
            'legend' => 'User guide',
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