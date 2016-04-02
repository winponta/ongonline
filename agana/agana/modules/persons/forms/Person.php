<?php

/**
 * Person Form
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_Person extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Person_Model_Person
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
                array('StringLength', false, array(0, 120)),
            ),
            'required' => true,
            'label' => 'Person name',
            'value' => ($this->_model) ? $this->_model->name : '',
            'dimension' => 2,
        ));
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
        
        $this->setName("person");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        //$this->_addElementName();
        $formutil->addElementName($this, array('maxlength'=>120, 'dimension'=>7));
        $formutil->addElementGender($this);
        $formutil->addElementDate($this, array(
            'name'      => 'birthdate',
            'label'     => 'Birthdate',
            'modelfield'=> 'birthdate'
            ));
        $formutil->addElementMaritalStatus($this, array('dimension'=>3));
        $formutil->addElementPhone($this, array('class' => 'float-left'));
        $formutil->addElementPhone($this, array(
            'name' => 'mobilephone',
            'label'=> 'Mobile phone',
            'modelfield' => 'mobilephone'
            ));
        $formutil->addElementEmail($this);
        $formutil->addElementAddress($this);
        $formutil->addElementAddressNumber($this);
        $formutil->addElementAddressDetails($this);
        $formutil->addElementPostalCode($this);
        $formutil->addElementCityId($this, array(
            'required'=>true,
            ));
        $formutil->addElementCityRegionId($this, array(
            'showcity'=>true,
        ));
        $formutil->addElementWebsite($this, array(
            'required'=>false,
            ));
        /*
        Isso deve resolver o problema do campo website ser obrigatório
        (Apesar de que pela função ele deveria já vir como opcional)
        */
        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        
        $this->addDisplayGroup(array(
            'name', 'gender', 'birthdate', 'marital_status', 
            'phone', 'mobilephone', 'email',
            'address', 'addressnumber', 'addressdetails',
            'postalcode', 'city_id', 'city_region_id', 'website'
                ), 'personform', array(
            'legend' => '',
        ));
                

//                $phonesForm = new Twitter_Bootstrap_Form_Inline();
//        $formutil->addElementPhone($phonesForm);
//        $formutil->addElementPhone($phonesForm, array(
//            'name' => 'mobilephone',
//            'label'=> 'Mobile Phone',
//            'modelfield' => 'mobilephone'
//            ));
//        
//        $phonesForm->addDisplayGroup(array(
//            'phone', 'mobilephone', 
//                ), 'personformphone', 
//            array(
//                'legend' => 'Phones',
//            )
//        );        
//                
//        $this->addSubForm($phonesForm, 'phonesform');
//

        
        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', 
                array(
                    'disableLoadDefaultDecorators' => true,
                    'decorators' => array('Actions')
                )
        );

    }

}
