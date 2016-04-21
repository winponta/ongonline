<?php

/**
 * Agana_Boleto_Object
 *
 * controls the boleto wrapper for OBBoleto lib
 * 
 * @category   Agana
 * @package    Agana_Boleto
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */

require_once __DIR__ . '/OBBoleto/lib/OB.php';

class Agana_Finance_Boleto extends OB {
    
    /**
     * Creates the ob boleto and instantiate the internal model
     * @param String Num banco 
     */
    public function __construct($codigoBanco) {
        require_once __DIR__ . '../OBBoleto/OB_init.php';
        parent::__construct($codigoBanco);
    }

    public static function generateBarCode($num) {
        Barcode::getImage($num);
    }
    
}

?>
