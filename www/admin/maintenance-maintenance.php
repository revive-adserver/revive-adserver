<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

phpAds_PageHeader("5.5");
phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4"));
phpAds_MaintenanceSelection("maintenance");


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br>";

$oMaintStatus = new OA_Maintenance_Status();

if (!$oMaintStatus->isScheduledMaintenanceRunning) {
    // Scheduled maintenance wasn't run in the last hour

    echo $strMaintenanceHasntRun;
    echo "<br><br>";

    if (!$oMaintStatus->isAutoMaintenanceRunning) {
        // Automatic maintenance wasn't run in the last hour

        if ($oMaintStatus->isAutoMaintenanceEnabled) {
            echo $strAutoMantenaceEnabledAndHasntRun;
        } else {
            echo $strAutoMantenaceDisabledAndHasntRun;
        }
    } else {
        if ($oMaintStatus->isAutoMaintenanceEnabled) {
            echo $strAutoMantenaceEnabledAndRunning;
        } else {
            echo $strAutoMantenaceDisabledAndRunning;
        }
    }
} else {
    echo $strMantenaceRunning;
    echo "<br><br>";

    if ($oMaintStatus->isAutoMaintenanceEnabled) {
        echo $strAutoMantenaceEnabled;
    } else {
        echo $strAutoMantenaceDisabled;
    }
}

echo "<br><br>";

phpAds_ShowBreak();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>