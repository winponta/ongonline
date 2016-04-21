<?php

/**
 * Agana_View_Helper_Menu
 *
 * @category   Agana
 * @package    Agana_Menu
 * @deprecated since version 0.0
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Navigation_Container extends Zend_Navigation_Container {

    public function loadMenu() {
        $modules = Agana_Util_Bootstrap::getModulesNames();
        $front = Zend_Controller_Front::getInstance();

        foreach ($modules as $module) {
            $boot = Agana_Util_Bootstrap::getBootstrap($module);
            if (isset($boot)) {
                if (count($boot->getOptions())) {
                    $menuOpt = $boot->getOptions();

                    if ($menuOpt['menu']['load']) {
                        if ($menuOpt['menu']['container'] == 'class') {
                            $class = ucfirst($module) . '_Module_Menu';

                            //if (Zend_Loader_Autoloader::autoload($class)) {
                            $path = $front->getModuleDirectory($module) . DIRECTORY_SEPARATOR . 'module';
                            //if (Zend_Loader_Autoloader::autoload($class)) {
                            /**
                             * @var Agana_Module_Menu_Interface
                             */
                            $moduleMenu = new $class();

                            $menuArray = $moduleMenu->getMenu();

                            foreach ($menuArray as $key => $m) {
                                if (is_numeric($key)) {
                                    $m = $menuArray[$key];

                                    if (isset($m['parent']) && trim($m['parent']) != '') {
                                        $parent = $this->findBy('id', $m['parent']);
                                        // if did not find a parent then create it                                    
                                        unset($m['parent']);
                                        $parent->addPage($m);
                                    } else {
                                        $page = $this->findBy('id', $m['id']);
                                        if (!$page) {
                                            $this->addPage($m);
                                        }
                                    }
                                }
                            }

                            //}
                        }
                    }
                }
            }
        }
    }

}