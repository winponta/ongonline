<?php

/**
 * Agana_Location_Module_Menu
 *
 * @category   Agana
 * @package    Agana_Location
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Location_Module_Menu extends Zend_Controller_Plugin_Abstract implements Agana_Module_Menu_Interface {

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

        if (!$globalMenu->findOneBy('id', 'menu-location')) {
            $newPage = new Zend_Navigation_Page_Mvc(
                    array(
                        'label' => '{{i class=||icon-map-marker||}}{{/i}} {{translate}}Location{{/translate}}',
                        'id' => 'menu-location',
                        'parent' => $menuAdm,
                        'load-in' => 'content-container',
                        'action' => 'index',
                        'controller' => 'gm',
                        'module' => 'aganacore',
                        'params' => array(
                            'id' => 'location',
                        ),
                        //'route' => 'gmRoute',
                        'order' => 1,
                    )
            );
        }
        
        $globalMenu->addPage($menuAdm);
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $this->injectGlobalMenu();
    }

}