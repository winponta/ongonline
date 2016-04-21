<?php

/**
 * Html form element
 *
 * @category   Agana
 * @package    Agana_Form
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Form_Element_Html extends Zend_Form_Element_Xhtml {

    /**
     * Default form view helper to use for rendering
     * @var string
     */
    public $helper = 'formNote';

    public function isValid($value, $context = null) {
        return true;
    }

}