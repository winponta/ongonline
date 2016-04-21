<?php

/**
 * Project Task Type Form
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Project_Form_Tasktype extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Project_Model_Tasktype
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

    private function _addElementParent() {
        $this->addElement('select', 'parent_id', array(
            'required' => false,
            'label' => 'Parent Task type',
            'dimension' => 6,
        ));
        
        $el = $this->getElement('parent_id');
        
        $tasktd = new Project_Domain_Tasktype();
        $tt = $tasktd->getAll('name');
        
        $el->addMultiOption(null, '');
        foreach ($tt as $item) {
            $el->addMultiOption($item->getId(), $item->getName());
        }
        
        if ($this->_model && $this->_model->parent_id) {
            $el->setValue($this->_model->parent_id);
        }
    }

    public function init() {
        $formutil = new Agana_Form_Util($this->_action, $this->_model);
        
        $this->setName("tasktype");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        //$this->_addElementName();
        $formutil->addElementName($this, array('maxlength'=>120));
        $formutil->addElementDescription($this, array('maxlength'=>1200));
        $this->_addElementParent();
        
        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'name', 'description', 'parent_id', 
                ), 'tasktypeform', array(
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