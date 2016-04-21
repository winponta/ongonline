<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Project_Persist_Interface_Project {
    public function save($model = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getAll();
}