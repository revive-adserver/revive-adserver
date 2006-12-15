<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: Priority.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/Max.php';
require_once 'Date.php';

/**
 * A wrapper class for running the Maintenance Priority Engine process.
 *
 * @static
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Priority
{

    /**
     * The method to run the Maintenance Priority Engine process.
     *
     * @static
     * @param boolean $alwaysRun Default value is false. If true, the Maintenance
     *                           Priority Engine process will always run, even if
     *                           instant priority updates have been disabled in the
     *                           configuration. Used to ensure that the maintenance
     *                           script process can always update priorities.
     */
    function run($alwaysRun = false)
    {
        // Get the configuration
        $conf = $GLOBALS['_MAX']['CONF'];
        // Should the MPE process run?
        if (!$alwaysRun) {
            // Is instant update for priority set?
            if (!$conf['priority']['instantUpdate']) {
                MAX::debug('Instant update of priorities disabled, not running MPE', PEAR_LOG_INFO);
                return;
            }
        }
        // Log the start of the process
        MAX::debug('Running Maintenance Priority Engine', PEAR_LOG_INFO);
        // Set longer time out, and ignore user abort
        if (!ini_get('safe_mode')) {
            @set_time_limit($conf['maintenance']['timeLimitScripts']);
            @ignore_user_abort(true);
        }
        // Create a Maintenance DAL object
        $oDal = new MAX_Dal_Maintenance_Priority();
        // Try to get the MPE database-level lock
        $lock = $oDal->obtainPriorityLock();
        if (!$lock) {
            MAX::debug('Unable to obtain database-level lock, not running MPE', PEAR_LOG_INFO);
            return;
        }
        // Ensure the the current time is registered with the ServiceLocator
        $oServiceLocator = &ServiceLocator::instance();
        $oDate = &$oServiceLocator->get('now');
        if (!$oDate) {
            // Record the current time, and register with the ServiceLocator
            $oDate = new Date();
            $oServiceLocator->register('now', $oDate);
        }
        // Run the MPE process for the AdServer module ONLY (at this stage :-)
        foreach ($conf['modules'] as $module => $installed) {
            if (($module == 'AdServer') && $installed) {
                // Create the MAX_Maintenance_Priority_AdServer class,
                // and run the prioritisation process
                require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer.php';
                $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
                $oMaintenancePriority->updatePriorities();
            }
        }
        // Release the MPE database-level lock
        $result = $oDal->releasePriorityLock();
        if (PEAR::isError($result)) {
            // Unable to continue!
            MAX::raiseError($result, null, PEAR_ERROR_DIE);
        }
        // Log the end of the process
        MAX::debug('Maintenance Priority Engine Completed', PEAR_LOG_INFO);
    }

}

?>
