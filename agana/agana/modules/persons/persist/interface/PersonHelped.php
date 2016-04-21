<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Persons_Persist_Interface_PersonHelped {
    public function save($type = null);
    public function delete($id);
    public function get($id);
}

