<?php

/**
 * Describe as class constants the home types allowed in application and
 * how they are persisted
 *
 * @author Ademir Mazer Jr <ademir@winponta.com.br>
 * @copyright (c) 2013, Winponta <http://www.winponta.com.br>
 */
class Persons_Model_Home {
    const SITUATION_OWNER       = 'owner';
    const SITUATION_RENT        = 'rent';
    const SITUATION_MORTGAGE    = 'mortgage';
    const SITUATION_PRESENT     = 'present';
    const SITUATION_INVASION    = 'invasion';
    
    const AREA_URBAN            = 'urban';
    const AREA_RURAL            = 'rural';
    const AREA_ISLAND           = 'island';
    const AREA_QUILOMBO         = 'quilombo';
    const AREA_INDIAN           = 'indian';
    
    const TYPE_BRICK            = 'brick';
    const TYPE_WOOD             = 'wood';
    //const TYPE_ADOBE            = 'adobe';
    
    static public function toArraySituation() {
        $c = new ReflectionClass((__CLASS__));
        $c = $c->getConstants();
        
        $res = array();
        foreach ($c as $key => $value) {
            if (strpos($key, 'SITUATION') === 0) {
                $res[$key] = $c[$key];
            }
        }
        
        return $res;
    }
    
    static public function toArrayArea() {
        $c = new ReflectionClass((__CLASS__));
        $c = $c->getConstants();
        
        $res = array();
        foreach ($c as $key => $value) {
            if (strpos($key, 'AREA') === 0) {
                $res[$key] = $c[$key];
            }
        }
        
        return $res;
    }

    static public function toArrayType() {
        $c = new ReflectionClass((__CLASS__));
        $c = $c->getConstants();
        
        $res = array();
        foreach ($c as $key => $value) {
            if (strpos($key, 'TYPE') === 0) {
                $res[$key] = $c[$key];
            }
        }
        
        return $res;
    }
}

