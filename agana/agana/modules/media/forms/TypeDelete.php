<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_Phone
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Phone_Form_TypeDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param Phone_Model_Type
     */
    public function __construct($phonetype) {
        $dataMessage = $this->getView()->translate('Are you sure you want to delete this phone type: ') . $phonetype->getName() . '?';
        
        $hiddenFields = array('id' => $phonetype->getId());
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}

?>
