<?php

/**
 * Agana_Module_Menu_Global
 *
 * @category   Agana
 * @package    Agana_Module
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Module_Menu_Global {

    static function navigationHeader($id, $icon, $label, $order = null, $parent = null, $class = 'nav-header') {
        $globalMenu = new Zend_Navigation();
        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

        $menu = $globalMenu->findOneBy('id', $id);

        if ($menu === null) {
            $menu = new Zend_Navigation_Page_Uri(
                    array(
                'label' => '{{i class=||' . $icon . '||}}{{/i}} {{translate}}' . $label . '{{/translate}}',
                'id' => $id,
                'order' => $order,
                'parent' => $parent,
                'class' => $class,
            ));

            if (is_null($parent)) {
                $globalMenu->addPage($menu);
            }
        }

        return $menu;
    }

    static function navigationDivider($order = null, $parent = null, $class = 'divider') {
        $menu = new Zend_Navigation_Page_Uri(
                array(
            'order' => $order,
            'parent' => $parent,
            'class' => $class,
        ));

        if (is_null($parent)) {
            $globalMenu->addPage($menu);
        }

        return $menu;
    }

    static function navigationPageURI($id, $icon, $label, $uri, $order = null, $parent = null, $class = '') {
        $globalMenu = new Zend_Navigation();
        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

        $menu = $globalMenu->findOneBy('id', $id);

        if ($menu === null) {
            $menu = new Zend_Navigation_Page_Uri(
                    array(
                'label' => '{{i class=||' . $icon . '||}}{{/i}} {{translate}}' . $label . '{{/translate}}',
                'id' => $id,
                'uri' => $uri,
                'order' => $order,
                'parent' => $parent,
                'class' => $class,
            ));

            if (is_null($parent)) {
                $globalMenu->addPage($menu);
            }
        }

        return $menu;
    }

    static function navigationPageMVC($id, $icon, $label, $module, $controller, $action, $loadIn = '', $order = null, $parent = null, $route = 'default') {

        $globalMenu = new Zend_Navigation();
        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

        $menu = $globalMenu->findOneBy('id', $id);

        if ($menu === null) {
            $menu = new Zend_Navigation_Page_Mvc(
                    array(
                'label' => '{{i class=||' . $icon . '||}}{{/i}} {{translate}}' . $label . '{{/translate}}',
                'parent' => $parent,
                'id' => $id,
                'load-in' => $loadIn,
                'action' => $action,
                'controller' => $controller,
                'module' => $module,
                'order' => $order,
                'route' => $route,
                    )
            );

            if (is_null($parent)) {
                $globalMenu->addPage($menu);
            }
        }


        return $menu;
    }

    static function getMenuRegistrations() {
        return self::navigationPageURI('menu-registrations', 'icon-list-alt', 'Registrations', '#', 100);
    }

    static function getMenuReports() {
        return self::navigationPageURI('menu-reports', 'icon-file-alt', 'Reports', '#', 900);
    }

}
