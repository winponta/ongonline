<?php

class Agana_Print_Html_Report extends Agana_Print_Abstract_Report {

    public function __construct(Agana_Print_Meta $metaReport, $theme_path, $watermark = '', $subject = 'System report') {
        parent::__construct($metaReport);
    }

    public function addPage($content) {
        
    }

    public function download($filename = '') {
        
    }

}
