<?php

/**
 * Agana Dashboard domain class
 *
 * @category   Agana
 * @package    Agana_Dashboard
 * @copyright  Copyright (c) 2013-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Dashboard_Domain_Dashboard {

    private $widgets = array();
    
    public function loadModulesWidgets() {
        $modules = Agana_Util_Bootstrap::getModulesNames();
        foreach ($modules as $mod) {
            $mod = ucfirst($mod);
            $class = $mod . '_Module_Dashboard';

            if (class_exists($class)) {
                $moduleDash = new $class;
                
                $this->widgets = array_merge($this->widgets, $moduleDash->getWidgets());
            }
        }

    }
    
    public function getWidgets() {
        return $this->widgets;
    }

}

