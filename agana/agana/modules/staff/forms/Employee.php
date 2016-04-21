<?php

/**
 * Staff Employee Form
 *
 * @category   Agana
 * @package    Agana_Staff
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Staff_Form_Employee extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Staff_Model_Employee
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
            'module'=>'persons',
            'controller'=>'person',
            'action'=>'search-form'
            ), null, true);
        
        $urlNew = $url->url(array(
            'module'=>'persons',
            'controller'=>'person',
            'action'=>'create'
            ), null, true);
        
        $append = '';
        if ($this->_action == self::ACTION_ADD) {
            $append .= '<a id="btnPersonSearch" href="'.$urlSearch.'" '
                            . ' rel="colorbox-search" search-return-id="id" search-return-value="person_name">'
                            . '<i class="icon-search" rel="tooltip" data-original-title="'.$this->translate->_("Search person").'"></i>'
                        . '</a>';
        }
        
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
                        . '<a class="hide" id="btnPersonCreate" href="'.$urlNew.'" rel="colorbox">' 
                            . '<i class="icon-plus-sign" rel="tooltip" data-original-title="'.$this->translate->_("Add new").' '.$this->translate->_("person").  '"></i>'
                        . '</a>',
        ));
    }

    private function _addElementRegNumber() {
        $this->addElement('text', 'registration_number', array(
            'label' => 'Registration number',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, 
                    array(0, 20)),
            ),
            'required' => true,
            'value' => ($this->_model) ? $this->_model->registration_number : '',
            'dimension' => 3,
        ));
    }

    private function _addElementBusunit() {
        $fu = new Busunit_Form_Util($this->_action, $this->_model);
        $fu->addElementBusunitId($this);
    }

    private function _addElementJobfunction() {
        $fu = new Staff_Form_Util($this->_action, $this->_model);
        $fu->addElementJobFunctionId($this);
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
        
        $this->setName("employee");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        $this->addElement($this->_getIdElement());

        //$this->_addElementName();
        $this->_addElementPerson();
        $this->_addElementRegNumber();
        $this->_addElementBusunit();
        $this->_addElementJobfunction();
        
        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'id', 'person_name', 'registration_number', 'busunit_id', 'job_function_id',
                ), 'employeeform', array(
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
