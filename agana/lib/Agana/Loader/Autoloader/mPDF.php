<?php

/**
 * Description of mPdf autoloader
 *
 * @author Ademir Mazer Jr
 */
class Agana_Loader_Autoloader_mPDF implements Zend_Loader_Autoloader_Interface {

    public function autoload($class) {
        if ('mPDF' != $class) {
            return false;
        }
        require_once LIB_PATH . '/mPDF/mpdf.php';
        return $class;
    }

}