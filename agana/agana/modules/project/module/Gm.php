<?php

/**
 * Agana_Project_Module_Gm
 *
 * @category   Agana
 * @package    Agana_Project
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Project_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $this->_name = 'Project';

        $this->_navigation[] = array(
                'icon'      => 'icon-folder-close',
                'label'     => 'Projects',
                'module'    => 'project',
                'controller'=> 'admin',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''
        );

        $this->_navigation[] = array(
                'icon'      => 'icon-tag',
                'label'     => 'Task types',
                'module'    => 'project',
                'controller'=> 'tasktype',
                'action'    => 'list',
                'route'     => 'default',
                'uri'       => '',
                'title'     => ''
        );
    }    

}