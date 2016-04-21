<?php

/**
 * Agana_Assistance_Module_Menu
 *
 * @category   Agana
 * @package    Agana_Assistance
 * @copyright  Copyright (c) 2011-2014 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Assistance_Module_Menu extends Zend_Controller_Plugin_Abstract implements Agana_Module_Menu_Interface {

    public function injectGlobalMenu() {
        //TODO ACL

        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

        $menuAssistance = $globalMenu->findOneBy('id', 'menu-assistance');

        if ($menuAssistance === null) {
            $menuAssistance = new Zend_Navigation_Page_Uri(
                    array(
                'label' => '{{i class=||icon-heart||}}{{/i}} {{translate}}Assistance{{/translate}}',
                'id' => 'menu-assistance',
                'uri' => '#',
                'order' => 300,
            ));
        }

        if (!$globalMenu->findOneBy('id', 'menu-new-assistance')) {
            $pageHeader = new Zend_Navigation_Page_Uri(
                    array(
                'label' => '{{i class=||icon-plus||}}{{/i}} Lançamentos',
                'parent' => $menuAssistance,
                'id' => 'menu-assistance-header-record',
                'class' => 'nav-header',
                    )
            );

            $newPage = new Zend_Navigation_Page_Mvc(
                    array(
                'label' => '{{i class=||icon-food||}}{{/i}} Lançar atendimento individual',
                'id' => 'menu-new-assistance',
                'parent' => $menuAssistance,
                'load-in' => 'content-container',
                'action' => 'create',
                'controller' => 'activity',
                'module' => 'assistance',
                //'route' => 'gmRoute',
                'order' => 1,
                    )
            );

            Agana_Module_Menu_Global::navigationDivider(2, $menuAssistance);

            $newPage = new Zend_Navigation_Page_Mvc(
                    array(
                'label' => '{{i class=||icon-group||}}{{/i}} Novo evento',
                'id' => 'menu-new-event',
                'parent' => $menuAssistance,
                'load-in' => 'content-container',
                'action' => 'create',
                'controller' => 'event',
                'module' => 'assistance',
                //'route' => 'gmRoute',
                'order' => 3,
                    )
            );
        }

        if (!$globalMenu->findOneBy('id', 'menu-list-all-assistances')) {
            Agana_Module_Menu_Global::navigationDivider(10, $menuAssistance);

            $pageHeader = new Zend_Navigation_Page_Uri(
                    array(
                'label' => '{{i class=||icon-cogs||}}{{/i}} Gerenciamento',
                'parent' => $menuAssistance,
                'id' => 'menu-assistance-header-manager',
                'class' => 'nav-header',
                'order' => 11,
                    )
            );

            $newPage = new Zend_Navigation_Page_Mvc(
                    array(
                'label' => '{{i class=||icon-group||}}{{/i}} Listar eventos',
                'id' => 'menu-new-events',
                'parent' => $menuAssistance,
                'load-in' => 'content-container',
                'action' => 'list',
                'controller' => 'event',
                'module' => 'assistance',
                //'route' => 'gmRoute',
                'order' => 15,
                    )
            );


            $newPage = new Zend_Navigation_Page_Mvc(
                    array(
                'label' => '{{i class=||icon-list||}}{{/i}} Listar assistências',
                'id' => 'menu-list-activity',
                'parent' => $menuAssistance,
                'load-in' => 'content-container',
                'action' => 'list',
                'controller' => 'activity',
                'module' => 'assistance',
                //'route' => 'gmRoute',
                'order' => 20,
                    )
            );
        }

        $globalMenu->addPage($menuAssistance);
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}
