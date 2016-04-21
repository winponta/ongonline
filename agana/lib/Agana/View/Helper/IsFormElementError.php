<?php

/**
 * Agana_View_Helper_FormElementMessageHasError
 * 
 * @category   Agana
 * @package    Agana_View_Helper
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_isFormElementError extends Zend_View_Helper_Abstract {

    /**
     * Main method
     * @param string The form object
     * @param string Name of the element
     * @return boolean
     */
    public function isFormElementError(Zend_Form $form, $element) {
        return isset($form->getErrors($element));
    }
    
}
