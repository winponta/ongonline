<?php

/**
 * Project Form
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Project_Form_Project extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Project_Model_Project
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_model->id,));
        }

        return $element;
    }

    public function init() {
        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        $this->setName("project");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        //$this->_addElementName();
        $formutil->addElementName($this, array('maxlength' => 60));

        //$this->addElementStatus();
        $formutil->addElementProjectStatus($this);

        $formutil->addElementDescription($this, array(
            'name' => 'abstract',
            'label' => 'Abstract',
            'maxlength' => 1200,
            'rows' => 10,
            'dimension' => 11,
            'required' => true,
            'modelfield' => 'abstract',
        ));
        $formutil->addElementDate($this, array(
            'name' => 'startdateexpected',
            'label' => 'Start date expected',
            'modelfield' => 'startdateexpected',
            'default' => false,
        ));
        $formutil->addElementDate($this, array(
            'name' => 'startdatereal',
            'label' => 'Start date real',
            'modelfield' => 'startdatereal',
            'default' => false,
        ));
        $formutil->addElementDate($this, array(
            'name' => 'finishdateexpected',
            'label' => 'Finish date expected',
            'modelfield' => 'finishdateexpected',
            'default' => false,
        ));
        $formutil->addElementDate($this, array(
            'name' => 'finishdatereal',
            'label' => 'Finish date real',
            'modelfield' => 'finishdatereal',
            'default' => false,
        ));
        $formutil->addElementDescription($this, array(
            'name' => 'fulldescription',
            'label' => 'Full description',
            'maxlength' => 0,
            'dimension' => 11,
            'rows' => 25,
            'modelfield' => 'fulldescription',
            'editor' => true,
        ));

        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'name', 'status', 'abstract', 'startdateexpected',
            'startdatereal', 'finishdateexpected', 'finishdatereal',
            'fulldescription',
                ), 'tasktypeform', array(
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}