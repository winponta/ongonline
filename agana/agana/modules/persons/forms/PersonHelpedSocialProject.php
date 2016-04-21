<?php

/**
 * Social Project Form
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonHelpedSocialProject extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Persons_Model_PersonHelpedSocialProject
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

    private function addSocialProjects() {
        $this->addElement('select', 'pfs_id', array(
            'required' => true,
            'label' => 'Programa Social',
            'dimension' => 6,
                //'class' => 'selectpicker',
        ));

        $el = $this->getElement('pfs_id');

        $pd = new Persons_Domain_SocialProject();
        $projects = $pd->getAll('sigla');

        $el->addMultiOption(null, null);
        foreach ($projects as $prj) {
            $el->addMultiOption($prj->getId(), $prj->getSigla() . ' - ' . $prj->getNome());
        }

    }

    private function addNumero() {
        $this->addElement('text', 'numero', array(
            'required' => true,
            'label' => 'Número',
            'dimension' => 6,
        ));
    }

    public function init() {
        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        $this->setName("socialproject");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $this->addElement($this->_getIdElement());
        $this->_addElementPerson();

        $this->addSocialProjects();
        $this->addNumero();
        
        $formutil->addElementButtonSave($this);
        $formutil->addElementButtonCancel($this);

        $this->addDisplayGroup(array(
            'id', 'pfs_id', 'numero',
                ), 'socialproject', array(
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}