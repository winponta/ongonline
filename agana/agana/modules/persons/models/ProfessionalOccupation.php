<?php

/**
 * Describe as class constants the professional occupations allowed in application and
 * how they are persisted
 *
 * @author Ademir Mazer Jr <ademir@winponta.com.br>
 * @copyright (c) 2013, Winponta <http://www.winponta.com.br>
 */
class Persons_Model_ProfessionalOccupation {
    const CITY_WORKER   = 'city worker';
    const RETIRED       = 'retired';
    const RURAL_WORKER  = 'rural worker';
    const UNEMPLOYED    = 'unemployed';
    const AUTONOMO    = 'autônomo';
    
    static public function toArray() {
        $c = new ReflectionClass((__CLASS__));
        return $c->getConstants();
    }
}

