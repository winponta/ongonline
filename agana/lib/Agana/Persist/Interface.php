<?php

/**
 * Description of Persist Interface
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Agana_Persist_Interface {
    public function save($object);
    public function delete($uid);
    public function get($uid);
}

?>
