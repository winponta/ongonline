<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Busunit_Persist_Interface_Headquarters {
    public function save($model = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getAll($params = null);
    public function getByAppAccount($appaccount_id);
}

?>
