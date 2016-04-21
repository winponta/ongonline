<?php

/**
 * Headquarters Form
 *
 * @category   Agana
 * @package    Agana_Busunit
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Busunit_Form_Headquarters extends Busunit_Form_Busunit { 

    public function __construct($action, $model = null, $options = null) {
        parent::__construct($action, $model, $options);
    }

    public function init() {
        parent::init();
        
        $this->setName('Headquarters');
        //$this->setLegend('Headquarters/Head Office');
        $this->setLegend('');
    }

}

?>
