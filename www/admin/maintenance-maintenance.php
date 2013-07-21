<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Status.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("maintenance-index");
phpAds_MaintenanceSelection("maintenance");


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br>";

$oMaintStatus = new OA_Maintenance_Status();

if (!$oMaintStatus->isScheduledMaintenanceRunning) {
    // Scheduled maintenance WAS NOT run in the last hour
    if (!$oMaintStatus->isAutoMaintenanceRunning) {
        // Automatic maintenance WAS NOT run in the last hour
        if ($oMaintStatus->isAutoMaintenanceEnabled) {
            // Automatic maintenance IS enabled
            echo $strScheduledMaintenanceHasntRun;
            echo "<br><br>";
            echo $strAutoMantenaceEnabledAndHasntRun;
        } else {
            // Automatic maintenance IS NOT enabled
            echo $strScheduledMaintenanceHasntRun;
            echo "<br><br>";
            echo $strAutoMantenaceDisabledAndHasntRun;
        }
    } else {
        // Automatic maintenance WAS run in the last hour
        if ($oMaintStatus->isAutoMaintenanceEnabled) {
            // Automatic maintenance IS enabled
            echo $strAutomaticMaintenanceHasRun;
            echo "<br><br>";
            echo $strAutoMantenaceEnabledAndRunning;
        } else {
            // Automatic maintenance IS NOT enabled
            echo $strAutomaticMaintenanceHasRun;
            echo "<br><br>";
            echo $strAutoMantenaceDisabledAndRunning;
        }
    }
} else {
    // Scheduled maintenance WAS run in the last hour
    echo $strScheduledMantenaceRunning;
    if ($oMaintStatus->isAutoMaintenanceEnabled) {
        // Automatic maintenance IS enabled
        echo "<br><br>";
        echo $strAutoMantenaceEnabled;
    }
}

echo "<br><br>";

phpAds_ShowBreak();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>