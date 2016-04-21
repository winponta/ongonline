<?php

/**
 * Business unit Module of Bootstrap
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Busunit_Bootstrap extends Zend_Application_Module_Bootstrap {

    /**
     *
     * @var Zend_Translate
     */
    protected $_translate = null;

    /**
     * Init config settings and resoure for this module
     *
     */
    protected function _initModuleConfig() {
        // load ini file
        Agana_Util_Bootstrap::loadModuleIni(dirname(__FILE__) . '/configs/module.ini', 'busunit', $this);
    }

    protected function _initTranslate() {
        $registry = Zend_Registry::getInstance();
        $this->_translate = $registry->get('Zend_Translate');
        $this->_translate->addTranslation(
                array(
                    'adapter' => 'array',
                    'content' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'locales',
                    'scan' => Zend_Translate::LOCALE_DIRECTORY,
                )
        );
        $registry->set('Zend_Translate', $this->_translate);
        return $registry;
    }

    function _initResources() {
        $autoloader = $this->getResourceLoader();
        $autoloader->addResourceType('domain', 'domain', 'Domain');
        $autoloader->addResourceType('persist', 'persist', 'Persist');
        $autoloader->addResourceType('persistdao', 'persist/dao', 'Persist_Dao');
        $autoloader->addResourceType('persistinterfacce', 'persist/interface', 'Persist_Interface');
        $autoloader->addResourceType('module', 'module', 'Module');
    }

    /**
     * Initilize Module specific Plugins:
     */
    protected function _initPlugins() {
        $zfc = Zend_Controller_Front::getInstance();
        // this plugin controls the creation to global menu navigation
        $zfc->registerPlugin(new Busunit_Module_Menu());
        
    }
}

?>
