<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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