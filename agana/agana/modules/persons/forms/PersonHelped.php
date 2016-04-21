<?php

/**
 * Person Helped Form
 *
 * @category   Agana
 * @package    Agana_Persons
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonHelped extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Persons_Model_PersonHelped
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

//        $description = new Agana_Form_Element_HtmlField('person_name', array(
//        ));
//        $description->addDecorator('Agana_Form_Decorator_Highlighted');
//        $description->setLabel('Person');
//        $this->addElement($description);

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

    private function _addElementReligion() {
        $this->addElement('text', 'religion', array(
            'label' => 'Religion',
            'value' => ($this->_model) ? $this->_model->getReligion() : '',
            'dimension' => 6,
            'placeholder' => $this->translate->_('Describe the religion name of this person'),
//            'required' => true,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 100)),
            ),
            'maxlength' => 100,
        ));
    }

    private function _addElementRentValue() {
        $this->addElement('text', 'rent_value', array(
            'label' => 'Rent value',
            'value' => ($this->_model) ? $this->_model->getRent_value() : '',
            'dimension' => 6,
            'placeholder' => $this->translate->_('If the situation is rented, what is the value'),
            'filters' => array('StringTrim', 'LocalizedToNormalized'),
            'class' => 'mask-input',
            'attribs' => array(
                'data-mask' => '{
                    "alias":"decimal", 
                    "radixPoint": ",",
                    "digits": 2,
                    "autoGroup": true, 
                    "groupSeparator": ".", 
                    "groupSize": 3,
                    "rightAlignNumerics": false
                    }',
            ),
        ));
    }

    private function _addElementProfessionalOccupation() {
        $this->addElement('radio', 'professional_occupation_choice', array(
            'label' => 'Professional occupation',
            'value' => ($this->_model) ? $this->_model->getProfessional_occupation() : NULL,
            'dimension' => 2,
            'rel' => 'choice-for-another-element',
            'data-target' => '#professional_occupation',
        ));

        $el = $this->getElement('professional_occupation_choice');

        $ops = Persons_Model_ProfessionalOccupation::toArray();
        foreach ($ops as $key => $value) {
            $ops[$key] = $this->translate->_($value);
        }
        sort($ops);
        foreach ($ops as $op) {
            $el->addMultiOption($op, $op);
        }
        $el->addMultiOption('', 'another');

        $this->addElement('text', 'professional_occupation', array(
            'label' => 'Professional occupation',
            'value' => ($this->_model) ? $this->_model->getProfessional_occupation() : '',
            'dimension' => 6,
            'required' => false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 100)),
            ),
            'maxlength' => 100,
            'readonly' => true,
        ));
    }

    private function _addElementHomeSituation() {
        $this->addElement('radio', 'home_situation_choice', array(
            'label' => 'Home situation',
            'value' => ($this->_model) ? $this->_model->getHome_situation() : NULL,
            'dimension' => 2,
            'rel' => 'choice-for-another-element',
            'data-target' => '#home_situation',
        ));

        $el = $this->getElement('home_situation_choice');

        $ops = Persons_Model_Home::toArraySituation();
        foreach ($ops as $key => $value) {
            $ops[$key] = $this->translate->_($value);
        }
        sort($ops);
        foreach ($ops as $op) {
            $el->addMultiOption($op, $op);
        }
        $el->addMultiOption('', 'another');

        $this->addElement('text', 'home_situation', array(
            'label' => 'Home situation',
            'value' => ($this->_model) ? $this->_model->getHome_situation() : '',
            'dimension' => 6,
            'required' => true,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 50)),
            ),
            'maxlength' => 50,
            'readonly' => true,
        ));
    }

    private function _addElementHomeArea() {
        $this->addElement('radio', 'home_area_choice', array(
            'label' => 'Home area',
            'value' => ($this->_model) ? $this->_model->getHome_area() : NULL,
            'dimension' => 2,
            'rel' => 'choice-for-another-element',
            'data-target' => '#home_area',
        ));

        $el = $this->getElement('home_area_choice');

        $ops = Persons_Model_Home::toArrayArea();
        foreach ($ops as $key => $value) {
            $ops[$key] = $this->translate->_($value);
        }
        sort($ops);
        foreach ($ops as $op) {
            $el->addMultiOption($op, $op);
        }
        $el->addMultiOption('', 'another');

        $this->addElement('text', 'home_area', array(
            'label' => 'Home area',
            'value' => ($this->_model) ? $this->_model->getHome_area() : '',
            'dimension' => 6,
            'required' => true,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 50)),
            ),
            'maxlength' => 50,
            'readonly' => true,
        ));
    }

    private function _addElementHomeType() {
        $this->addElement('radio', 'home_type_choice', array(
            'label' => 'Home type',
            'value' => ($this->_model) ? $this->_model->getHome_type() : NULL,
            'dimension' => 2,
            'rel' => 'choice-for-another-element',
            'data-target' => '#home_type',
        ));

        $el = $this->getElement('home_type_choice');

        $ops = Persons_Model_Home::toArrayType();
        foreach ($ops as $key => $value) {
            $ops[$key] = $this->translate->_($value);
        }
        sort($ops);
        foreach ($ops as $op) {
            
            $el->addMultiOption($op, $op);
        }
        $el->addMultiOption('', 'another');

        $this->addElement('text', 'home_type', array(
            'label' => 'Home type',
            'value' => ($this->_model) ? $this->_model->getHome_type() : '',
            'dimension' => 6,
            'required' => true,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 50)),
            ),
            'maxlength' => 50,
            'readonly' => true,
        ));
    }

    public function init() {
        $this->translate = Zend_Registry::get("Zend_Translate");

        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        $this->setName("personhelped");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $this->addElement($this->_getIdElement());

        //$this->_addElementName();
        $this->_addElementPerson();

        $formutil->addElementDate($this, array(
            'name' => 'first_help_date',
            'modelfield' => 'first_help_date',
            'label' => 'First help date',
            'description' => 'When the first help was made for this person',
            'required' => false,
            'default' => 'today',
        ));

        $this->_addElementReligion();

        $formutil->addElementStateId($this, array(
            'name' => 'born_state_id',
            'modelfield' => 'born_state_id',
            'required' => true,
        ));

        $formutil->addElementCityId($this, array(
            'name' => 'born_city_id',
            'modelfield' => 'born_city_id',
            'required' => true,
        ));

        $this->_addElementProfessionalOccupation();
        $formutil->addElementDescription($this, array(
            'label' => 'Professional experience',
            'name' => 'professional_experience',
            'modelfield' => 'professional_experience',
        ));

        $this->addElement('checkbox', 'live_with_family', array(
            'label' => 'Live with family',
            'value' => ($this->_model) ? $this->_model->getLive_with_family() : '',
            'description' => 'Check this field if this person live with his/her family',
        ));
        $this->_addElementHomeSituation();
        $this->_addElementRentValue();
        $this->_addElementHomeArea();
        $this->_addElementHomeType();
//        $formutil->addElementDate($this, array(
//            'name' => 'home_since',
//            'modelfield' => 'home_since',
//            'label' => 'Living since',
//            'description' => 'Since that date lives in this house',
//            'required' => true,
//            'default' => 'false',
//        ));
        $this->addElement('text', 'home_pieces_number', array(
            'label' => 'Home pieces',
            'value' => ($this->_model) ? $this->_model->getHome_pieces_number() : '',
            'type' => 'number',
//            'required' => true,
            'class' => 'mask-input',
            'data-mask' => '{"mask": "9", "repeat": 2, "greedy":false}',
        ));

        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'id', 'first_help_date', 'religion', 
                ), 'personhelpedform', array(
        ));

        $this->addDisplayGroup(array(
            'born_state_id', 'born_city_id',
                ), 'personhelpedbornform', array(
            'legend' => 'Birth data',
        ));

        $this->addDisplayGroup(array(
            'professional_occupation_choice', 'professional_occupation',
            'professional_experience',
                ), 'personhelpedprofessionalform', array(
            'legend' => 'Professional data',
        ));

        $this->addDisplayGroup(array(
//            'live_with_family', 'home_since',
            'live_with_family',
            'home_situation_choice', 'home_situation', 'rent_value',
            'home_area_choice', 'home_area',
            'home_type_choice', 'home_type', 'home_pieces_number',
                ), 'personhelpedhomeform', array(
            'legend' => 'Home data',
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}
