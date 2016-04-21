<?php

class Dashboard_Model_Widget extends Agana_Data_Bean  {
    private $icon;
    private $title;
    private $description;
    private $module;
    private $controller;
    private $action;
    private $params;
    private $dimension;
    
    public function getDimension() {
        return $this->dimension;
    }

    public function setDimension($dimension) {
        $this->dimension = $dimension;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getModule() {
        return $this->module;
    }

    public function setModule($module) {
        $this->module = $module;
    }

    public function getController() {
        return $this->controller;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getParams() {
        return ($this->params) ? $this->params : array();
    }

    public function setParams($params) {
        $this->params = $params;
    }

}

