<?php

/**
 * Agana_Domain_Gm_Group
 *
 * controls the identity of objects
 * 
 * @category   Agana
 * @package    Agana_Gm
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Domain_Gm_Group {

    protected $_name = 'gm';
    protected $_label = 'Gm Group Name';
    protected $_modules = array();

    public function modulesToArray() {
        return $this->_modules;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($_name) {
        $this->_name = $_name;
    }

    public function getLabel() {
        return $this->_label;
    }

    public function setLabel($_label) {
        $this->_label = $_label;
    }

    /**
     * Load group for GM based on each module.ini configuration.
     * An example is: 
     * 
     * project.gm.group = project
     * project.gm.label = 'Projects'
     * project.module.enabled = on
     */
    public function loadGroup($groupName) {
        $this->setName($groupName);

        $modules = Agana_Util_Bootstrap::getModulesNames();
        $front = Zend_Controller_Front::getInstance();

        foreach ($modules as $module) {
            $boot = Agana_Util_Bootstrap::getBootstrap($module);
            if (isset($boot)) {
                if (count($boot->getOptions())) {
                    $options = $boot->getOptions();

                    if (isset($options['gm']['group'])) {
                        if (strtolower($options['gm']['group']) == strtolower($this->getName())) {

                            if (isset($options['gm']['label'])) {
                                $this->setLabel($options['gm']['label']);
                            }

                            $class = ucfirst($module) . '_Module_Gm';

//if (Zend_Loader_Autoloader::autoload($class)) {
                            $path = $front->getModuleDirectory($module) . DIRECTORY_SEPARATOR . 'module';
//if (Zend_Loader_Autoloader::autoload($class)) {
                            /**
                             * @var Agana_Module_Menu_Interface
                             */
                            $moduleGm = new $class();

                            $this->_modules[$moduleGm->getName()] = $moduleGm;
                        }
                    }
                }
            }
        }
    }

    /**
     */
    public function loadReport($reportId) {
        $this->setName($reportId);

        $reps = Agana_Print_Menu_Global::getReportsFromGroup($reportId);

        foreach ($reps as $r) {
            if ($r->isGroup()) {
                $this->setLabel($reps[0]->getLabel());
            } else {

                $moduleGm = new Agana_Module_Gm();

                $moduleGm->setName($r->getName());
                $moduleGm->setNavigation(
                        $r->getIcon(), $r->getLabel(), $r->getModule(), $r->getController(), $r->getAction(), $r->getParams()
                );

                $this->_modules[$moduleGm->getName()] = $moduleGm;
            }
        }
    }

}
