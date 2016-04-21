<?php

/**
 * Util class to acces bootstrap functions easier.
 * This is based on the Application_Api_Util_Bootstrasp from marsbomber @link https://github.com/marsbomber/zf1-doctrine2/tree/modular_setup.
 * When no module name is seted, than application bootstrap is returned, else
 * the module bootstrap is.
 * 
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Agana_Util_Bootstrap {

    /**
     * Module default name to class access options
     * 
     * @var String module name
     */
    private static $_defaultModule = 'aganacore';

    /**
     * Module name to class access options
     * 
     * @var String module name
     */
    private static $_module = 'aganacore';

    /**
     * Sets module name to default aganacore
     * 
     */
    public static function setDefaultModule() {
        self::$_module = self::$_defaultModule;
    }

    /**
     * Sets module name to be accessed
     * 
     * @param String $name 
     */
    public static function setModule($name) {
        self::$_module = $name;
    }

    /**
     * Returns module name
     * @return String
     */
    public static function getModule() {
        return self::$_module;
    }

    /**
     * Resource ArrayObject contains all bootstrap classes
     *
     * @return Zend_Application_Bootstrap_Bootstrap
     */
    public static function getBootstrap($module = null) {
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam('bootstrap');
        if (!isset($module)) {
            return $bootstrap;
        } else {
            if ($bootstrap->getResource('modules')->offsetExists($module)) {
                return $bootstrap->getResource('modules')->offsetGet($module);
            } else {
                return null;
            }
        }
    }

    /**
     * Get an item from the bootstrap container (Registry)
     * @param string $item
     * @return mixed
     */
    public static function getItem($item) {
        $bootstrap = self::getBootstrap();
        return $bootstrap->getContainer()->$item;
    }

    /**
     * Get a resource from App configuration or a ini specific module
     * 
     * @param string $resource
     * @param string $module
     * @return mixed
     */
    public static function getResource($resource, $module='') {
        if (trim($module)) {
            self::setModule($module);
        }
        $bootstrap = self::getBootstrap();
        return $bootstrap->getResource($resource);
        if (trim($module)) {
            self::setDefaultModule();
        }
    }

    /**
     * Get a bootstrap option
     *
     * @param string $option
     * @return mixed
     */
    public static function getOption($option) {
        $bootstrap = self::getBootstrap();
        return $bootstrap->getOption($option);
    }

    public static function getModulesNames() {
        $front = Zend_Controller_Front::getInstance();
        $cd = $front->getControllerDirectory();
        return array_keys($cd);
    }

    /**
     * Loads a ini config file associated to a module.
     * The module bootstrap object is needed when the application bootstrap isn't avaiable yet
     * 
     * @param String file name and path
     * @param String name of the module to load
     * @param Zend_Application_Module_Bootstrap the module bootstrap object
     */
    public static function loadModuleIni($file, $module, $bootstrap=null) {
        if (!isset($bootstrap)) {
            $bootstrap = self::getBootstrap();
        }
        $iniOptions = new Zend_Config_Ini($file, APPLICATION_ENV);
        $moduleIniOptions = $iniOptions->toArray();
        if (isset($moduleIniOptions[$module])) {
            $bootstrap->setOptions($moduleIniOptions[$module]);
        }
    }
    
    public static function iniNewTranslate($path) {
        $registry = Zend_Registry::getInstance();
        $translate = $registry->get('Zend_Translate');
        $translate->addTranslation(
                array(
                    'adapter' => 'array',
                    'content' => $path,
                    'scan' => Zend_Translate::LOCALE_DIRECTORY,
                )
        );
        $registry->set('Zend_Translate', $translate);
        return $registry;        
    }
}