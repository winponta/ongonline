<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class Busunit_Persist_Dao_Busunit extends Agana_Persist_Dao_Abstract implements Busunit_Persist_Interface_Headquarters {

    /**
     * Table name in database
     * @var String 
     */
    protected $_name = 'busunit';

    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'busunit_id_seq';

    /**
     * Name of the model class to be used in prepare functions
     * @var String 
     */
    protected $_modelClass = 'Busunit_Model_Busunit';

    /**
     * Prepare data for insert
     * 
     * @param Busunit_Model_Busunit
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $dataPrepared = $this->_prepareUpdateData($data);

        $dataPrepared['appaccount_id'] = $data->getAppaccount_id();
        $dataPrepared['head'] = $data->getHead();

        return $dataPrepared;
    }

    /**
     * Prepare data for update 
     * 
     * @param Busunit_Model_Busunit
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $dataPrepared = array(
            'name' => $data->getName(),
            'tradename' => $data->getTradename(),
            'doctaxnumber' => $data->getDoctaxnumber(),
            'phone' => $data->getPhone(),
            'address' => $data->getaddress(),
            'addressnumber' => $data->getAddressnumber(),
            'addressdetails' => $data->getAddressdetails(),
            'district' => $data->getDistrict(),
            'postalcode' => $data->getPostalcode(),
            'website' => $data->getWebsite(),
            'city_id' => $data->getCity_id(),
        );

        return $dataPrepared;
    }

    /**
     * prepare data to be returned from query
     * @param array
     * @return Location_Model_State
     */
    protected function _prepareReturnData($data, $returnArray = true) {
        $ret = parent::_prepareReturnData($data, $returnArray);
        return $ret;
    }

    public function getByAppAccount($appaccount_id, $head = 0, $params = null) {
        $db = $this->getDefaultAdapter();
        $sql = $db->select()
                ->from($this->_name)
                ->where('appaccount_id = ?', $appaccount_id)
                ->where('head = ?', $head);
        $db->setFetchMode(Zend_DB::FETCH_ASSOC);
        
        $returnArray = (isset($params['returnArray'])) ? $params['returnArray'] : false;
        return $this->_prepareReturnData($db->fetchRow($sql), $returnArray);
    }

    /**
     * Query all business units for an app account
     * @param array $params <br>
     *          $orderby String : The name of column to order the query. Empty string is the default <br>
     *          $excludeHead bool : If the headquarter should be excluded from results, FALSE is the default <br>
     *          $appaccount_id int : The id of the app account to query business units related. REQUIRED
     * @return stdClass
     */
    public function getAll($params = null) {
        //, $excludeHead = false, $appaccount_id) {
        
        $orderby = (isset($params['orderby'])) ? $params['orderby'] : '';
        $excludeHead = (isset($params['excludeHead'])) ? $params['excludeHead'] : false;
        
        if (isset($params['appaccount_id'])) {
            $appaccount_id = $params['appaccount_id'];
        } else {
            throw new Agana_Exception('appaccount_id param is missing when calling Busunit getAll dao class');
        }
        
        try {
            $db = $this->getDefaultAdapter();
            $sql = $db->select()
                    ->from($this->_name)
                    ->where('appaccount_id = ?', $appaccount_id)
                    ->order($orderby);

            if ($excludeHead) {
                $sql->where('head = ?', 0);
            }

            $db->setFetchMode(Zend_DB::FETCH_ASSOC);

            return $this->_prepareReturnData($db->fetchAll($sql));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
