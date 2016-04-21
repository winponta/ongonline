<?php

/**
 * Utilities to Forms
 *
 * @category   Agana
 * @package    Agana_Busunit
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Busunit_Form_Util {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Busunit_Model_Busunit
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
    }

    /**
     * Adds an element BusUnitId.<br/><br/>
     * Defaults:<br/>
     * name         = busunit_id<br/>
     * requires     = true<br/>
     * label        = Business unit<br/>
     * placeholder  = 'Choose a business unit'<br/>
     * dimension    = 6<br/>
     * modelfield   = busunit_id<br/>
     * firstvaluenull  = true
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementBusunitId($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'busunit_id';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'busunit_id';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Business unit',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'placeholder' => 'Choose a business unit',
            'required' => isset($options['required']) ? $options['required'] : true,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $firstvaluenull = isset($options['firstvaluenull']) ? $options['firstvaluenull'] : true;
        if ($firstvaluenull) {
            $el->addMultiOption(null, null);
        }

        /////////////////////
        // Add Headquarters
        $bud = new Busunit_Domain_Headquarters();
        $bu = $bud->getByAppAccount(Zend_Auth::getInstance()->getIdentity()->appaccount_id);

        $el->addMultiOption($bu->getId(), $bu->getName());

        // Add Branchs
        $bud = new Busunit_Domain_Branch();
        $bu = $bud->getAll('name');

        foreach ($bu as $busunit) {
            $el->addMultiOption($busunit->getId(), $busunit->getName());
        }

        // set value
        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }

}