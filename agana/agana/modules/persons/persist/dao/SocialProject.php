<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Persons_Persist_Dao_SocialProject extends Agana_Persist_Dao_Abstract implements Persons_Persist_Interface_PersonDocs {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'programa_federal_social';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Prepare data for insert
     * 
     * @param Persons_Model_SocialProject
     * @return Array 
     */
    protected function _prepareInsertData($data) {
    }

    /**
     * Prepare data for update 
     * 
     * @param Persons_Model_SocialProject
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Persons_Model_SocialProject
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        if (is_array($data)) {
            if (!isset($data[0])) {
                $data = array(0 => $data);
            }

            $col = array();
            foreach ($data as $key => $row) {
                if ($row) {
                    $o = new Persons_Model_SocialProject($row);

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