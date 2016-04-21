<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_App
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class App_Form_AccountDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param Phone_Model_Type
     */
    public function __construct($account) {
        $dataMessage = $this->getView()->translate('Are you sure you want to delete this app account: ') . $account->getName() . '?';
        
        $hiddenFields = array('id' => $account->getId());
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}

?>
