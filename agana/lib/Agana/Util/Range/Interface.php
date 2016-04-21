<?php

/**
 * Agana_Util_Range_Abstract
 * defines the Range Abstract super class for concret Range objects
 * 
 * @category   Agana
 * @package    Agana_Util
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 * @link http://martinfowler.com/eaaDev/Range.html
 */
abstract class Agana_Util_Range_Abstract {
    // TODO: terminar o RANGE usando a referencia do Fowler
    
    /**
     * the initial value of the range
     */
    private $_start = null;
    
    /**
     * the final value of the range
     */
    private $_end = null;

    /**
     * instantiate the range object with the start and end values of the range
     * 
     * @param type $start
     * @param type $end 
     */
    public function __construct($start, $end) {
        $this->_start   = $start;
        $this->_end     = $end;
    }
    
    /**
     * defines if a value is included in the range
     * 
     * @param type $value 
     * @return bool
     */
    abstract public function includes($value) {}

    public function get_start() {
        return $this->_start;
    }

    public function set_start($_start) {
        $this->_start = $_start;
    }

    public function get_end() {
        return $this->_end;
    }

    public function set_end($_end) {
        $this->_end = $_end;
    }

}

?>
