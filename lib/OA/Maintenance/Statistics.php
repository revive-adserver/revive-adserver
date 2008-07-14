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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Tracker.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A wrapper class for running the Maintenance Statistics Engine process.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Statistics
{

    /**
     * The method to run the Maintenance Statistics Engine process.
     *
     * @static
     */
    function run()
    {
        OA::switchLogFile('maintenance');

        // Get the configuration
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Log the start of the process
        OA::debug('Running Maintenance Statistics Engine', PEAR_LOG_INFO);

        // Set longer time out, and ignore user abort
        if (!ini_get('safe_mode')) {
            @set_time_limit($aConf['maintenance']['timeLimitScripts']);
            @ignore_user_abort(true);
        }

        // Run the following code as the "Maintenance" user
        OA_Permission::switchToSystemProcessUser('Maintenance');

        // Ensure the the current time is registered with the OA_ServiceLocator
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDate = &$oServiceLocator->get('now');
        if (!$oDate) {
            // Record the current time, and register with the OA_ServiceLocator
            $oDate = new Date();
            $oServiceLocator->register('now', $oDate);
        }

        // Run the MSE process for the AdServer and Tracker modules
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateStatistics();
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_Tracker();
        $oMaintenanceStatistics->updateStatistics();

        // Return to the "normal" user
        OA_Permission::switchToSystemProcessUser();

        // Log the end of the process
        OA::debug('Maintenance Statistics Engine Completed', PEAR_LOG_INFO);
        OA::switchLogFile();
    }

}

?>
