<?php

/**
 * Agana_Person_Module_Gm
 *
 * @category   Agana
 * @package    Agana_Persons
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $this->_name = 'Persons';

        $this->_navigation = array(
            array(
            'icon'      => 'icon-users',
            'label'     => 'Persons',
            'module'    => 'persons',
            'controller'=> 'person',
            'action'    => 'list',
            'route'     => 'default',
            'uri'       => '',
            'title'     => '',
                ),
            
            array(
            'icon'      => 'icon-user',
            'label'     => 'Persons',
            'module'    => 'persons',
            'controller'=> 'person',
            'action'    => 'list',
            'route'     => 'default',
            'uri'       => '',
            'title'     => '',
                ),
            
        );
    }    

}

