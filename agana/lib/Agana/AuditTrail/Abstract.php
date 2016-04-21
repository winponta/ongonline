<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Abstract
 *
 * @author nuno
 */
class Agana_AuditTrail_Abstract {

    const EVENT_TYPE_INSERT = 'INS';
    const EVENT_TYPE_UPDATE = 'UPD';
    const EVENT_TYPE_DELETE = 'DEL';

    protected $trackFields = null;
    protected $trackFieldsMeta = null;
    
    protected $trackTable = null;
    protected $trackTableMeta = null;
    
    /**
     *
     * @var Zend_Log
     */
    protected $log;

    protected $columnMapping = array(
        'record_id' => 'record_id',
        'tablename' => 'tablename',
        'fieldname' => 'fieldname',
        'eventdate' => 'eventdate',
        'eventtype' => 'eventtype',
        'user_id' => 'user_id',
        'value' => 'value',
        'appaccount_id' => 'appaccount_id',
        'fieldtexttype' => 'fieldtexttype',
    );

    public function __construct() {
        $db = Zend_Db_Table::getDefaultAdapter();

        $logWriter = new Zend_Log_Writer_Db($db, 'audit_trail', $this->columnMapping);

        $this->log = new Zend_Log($logWriter);
    }

    private function logUpdate($eventType, $table, $oldValue, $newValue, $user) {
        $timestamp = Zend_Date::now()->toString('yyyy-MM-dd HH:mm:ss');
        
        if ($this->trackFields != null) {
            // insert a log for each tracked field
            foreach ($this->trackFields as $field) {
                if (isset($oldValue[$field]) && isset($newValue[$field])) {
                    if ($oldValue[$field] != $newValue[$field]) {
                        $this->setColEventType(self::EVENT_TYPE_UPDATE);
                        $this->setColEventDate($timestamp);
                        $this->setColFieldName($field);
                        $this->setColRecordId($oldValue['id']);
                        $this->setColAppAccountId($user['appaccount_id']);
                        $this->setColUserId($user['user_id']);
                        $this->setColTableName($table);
                        $this->setColFieldTextType(false);
                        $this->setColValue($oldValue[$field]);
                        
                        $this->log->log('UPDATE on database', Zend_Log::INFO);
                    }
                }
            }
        } else {
            throw new Agana_Exception('Track Fields for audit trail is not set');
        }
    }

    public final function log($eventType, $table, $oldValue, $newValue, $user) {
        if ($eventType == self::EVENT_TYPE_UPDATE) {
            $this->logUpdate($eventType, $table, $oldValue, $newValue, $user);
        }
    }

    public function setColRecordId($value) {
        $this->log->setEventItem('record_id', $value);
    }

    public function setColTableName($value) {
        $this->log->setEventItem('tablename', $value);
    }

    public function setColFieldName($value) {
        $this->log->setEventItem('fieldname', $value);
    }

    public function setColEventType($value) {
        $this->log->setEventItem('eventtype', $value);
    }

    public function setColUserId($value) {
        $this->log->setEventItem('user_id', $value);
    }

    public function setColAppAccountId($value) {
        $this->log->setEventItem('appaccount_id', $value);
    }

    public function setColFieldTextType($value) {
        $this->log->setEventItem('fieldtexttype', $value);
    }

    public function setColValue($value) {
        $this->log->setEventItem('value', $value);
    }

    public function setColEventDate($value) {
        $this->log->setEventItem('eventdate', $value);
    }

    public function getTrackFields() {
        return $this->trackFields;
    }
    
    protected function setTrackFields($trackFields) {
        $this->trackFields = $trackFields;
    }
    
    protected function setTrackFieldsMeta($trackFieldsMeta) {
        $this->trackFieldsMeta = $trackFieldsMeta;
    }
    
    protected function setTrackTable($value) {
        $this->trackTable = $value;
    }
    
    public function getTrackTable() {
        return $this->trackTable;
    }
    
    protected function setTrackTableMeta($value) {
        $this->trackTableMeta = $value;
    }
    
    public function getTrackTableMeta() {
        return $this->trackTableMeta;
    }
}
