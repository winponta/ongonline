<?php

/**
 * Utilities to Forms
 *
 * @category   Agana
 * @package    Agana_Staff
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Staff_Form_Util {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Staff_Model
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
     * Adds an element JobFunctionId.<br/><br/>
     * Defaults:<br/>
     * name         = job_function_id<br/>
     * requires     = true<br/>
     * label        = Business unit<br/>
     * placeholder  = 'Choose a job function'<br/>
     * dimension    = 6<br/>
     * modelfield   = job_function_id<br/>
     * firstvaluenull  = true
     * 
     * @param Zend_Form $form The Zend_Form object where the element will be added
     * @param array $options The options to pass in the element
     */
    public function addElementJobFunctionId($form, $options = array()) {
        $elementName = isset($options['name']) ? $options['name'] : 'job_function_id';
        $modelField = isset($options['modelfield']) ? $options['modelfield'] : 'job_function_id';

        $form->addElement('select', $elementName, array(
            'filters' => array('StringTrim'),
            'label' => isset($options['label']) ? $options['label'] : 'Job function',
            'dimension' => isset($options['dimension']) ? $options['dimension'] : 6,
            'placeholder' => 'Choose a job function',
            'required' => isset($options['required']) ? $options['required'] : true,
            'value' => ($this->_model) ? $this->_model->$modelField : '',
        ));

        $el = $form->getElement($elementName);

        $firstvaluenull = isset($options['firstvaluenull']) ? $options['firstvaluenull'] : true;
        if ($firstvaluenull) {
            $el->addMultiOption(null, null);
        }

        /**
         * Add job functions
         */
        $jfd = new Staff_Domain_Jobfunction();
        $jf = $jfd->getAll('name');
        
        foreach ($jf as $item) {
            $el->addMultiOption($item->getId(), $item->getName());
        }

        // set value
        if (($this->_model) && ($this->_model->$modelField)) {
            $el->setValue($this->_model->$modelField);
        } else {
            $el->setValue(null);
        }
    }
}