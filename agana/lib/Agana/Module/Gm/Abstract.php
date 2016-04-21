<?php
/**
 * Agana_Module_Gm_Abstract
 *
 * @category   Agana
 * @package    Agana_Gm
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
abstract class Agana_Module_Gm_Abstract {
    protected $_navigation = array();
    protected $_name = '';
    
    public function getName() {
        return $this->_name;
    }

    public function getNavigation() {
        return $this->_navigation;
    }

}
