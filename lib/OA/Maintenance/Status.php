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

require_once LIB_PATH . '/Maintenance.php';


/**
 * A class for providing information about maintenance status
 *
 * @package    OpenXMaintenance
 */
class OA_Maintenance_Status
{
    var $isAutoMaintenanceEnabled;

    var $isScheduledMaintenanceRunning = false;
    var $isAutoMaintenanceRunning      = false;

    function __construct()
    {
        // Check auto-maintenance settings
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->isAutoMaintenanceEnabled = !empty($aConf['maintenance']['autoMaintenance']);

        // Get time 1 hour ago
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oNow = $oServiceLocator->get('now');
        if ($oNow) {
            $oOneHourAgo = new Date($oNow);
        } else {
            $oOneHourAgo = new Date();
        }
        $oOneHourAgo->subtractSpan(new Date_Span('0-1-0-0'));

        // Get last runs
        $oLastCronRun = OX_Maintenance::getLastScheduledRun();
        $oLastRun     = OX_Maintenance::getLastRun();

        // Reset minutes and seconds
        if (isset($oLastCronRun)) {
            $oLastCronRun->setMinute(0);
            $oLastCronRun->setSecond(0);
        }
        if (isset($oLastRun)) {
            $oLastRun->setMinute(0);
            $oLastRun->setSecond(0);
        }

        // Check if any kind of maintenance was run
        if (isset($oLastCronRun) && !$oOneHourAgo->after($oLastCronRun)) {
            $this->isScheduledMaintenanceRunning = true;
        } elseif (isset($oLastRun) && !$oOneHourAgo->after($oLastRun)) {
            $this->isAutoMaintenanceRunning = true;
        }
    }
}

?>