<?php

/**
 * Agana_Location_Module_Gm
 *
 * @category   Agana
 * @package    Agana_Location
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Location_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $this->_name = 'Location';

        $this->_navigation = array(
            array(
                'icon'      => 'icon-globe',
                'label'     => 'Countries',
                'module'    => 'location',
                'controller'=> 'country',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''
                ),
            array(
                'icon'      => 'icon-globe',
                'label'     => 'States',
                'module'    => 'location',
                'controller'=> 'state',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''                
            ),
            array(
                'icon'      => 'icon-picture',
                'label'     => 'Cities',
                'module'    => 'location',
                'controller'=> 'city',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''                
            ),
            array(
                'icon'      => 'icon-road',
                'label'     => 'City regions',
                'module'    => 'location',
                'controller'=> 'city-region',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''                
            )
        );
    }    

}