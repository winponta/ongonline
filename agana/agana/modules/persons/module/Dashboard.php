<?php

/**
 * Description of Dashboard
 *
 * @author nuno
 */
class Persons_Module_Dashboard extends Dashboard_Domain_Abstract {
    public function getWidgets(){
        $w = new Dashboard_Model_Widget();
        $w->setTitle('Today\'s anniversaries');
        $w->setIcon('icon-user');
        $w->setModule('persons');
        $w->setController('persons');
        $w->setAction('widget-today-anniversaries');
        $w->setDimension(3);
        
        $widgets[] = $w;
        
        return $widgets;
    }
}
