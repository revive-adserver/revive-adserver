<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';

require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';

/**
 * A library class for providing automatic maintenance process methods.
 *
 * @static
 * @package    Openads
 * @subpackage Maintenance
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class OA_Maintenance_Auto
{
    function run()
    {
    	// Make sure that the output is sent to the browser before
    	// loading libraries and connecting to the db
    	flush();

    	MAX_Admin_Preferences::loadPrefs(0);

        $aConf = $GLOBALS['_MAX']['CONF'];
        $aPref = $GLOBALS['_MAX']['PREF'];

    	$iLastRun = $aPref['maintenance_timestamp'];

    	// Make sure that negative values don't break the script
    	if ($iLastRun > 0) {
    		$iLastRun = strtotime(date('Y-m-d H:00:05', $iLastRun));
    	}

    	if (time() >= $iLastRun + 3600)
    	{
    	    $oLock =& OA_DB_AdvisoryLock::factory();

    		if ($oLock->get(OA_DB_ADVISORYLOCK_MAINTENANCE))
    		{
    			require_once MAX_PATH . '/lib/max/Maintenance.php';

    			$oMaint =& new MAX_Maintenance();

    			$oMaint->run();

    			$oLock->release();
    		}
    	}
    }
}

?>