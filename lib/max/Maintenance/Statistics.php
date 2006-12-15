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
$Id$
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/Max.php';

/**
 * A wrapper class for running the Maintenance Statistics Engine process.
 *
 * @static
 * @package    MaxMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Statistics
{

    /**
     * The method to run the Maintenance Statistics Engine process.
     *
     * @static
     */
    function run()
    {
        // Get the configuration
        $conf = $GLOBALS['_MAX']['CONF'];
        // Log the start of the process
        MAX::debug('Running Maintenance Statistics Engine', PEAR_LOG_INFO);
        // Set longer time out, and ignore user abort
        if (!ini_get('safe_mode')) {
            @set_time_limit($conf['maintenance']['timeLimitScripts']);
            @ignore_user_abort(true);
        }
        // Ensure the the current time is registered with the ServiceLocator
        $oServiceLocator = &ServiceLocator::instance();
        $oDate = &$oServiceLocator->get('now');
        if (!$oDate) {
            // Record the current time, and register with the ServiceLocator
            $oDate = new Date();
            $oServiceLocator->register('now', $oDate);
        }
        // Run the MSE process for all installed modules
        foreach ($conf['modules'] as $module => $installed) {
            if ($installed) {
                // Create the MAX_Maintenance_Statistics_MODULE class,
                // and run the statistics process
                require_once MAX_PATH . '/lib/max/Maintenance/Statistics/' . $module . '.php';
                $className = 'MAX_Maintenance_Statistics_' . $module;
                $oMaintenanceStatistics = new $className();
                $oMaintenanceStatistics->updateStatistics();
            }
        }
        // Log the end of the process
        MAX::debug('Maintenance Statistics Engine Completed', PEAR_LOG_INFO);
    }

}

?>
