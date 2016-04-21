<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_Staff
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Staff_Form_JobfunctionDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param Location_Model_Country
     */
    public function __construct($model) {
        $dataMessage = $this->getView()->translate('Are you sure you want to delete this job function: ') . $model->getName() . '?';
        
        $hiddenFields = array('id' => $model->getId());
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}

?>
