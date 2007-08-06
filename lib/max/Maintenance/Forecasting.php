<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * A wrapper class for running the Maintenance Forecasting Engine process.
 *
 * @static
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Forecasting
{

    /**
     * The method to run the Maintenance Forecasting Engine process.
     *
     * @static
     */
    function run()
    {
        // Get the configuration
        $conf = $GLOBALS['_MAX']['CONF'];
        // Log the start of the process
        MAX::debug('Running Maintenance Forecasting Engine', PEAR_LOG_INFO);
        // Set longer time out, and ignore user abort
        if (!ini_get('safe_mode')) {
            @set_time_limit($conf['maintenance']['timeLimitScripts']);
            @ignore_user_abort(true);
        }
        
        // Attempt to increase PHP memory
        increaseMemoryLimit($GLOBALS['_MAX']['REQUIRED_MEMORY']['MAINTENANCE']);
        
        // Ensure the the current time is registered with the ServiceLocator
        $oServiceLocator = &ServiceLocator::instance();
        $oDate = &$oServiceLocator->get('now');
        if (!$oDate) {
            // Record the current time, and register with the ServiceLocator
            $oDate = new Date();
            $oServiceLocator->register('now', $oDate);
        }
        // Run the MFE process for the AdServer module ONLY (at this stage :-)
        foreach ($conf['modules'] as $module => $installed) {
            if (($module == 'AdServer') && $installed) {
                // Create the MAX_Maintenance_Forecasting_AdServer class,
                // and run the forecasting process
                require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer.php';
                $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
                $oMaintenanceForecasting->updateForecasts();
            }
        }
        // Log the end of the process
        MAX::debug('Maintenance Forecasting Engine Completed', PEAR_LOG_INFO);
    }

}

?>
