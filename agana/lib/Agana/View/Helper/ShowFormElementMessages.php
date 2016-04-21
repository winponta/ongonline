<?php

/**
 * Agana_View_Helper_ShowFormElementMessage
 * 
 * @category   Agana
 * @package    Agana_View_Helper
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_ShowFormElementMessages extends Zend_View_Helper_Abstract {

    /**
     * Main method
     * @param string The form object
     * @param string Name of the element
     * @return string HTML block showing message
     */
    public function showFormElementMessages(Zend_Form $form, $element) {
        if ($form->getMessages($element)) {
            echo '<ul class="help-inline alert-error form-error-msg" rel="' . $element . '">';
            foreach ($form->getMessages($element) as $error) {
                echo '<li class="icon-exclamation-sign">' . $error . '</li>';
            }
            echo '</ul>';
        }
    }
    
}