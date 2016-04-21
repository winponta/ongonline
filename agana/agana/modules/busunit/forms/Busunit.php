<?php

/**
 * Busunit Form
 *
 * @category   Agana
 * @package    Agana_Busunit
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
abstract class Busunit_Form_Busunit extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Busunit_Model_Busunit
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    protected function _addElementName() {
        $this->addElement('text', 'name', array(
            'class'         => 'focused',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 100)),
            ),
            'required' => true,
            'label' => 'Name',
            'value' => ($this->_model) ? $this->_model->name : '',
            'dimension' => 6,
        ));

        if ($this->_action == self::ACTION_ADD) {
            $this->getElement('name')->addValidator('Db_NoRecordExists', false, array('table' => 'busunit', 'field' => 'name',)
            );
        }
    }

    protected function _addElementTradeName() {
        $this->addElement('text', 'tradename', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 100)),
            ),
            'label' => 'Trade name',
            'value' => ($this->_model) ? $this->_model->tradename : '',
            'dimension' => 6,
        ));

    }

    protected function _addElementDocTaxNumber() {
        $this->addElement('text', 'doctaxnumber', array(
            'filters' => array('StringTrim'),
            'label' => 'Tax Number',
            'value' => ($this->_model) ? $this->_model->doctaxnumber : '',
            'dimension' => 3,
            'description' => 'You can use any ponctuation to format your doc number. Example: 02.432.123/0001-00',
            'validators' => array(
                array('StringLength', false, array(0, 20)),
            ),
        ));
        $el = $this->getElement('doctaxnumber');
        
        $or = new Agana_Validate_Or();
        $or->addValidator(new Agana_Validate_Cnpj());
        $or->addValidator(new Agana_Validate_Cpf());
        
        $el->addValidator($or);
    }

    protected function _addElementPhone() {
        $this->addElement('text', 'phone', array(
            'filters' => array('StringTrim'),
            'label' => 'Phone',
            'value' => ($this->_model) ? $this->_model->phone : '',
            'dimension' => 3,
            'validators' => array(
                array('StringLength', false, array(0, 16)),
            ),
        ));
    }

    protected function _addElementAddress() {
        $this->addElement('text', 'address', array(
            'filters' => array('StringTrim'),
            'label' => 'Address',
            'value' => ($this->_model) ? $this->_model->address : '',
            'dimension' => 6,
            'validators' => array(
                array('StringLength', false, array(0, 150)),
            ),
        ));
    }

    protected function _addElementAddressNumber() {
        $this->addElement('text', 'addressnumber', array(
            'filters' => array('StringTrim'),
            'label' => 'Address number',
            'value' => ($this->_model) ? $this->_model->addressnumber : '',
            'dimension' => 2,
            'description' => 'You may use letters. Example: C-01',
            'validators' => array(
                array('StringLength', false, array(0, 6)),
            ),
        ));
    }

    protected function _addElementAddressDetails() {
        $this->addElement('text', 'addressdetails', array(
            'filters' => array('StringTrim'),
            'label' => 'Address details',
            'value' => ($this->_model) ? $this->_model->addressdetails : '',
            'dimension' => 6,
            'description' => 'You may describe details to the location. Example: at corner of Good Bread Bakery',
            'validators' => array(
                array('StringLength', false, array(0, 150)),
            ),
        ));
    }

    protected function _addElementDistrict() {
        $this->addElement('text', 'district', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'label' => 'District',
            'value' => ($this->_model) ? $this->_model->district : '',
            'dimension' => 6,
        ));

    }


    protected function _addElementPostalCode() {
        $this->addElement('text', 'postalcode', array(
            'filters' => array('StringTrim'),
            'label' => 'Postal code',
            'value' => ($this->_model) ? $this->_model->postalcode : '',
            'dimension' => 2,
            'validators' => array(
                array('StringLength', false, array(0, 9)),
            ),
        ));
    }

    protected function _addElementWebSite() {
        $this->addElement('text', 'website', array(
            'filters' => array('StringTrim'),
            'label' => 'Web site',
            'value' => ($this->_model) ? $this->_model->website : '',
            'dimension' => 9,
            'description' => 'The url address of your organization web site. Example: http://www.winponta.com.br',
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
        ));
    }

    protected function _addElementCity() {
        $this->addElement('select', 'city_id', array(
            'required' => false,
            'label' => 'City',
            'dimension' => 4,
            'placeholder' => 'Choose a city',
        ));
        
        $el = $this->getElement('city_id');
        
        $cd = new Location_Domain_City();
        $c = $cd->getAll(array('orderby' => 'name'));
        
        foreach ($c as $city) {
            $el->addMultiOption($city->getId(), $city->getName());
        }
        
        if (($this->_model) && ($this->_model->city_id)) {
            $el->setValue($this->_model->city_id);
        } else {
            $el->setValue(-1);
        }
    }

    protected function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_model->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("Headquarters");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addElementName();
        $this->_addElementTradeName();
        $this->_addElementDocTaxNumber();
        $this->_addElementPhone();
        $this->_addElementAddress();
        $this->_addElementAddressNumber();
        $this->_addElementAddressDetails();
        $this->_addElementDistrict();
        $this->_addElementCity();
        $this->_addElementPostalCode();
        $this->_addElementWebSite();

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
            'name', 'tradename', 'doctaxnumber', 
            'phone', 'address', 'addressnumber',
            'addressdetails','district', 'city_id', 'postalcode',
            'website',
                ), 'busunitform', array(
            //'legend' => 'Business Unit: Headquarters/Branches',
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
