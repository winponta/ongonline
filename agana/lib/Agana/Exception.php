<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Exception
 *
 * @author nuno
 */
class Agana_Exception extends Zend_Exception {
    const EXCEPTION_APP_WARNING = 10000;

    public function __construct($msg = '', $code = 0, Exception $previous = null) {
        if (is_array($msg)) {
            $txt = '' ;
            foreach ($msg as $key => $value) {
                $txt .= $key . ': '. $value . '   \n  ';
            }
            $msg = $txt;
        }
        parent::__construct($msg, $code, $previous);
    }
}

