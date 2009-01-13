<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

setupIncludePath();

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';

require_once OX_PATH . '/lib/OX.php';

/**
 * A library class for providing automatic maintenance process methods.
 *
 * @static
 * @package    OpenXMaintenance
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Maintenance_Auto
{
    function run()
    {
    	// Make sure that the output is sent to the browser before
    	// loading libraries and connecting to the db
    	flush();

        $aConf = $GLOBALS['_MAX']['CONF'];

        // Set longer time out, and ignore user abort
        if (!ini_get('safe_mode')) {
            @set_time_limit($aConf['maintenance']['timeLimitScripts']);
            @ignore_user_abort(true);
        }

	    if (!defined('OA_VERSION')) {
	        // If the code is executed inside delivery, the constants
	        // need to be initialized
    	    require_once MAX_PATH . '/constants.php';
    	    setupConstants();
	    }

	    $oLock =& OA_DB_AdvisoryLock::factory();

		if ($oLock->get(OA_DB_ADVISORYLOCK_MAINTENANCE))
		{
            OA::debug('Running Automatic Maintenance Task', PEAR_LOG_INFO);

        	OA_Preferences::loadAdminAccountPreferences();

		    require_once LIB_PATH . '/Maintenance.php';
			$oMaint = new OX_Maintenance();
			$oMaint->run();
			$oLock->release();

			OA::debug('Automatic Maintenance Task Completed', PEAR_LOG_INFO);
		} else {
			OA::debug('Automatic Maintenance Task not run: could not acquire lock', PEAR_LOG_INFO);
		}
    }
}

?>