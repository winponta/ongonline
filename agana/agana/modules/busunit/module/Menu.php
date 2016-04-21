<?php

/**
 *
 * @category   Agana
 * @package    Agana_Busunit
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Busunit_Module_Menu extends Zend_Controller_Plugin_Abstract implements Agana_Module_Menu_Interface {

    public function injectGlobalMenu() {
        //TODO ACL

        $globalMenu = Zend_Registry::get('Navigation.GlobalMenu');

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
                    'label' => '{{i class=||icon-briefcase||}}{{/i}} {{translate}}Business units{{/translate}}',
                    'id' => 'menu-busunit',
                    'parent' => $menuAdm,
                    'load-in' => 'content-container',
                    'action' => 'index',
                    'controller' => 'gm',
                    'module' => 'aganacore',
                    'params' => array(
                        'id' => 'busunit',
                    ),
                    //'route' => 'gmRoute',
                    'order' => -1,
                )
        );
        
        $globalMenu->addPage($menuAdm);
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}