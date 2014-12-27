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