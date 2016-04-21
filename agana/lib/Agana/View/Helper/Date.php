<?php

/**
 * Agana_View_Helper_Date
 * Date time format view helper, based on artcle from Wanderson Henrique Camargo Rosa

 * @see lib/Agana/views/helpers/Date.php
 * @tutorial http://www.wanderson.camargo.nom.br/2011/01/criando-um-view-helper-para-zend-framework/
 * @category   Agana
 * @package    Agana_View_Helper
 * @copyright  Copyright (c) 2011-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_Date extends Zend_View_Helper_Abstract {
    /**
     * Date manipulation
     * @var Zend_Date
     */
    protected static $_date = null;
 
    /**
     * Main method
     * @param string $value Valor para Formatação
     * @param string $format Formato de Saída
     * @return string Valor Formatado
     */
    public function date($value, $format = Zend_Date::DATETIME_MEDIUM)
    {
        if ($value) {
            $date = $this->getDate();
            return $date->set($value)->get($format);
        } else {
            return '';
        }
    }
 
    /**
     * Acesso ao Manipulador de Datas
     * @return Zend_Date
     */
    public function getDate()
    {
        if (self::$_date == null) {
            self::$_date = new Zend_Date();
        }
        return self::$_date;
    }
}