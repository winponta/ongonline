<?php

/**
 * Project Form
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonHelpedProject extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Project_Model_Project
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _getIdElement() {
        $element = $this->createElement('hidden', 'person_id', array('value' => 
                                                                    ($this->_model) ? $this->_model->id : '',
                                                                )
                );
        return $element;
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
            . $translate->_("Details")
            . '</a>'
            . ' | '
            . '<a class="hide" id="btnPersonCreate" href="' . $urlNew . '" rel="colorbox">'
            . '<i class="icon-plus-sign" rel="tooltip" data-original-title="' . $translate->_("Add new") . ' ' . $translate->_("person") . '"></i>'
            . '</a>',
        ));
    }

    private function addProjects() {
        $this->addElement('select', 'project_id', array(
            'required' => true,
            'label' => 'Projects',
            'dimension' => 6,
                //'class' => 'selectpicker',
        ));

        $el = $this->getElement('project_id');

        $pd = new Project_Domain_Project();
        $projects = $pd->getAll();

        $el->addMultiOption(null, null);
        foreach ($projects as $prj) {
            $el->addMultiOption($prj->getId(), $prj->getName());
        }

    }

    public function init() {
        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        $this->setName("project");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $this->addElement($this->_getIdElement());
        $this->_addElementPerson();

        $this->addProjects();

        $formutil->addElementDate($this, array(
            'name' => 'date_in',
            'label' => 'Date in',
            'modelfield' => 'date_in',
            'default' => 'today',
        ));

        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'id', 'project_id', 'date_in',
                ), 'project', array(
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}