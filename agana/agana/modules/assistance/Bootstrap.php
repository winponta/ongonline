<?php

/**
 * Assistance Module of Bootstrap
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Assistance_Bootstrap extends Zend_Application_Module_Bootstrap {

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
        Agana_Util_Bootstrap::loadModuleIni(dirname(__FILE__) . '/configs/module.ini', 'location', $this);
    }

    protected function _initTranslate() {
        $this->_translate = Agana_Util_Bootstrap::iniNewTranslate(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'locales');
        return $this->_translate;
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
        $zfc->registerPlugin(new Assistance_Module_Menu());
        
    }

    function _initViewHelpers() {
        /**
         * Add the User View helpers path
         */
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->addHelperPath(
                __DIR__ . '/views/helpers', 'Assistance_View_Helper'
        );
    }

    public function _initReports() {
        $r = new Agana_Print_Menu_Report();
        $r->setGroup('Project', 'Projects Reports');

        Agana_Print_Menu_Global::saveGroup($r);

        $r = new Agana_Print_Menu_Report();
        $r->setReport(
                'Assistances-By-Project', 'Assistances by project', 'icon-double-angle-right', 'Assistance_Domain_Activity', 
                'assistance', 'activity', 'report-by-project', null, 'Project'
        );
        Agana_Print_Menu_Global::saveGroup($r);
    }
    
}
