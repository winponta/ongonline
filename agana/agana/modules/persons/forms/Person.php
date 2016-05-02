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

    /*
     * Início do bloco de métodos de documento
     */

    private function _addElementIdentityCard() {
        $this->addElement('text', 'identitycard', array(
            'label' => 'Identity card',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 20)),
            ),
            'value' => ($this->_model) ? $this->_model->identitycard : '',
            'dimension' => 3,
        ));
    }

    private function _addElementIndividualDocTaxNumber() {
        $this->addElement('text', 'individualdoctaxnumber', array(
            'filters' => array('StringTrim'),
            'label' => 'Individual tax number',
            'value' => ($this->_model) ? $this->_model->individualdoctaxnumber : '',
            'dimension' => 3,
            'description' => 'You can use any ponctuation to format your doc number. Example: 015.234.919-67',
            'validators' => array(
                array('StringLength', false, array(0, 20)),
            ),
        ));
        $el = $this->getElement('individualdoctaxnumber');

        $or = new Agana_Validate_Or();
        $or->addValidator(new Agana_Validate_Cnpj());
        $or->addValidator(new Agana_Validate_Cpf());

        $el->addValidator($or);
    }

    private function _addElementBirthCertificate() {
        $this->addElement('text', 'birthcertificate', array(
            'label' => 'Birth certificate',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 20)),
            ),
            'value' => ($this->_model) ? $this->_model->birthcertificate : '',
            'dimension' => 3,
        ));
    }

    private function _addElementProfessionalCard() {
        $this->addElement('text', 'professionalcard', array(
            'label' => 'Professional card',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 20)),
            ),
            'value' => ($this->_model) ? $this->_model->professionalcard : '',
            'dimension' => 3,
        ));
    }

    private function _addElementDriversLicense() {
        $this->addElement('text', 'driverslicense', array(
            'label' => 'Drivers license',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 20)),
            ),
            'value' => ($this->_model) ? $this->_model->driverslicense : '',
            'dimension' => 3,
        ));
    }

    private function _addElementVoterRegistration() {
        $this->addElement('text', 'voterregistration', array(
            'label' => 'Voter registration',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 20)),
            ),
            'value' => ($this->_model) ? $this->_model->voterregistration : '',
            'dimension' => 3,
        ));
    }

    private function _addElementMilitaryRegistration() {
        $this->addElement('text', 'militaryregistration', array(
            'label' => 'Military registration',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 30)),
            ),
            'value' => ($this->_model) ? $this->_model->militaryregistration : '',
            'dimension' => 3,
        ));
    }

    private function _addElementHealthSystemCard() {
        $this->addElement('text', 'healthsystemcard', array(
            'label' => 'Health system card',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 20)),
            ),
            'value' => ($this->_model) ? $this->_model->healthsystemcard : '',
            'dimension' => 3,
        ));
    }


    private function _addElementPis() {
        $this->addElement('text', 'pis', array(
            'label' => 'PIS/NIS/NIT',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 14)),
            ),
            'value' => ($this->_model) ? $this->_model->pis : '',
            'dimension' => 3,
        ));
    }

    /*
     * Fim do bloco de métodos de documento
     */

    private function _addElementName() {
        $this->addElement('text', 'name', array(
            'class' => 'focused',
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
        $this->addAttribs(array('load-in' => 'content-container'));

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        //$this->_addElementName();
        $formutil->addElementName($this, array('maxlength' => 120, 'dimension' => 7));
        $formutil->addElementGender($this);
        $formutil->addElementDate($this, array(
            'name' => 'birthdate',
            'label' => 'Birthdate',
            'modelfield' => 'birthdate'
        ));
        $formutil->addElementMaritalStatus($this, array('dimension' => 3));
        $formutil->addElementPhone($this, array('class' => 'float-left'));
        $formutil->addElementPhone($this, array(
            'name' => 'mobilephone',
            'label' => 'Mobile phone',
            'modelfield' => 'mobilephone'
        ));
        $formutil->addElementEmail($this);
        $formutil->addElementAddress($this);
        $formutil->addElementAddressNumber($this);
        $formutil->addElementAddressDetails($this);
        $formutil->addElementPostalCode($this);
        $formutil->addElementCityId($this, array(
            'required' => true,
        ));
        $formutil->addElementCityRegionId($this, array(
            'showcity' => true,
        ));

        $this->_addElementIdentityCard();
        $this->_addElementIndividualDocTaxNumber();
        $this->_addElementBirthCertificate();
        $this->_addElementProfessionalCard();
        $this->_addElementDriversLicense();
        $this->_addElementVoterRegistration();
        $this->_addElementMilitaryRegistration();
        $this->_addElementHealthSystemCard();
        $this->_addElementPis();

//        $this->addDisplayGroup(
//                array('save', 'cancel'), 'actions-end', array(
//            'disableLoadDefaultDecorators' => true,
//            'decorators' => array('Actions')
//                )
//        );
//        $formutil->addElementWebsite($this, array(
//            'required'=>false,
//            ));
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
            'postalcode', 'city_id', 'city_region_id', 'website', 'person_name', 'identitycard', 'individualdoctaxnumber',
            'birthcertificate', 'professionalcard', 'driverslicense',
            'voterregistration', 'militaryregistration',
            'healthsystemcard', 'pis'
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
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}
