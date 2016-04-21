<?php

/**
 * Staff Module of Bootstrap
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Staff_Bootstrap extends Zend_Application_Module_Bootstrap {

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
        Agana_Util_Bootstrap::loadModuleIni(dirname(__FILE__) . '/configs/module.ini', 'staff', $this);
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
        $zfc->registerPlugin(new Staff_Module_Menu());
    }

    function _initPersonDependency() {
        if (Zend_Registry::isRegistered('Person-Dependency-Domain')) {
            $p = Zend_Registry::get('Person-Dependency-Domain');
        } else {
            $p = array();
        }
        // Employee
        $dep['domain']['class'] = 'Staff_Domain_Employee';
        $dep['menu']['label'] = 'Employee';
        $dep['menu']['title'] = 'Employee';
        $dep['menu']['icon'] = 'icon-group';
        $dep['menu']['module'] = 'staff';
        $dep['menu']['controller'] = 'employee';
        $dep['menu']['action'] = 'get';

        $dep['menu']['new']['title'] = 'Add new Employee';
        $dep['menu']['new']['module'] = 'staff';
        $dep['menu']['new']['controller'] = 'employee';
        $dep['menu']['new']['action'] = 'create';

        $p[] = $dep;

        Zend_Registry::getInstance()->set('Person-Dependency-Domain', $p);

        // Volunteer
        if (Staff_Domain_Volunteer::isControllerEnabled($this->getOptions())) {
            unset($dep);
            $dep['domain']['class'] = 'Staff_Domain_Volunteer';
            $dep['menu']['label'] = 'Volunteer';
            $dep['menu']['title'] = 'Volunteer';
            $dep['menu']['icon'] = 'icon-group';
            $dep['menu']['module'] = 'staff';
            $dep['menu']['controller'] = 'volunteer';
            $dep['menu']['action'] = 'get';

            $dep['menu']['new']['title'] = 'Add new Volunteer';
            $dep['menu']['new']['module'] = 'staff';
            $dep['menu']['new']['controller'] = 'volunteer';
            $dep['menu']['new']['action'] = 'create';

            Zend_Registry::getInstance()->set('Person-Dependency-Domain', $p);

            $p[] = $dep;
        }
        

        Zend_Registry::getInstance()->set('Person-Dependency-Domain', $p);
    }

}
