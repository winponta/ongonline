<?php

/**
 * Description of User_Interface
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface User_Persist_Interface_User {
    public function save($user = null);
    public function delete($id);
    public function get($id);
    public function getByName($name, $appaccount_id);
    public function getAll($show, $appaccount_id);
}
