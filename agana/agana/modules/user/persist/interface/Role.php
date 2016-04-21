<?php

/**
 * Description of Role_Interface
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface User_Persist_Interface_Role {
    public function save($role = null);
    public function delete($id);
    public function get($id);
    public function getByName($name, $appaccount_id);
    public function getAll($appaccount_id);
}
