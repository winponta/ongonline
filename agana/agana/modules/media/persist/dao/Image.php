<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Media_Persist_Dao_Image extends Agana_Persist_Dao_Abstract implements Media_Persist_Interface_Image {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'media';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'media_id_seq';

    /**
     * Prepare data for insert
     * 
     * @param Media_Model_Image
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'title' => $data->getTitle(),
            'mimetype' => $data->getMimetype(),
            'file' => $data->getFile(),
            'filesize' => $data->getFileSize(),
            //'objid' => Agana_Service_Object::create('media'),
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param Media_Model_Image
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'title' => $data->getTitle(),
            'mimetype' => $data->getMimetype(),
            'file' => $data->getFile(),
            'filesize' => $data->getFileSize(),
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return Media_Model_Image
     */
    protected function _prepareReturnData($data, $returnArray = false) {
        $o = new Media_Model_Image($data);
        return $o;
    }

    /**
     * Search a persisted media in database by its file field
     * @param string $file name
     * @return Media_Model_Image
     */
    public function getByFileName($name) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->where('file = ?', $name);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql));
    }

    /**
     * Searchs persistence and returns a media by its relation with the table name
     * @param string relation table name
     * @param integer id value on relation table
     * @return Media_Model_Image
     * @throws Agana_Exception 
     */
    public function getByRelation($relation, $id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->joinInner(
                        'person_media',
                        'id = person_media.media_id',
                        array()
                        )
                ->where('person_id = ?', $id);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        return $this->_prepareReturnData($db->fetchRow($sql));
    }
}

?>
