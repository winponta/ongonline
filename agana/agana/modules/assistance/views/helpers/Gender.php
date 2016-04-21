<?php

/**
 * Retorna uma identificação visual de como o assistido foi identificado: por
 * finger key ou outra maneira
 *
 * @category   Agana
 * @package    Agana_Assistance
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Assistance_View_Helper_IdentifiedWidget extends Zend_View_Helper_Abstract {

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
