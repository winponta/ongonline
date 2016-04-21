<?php

/**
 * Search Form
 *
 * @category   Agana
 * @package    Agana_Form
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Form_Search extends Twitter_Bootstrap_Form_Inline {

    /**
     *
     * @var Agana_Model_Userguide
     */
    protected $_model;
    
    public function __construct($model = null, $options = null) {
        $this->_model = $model;
        parent::__construct($options);
        
        if (isset($options['urlAction'])) {
            $this->setAction($options['urlAction']);
        }
    }

    private function _addElementTerm() {
        $translate = Zend_Registry::get("Zend_Translate");
        
        $this->addElement('text', 'term', array(
            'class'         => 'focused',
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => '',
            'placeholder' => $translate->_('Enter the search term'),
            'dimension' => 9,
        ));
    }
    
    public function init() {
        $this->setName("search");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in'=>'content-container'));

        $this->_addElementTerm();

        $this->addElement('submit', 'search', array(
            'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
            'label' => 'Search',
            'icon' => 'icon-search',
        ));

//        $this->addElement('submit', 'cancel', array(
//            'label' => 'Cancel',
//            'value' => 'cancel',
//        ));

        $this->addDisplayGroup(array(
            'search', 'term', //'cancel'
                ), 'searchform', array(
        ));

    }

}