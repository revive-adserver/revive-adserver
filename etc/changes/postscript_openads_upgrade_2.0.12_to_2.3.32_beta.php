<?php

require_once MAX_PATH . '/lib/OA/Dal/Mainentance/Statistics/Factory.php';

class OA_UpgradePostscript
{

    function OA_UpgradePostscript()
    {

    }

    function execute()
    {
// activate campaigns
// needs tests
//        $oNowDate = new Date();
//
//        define('DISABLE_ALL_EMAILS', 1);
//        $oDalMSF = new OA_Dal_Maintenance_Statistics_Factory();
//        $oDalMaintenanceStatistics = $oDalMSF->factory('AdServer');
//        $oDalMaintenanceStatistics->managePlacements($oNowDate);
        return true;

    }

}

?>