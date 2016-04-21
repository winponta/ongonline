<?php

/**
 * Agana_User_Module_Menu
 *
 * @category   Agana
 * @package    Agana_User
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Module_Menu {

    public function getMenu() {
        //TODO ACL

        return array(
            array(
                'label' => '{{i class=||icon-cog||}}{{/i}} {{translate}}Administration{{/translate}}',
                'id' => 'menu-adm',
                'uri' => '#',
                'order' => 999,
            ),
            array(
                'label' => '{{i class=||icon-user||}}{{/i}} {{translate}}Users{{/translate}}',
                'id' => 'menu-adm-users',
                'parent' => 'menu-adm',
                'module' => 'user',
                'controller' => 'admin',
                'action' => 'index',
            ),
        );
    }

}
