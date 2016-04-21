<?php

/**
 * Agana_Domain_Gm
 *
 * controls the identity of objects
 * 
 * @category   Agana
 * @package    Agana_Gm
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Domain_Gm {

    protected $_group = null;
    
    public function getGroup() {
        return $this->_group;
    }

    public function setGroup($_group) {
        $this->_group = $_group;
    }

    public function loadGroup($group) {
        $this->_group = new Agana_Domain_Gm_Group();
        $this->_group->loadGroup($group);
    }

    public function loadReport($reportId) {
        $this->_group = new Agana_Domain_Gm_Group();
        $this->_group->loadReport($reportId);
    }

}