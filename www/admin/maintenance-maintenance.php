<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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


// Security check
phpAds_checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_MaintenanceSelection("maintenance");


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br>";

$aConf = $GLOBALS['_MAX']['CONF'];
$aPref = $GLOBALS['_MAX']['PREF'];

$iLastCronRun = $aPref['maintenance_cron_timestamp'];

// Make sure that negative values don't break the script
if ($iLastCronRun > 0) {
    $iLastCronRun = strtotime(date('Y-m-d H:00:00', $iLastCronRun));
}

if (time() >= $iLastCronRun + 3600) {
    // Scheduled maintenance wasn't run in the last hour

    echo "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>"."<br><br>";

    $iLastRun = $aPref['maintenance_timestamp'];

    // Make sure that negative values don't break the script
    if ($iLastRun > 0) {
        $iLastRun = strtotime(date('Y-m-d H:00:00', $iLastRun));
    }

    if (time() >= $iLastRun + 3600) {
        // Automatic maintenance wasn't run in the last hour

        if (!empty($conf['maintenance']['autoMaintenance'])) {
            echo "Automatic maintenance is enabled, but it has not been triggered. Note that automatic maintenance is triggered only when Openads delivers banners.
                  For best performance it is advised to set up <a href='http://docs.openads.org/openads-2.3-guide/maintenance.html' target='_blank'>scheduled maintenance</a>.";
        } else {
            echo "Also, automatic maintenance is disabled, so when ".MAX_PRODUCT_NAME." delivers banners, maintenance is not triggered.
                  If you do not plan to run <a href='http://docs.openads.org/openads-2.3-guide/maintenance.html' target='_blank'>scheduled maintenance</a>,
                  you must <a href='settings-admin.php?auto_maintenance=t'>enable auto maintenance</a> to ensure that ".MAX_PRODUCT_NAME." works correctly.";
        }
    } else {
        if (!empty($conf['maintenance']['autoMaintenance']))
            echo "Automatic maintenance is enabled and will trigger maintenance every hour.
                  For best performance it is advised to set up <a href='http://docs.openads.org/openads-2.3-guide/maintenance.html' target='_blank'>scheduled maintenance</a>.";
        else
            echo "Automatic maintenance is disabled too but a maintenance task has recently run. To make sure that ".MAX_PRODUCT_NAME." works correctly you should either
                  set up <a href='http://docs.openads.org/openads-2.3-guide/maintenance.html' target='_blank'>scheduled maintenance</a> or <a href='settings-admin.php?auto_maintenance=t'>enable auto maintenance</a>. ";
    }
} else {
    echo "<b>Scheduled maintenance seems to be correctly running.</b>"."<br><br>";

    if (!empty($conf['maintenance']['autoMaintenance'])) {
        echo "Automatic maintenance is enabled. For best performance it is advised to <a href='settings-admin.php?auto_maintenance=f'>disable automatic maintenance</a>.";
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
