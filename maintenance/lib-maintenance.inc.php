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



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



// Defaults
if (!defined('phpAds_LastMidnight'))
	define('phpAds_LastMidnight', mktime(0, 0, 0, date('m'), date('d'), date('Y')));

// Set up constants
define('PHPADS_MAINT_TYPE_REGULAR',		0);
define('PHPADS_MAINT_TYPE_PRIORITY',	1);
define('PHPADS_MAINT_TYPE_CLEARCACHE',	2);



function phpAds_performMaintenance($maintenance_type = PHPADS_MAINT_TYPE_REGULAR)
{
	global $phpAds_config;
	
	// Include required files
	if (!defined('LIBLOCKS_INCLUDED'))
		require (phpAds_path.'/libraries/lib-locks.inc.php');

	// Aquire maintenance lock to ensure that maintenance runs only once
	if ($lock = phpAds_maintenanceGetLock())
	{
		// Set time limit and ignore user abort
		if (!get_cfg_var ('safe_mode')) 
		{
			@set_time_limit(300);
			@ignore_user_abort(1);
		}
		
		// Include required files
		if (!defined('LIBMAIL_INCLUDED'))
			require (phpAds_path."/libraries/lib-mail.inc.php");
		if (!defined('LIBADMINSTATISTICS_INCLUDED'))
			require (phpAds_path."/admin/lib-statistics.inc.php");
		if (!defined('LIBADMINCONFIG_INCLUDED'))
			require	(phpAds_path."/admin/lib-config.inc.php"); 
	
		// Load language strings
		@include (phpAds_path.'/language/english/default.lang.php');
		if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
			@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
		
		if ($maintenance_type == PHPADS_MAINT_TYPE_REGULAR)
		{			
			// Update the timestamp
			$res = phpAds_dbQuery ("
				UPDATE
					".$phpAds_config['tbl_config']."
				SET
					maintenance_timestamp = '".time()."'
			");
			
			// Run different maintenance tasks on midnight or soon after if the last run was before midnight
			if ($phpAds_config['maintenance_timestamp'] < phpAds_LastMidnight)
			{
				include (phpAds_path."/maintenance/maintenance-reports.php");
				include (phpAds_path."/maintenance/maintenance-autotargeting.php");
				include (phpAds_path."/maintenance/maintenance-geotargeting.php");
				include (phpAds_path."/maintenance/maintenance-cleantables.php");
				include (phpAds_path."/maintenance/maintenance-openadssync.php");
			}
			
			// Always run activation, it will run lb-only tasks if midnight maintenance has already run
			include (phpAds_path."/maintenance/maintenance-activation.php");
		}		
		
		// Release maintenance lock
		phpAds_maintenanceReleaseLock($lock);
		
		// Run priority only when needed
		if ($maintenance_type != PHPADS_MAINT_TYPE_CLEARCACHE)
			include (phpAds_path."/maintenance/maintenance-priority.php");
		
		// Acquire priority lock, waiting for the task completion
		if (true) // $dclock = phpAds_maintenanceGetLock(phpAds_lockPriority, phpAds_lockTimeDeliveryCache))
		{
			// Rebuild cache
			if (!defined('LIBVIEWCACHE_INCLUDED')) 
				include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
			
			phpAds_cacheDelete();
			
			// Sleep for 1 second to avoid load balanced webservers to
			// connect to the main db at the same time
			sleep(1);
			
			// Release lock
			//phpAds_maintenanceReleaseLock($dclock);
		}
		
		return true;
	}
	
	return false;
}

?>