<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_UserDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param String $uid 
     */
    public function __construct($id) {
        $dataMessage = 'Are you sure you want to delete user?';
        
        $hiddenFields = array('id' => $id);
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}

