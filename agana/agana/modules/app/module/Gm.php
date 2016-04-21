<?php

/**
 * Agana_App_Module_Gm
 *
 * @category   Agana
 * @package    Agana_App
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class App_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $this->_name = 'App Account';

        $this->_navigation = array(
            'icon'      => 'icon-cog',
            'label'     => 'App Account',
            'module'    => 'app',
            'controller'=> 'account',
            'action'    => 'index',
            'route'     => 'default',
            'uri'       => '',
            'title'     => '',
            'order'     => 0,
        );
    }    

}

?>
