<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 * @copyright (c) 2013, Winponta Software
 */
interface Calendar_Persist_Interface_Agenda {
    public function save($model = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getByModule($module_id);
    public function getAll($params = null);
    public function getByPerson($person_id);
}

?>
