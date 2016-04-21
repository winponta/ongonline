<?php
/**
 * Agana_Report
 *
 * @category   Agana
 * @package    Agana_Report
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Print_Menu_Report {
    protected $name = '';
    protected $id;
    protected $label;
    protected $icon;
    protected $domainClass;
    protected $module;
    protected $controller;
    protected $action;
    protected $params = array();
    protected $group = null;
    protected $isGroup = false;
    
    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getDomainClass() {
        return $this->domainClass;
    }

    public function getModule() {
        return $this->module;
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function getParams() {
        return $this->params;
    }

    public function getGroup() {
        return $this->group;
    }

    public function isGroup() {
        return $this->isGroup;
    }
        
    public function setGroup($id, $label) {
        $this->isGroup = true;
        $this->id = $id;
        $this->label = $label;
    }

    public function setReport($id, $label, $icon, $domainClass, $module, $controller, $action, $params = [], $group = null) {
        $this->isGroup = false;
        $this->name = $id;
        $this->id = $id;
        $this->label = $label;
        $this->icon = $icon;
        $this->domainClass = $domainClass;
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
        $this->group = $group;
    }

}
