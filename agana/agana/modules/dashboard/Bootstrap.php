<?php

/**
 * Dashboard Bootstrap
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Dashboard_Bootstrap extends Zend_Application_Module_Bootstrap {
    /**
     * Init config settings and resoure for this module
     *
     */
    protected function _initModuleConfig() {
        // load ini file
        Agana_Util_Bootstrap::loadModuleIni(dirname(__FILE__) . '/configs/module.ini', 'dashboard', $this);
    }

    function _initResources() {
        $autoloader = $this->getResourceLoader();
        $autoloader->addResourceType('module', 'module', 'Module');
        $autoloader->addResourceType('domain', 'domain', 'Domain');
    }

    /**
     * Initilize Module specific Plugins:
     */
    protected function _initPlugins() {
        $zfc = Zend_Controller_Front::getInstance();
        // this plugin controls the creation to global menu navigation
        $zfc->registerPlugin(new Dashboard_Module_Menu());
        
    }
}

?>
