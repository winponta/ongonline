<?php

class Agana_Filter_Transliterate implements Zend_Filter_Interface {

    public function filter($string, $toLower = true) {
        // Lista de caracteres que devem ser substituídos
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ$ßàáâãäåæ@çèéêë&amp;'
                . 'ìíîïðñòóôõöøùúûüýýþÿŔŕ°ºª,.;:\|/"^~*%# ()[]{}=!?`‘’'
                . "'";

        // Lista que irá substituir os caracteres acima
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybssaaaaaaaaceeeee'
                . 'iiiidnoooooouuuuyybyRrooa--------------------------'
                . '-';

        $normalizeChars = array( 
            'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Å'=>'A', 'Ä'=>'A', 'Æ'=>'AE', 'Ç'=>'C', 
            'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ð'=>'Eth', 
            'Ñ'=>'N', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ŕ'=>'R',
            'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 
    
            'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a', 'ä'=>'a', 'æ'=>'ae', 'ç'=>'c', 
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'eth', 
            'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ŕ'=>'r',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 
            
            'ß'=>'sz', 'þ'=>'thorn', 'ÿ'=>'y',
            
            '&amp;'=>'e', '&'=>'e',
            
            ' '=>'-', '°'=>'o', 'º'=>'o', 'ª'=>'a', ','=>'-', '.'=>'-',
            ';'=>'-', ':'=>'-', '\\'=>'-','|'=>'-', '/'=>'-', '"'=>'-', 
            '^'=>'-', '~'=>'-', '*'=>'-', '%'=>'-', '#'=>'-', '('=>'-', 
            ')'=>'-', '['=>'-', ']'=>'-', '{'=>'-', '}'=>'-', '='=>'-', 
            '!'=>'-', '?'=>'-', '`'=>'-', '‘'=>'-', '’'=>'-',
            "'"=>'-'
        );
        
        // Efetua a substituição
        //$string = strtr($string, $a, $b);
        $string = strtr($string, $normalizeChars);

        // Deixa tudo minúsculo
        if ($toLower) {
            $string = strtolower($string);
        }

        // Evita hífens repetidos
        $string = preg_replace('/--+/', '-', $string);
        return $string;
    }

}