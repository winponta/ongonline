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
class Assistance_View_Helper_IdentifiedByWidget extends Zend_View_Helper_Abstract {

    /**
     * Receives true or false because today is just id by finger key or manual
     * 
     * @param boolean $idByFingerKey
     * @return String
     */
    public function identifiedByWidget($idByFingerKey) {
        if ($idByFingerKey) {
            $icoIded = 'icon-hand-up';
            $classIded = 'text-success';
            $toolTip = 'Identificado por BIOMETRIA';
        } else {
            $icoIded = 'icon-keyboard';
            $classIded = 'text-warning';
            $toolTip = 'Lançamento manual';
        }

        $widget = '<span class=" '
                . $classIded 
                . '" rel="tooltip" '
                . 'title="' 
                . $toolTip . '"> '
                . '<i class="'
                . $icoIded 
                . ' "></i>'
                . '</span>';
        
        return $widget;
    }
}
