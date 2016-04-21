<?php

/**
 * Agana_Debug class formats and shows debug information at output.
 * Uses/Based on Zend_Debug class, version    $Id: Debug.php 23775 2011-03-01 17:25:24Z ralph $
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Agana_Debug {

    /**
     * Each dump added to debug
     * @var array 
     */
    protected $_dumps = array();

    /**
     * Generates the output text
     * 
     * @param  mixed  $var   The variable to dump.
     * @param  string $label OPTIONAL Label to prepend to output.
     * @return string 
     */
    protected function _getOutput($var, $label=null) {
        // format the label
        // if it is a object, format with its properties
        $trace = debug_backtrace();
        $l = 'FILE: ' . basename($trace[0]['file']) . '<br/>';
        $l .= 'FUNCTION: ' . $trace[0]['function'] . '<br/>';
        $l .= 'LINE: ' . $trace[0]['line'] . '<br/>';
        $l .= 'PATH: ' . $trace[0]['file'];
        if (is_object($label)) {
            $label = 'CLASS: ' . get_class($label);
        } else {
            $label = ($label === null) ? '' : rtrim($label) . ' ';
        }
        $label = '<header style="
                            border-bottom: 2px solid #c99; 
                            color: #752201;
                            cursor:pointer;"
                            >' .
                ' <span class="arrow">&darr;</span> DEBUG: ' . $label .
                '</header>';

        $output = Zend_Debug::dump($var, NULL, false);

        $output = '<article class="debug" 
                        style="margin: 1em; 
                            padding: 0 1em;
                            background-color: #ddd;"
                            >' .
                $label .
                '<section style="display:none">' .
                '<small>' . $l . '</small>' .
                $output .
                '</section>' .
                '</article>';

        return $output;
    }

    /**
     * Debug helper function.  This is a wrapper for var_dump() that adds
     * the <pre /> tags, cleans up newlines and indents, and runs
     * htmlentities() before output.
     *
     * @param  mixed  $var   The variable to dump.
     * @param  string $label OPTIONAL Label to prepend to output.
     * @param  bool   $echo  OPTIONAL Echo output if true.
     * @return string
     */
    public static function dump($var, $label=null, $echo=true) {
        $output = self::_getOutput($var, $label);

        if ($echo) {
            echo($output);
        }
        return $output;
    }

    /**
     * Adds the dump output to an array that is printed at the end of the front controler request cicle
     * 
     * @see dump
     * @param type $var
     * @param type $label
     * @return type 
     */
    public function add($var, $label=null) {
        $output = $this->_getOutput($var, $label);

        $this->_dumps[] = $output;

        return $output;
    }
    
    /**
     * Returns the html output of all dumped vars
     */
    public function getAll() {
        $html = '';
        for ($i = 0; $i < count($this->_dumps); $i++) {
            $html .= $this->_dumps[$i];
        }
        
        return $html;
    }

}

?>
