<?php

/**
 * Social Project Form
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonFingerprint extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Persons_Form_PersonFingerprint
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _getIdElement() {
        $element = $this->createElement('hidden', 'person_id', array('value' => 
                                                                    ($this->_model) ? $this->_model->id : '',
                                                                )
                );
        return $element;
    }

    private function addFingerNumber() {
        $this->addElement('text', 'finger_number', array(
            'required' => true,
            'label' => 'Número',
            'dimension' => 6,
        ));
    }

    private function addTextHash() {
        $this->addElement('textarea', 'text_hash', array(
            'required' => true,
            'label' => 'Número',
            'dimension' => 6,
        ));
    }

    public function init() {
        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        $this->setName("socialproject");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $this->addElement($this->_getIdElement());
        $this->addFingerNumber();
        $this->addTextHash();
        
        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'person_id', 'finger_number', 'text_hash',
                ), 'fprint', array(
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}