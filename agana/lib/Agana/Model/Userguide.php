<?php
/**
 * Userguide is a model used to control user gudie pages
 *
 * @author Ademir Mazer Jr (Nuno Mazer)
 */
class Agana_Model_Userguide extends Agana_Data_Bean {
    protected $page;
    protected $title;
    protected $content;
    protected $updated;    
    
    public function toArray() {
        return array(
            'name' => $this->page,
            'title' => $this->title,
            'content' => $this->content,
            'updated' => $this->updated
            );
    }
}

?>
