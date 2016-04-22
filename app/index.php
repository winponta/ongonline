<?php
if (strtolower(getenv('APPLICATION_ENV')) == 'development') {
    error_reporting(E_ALL|E_STRICT|E_RECOVERABLE_ERROR|E_DEPRECATED|E_USER_DEPRECATED);
    ini_set('display_errors', 'on');

    // Define path to application directory
    defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../agana/agana'));

    // Define lib path
    defined('LIB_PATH')
        || define('LIB_PATH',  realpath(APPLICATION_PATH . '/../lib'));

    // Define data path
    defined('APPLICATION_DATA_PATH')
        || define('APPLICATION_DATA_PATH',  realpath(APPLICATION_PATH . '/../data'));

} else if (strtolower(getenv('APPLICATION_ENV')) == 'testing') {
    error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
    ini_set('display_errors', 'on');

    // Define path to application directory
    defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', '/home/ong/ongonline_app_teste/agana');

    // Define lib path
    defined('LIB_PATH')
        || define('LIB_PATH',  realpath(APPLICATION_PATH . '/../lib'));

    // Define data path
    defined('APPLICATION_DATA_PATH')
        || define('APPLICATION_DATA_PATH',  '/home/ong/ongonline_app_teste/data');

} else { 
    // Define path to application directory
    defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', '/home/ong/ongonline_app/agana');

    // Define lib path
    defined('LIB_PATH')
        || define('LIB_PATH',  realpath(APPLICATION_PATH . '/../lib'));

        // Define data path
    defined('APPLICATION_DATA_PATH')
        || define('APPLICATION_DATA_PATH',  '/home/ong/ongonline_app/data');

}

// Define path to public directory (the view of the client)
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__) ));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    LIB_PATH,
    get_include_path(),
)));

/** Zend_Application */
require 'Zend/Application.php';
require 'Zend/Config/Ini.php';

if (strtolower(getenv('APPLICATION_ENV')) == 'development') {
    $config = new Zend_Config_Ini (APPLICATION_PATH . '/../../configs/agana_ongonline.ini', APPLICATION_ENV, array ('allowModifications' => true));
    $config->merge (new Zend_Config_Ini (APPLICATION_PATH . '/../../configs/agana_ongonline_version.ini'));

// Create application, bootstrap, and run
    $application = new Zend_Application(
        APPLICATION_ENV,
        $config
    );
} else {
    $config = new Zend_Config_Ini (APPLICATION_PATH . '/../configs/agana_ongonline.ini', APPLICATION_ENV, array ('allowModifications' => true));
    $config->merge (new Zend_Config_Ini (APPLICATION_PATH . '/../configs/agana_ongonline_version.ini'));

    // Create application, bootstrap, and run
    $application = new Zend_Application(
        APPLICATION_ENV,
        $config
    );
}

$application->bootstrap()
            ->run();
