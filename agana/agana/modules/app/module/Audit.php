<?php

/**
 * Description of Audit
 *
 * @author nuno
 */
class App_Module_Audit extends Agana_AuditTrail_Abstract {

    public function __construct() {
        parent::__construct();

        $this->setTrackFields(array(
            'id', 'name', 'email', 
        ));
        
        $this->setTrackFieldsMeta(array(
            'id', 'Name', 'Email', 
        ));
        
        $this->setTrackTable('appaccount');
        $this->setTrackTableMeta('App Account');
    }


}

?>
