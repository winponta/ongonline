<?php

/**
 * State Form
 *
 * @category   Agana
 * @package    Agana_Location
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Location_Form_State extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Location_Model_State
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
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
            'value' => ($this->_model) ? $this->_model->name : '',
            'dimension' => 4,
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'state', 'field' => 'name',)
            );
        }
    }

    private function _addElementAbbreviation() {
        $this->addElement('text', 'abbreviation', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(2, 2)),
            ),
            'required' => true,
            'label' => 'USPS',
            'value' => ($this->_model) ? $this->_model->abbreviation : '',
            'dimension' => 1,
        ));
        
        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'state', 'field' => 'name',)
            );
        }
    }

    private function _addElementCountry() {
        $this->addElement('select', 'country_id', array(
            'required' => true,
            'label' => 'Country',
            'dimension' => 4,
        ));
        
        $el = $this->getElement('country_id');
        
        $cd = new Location_Domain_Country();
        $c = $cd->getAll('name');
        
        foreach ($c as $country) {
            $el->addMultiOption($country->getId(), $country->getName());
        }
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_model->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("state");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementName();
        $this->_addElementAbbreviation();
        $this->_addElementCountry();

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
            'name', 'abbreviation', 'country_id', 
                ), 'stateform', array(
           // 'legend' => 'State',
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
