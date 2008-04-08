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

    echo "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>"."<br><br>";

    if (!$oMaintStatus->isAutoMaintenanceRunning) {
        // Automatic maintenance wasn't run in the last hour

        if ($oMaintStatus->isAutoMaintenanceEnabled) {
            echo "Automatic maintenance is enabled, but it has not been triggered. Note that automatic maintenance is triggered only when OpenX delivers banners.
                  For best performance it is advised to set up <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a>.";
        } else {
            echo "Also, automatic maintenance is disabled, so when ".MAX_PRODUCT_NAME." delivers banners, maintenance is not triggered.
                  If you do not plan to run <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a>,
                  you must <a href='settings-admin.php'>enable auto maintenance</a> to ensure that ".MAX_PRODUCT_NAME." works correctly.";
        }
    } else {
        if ($oMaintStatus->isAutoMaintenanceEnabled) {
            echo "Automatic maintenance is enabled and will trigger maintenance every hour.
                  For best performance it is advised to set up <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a>.";
        } else {
            echo "Automatic maintenance is disabled too but a maintenance task has recently run. To make sure that ".MAX_PRODUCT_NAME." works correctly you should either
                  set up <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a> or <a href='settings-admin.php'>enable auto maintenance</a>. ";
        }
    }
} else {
    echo "<b>Scheduled maintenance seems to be correctly running.</b>"."<br><br>";

    if ($oMaintStatus->isAutoMaintenanceEnabled) {
        echo "Automatic maintenance is enabled. For best performance it is advised to <a href='account-settings-maintenance.php'>disable automatic maintenance</a>.";
    } else {
        echo "Automatic maintenance is disabled.";
    }
}

echo "<br><br>";

phpAds_ShowBreak();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>