<?php

/**
 * Agana_Staff_Module_Gm
 *
 * @category   Agana
 * @package    Agana_Staff
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Staff_Module_Gm extends Agana_Module_Gm_Abstract {

    public function __construct() {
        $boot = Agana_Util_Bootstrap::getBootstrap('staff');
        $boot = $boot->getOptions();

        $this->_name = 'Staff';

        $this->_navigation[] = array(
            'icon' => 'icon-group',
            'label' => 'Employees',
            'module' => 'staff',
            'controller' => 'employee',
            'action' => 'list',
            'route' => 'default',
            'uri' => '',
            'title' => ''
        );

        if (Staff_Domain_Volunteer::isControllerEnabled()) {
            $this->_navigation[] = array(
                'icon' => 'icon-group',
                'label' => 'Volunteers',
                'module' => 'staff',
                'controller' => 'volunteer',
                'action' => 'list',
                'route' => 'default',
                'uri' => '',
                'title' => ''
            );
        }

        $this->_navigation[] = array(
            'icon' => 'icon-wrench',
            'label' => 'Job function',
            'module' => 'staff',
            'controller' => 'jobfunction',
            'action' => 'list',
            'route' => 'default',
            'uri' => '',
            'title' => ''
        );

        if (Staff_Domain_Expertisearea::isControllerEnabled()) {
            $this->_navigation[] = array(
                'icon' => 'icon-certificate',
                'label' => 'Expertise area',
                'module' => 'staff',
                'controller' => 'expertisearea',
                'action' => 'list',
                'route' => 'default',
                'uri' => '',
                'title' => ''
            );
        }
    }

}

?>
