<?php

/**
 * Branch Form
 *
 * @category   Agana
 * @package    Agana_Busunit
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Busunit_Form_Branch extends Busunit_Form_Busunit {

    public function __construct($action, $model = null, $options = null) {
        parent::__construct($action, $model, $options);
    }

    public function init() {
        parent::init();
        
        $this->setName('Branch');
        $this->setLegend('Branch');
    }

}

?>
