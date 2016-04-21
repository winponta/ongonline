<?php

/**
 * Agana_View_Helper_PrintButtonsBlock render a div block to put in input forms
 * for setup reports
 * 
 * @category   Agana
 * @package    Agana_View_Helper
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_PrintButtonsBlock extends Zend_View_Helper_Abstract {

    /**
     * Main method
     * @return string HTML block 
     */
    public function printButtonsBlock() {
        return '        
        <div class="row-fluid text-center">
            <p><small class="text-warning"><translate>Generate report at</translate></small></p>
            <a href="#" report-format="html" class="btn btn-primary open-report-colorbox">
                <i class="icon-desktop"></i> <translate>Screen</translate>
            </a>
            <a href="#" report-format="pdf" class="btn btn-danger open-report-colorbox">
                <i class="icon-book"></i> PDF
            </a>
            </ul>
        </div>
        ';
    }
    
}