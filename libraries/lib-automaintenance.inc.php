<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Set define to prevent duplicate include
define ('LIBAUTOMAINTENANCE_INCLUDED', true);


// Include required files
if (!defined('LIBDBCONFIG_INCLUDED'))
	require (phpAds_path.'/libraries/lib-dbconfig.inc.php');



function phpAds_performAutoMaintenance()
{
	global $phpAds_config;

	// Make sure that the output is sent to the browser before
	// loading libraries and connecting to the db
	flush();

	// Include required files
	if (!defined('LIBLOCKS_INCLUDED'))
		require (phpAds_path.'/libraries/lib-locks.inc.php');
		
	// Load config from the db
	phpAds_LoadDbConfig();
	
	$last_run = $phpAds_config['maintenance_timestamp'];
	
	// Make sure that negative values don't break the script
	if ($last_run > 0)
		$last_run = strtotime(date('Y-m-d H:00:05', $last_run));
	
	if (time() >= $last_run + 3600)
	{
		if ($amlock = phpAds_maintenanceGetLock())
		{
			if (!defined('LIBUSERLOG_INCLUDED'))
				require (phpAds_path."/libraries/lib-userlog.inc.php");
			
			require (phpAds_path."/maintenance/lib-maintenance.inc.php");

			// Got the advisory lock, we can proceed running maintenance
			phpAds_userlogSetUser (phpAds_userAutoMaintenance);

			// Finally run maintenance
			phpAds_performMaintenance();
			
			// Release lock, although it was already released by maintenance
			phpAds_maintenanceReleaseLock($amlock);
		}
	}
}

?>
