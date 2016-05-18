<?php

/**
 * Person Docs Form
 *
 * @category   Agana
 * @package    Agana_Persons
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonDocs extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Persons_Model_PersonDocs
     */
    protected $_model;
    protected $_action;

    /**
     *
     * @var Zend_Translate_Adapter
     */
    private $translate = null;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _addElementPerson() {
        $translate = Zend_Registry::get("Zend_Translate");

        $url = new Zend_View_Helper_Url();

        $urlSearch = $url->url(array(
            'module' => 'persons',
            'controller' => 'person',
            'action' => 'search-form'
                ), null, true);

        $urlNew = $url->url(array(
            'module' => 'persons',
            'controller' => 'person',
            'action' => 'create'
                ), null, true);

        $append = '';
//        if ($this->_action == self::ACTION_ADD) {
//            $append .= '<a id="btnPersonSearch" href="'.$urlSearch.'" '
//                            . ' rel="colorbox-search" search-return-id="id" search-return-value="person_name">'
//                            . '<i class="icon-search" rel="tooltip" data-original-title="'.$this->translate->_("Search person").'"></i>'
//                        . '</a>';
//        }

        $this->addElement('text', 'person_name', array(
            'label' => 'Person',
            'value' => ($this->_model) ? $this->_model->getPerson()->getName() : '',
            'dimension' => 6,
            'disabled' => true,
            'placeholder' => $translate->_('Use the links aside to search a person or create a new one'),
            'append' => $append
            . ' | '
            . '<a class="hide" id="btnPersonDetails" href="#" rel="colorbox-details">'
            . $this->translate->_("Details")
            . '</a>'
            . ' | '
            . '<a class="hide" id="btnPersonCreate" href="' . $urlNew . '" rel="colorbox">'
            . '<i class="icon-plus-sign" rel="tooltip" data-original-title="' . $this->translate->_("Add new") . ' ' . $this->translate->_("person") . '"></i>'
            . '</a>',
        ));
    }

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
            'label' => 'PIS',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, 14)),
            ),
            'value' => ($this->_model) ? $this->_model->pis : '',
            'dimension' => 3,
        ));
    }

    private function _getIdElement() {
        $element = null;

        $params = array();
        $params['required'] = true;
        if ($this->_model) {
            $params['valu'] = $this->_model->id;
        }

        $element = $this->createElement('hidden', 'id', $params);

        return $element;
    }

    public function init() {
        $this->translate = Zend_Registry::get("Zend_Translate");

        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        $this->setName("persondocs");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $this->addElement($this->_getIdElement());

        //$this->_addElementName();
        $this->_addElementPerson();
        $this->_addElementIdentityCard();
        $this->_addElementIndividualDocTaxNumber();
        $this->_addElementBirthCertificate();
        $this->_addElementProfessionalCard();
        $this->_addElementDriversLicense();
        $this->_addElementVoterRegistration();
        $this->_addElementMilitaryRegistration();
        $this->_addElementHealthSystemCard();
        $this->_addElementPis();

        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'id', 'person_name', 'identitycard', 'individualdoctaxnumber',
            'birthcertificate', 'professionalcard', 'driverslicense',
            'voterregistration', 'militaryregistration',
            'healthsystemcard',
                ), 'persondocform', array(
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}
