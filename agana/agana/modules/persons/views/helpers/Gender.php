<?php

/**
 * Returns Male or Female word for genre based on f or m passed
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Person_View_Helper_Gender extends Zend_View_Helper_Abstract {

    /**
     * Receives a gender and returns the full description
     * 
     * @param String $gender F or M
     * @return String
     */
    public function gender($gender) {
        if (strtolower($gender) == 'f' ) {
            return 'Female';
        } else if (strtolower($gender) == 'm' ) {
            return 'Male';
        }
        
        return 'Unknow = ' . $gender;
    }
}
