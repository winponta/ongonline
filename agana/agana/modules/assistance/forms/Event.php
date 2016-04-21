<?php

/**
 * Event Activity Form
 *
 * @category   Agana
 * @package    Agana_Assistance
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Assistance_Form_Event extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Assistance_Model_Event
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _addProjectId() {
        $this->addElement('select', 'project_id', array(
            'required' => false,
            'label' => 'Projeto',
            'dimension' => 6,
        ));

        $el = $this->getElement('project_id');

        $prjDomain = new Project_Domain_Project();
        $prj = $prjDomain->getByStatus(Project_Model_Project::PROJECT_STATUS_ACTIVE_ID);

        $el->addMultiOption(null, null);
        foreach ($prj as $proj) {
            $el->addMultiOption($proj->getId(), $proj->getName());
        }

        if ($this->_model && $this->_model->project_id) {
            $el->setValue($this->_model->project_id);
        }
    }

    private function _addTaskId() {
        $this->addElement('select', 'task_type_id', array(
            'required' => true,
            'label' => 'Tipo de tarefa',
            'dimension' => 6,
        ));

        $el = $this->getElement('task_type_id');

        $taskDomain = new Project_Domain_Tasktype();
        $task = $taskDomain->getAll();

        $el->addMultiOption(null, null);
        foreach ($task as $tsk) {
            $tskName = '';
            if (trim($tsk->getParent_id()) != '') {
                $tskName = $tsk->getParent()->getName() . ' :: ';
            }
            $tskName .= $tsk->getName();

            $el->addMultiOption($tsk->getId(), $tskName);
        }

        if ($this->_model && $this->_model->task_type_id) {
            $el->setValue($this->_model->task_type_id);
        }
    }

    private function _getIdElement() {
        $element = null;

        if ($this->_action == self::ACTION_EDIT) {
            $element = $this->createElement('hidden', 'id', array('value' => $this->_model->id,));
        }

        return $element;
    }

    public function init() {
        $this->setName("eventoatividade_assistencia");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $formutil->addElementDate($this, array(
            'name' => 'event_date',
            'modelfield' => 'event_date',
            'label' => 'Data do evento de atendimento',
            'description' => 'Data em que o evento de atendimento em grupo está sendo/foi realizado. DD/MM/AAAA',
            'required' => true,
            'default' => 'today',
        ));

        $this->_addProjectId();
        $this->_addTaskId();

        $this->addElement('submit', 'save', array(
            'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
            'label' => 'Save',
            'icon' => 'icon-ok-circle',
        ));

        $this->addElement('submit', 'cancel', array(
            'label' => 'Cancel',
            'value' => 'cancel',
        ));

        $this->addDisplayGroup(array(
            'event_date', 'project_id', 'task_type_id',
                ), 'evento_assistencia_form', array(
                //'legend' => 'Activity',
        ));

        $this->addDisplayGroup(
                array('save', 'cancel'), 'actions-end', array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array('Actions')
                )
        );
    }

}
