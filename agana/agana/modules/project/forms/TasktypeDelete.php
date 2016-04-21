<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Project_Form_TasktypeDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param Project_Model_Tasktype
     */
    public function __construct($model) {
        $dataMessage = $this->getView()->translate('Are you sure you want to delete this task type: ') . $model->getName() . '?';
        
        $hiddenFields = array('id' => $model->getId());
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}