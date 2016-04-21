<?php

/**
 * City Region Form
 *
 * @category   Agana
 * @package    Agana_Location
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Location_Form_CityRegion extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Location_Model_CityRegion
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
            'dimension' => 5,
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'city_region', 'field' => 'name',)
            );
        }
    }

    private function _addElementCIty() {
        $this->addElement('select', 'city_id', array(
            'required' => true,
            'label' => 'City',
            'dimension' => 4,
        ));
        
        $el = $this->getElement('city_id');
        
        $cd = new Location_Domain_City();
        $c = $cd->getAll('name');
        
        foreach ($c as $city) {
            $el->addMultiOption($city->getId(), $city->getName());
        }
        
        if ($this->_model && $this->_model->city_id) {
            $el->setValue($this->_model->city_id);
        }
    }

    private function _addElementParent() {
        $this->addElement('select', 'parent_id', array(
            'label' => 'Parent region',
            'dimension' => 4,
        ));
        
        $el = $this->getElement('parent_id');
        
        $cd = new Location_Domain_CityRegion();
        $c = $cd->getAll('name');
        
        $el->addMultiOption(null, null);
        foreach ($c as $region) {
            $el->addMultiOption($region->getId(), $region->getName());
        }
        
        if ($this->_model && $this->_model->parent_id) {
            $el->setValue($this->_model->parent_id);
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
        $this->setName("cityregion");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementName();
        $this->_addElementCIty();
        $this->_addElementParent();

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
            'name', 'city_id', 'parent_id',
                ), 'cityform', array(
            //'legend' => 'City',
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