<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Staff_Persist_Interface_Jobfunction {
    public function save($model = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getAll();
}

