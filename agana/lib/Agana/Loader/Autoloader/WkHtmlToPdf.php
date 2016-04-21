<?php

/**
 * Description of Wkhtmltopdf autoloader
 *
 * @author Ademir Mazer Jr
 */
class Agana_Loader_Autoloader_WkHtmlToPdf implements Zend_Loader_Autoloader_Interface {

    public function autoload($class) {
        if ('WkHtmlToPdf' != $class) {
            return false;
        }
        require_once LIB_PATH . '/phpWkHtmlToPdf/WkHtmlToPdf.php';
        return $class;
    }

}