<?php

/**
 * Utilities to Forms
 *
 * @category   Agana
 * @package    Agana_Form
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Form_Util {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Agana Model object
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
    }

    /**
     * Adds an element Name.
     * Defaults:
     * name         = name
     * requires     = true
     * label        = Name
     * dimension    = 6
     * maxlength    = 100
     * modelfield   = name
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementName($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'name';

        $form->addElement('text', $elementName, array(
            'class' => 'focused',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 100)),
            ),
            'required' => isset($options['required']) ? $options['required'] : true,
            'label' => isset($options['label']) ? $options['label'] : 'Name',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->name) : '',
        ));
    }

    /**
     * Adds an element Description. <br/>
     * Defaults: <br/>
     * name         = description <br/>
     * requires     = false <br/>
     * label        = Description <br/>
     * dimension    = 6 <br/>
     * rows         = 5 <br/>
     * maxlength    = 400 <br/>
     * modelfield   = description <br/>
     * description  = '' <br/>
     * editor       = false <br/>
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementDescription($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'description';

        $form->addElement('textarea', $elementName, array(
            'filters' => array('StringTrim'),
            'required' => isset($options['required']) ? $options['required'] : false,
            'label' => isset($options['label']) ? $options['label'] : 'Description',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'description' => isset($options['description']) ? $options['description'] : '',
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->description) : '',
            'rows' => isset($options['rows']) ? $options['rows'] : 5,
            'class' => (isset($options['editor'])) ?
                    ($options['editor']) ? 'editor' : '' : '',
        ));

        // by default maxlength is 400 but if it is passed by param and is 0 (zero)
        // then should not be set, even to default value
        $setMaxlength = true;
        if (isset($options['maxlength'])) {
            $setMaxlength = intval($options['maxlength']) > 0;
        }
        if ($setMaxlength) {
            $el = $form->getElement($elementName);
            $el->addValidator(new Zend_Validate_StringLength(
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 400)
                    )
            );
        }
    }

    /**
     * Adds an element Phone (Mobile).
     * Defaults:
     * name         = phone
     * requires     = false
     * label        = Phone
     * dimension    = 3
     * maxlength    = 16
     * modelfield   = phone
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementPhone($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'phone';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Phone',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 3,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 16)),
            ),
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->phone) : '',
            'class' => isset($options['class']) ? $options['class'] : '',
        ));
    }

    /**
     * Adds an element Date. <br/>
     * Defaults: <br/>
     * name         = date <br/>
     * requires     = false <br/>
     * locale       = pt_BR <br/>
     * label        = Date <br/>
     * dimension    = 2 <br/>
     * maxlength    = 12 <br/>
     * modelfield   = date <br/>
     * description  = 'Date format' <br/>
     * addDescriptionFormat  = true <br/>
     * class        = '' <br/>
     * rel          = datepicker  <br/>
     * default      = today <br/>
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementDate($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'date';

        $dateFormat = new Zend_Date("2012.12.31");

        $modelfieldValue = ($this->_model) ?
                ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->date) : '';

        $default = isset($options['default']) ? $options['default'] : 'today';

        /*
          Aparentemente não vejo algo errado aí, mas pela descrição que tive do erro
          Acredito que o problema esteja no if acima e na função abaixo
          Pelo que entendi ele está colocando o valor automaticamente como today
          Com esse today, ele entra na linha 174
          Entrando na linha 174 ele atribui a data do dia ao invés do aniversário
         * 
         Hébertom: o problema é logo abaixo mesmo, para não alterar a lógica apenas modifiquei para $modelfieldValue = ""
         */

        if (empty($modelfieldValue)) {
            if ($default !== false) {
                if (strtolower($default) == 'today') {
                    $modelfieldValue = ""; // Zend_Date::now();
                } else {
                    $modelfieldValue = new Zend_Date($default);
                }
            }
        }

        if ($modelfieldValue) {
            $modelfieldValue = new Zend_Date($modelfieldValue);
            $modelfieldValue = $modelfieldValue->get(Zend_Date::DATE_MEDIUM);
        }

        $description = $form->getTranslator()->_(isset($options['description']) ? $options['description'] : '');

        $addDescriptionFormat = isset($options['addDescriptionFormat']) ? $options['addDescriptionFormat'] : true;
        if ($addDescriptionFormat) {
            $description .= ' - Date format ' . $dateFormat->get(Zend_Date::DATE_MEDIUM);
        }

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Date',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 2,
            'required' => isset($options['required']) ? $options['required'] : false,
            'description' => $description,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 12)
                ),
                array('Date', false,
                    array(
                        'format' => 'dd.mm.YYYY',
                        'locale' => isset($options['locale']) ? $options['locale'] : 'pt_BR'
                    ),
                ),
                array('Regex', false,
                    array(
                        'pattern' => '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/',
                        'messages' => array(
                            Zend_Validate_Regex::NOT_MATCH => "Date does not match the format 'dd/mm/yyyy'"
                        )
                    )
                ),
            ),
            'value' => $modelfieldValue,
            'class' => isset($options['class']) ? $options['class'] : '',
            'rel' => isset($options['rel']) ? $options['rel'] : 'datepicker',
        ));
    }

    /**
     * Adds an element Time. <br/>
     * Defaults: <br/>
     * name         = time <br/>
     * requires     = false <br/>
     * locale       = pt_BR <br/>
     * label        = Time <br/>
     * dimension    = 2 <br/>
     * maxlength    = 5 <br/>
     * modelfield   = time <br/>
     * description  = 'Time format' <br/>
     * class        = '' <br/>
     * rel          = timepicker  <br/>
     * default      = today <br/>
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementTime($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'date';

        $dateFormat = new Zend_Date();

        $modelfieldValue = ($this->_model) ?
                ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->time) : '';

        $default = isset($options['default']) ? $options['default'] : 'today';

        if (empty($modelfieldValue)) {
            if ($default !== false) {
                if (strtolower($default) == 'today') {
                    $modelfieldValue = Zend_Date::now();
                } else {
                    $modelfieldValue = new Zend_Date($default);
                }
            }
        }

        if ($modelfieldValue) {
            $modelfieldValue = new Zend_Date($modelfieldValue);
            $modelfieldValue = $modelfieldValue->get(Zend_Date::TIME_SHORT);
        }

        $description = $form->getTranslator()->_(isset($options['description']) ? $options['description'] : '');
        $description .= ' - Time format ' . $dateFormat->get(Zend_Date::TIME_MEDIUM);

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Time',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 2,
            'required' => isset($options['required']) ? $options['required'] : false,
            'description' => $description,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 12)
                ),
                array('Date', false,
                    array(
                        'format' => 'HH:mm',
                        'locale' => isset($options['locale']) ? $options['locale'] : 'pt_BR'
                    ),
                ),
//                array('Regex', false,
//                    array(
//                        'pattern' => '/^[01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/',
//                        'messages' => array(
//                                Zend_Validate_Regex::NOT_MATCH => "Time does not match the format 'HH:MM'"
//                            )
//                        )                    
//                ),
            ),
            'value' => $modelfieldValue,
            'class' => isset($options['class']) ? $options['class'] : '',
                //'rel' => isset($options['rel']) ? $options['rel'] : 'datepicker',
        ));
    }

    /**
     * Adds an element Address.
     * Defaults:
     * name         = address
     * requires     = false
     * label        = address
     * dimension    = 6
     * maxlength    = 150
     * modelfield   = address
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementAddress($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'address';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Address',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 150)),
            ),
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->address) : '',
        ));
    }

    /**
     * Adds an element Address Number.
     * Defaults:
     * name         = addressnumber
     * requires     = false
     * label        = Address number
     * description  => 'You may use letters. Example: C-01',
     * dimension    = 2
     * maxlength    = 6
     * modelfield   = addressnumber
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementAddressNumber($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'addressnumber';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Address number',
            'description' => isset($options['description']) ? $options['description'] : 'You may use letters. Example: C-01',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 2,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 6)),
            ),
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->addressnumber) : '',
        ));
    }

    /**
     * Adds an element Address Details.
     * Defaults:
     * name         = addressdetails
     * requires     = false
     * label        = Address details
     * description  => 'You may describe details to the location. Example: at corner of Good Bread Bakery'
     * dimension    = 6
     * maxlength    = 150
     * modelfield   = addressdetails
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementAddressDetails($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'addressdetails';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Address details',
            'description' => isset($options['description']) ? $options['description'] : 'You may describe details to the location. Example: at corner of Good Bread Bakery',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 150)),
            ),
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->addressdetails) : '',
        ));
    }

    /**
     * Adds an element District.
     * Defaults:
     * name         = district
     * requires     = false
     * label        = District
     * dimension    = 6
     * maxlength    = 50
     * modelfield   = district
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementDistrict($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'district';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'District',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 50)),
            ),
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->district) : '',
        ));
    }

    /**
     * Adds an element Postal Code.
     * Defaults:
     * name         = postalcode
     * requires     = false
     * label        = Postal code
     * dimension    = 2
     * maxlength    = 9
     * modelfield   = postalcode
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementPostalCode($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'postalcode';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Postal code',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 2,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 9)),
            ),
            'value' => ($this->_model) ?
                    ((isset($options['modelfield'])) ? $this->_model->$options['modelfield'] : $this->_model->postalcode) : '',
        ));
    }

    /**
     * Adds an element StateId.<br/>
     * Defaults:<br/>
     * name         = state_id<br/>
     * requires     = false<br/>
     * label        = State<br/>
     * placeholder  = 'Choose a state'<br/>
     * dimension    = 4<br/>
     * modelfield   = state_id<br/>
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementStateId($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'state_id';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'state_id';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'State',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 4,
            'placeholder' => 'Choose a state',
            'required' => isset($options['required']) ? $options['required'] : false,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $cd = new Location_Domain_State();
        $c = $cd->getAll(array('orderby' => 'name'));

        $el->addMultiOption(null, null);
        foreach ($c as $city) {
            $el->addMultiOption($city->getId(), $city->getName());
        }

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }

    /**
     * Adds an element CityId.
     * Defaults:
     * name         = city_id
     * requires     = false
     * label        = City
     * placeholder  = 'Choose a city'
     * dimension    = 4
     * modelfield   = city_id
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementCityId($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'city_id';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'city_id';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'City',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 4,
            'placeholder' => 'Choose a city',
            'required' => isset($options['required']) ? $options['required'] : false,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $cd = new Location_Domain_City();
        $c = $cd->getAll(array('orderby' => 'name'));

        $el->addMultiOption(null, null);
        foreach ($c as $city) {
            $el->addMultiOption($city->getId(), $city->getName());
        }

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }

    /**
     * Adds an element CityRegionId.
     * Defaults:
     * name         = city_region_id
     * requires     = false
     * label        = City region
     * placeholder  = 'Choose a region'
     * dimension    = 4
     * modelfield   = city_region_id
     * showcity     = false (if should show city name with region name)
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementCityRegionId($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'city_region_id';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'city_region_id';

        $showCity = isset($options['showcity']) ? $options['showcity'] : false;

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'City region',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 4,
            'placeholder' => 'Choose a region',
            'required' => isset($options['required']) ? $options['required'] : false,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $cd = new Location_Domain_CityRegion();
        $c = $cd->getAll(array('orderby' => 'name'));

        $el->addMultiOption(null, null);
        foreach ($c as $region) {
            $regionName = $region->getName();
            if ($showCity) {
                $regionName .= ' (' . $region->getCity()->name . ')';
            }
            $el->addMultiOption($region->getId(), $regionName);
        }

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }

    /**
     * Adds an element Marital Status.
     * Defaults:
     * name         = marital_status
     * requires     = false
     * label        = Marital status
     * placeholder  = 'Choose a marital status'
     * dimension    = 2
     * modelfield   = marital_status
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementMaritalStatus($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'marital_status';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'marital_status';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Marital status',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 2,
            'placeholder' => 'Choose a marital status',
            'required' => isset($options['required']) ? $options['required'] : false,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $el->addMultiOption(null, null);
        $el->addMultiOption(Persons_Model_MaritalStatus::SINGLE, Persons_Model_MaritalStatus::SINGLE);
        $el->addMultiOption(Persons_Model_MaritalStatus::MARRIED, Persons_Model_MaritalStatus::MARRIED);
        $el->addMultiOption(Persons_Model_MaritalStatus::WIDOW_ER, Persons_Model_MaritalStatus::WIDOW_ER);
        $el->addMultiOption(Persons_Model_MaritalStatus::SEPARETED, Persons_Model_MaritalStatus::SEPARETED);
        $el->addMultiOption(Persons_Model_MaritalStatus::STABLE_UNION, Persons_Model_MaritalStatus::STABLE_UNION);

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }

    /**
     * Adds an element Gender.
     * Defaults:
     * name         = gender
     * requires     = true
     * label        = Gender
     * dimension    = 4
     * modelfield   = gender
     * class        = ''
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementGender($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'gender';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'gender';

        $form->addElement('radio', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Gender',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 4,
            'required' => isset($options['required']) ? $options['required'] : true,
            'class' => isset($options['class']) ? $options['class'] : '',
        ));

        $el = $form->getElement($elementName);

        $el->addMultiOptions(array(
            'm' => 'Male',
            'f' => 'Female'
        ));

        $el->setSeparator('&nbsp&nbsp&nbsp');

        $el->setAttrib('label_class', 'display-inline-block');

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }

    /**
     * Adds an element Website url.
     * Defaults:
     * name         = website
     * requires     = false
     * label        = Website
     * description  => 'The url address of your organization web site. Example: http://www.winponta.com.br',
     * dimension    = 9
     * maxlength    = 255
     * modelfield   = website
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementWebsite($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'website';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'website';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Website',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 9,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 255)),
            ),
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));
    }

    /**
     * Adds an element Email.
     * Defaults:
     * name         = email
     * requires     = false
     * label        = Email
     * description  => 'Format: your@email.com',
     * dimension    = 9
     * maxlength    = 255
     * modelfield   = email
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementEmail($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'email';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'email';

        $form->addElement('text', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Email',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 9,
            'required' => isset($options['required']) ? $options['required'] : false,
            'validators' => array(
                array('StringLength', false,
                    array(0, isset($options['maxlength']) ? $options['maxlength'] : 255)),
            ),
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));
    }

    /**
     * Adds an element EmployeeId as a Combobox.
     * Defaults:
     * name         = employee_id
     * requires     = true
     * label        = Employee
     * placeholder  = Chosse an employee
     * dimension    = 6
     * modelfield   = employee_id
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     * @return Zend_Form_Element Zend Form element just created
     */
    public function addElementEmployeeIdCombo($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'employee_id';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'employee_id';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Employee',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'placeholder' => 'Choose an employee',
            'required' => isset($options['required']) ? $options['required'] : true,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $employeeDomain = new Staff_Domain_Employee();
        $employeeList = $employeeDomain->getAll('name');

        $el->addMultiOption(null, null);
        foreach ($employeeList as $employee) {
            $el->addMultiOption($employee->getId(), $employee->getPerson()->getName());
        }

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }

        return $el;
    }

    /**
     * Adds an element Status of Project as a Combobox.<br/>
     * Defaults:<br/>
     * name         = status<br/>
     * required     = true<br/>
     * label        = Status<br/>
     * dimension    = 6<br/>
     * modelfield   = status<br/>
     * class        = selectpicker<br/>
     * first-options= must be and array of array('value1', 'label'). Default is an empty array<br/>
     * sample of first-options: array(array('value'=>null, 'label'=>'Choose an option'))
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     * @return Zend_Form_Element Zend Form element just created
     */
    public function addElementProjectStatus($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'status';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'status';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Status',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'required' => isset($options['required']) ? $options['required'] : true,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
            'class' => isset($options['class']) ? $options['class'] : 'selectpicker',
        ));

        $el = $form->getElement($elementName);

        if (isset($options['first-options'])) {
            foreach ($options['first-options'] as $op) {
                $el->addMultiOption($op['value'], $op['label']);
            }
        }

        $el->addMultiOption(Project_Model_Project::PROJECT_STATUS_DRAFT_ID, Project_Model_Project::PROJECT_STATUS_DRAFT_LABEL);
        $el->addMultiOption(Project_Model_Project::PROJECT_STATUS_ACTIVE_ID, Project_Model_Project::PROJECT_STATUS_ACTIVE_LABEL);
        $el->addMultiOption(Project_Model_Project::PROJECT_STATUS_FINISHED_ID, Project_Model_Project::PROJECT_STATUS_FINISHED_LABEL);
        $el->addMultiOption(Project_Model_Project::PROJECT_STATUS_CLOSED_ID, Project_Model_Project::PROJECT_STATUS_CLOSED_LABEL);
        $el->addMultiOption(Project_Model_Project::PROJECT_STATUS_PAUSED_ID, Project_Model_Project::PROJECT_STATUS_PAUSED_LABEL);

        $optionClasses[] = '" data-content="<span class=\'label\'>' . $form->getTranslator()->_(Project_Model_Project::PROJECT_STATUS_DRAFT_LABEL) . '</span>';
        $optionClasses[] = '" data-content="<span class=\'label label-success\'>' . $form->getTranslator()->_(Project_Model_Project::PROJECT_STATUS_ACTIVE_LABEL) . '</span>';
        $optionClasses[] = '" data-content="<span class=\'label label-info\'>' . $form->getTranslator()->_(Project_Model_Project::PROJECT_STATUS_FINISHED_LABEL) . '</span>';
        $optionClasses[] = '" data-content="<span class=\'label label-inverse\'>' . $form->getTranslator()->_(Project_Model_Project::PROJECT_STATUS_CLOSED_LABEL) . '</span>';
        $optionClasses[] = '" data-content="<span class=\'label label-warning\'>' . $form->getTranslator()->_(Project_Model_Project::PROJECT_STATUS_PAUSED_LABEL) . '</span>';
        $el->setAttrib('optionClasses', $optionClasses);

        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }

        return $el;
    }

    /**
     * Adds an element Submit Button Save.
     * Defaults:
     * name         = save
     * label        = Save
     * value        = save
     * buttonType   = Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
     * icon         = 'icon-ok-circle',
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementButtonSave($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'save';
        $buttonType = isset($options['buttonType']) ? $options['buttonType'] : Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY;

        $form->addElement('button', $elementName, array(
            'buttonType' => $buttonType,
            'value' => isset($options['value']) ? $options['value'] : 'save',
            'label' => isset($options['label']) ? $options['label'] : 'Save',
            'icon' => isset($options['icon']) ? $options['icon'] : 'ok',
            'type' => 'submit',
        ));
    }

    /**
     * Adds an element Submit Button Cancel.
     * Defaults:
     * name         = cancel
     * label        = Cancel
     * value        = value
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementButtonCancel($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'cancel';

        $form->addElement('button', $elementName, array(
            'value' => isset($options['value']) ? $options['value'] : 'cancel',
            'label' => isset($options['label']) ? $options['label'] : 'Cancel',
            'icon' => isset($options['icon']) ? $options['icon'] : 'undo',
            'type' => 'submit',
        ));
    }

    /**
     * Adds an element Submit Button Print.
     * Defaults:
     * name         = print
     * label        = Print
     * value        = print
     * buttonType   = Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
     * icon         = 'icon-print',
     * type         = button
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementButtonPrint($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'print';
        $buttonType = isset($options['buttonType']) ? $options['buttonType'] : Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY;

        $form->addElement('button', $elementName, array(
            'buttonType' => $buttonType,
            'value' => isset($options['value']) ? $options['value'] : 'print',
            'label' => isset($options['label']) ? $options['label'] : 'Print',
            'icon' => isset($options['icon']) ? $options['icon'] : 'print',
            'class' => 'open-report-colorbox',
            'type' => 'submit',
        ));
    }

    protected function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_model->id,));
        }

        return $element;
    }

}
