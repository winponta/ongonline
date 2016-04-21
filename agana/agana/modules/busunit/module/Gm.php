<?php

/**
 * Agana_Busunit_Module_Gm
 *
 * @category   Agana
 * @package    Agana_Location
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Busunit_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $this->_name = 'Business units';

        $this->_navigation = array(
            array(
                'icon'      => 'icon-home',
                'label'     => 'Headquarters',
                'module'    => 'busunit',
                'controller'=> 'headquarters',
                'action'    => 'get',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''
                ),
            array(
                'icon'      => 'icon-sitemap',
                'label'     => 'Business units',
                'module'    => 'busunit',
                'controller'=> 'branch',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => 'Branches, units, subsidiaries, etc'
            ),
        );
    }    

}