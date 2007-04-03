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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';

require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
require_once MAX_PATH . '/lib/OA/DB/Distributed.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Distributed.php';

/**
 * A library class for providing automatic maintenance process methods.
 *
 * @static
 * @package    Openads
 * @subpackage Maintenance
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class OA_Maintenance_Distributed
{
    function run()
    {
        $oLock =& OA_DB_AdvisoryLock::factory();

    	if ($oLock->get(OA_DB_ADVISORYLOCK_DISTIRBUTED))
    	{
            MAX::debug('Running Distributed Statistics Engine', PEAR_LOG_INFO);

    	    $oDal  =& new OA_Dal_Maintenance_Distributed();

            $oStart = $oDal->getMaintenanceDistributedLastRunInfo();

            // Ensure the the current time is registered with the ServiceLocator
            $oServiceLocator = &ServiceLocator::instance();
            $oEnd = &$oServiceLocator->get('now');
            if (!$oEnd) {
                // Record the current time, and register with the ServiceLocator
                $oEnd = new Date();
                $oServiceLocator->register('now', $oEnd);
            }

            // Copy statistics up to the previous second
            $oEnd->subtractSeconds(1);

            $oDal->processTable('data_raw_ad_impression', $oStart, $oEnd);
            $oDal->processTable('data_raw_ad_click', $oStart, $oEnd);

            $oDal->setMaintenanceDistributedLastRunInfo($oEnd);

    		$oLock->release();

            MAX::debug('Distributed Statistics Engine Completed', PEAR_LOG_INFO);
    	} else {
            MAX::debug('Distributed Statistics Engine Already Running', PEAR_LOG_INFO);
    	}
    }
}

?>