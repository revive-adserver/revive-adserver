<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

require_once MAX_PATH . '/lib/OA/Maintenance.php';


/**
 * A class for providing information about maintenance status
 *
 * @package    OpenXMaintenance
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Maintenance_Status
{
    var $isAutoMaintenanceEnabled;

    var $isScheduledMaintenanceRunning = false;
    var $isAutoMaintenanceRunning      = false;

    function OA_Maintenance_Status()
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
        $oLastCronRun = OA_Maintenance::getLastScheduledRun();
        $oLastRun     = OA_Maintenance::getLastRun();

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