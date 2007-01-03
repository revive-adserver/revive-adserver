<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Set define to prevent duplicate include
define ('LIBAUTOMAINTENANCE_INCLUDED', true);


// Include required files
if (!defined('LIBDBCONFIG_INCLUDED'))
{
	include (phpAds_path.'/libraries/lib-dbconfig.inc.php');
}



function phpAds_performAutoMaintenance()
{
	global $phpAds_config;

	// Make sure that the output is sent to the browser before
	// loading libraries and connecting to the db
	flush();

	// Load config from the db
	phpAds_LoadDbConfig();
	
	$last_run = floor($phpAds_config['maintenance_timestamp'] / 3600) * 3600;
	
	if (time() >= $last_run + 75 * 60)
	{
		// Maintenance wasn't run in the last 1:15
		$lock_name = addslashes('pan.'.$phpAds_config['instance_id']);
		
		if (phpAds_dbResult(phpAds_dbQuery("SELECT GET_LOCK('{$lock_name}', 0)"), 0, 0))
		{
			require (phpAds_path."/libraries/lib-userlog.inc.php");
			require (phpAds_path."/maintenance/lib-maintenance.inc.php");

			// Got the advisory lock, we can proceed running maintenance
			phpAds_userlogSetUser (phpAds_userAutoMaintenance);

			// Finally run maintenance
			phpAds_performMaintenance();
			
			// Release lock
			phpAds_dbQuery("SELECT RELEASE_LOCK('{$lock_name}')");
		}
	}
}

?>