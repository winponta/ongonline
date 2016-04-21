<?php

class Agana_Data_BeanUtil {
    /**
     * Populate a bean with the data array setting the 
     * @param object $bean
     * @param array $data 
     */
    public static function populate($bean, $data) {
        foreach ($data as $key => $value) {
            $set = 'set' . ucfirst($key);
            $bean->$set($value);
        }
    }
}
