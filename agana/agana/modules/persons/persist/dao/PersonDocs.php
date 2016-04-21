<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Persons_Persist_Dao_PersonDocs extends Agana_Persist_Dao_Abstract implements Persons_Persist_Interface_PersonDocs {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'person_docs';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Prepare data for insert
     * 
     * @param Person_Model_PersonDocs
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['id'] = $data->getId();

        return $dataPrepared;
    }

    /**
     * Prepare data for update 
     * 
     * @param Person_Model_PersonDocs
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataPrepared = $data->toArray();

        unset($dataPrepared['id']);
        
        return $dataPrepared;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Person_Model_PersonDocs
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        if (is_array($data)) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }

            $col = array();
            foreach ($data as $key => $row) {
                if ($row) {
                    $o = new Persons_Model_PersonDocs($row);

                    $col[] = $o;
                }
            }

            if ($returnArray) {
                return $col;
            } else {
                return $col[0];
            }
        } else {
            return null;
        }
    }

}