<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
interface Media_Persist_Interface_Image {
    public function save($type = null);
    public function delete($id);
    public function get($id);
    public function getByFileName($name);
    public function getAll();
}

?>
