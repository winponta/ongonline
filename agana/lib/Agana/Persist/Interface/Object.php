<?php

/**
 * Description of Object Interface
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Agana_Persist_Interface_Object {
    public function save($object);
    public function delete($uid);
    public function get($uid);
}

?>
