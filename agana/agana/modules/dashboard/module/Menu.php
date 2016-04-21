<?php

/**
 * Agana_User_Module_Menu
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Dashboard_Module_Menu extends Zend_Controller_Plugin_Abstract implements Agana_Module_Menu_Interface {

    public function injectGlobalMenu() {
        //TODO ACL

        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

        $newPage = new Zend_Navigation_Page_Mvc(
            array(
                'label' => '{{i class=||icon-dashboard||}}{{/i}} Dashboard',
                'id' => 'menu-dashboard',
                'order' => 0,
                'module' => 'dashboard',
                'controller' => 'index',
                'action' => 'index',
            ));
        $globalMenu->addPage($newPage);

        $menuAdm = $globalMenu->findOneBy('id', 'menu-adm');

        if ($menuAdm === null) {
            $menuAdm = new Zend_Navigation_Page_Uri(
            array(
                'label' => '{{i class=||icon-cog||}}{{/i}} {{translate}}Administration{{/translate}}',
                'id' => 'menu-adm',
                'uri' => '#',
                'order' => 999,
            ));
        }
        
        $newPage = new Zend_Navigation_Page_Mvc(
                array(
                'label' => '{{i class=||icon-bar-chart||}}{{/i}} {{translate}}Dashboard{{/translate}}',
                'id' => 'menu-adm-dashboard',
                'parent' => $menuAdm,
                'module' => 'dashboard',
                'controller' => 'admin',
                'action' => 'index',
            )
        );
        
        $globalMenu->addPage($menuAdm);
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}
