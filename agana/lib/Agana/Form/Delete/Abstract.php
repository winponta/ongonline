<?php

/**
 * Agana_Form_Delete_Abstract
 *
 * @category   Agana
 * @package    Agana_Form
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
abstract class Agana_Form_Delete_Abstract extends Twitter_Bootstrap_Form {

    /**
     * The message of data record being deleted
     * @var String
     */
    protected $_dataMessage;

    /**
     * Array of hidden fields to be inserted in the form. Format fielName => value
     * @var array (fieldName => vale)
     */
    protected $_hiddenFields;

    public function __construct($dataMessage = 'this record', $hiddenFields = null, $options = null) {
        $this->_dataMessage = $dataMessage;
        $this->_hiddenFields = $hiddenFields;
        parent::__construct($options);
    }

    public function init() {
        $this->setName("delete");
        $this->setMethod('POST');
        $this->addAttribs(array('load-in'=>'content-container'));

        $description = new Agana_Form_Element_Html('delete_data_description');
        $description->setLabel($this->_dataMessage);
        $this->addElement($description);

        if (is_array($this->_hiddenFields)) {
            foreach ($this->_hiddenFields as $field => $value) {
                $this->addElement('hidden', $field, array(
                    'value' => $value,
                ));
            }
        } else {
            $this->_hiddenFields = array();
        }

        $elements = array_merge(array('delete_data_description'), array_keys($this->_hiddenFields));

        $this->addDisplayGroup(array('delete_data_description'), 'deleteFormGroup', 
                array('legend' => 'Delete',)
        );

        $this->addElement('submit', 'confirm', array(
            'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_DANGER,
            'required' => false,
            'ignore' => FALSE,
            'label' => 'Confirm',
            'xload-in' => 'content-container',
        ));
        
//        $this->getElement('confirm')->addDecorator('HtmlTag', array(
//            'tag' => 'span',
//            'style' => 'float:left',
////            'openOnly' => true,
////            'placement' => Zend_Form_Decorator_Abstract::PREPEND
//        ));

        $this->addElement('submit', 'cancel', array(
            'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
            'required' => false,
            'label' => 'Cancel',
            'load-in' => 'content-container',
        ));
//        $this->getElement('cancel')->addDecorator('HtmlTag', array(
//            'tag' => 'span',
//            'style' => 'float:left;margin-left:1em;',
////            'openOnly' => true,
////            'placement' => Zend_Form_Decorator_Abstract::PREPEND
//        ));

        $this->addDisplayGroup(
                array('cancel', 'confirm', 'cancel-link'), 'actions-end', array(
                    'disableLoadDefaultDecorators' => true,
                    'decorators' => array('Actions')
                )
        );
    }

}
