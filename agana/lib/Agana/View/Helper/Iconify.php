<?php
/**
* Description of Iconify
*
* @author Sarjono Mukti Aji <me@simukti.net>
*/
//use \Zend_View_Helper_Abstract as HelperAbstract;

class Agana_View_Helper_Iconify extends Zend_View_Helper_Abstract {
    public function iconify($string) {
        if(is_string($string)) {
            $string = str_replace(array('{{', '}}', '||'), array('<','>', '"'), $string);
        }
        return $string;
    }
}