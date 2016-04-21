<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Location_Persist_Interface_Country {
    public function save($model = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getAll();
}