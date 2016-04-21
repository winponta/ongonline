<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../agana'));

// Define path to public directory (the view of the client)
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__) ));

// Define lib path
defined('LIB_PATH')
    || define('LIB_PATH',  realpath(APPLICATION_PATH . '/../lib'));

// Define lib path
defined('APPLICATION_DATA_PATH')
    || define('APPLICATION_DATA_PATH',  realpath(APPLICATION_PATH . '/../data'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    LIB_PATH,
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/agana.ini'
);


$application->bootstrap()
            ->run();