<?php

/**
 * DeleteForm
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonDelete extends Agana_Form_Delete_Abstract {

    /**
     *
     * @param Phone_Model_Type
     */
    public function __construct($person) {
        $dataMessage = $this->getView()->translate('Are you sure you want to delete this person: ') . $person->getName() . '?';
        
        $hiddenFields = array('id' => $person->getId());
        parent::__construct($dataMessage, $hiddenFields);
    }
    
}
