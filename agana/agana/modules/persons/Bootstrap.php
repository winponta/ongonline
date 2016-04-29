<?php

/**
 * Person Module of Bootstrap
 *
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Persons_Bootstrap extends Zend_Application_Module_Bootstrap {

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
        Agana_Util_Bootstrap::loadModuleIni(dirname(__FILE__) . '/configs/module.ini', 'persons', $this);
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
        $zfc->registerPlugin(new Persons_Module_Menu());
    }

    function _initViewHelpers() {
        /**
         * Add the User View helpers path
         */
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->addHelperPath(
                __DIR__ . '/views/helpers', 'Person_View_Helper'
        );
    }

    function _initPersonDependency() {
        $p = Persons_Domain_Person::getDepencyDomain();

        $dep['domain']['class'] = 'Persons_Domain_Person';
        $dep['menu']['label'] = 'Person';
        $dep['menu']['title'] = 'Person details';
        $dep['menu']['icon'] = 'icon-user-md';
        $dep['menu']['module'] = 'persons';
        $dep['menu']['controller'] = 'person';
        $dep['menu']['action'] = 'get';
        $dep['menu']['order'] = 0;

        // Pdf generation
        $dep['pdf']['module'] = 'persons';
        $dep['pdf']['controller'] = 'person';
        $dep['pdf']['action'] = 'pdf-record';

        array_unshift($p, $dep);

        /**
         * Docs
         */
//        unset($dep);
//        $dep['domain']['class'] = 'Persons_Domain_PersonDocs';
//        $dep['menu']['label'] = 'Docs';
//        $dep['menu']['title'] = 'Docs';
//        $dep['menu']['icon'] = 'icon-credit-card';
//        $dep['menu']['module'] = 'persons';
//        $dep['menu']['controller'] = 'person-docs';
//        $dep['menu']['action'] = 'get';
//        //$dep['menu']['order'] = 1;
//
//        $dep['menu']['new']['title'] = 'Add new Docs';
//        $dep['menu']['new']['module'] = 'persons';
//        $dep['menu']['new']['controller'] = 'person-docs';
//        $dep['menu']['new']['action'] = 'create';

        // Pdf generation
        $dep['pdf']['module'] = 'persons';
        $dep['pdf']['controller'] = 'person-docs';
        $dep['pdf']['action'] = 'pdf-record';

        $p[] = $dep;

        /**
         * Fingerprint
         */
        unset($dep);
        $dep['domain']['class'] = 'Persons_Domain_PersonFingerprint';
        $dep['menu']['label'] = 'Impressão digital';
        $dep['menu']['title'] = 'Impressão digital';
        $dep['menu']['icon'] = 'icon-hand-up';
        $dep['menu']['module'] = 'persons';
        $dep['menu']['controller'] = 'person-fingerprint';
        $dep['menu']['action'] = 'list';
        $dep['menu']['allways-show'] = true;
        //$dep['menu']['order'] = 1;

        $p[] = $dep;

        /**
         * Helped
         */
        if (Persons_Domain_PersonHelped::isControllerEnabled($this->getOptions())) {
            unset($dep);
            $dep['domain']['class'] = 'Persons_Domain_PersonHelped';
            $dep['menu']['label'] = 'Person helped';
            $dep['menu']['title'] = 'Person helped';
            $dep['menu']['icon'] = 'icon-heart';
            $dep['menu']['module'] = 'persons';
            $dep['menu']['controller'] = 'person-helped';
            $dep['menu']['action'] = 'get';
            //$dep['menu']['order'] = 1;

            $dep['menu']['new']['title'] = 'Add new Person helped';
            $dep['menu']['new']['module'] = 'persons';
            $dep['menu']['new']['controller'] = 'person-helped';
            $dep['menu']['new']['action'] = 'create';

            // Pdf generation
            $dep['pdf']['module'] = 'persons';
            $dep['pdf']['controller'] = 'person-helped';
            $dep['pdf']['action'] = 'pdf-record';

            $p[] = $dep;
        }

        Zend_Registry::getInstance()->set('Person-Dependency-Domain', $p);
    }

    public function _initReports() {
        /**
         * Helped
         */
        if (Persons_Domain_PersonHelped::isControllerEnabled($this->getOptions())) {
            $r = new Agana_Print_Menu_Report();
            $r->setGroup('Project', 'Projects Reports');

            Agana_Print_Menu_Global::saveGroup($r);
     
            $r = new Agana_Print_Menu_Report();
            $r->setReport(
                    'Person-Helped-By-Project', 'Persons helped by project', 'icon-double-angle-right', 'Persons_Domain_PersonHelped', 
                    'persons', 'person-helped-project', 'report-by-project', null, 'Project'
            );
            Agana_Print_Menu_Global::saveGroup($r);
        }
    }

}
