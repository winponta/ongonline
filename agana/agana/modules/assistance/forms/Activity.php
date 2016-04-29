<?php

/**
 * Activity Form
 *
 * @category   Agana
 * @package    Agana_Assistance
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Assistance_Form_Activity extends Twitter_Bootstrap_Form_Horizontal {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Assistance_Model_Activity
     */
    protected $_model;
    protected $_action;

    public function __construct($action, $model = null, $options = null) {
        $this->_action = $action;
        $this->_model = $model;
        parent::__construct($options);
    }

    private function _addElementPersonPerformed() {
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
        if ($this->_action == self::ACTION_ADD) {
            $append .= '<a id="btnPersonPerformedSearch" href="' . $urlSearch . '" '
                    . ' rel="colorbox-search" search-return-id="id" search-return-value="person_name">'
                    . '<i class="icon-search" rel="tooltip" data-original-title="' . $translate->_("Search person") . '"></i>'
                    . '</a>';
        }

        $description = new Agana_Form_Element_Html('person_performed_name', array(
        ));
        //$description->addDecorator('Agana_Form_Decorator_Highlighted');
        $description->setLabel('Person');
        $this->addElement($description);

        $this->addElement('text', 'person_performed_name', array(
            'label' => 'Person',
            'value' => ($this->_model) ? $this->_model->getPerson()->getName() : '',
            'dimension' => 2,
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
        $task = $taskDomain->getAllParentTask();
        
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

    private function _addIdByFingerkey() {
        $this->addElement('hidden', 'id_by_finger_key', array(
            'required' => true,
            'value' => !is_object($this->_model) ? '0' : $this->_model->id_by_finger_key,)
        );
    }

    private function _addPersonPerformedId() {
        $this->addElement('hidden', 'person_performed_id', array(
            'required' => true,
            'value' => !is_object($this->_model) ? '' : $this->_model->person_performed_id,)
        );
    }

    private function _addPersonHelpedId() {
        $this->addElement('hidden', 'person_helped_id', array(
            'required' => true,
            'value' => !is_object($this->_model) ? '' : $this->_model->person_helped_id,)
        );
    }

    private function _addPersonRecordedId() {
        $this->addElement('hidden', 'person_recorded_id', array(
            'required' => true,
            'value' => !is_object($this->_model) ? '' : $this->_model->person_recorded_id,)
        );
    }

    public function init() {
        $this->setName("atividade_assistencia");
        $this->setMethod('post');
        $this->_addClassNames('well');
        $this->addAttribs(array('load-in' => 'content-container'));

        $formutil = new Agana_Form_Util($this->_action, $this->_model);

        if ($this->_action == self::ACTION_EDIT) {
            $this->addElement($this->_getIdElement());
        }

        $this->_addIdByFingerkey();
        $this->_addPersonPerformedId();
        $this->_addPersonRecordedId();
        $this->_addPersonHelpedId();

        $formutil->addElementDate($this, array(
            'name' => 'assistance_date',
            'modelfield' => 'assistance_date',
            'label' => 'Data do atendimento',
            'description' => 'Data em que foi realizado o atendimento. DD/MM/AAAA',
            'required' => true,
            'default' => 'today',
        ));

        $formutil->addElementTime($this, array(
            'name' => 'assistance_time',
            'modelfield' => 'assistance_time',
            'label' => 'Hora do atendimento',
            'description' => 'Hora em que foi realizado o atendimento. HH:MM',
            'required' => true,
            'default' => 'today',
        ));

        $this->_addProjectId();
        $this->_addTaskId();

        $formutil->addElementDescription($this);

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
            'id_by_finger_key', 'person_performed_id', 'person_helped_id', 'person_recorded_id',
            'assistance_date', 'assistance_time', 'project_id', 'task_type_id',
            'description',
                ), 'atividade_assistencia_form', array(
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
