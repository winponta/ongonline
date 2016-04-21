<?php

/**
 *
 * @author Ademir Mazer Jr - Nuno Mazer - http://ademir.winponta.com.br
 */
class App_Persist_Dao_Account extends Agana_Persist_Dao_Abstract implements App_Persist_Interface_Account {
    
    /**
     * Table name in database
     * @var String 
     */
    protected $_name   = 'appaccount';
    
    /**
     * Primary key of table
     * @var String 
     */
    protected $_primary = 'id';

    /**
     * Name of the sequence in database
     * @var String 
     */
    protected $_sequence = 'appaccount_id_seq';
    
    public function __construct($config = array()) {
        parent::__construct($config);
        
        $this->setTrackUpdateAuditTrail(true);
        $this->setAuditTrailClassName('App_Module_Audit');
    }

    /**
     * Prepare data for insert
     * 
     * @param App_Model_Account
     * @return Array 
     */
    protected function _prepareInsertData($data) {
        $data = array(
            'name'      => $data->getName(),
            'email'     => $data->getEmail(),
            'created'   => $this->getNowTimestamp(),
            //'objid'     => Agana_Service_Object::create('appaccount'),
        );

        return $data;
    }

    /**
     * Prepare data for update 
     * 
     * @param App_Model_Account
     * @return Array 
     */
    protected function _prepareUpdateData($data) {
        $data = array(
            'name' => $data->getName(),
            'email' => $data->getEmail(),
        );
        
        return $data;
    }

    /**
     *prepare data to be returned from query
     * @param array
     * @return App_Model_Account
     */
    protected function _prepareReturnData($data, $returnArray = false) {
        $o = new App_Model_Account($data);
        return $o;
    }


}

?>
