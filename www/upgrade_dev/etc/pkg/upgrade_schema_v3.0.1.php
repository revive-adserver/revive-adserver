<?php

require_once(MAX_PATH.'/lib/max/Migration.php');

/**
 * Event handling class for Openads deployment system
 *
 */

class Migration_v3_0_1 extends Migration
{

    function Migration_v3_0_1($mdb2)
    {
        $this->__construct();
    }

    function afterAddField_acls_ad_id()
    {
        $this->copyData('acls', 'bannerid', 'acls', 'ad_id'); // copy from acls.bannerid to acls.ad_id
        $this->logEvent(__METHOD__, array('table'=>'acls', 'column'=>'ad_id'));
    }

    function beforeRemoveField_acls_bannerid()
    {
      $this->beforeRemoveField('acls', 'bannerid');
      // ad_id data integrity check
    }
}

?>