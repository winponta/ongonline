<?php

/**
 * Assistance Form
 *
 * @category   Agana
 * @package    Agana_Assistance
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Assistance_Form_ActivityReportByProject extends Twitter_Bootstrap_Form_Horizontal {

    private $translate = null;

    public function __construct() {
        $this->translate = $this->getTranslator();

        parent::__construct();
    }

    private function addProjects() {
        $this->addElement('select', 'project_id', array(
            'required' => true,
            'label' => 'Filter by project',
            'dimension' => 6,
                //'class' => 'selectpicker',
        ));

        $el = $this->getElement('project_id');

        $pd = new Project_Domain_Project();
        $projects = $pd->getAll();

        $el->addMultiOption(null, $this->translate->_('All projects'));
        foreach ($projects as $prj) {
            $el->addMultiOption($prj->getId(), $prj->getName());
        }
    }

    public function init() {
        $formutil = new Agana_Form_Util(null);

        $this->setName("report-persons-by-project");
        $this->setMethod('post');
        //$this->addAttribs(array('load-in' => 'content-container'));

        $this->addProjects();
        $el = $formutil->addElementProjectStatus($this, array(
            'label'         => $this->getTranslator()->_('Filter by') . ' status',
            'first-options' => array(array('value' => null, 'label' => 'Any status'))
        ));
        
        $el = $formutil->addElementDate($this, array(
            'name'          => 'date_from',
            'label'         => 'À partir da data',
            'default'       => false,
            'addDescriptionFormat' => false,
        ));
        
        $el = $formutil->addElementDate($this, array(
            'name'          => 'date_to',
            'label'         => 'Até a data',
            'default'       => false,
            'addDescriptionFormat' => false,
        ));
        
        $this->addElement('checkbox', 'summarized', array(
            'label' => 'Resumido',
            'description' => 'Check this field to print this report in a summarized format',
        ));

        
        //$formutil->addElementButtonPrint($this, array('type'=>'link'));

        $this->addDisplayGroup(array(
            'id', 'project_id', 'status',
            'date_from','date_to',
            'summarized',
                ), 'project', array()
            );
    }

}
