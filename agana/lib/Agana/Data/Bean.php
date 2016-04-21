<?php

/**
 * This class must be extended by Bean Models of the application.
 * It defines magical methods __get and __set that ensure Beans can be populated easilly
 * by Controllers
 *
 * @author Ademir Mazer Jr (Nuno Mazer) http://ademir.winponta.com.br
 * @package Agana
 * @subpackage Config
 * @abstract
 */
abstract class Agana_Data_Bean {

    public function __construct($data = null) {
        if (!is_null($data) && !$data == false) {
            $this->populate($data);
        }
    }
    
    public function __call($name, $arguments) {
        if (strpos($name, 'get') === 0) {
            $property = strtolower(substr($name, 3, 1)) . substr($name, 4);
            return $this->$property;
        } elseif (strpos($name, 'set') === 0) {
            $property = strtolower(substr($name, 3, 1)) . substr($name, 4);
            return $this->$property = $arguments[0];
        } else {
            throw new Exception('Method '.$name.' does not exist');
        }
    }

    public function __get($name) {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return call_user_func(array($this, $getter));
        }
        return $this->$name;
    }

    public function __set($name, $value) {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            call_user_func(array($this, $setter), $value);
        } else {
            $property = strtolower($name);
            if (property_exists($this, $property)) {
                $this->property = $value;
            }
        }
    }

    /**
     * Populate the bean class with data from data map array param. It uses the
     * class's setters.
     * The data map must be an array with named index for properties and its values.
     * @example
     * $data['id'] = 5
     * $data['company'] = 'Winponta'
     * $data['url'] = 'http://www.winponta.com.br'
     *
     * @param Array $data
     */
    public function populate($data) {
        foreach ($data as $propertie => $value) {
            $setter = 'set'.$propertie;
            $this->$setter(stripcslashes($value));
        }
    }

}