<?php

/**
 * Timestamp util class
 *
 * @author Ademir Mazer Jr
 */
class Agana_Util_DateTime {
    /**
     * Convert a date to YYMMDD format, using the separator passed by param
     * like 99-12-31. 
     * If a date with single char for day or month is passed, the function 
     * fills left chars with 0, like 99-03-04
     * 
     * @param string $date
     * @param string $separator
     * @return string
     */
    public static function dateToYYMMDD($date, $separator = '-') {
        $zd = new Zend_Date($date);
        $date = $zd->get(Zend_Date::YEAR_8601) . $separator . 
                str_pad($zd->get(Zend_Date::MONTH), 2, '0', STR_PAD_LEFT) . $separator . 
                str_pad($zd->get(Zend_Date::DAY_SHORT), 2, '0', STR_PAD_LEFT);
        return $date;
    }
    
    /**
     * Scramble a timestamp changing each x chars to ascii 97 + chars (a ...)
     * and then inverting the digits sequence 
     * 
     * @param timestamp $time
     * @param int $each
     * @return String
     */
    public static function timestampToScrambleChars($time = null, $each = 2) {
        if (is_null($time)) {
            $time = time();
        }
        
        $timeArray = str_split($time);

        $qtde = count($timeArray);
        for ($i = 1; $i < $qtde; $i+=$each) {
            $timeArray[$i] = chr($timeArray[$i] + 97);
        }

        $time = implode('', array_reverse($timeArray));
        
        return $time;
    }

    /**
     * Returns to timestamp an scrambled a timestamp string by inverted digits 
     * sequence and then changed each x chars to ascii 97 + chars (a ...)
     * 
     * @param String $timeScrambled
     * @param int $each
     * @return String timestamp
     */
    public static function scrambledCharsToTimestamp($timeScrambled, $each = 2) {
        $timeArray = array_reverse(str_split($timeScrambled));

        $qtde = count($timeArray);
        for ($i = 1; $i < $qtde; $i+=$each) {
            $timeArray[$i] = ord($timeArray[$i]) - 97;
        }

        $timeStamp = implode('', $timeArray);
        
        return $timeStamp;
    }
    
    /**
     * Validate a date from format XX
     */
    public static function validate($date, $format = 'd/m/Y') {
        //$res = (strtotime($date))?true:false;
        //return $res;
        list($dd,$mm,$yyyy) = explode('/',$date);
        return checkdate($mm, $dd, $yyyy);

    }
}

