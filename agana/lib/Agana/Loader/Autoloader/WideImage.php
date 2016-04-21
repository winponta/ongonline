<?php

/**
 * Description of WideImage autoloader
 *
 * @author nuno
 */
class Agana_Loader_Autoloader_WideImage implements Zend_Loader_Autoloader_Interface {

    public function autoload($class) {
        if ('WideImage' != $class) {
            return false;
        }
        require_once LIB_PATH . '/WideImage/WideImage.php';
        return $class;
    }

}