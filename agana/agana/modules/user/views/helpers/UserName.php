<?php

/**
 * UserName view helper returns the logged user name
 *
 * @category   Agana
 * @package    Agana_View_Helper_
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_UserName extends Zend_View_Helper_Abstract {

    public function userName() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity()->name;
        }
        
        return '';
    }
}

