<?php

/**
 * Util class to crypt and has functions
 * 
 * @author Ademir Mazer Jr (Nuno Mazer) - http://ademir.winponta.com.br
 */
class Agana_Util_Crypt {


    /**
     * Generate a calculated randomic salt to be used with the password field
     * 
     * @param string $pwd
     * @param string $name
     * @return string
     */
    public static function calcRndTimeSalt($pwd, $name) {
        $salt = sha1(time()*  mt_rand());
        $salt = md5($salt.date('YYYY:mm:dd'));
        if (strlen($pwd)>3) {
            $pwd = substr($pwd, strlen($pwd)/3) . substr($pwd, strlen($pwd)/2);
        } 
        if (strlen($name)>3) {
            $name = substr($name, strlen($name)/3) . substr($name, strlen($name)/2);
        } 
        $salt = md5($salt.sha1($pwd).$name);
        return $salt;
    }
}