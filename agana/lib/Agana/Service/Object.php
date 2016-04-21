<?php
/**
 * Agana_Service_Object provides some services to work with objects
 *
 * @category   Agana
 * @package    Agana_Object
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Service_Object {
    /**
     * Creates a new object in persistence and return it
     * 
     * @param String table name
     * @return Agana_Model_Object
     */
    public static function create($table) {
        if (isset($table)) {
            $o = new Agana_Model_Object(null);
            $o->setTableName($table);

            $od = new Agana_Domain_Object($o);
            return $od->add();
        } else {
            throw new Agana_Exception('Object table name should not be null');
        }
    }

}
?>
