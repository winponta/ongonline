<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface App_Persist_Interface_Account {
    public function save($type = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getAll();
}

?>
