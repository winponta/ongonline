<?php

/**
 * Agana_Module_Gm
 *
 * @category   Agana
 * @package    Agana_Gm
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Module_Gm extends Agana_Module_Gm_Abstract {

    public function setName($name) {
        $this->_name = $name;
    }

    public function setNavigation($icon, $label, $module, $controller, $action, $params=null, $route = 'default', $uri = '', $title = '') {
        $this->_navigation[] = array(
            'icon' => $icon,
            'label' => $label,
            'module' => $module,
            'controller' => $controller,
            'action' => $action,
            'params' => $params,
            'route' => $route,
            'uri' => $uri,
            'title' => $title
        );
    }

}
