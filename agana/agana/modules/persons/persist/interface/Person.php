<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Persons_Persist_Interface_Person {
    public function save($type = null);
    public function delete($id);
    public function get($id);
    public function getByName($name);
    public function getAll($appaccountId,$orderby);
    public function searchByName($term, $appaccountId, $orderby);
}

