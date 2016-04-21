<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Audit
 *
 * @author nuno
 */
class User_Module_Audit extends Agana_AuditTrail_Abstract {

    public function __construct() {
        parent::__construct();

        $this->setTrackFields(
            array('id', 'name', 'email', 'status', 'acl_role_id')
        );
        
        $this->setTrackFieldsMeta(
            array('id', 'Name', 'Email', 'Status', 'User role')
        );
        
        $this->setTrackTable('user');
        $this->setTrackTableMeta('User profile');
    }


}


