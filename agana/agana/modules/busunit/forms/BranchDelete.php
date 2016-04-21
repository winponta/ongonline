<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_Busunit
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Busunit_Form_BranchDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param Location_Model_Country
     */
    public function __construct($model) {
        $dataMessage = $this->getView()->translate('Are you sure you want to delete this branch: ') . $model->getName() . '?';
        
        $hiddenFields = array('id' => $model->getId());
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}

?>
