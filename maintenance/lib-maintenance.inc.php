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



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



function phpAds_performMaintenance()
{
	global $phpAds_config;
	
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
	
	// Update the timestamp
	$res = phpAds_dbQuery ("
		UPDATE
			".$phpAds_config['tbl_config']."
		SET
			maintenance_timestamp = '".time()."'
	");
	
	
	// Run different maintenance tasks
	if (date('H') == 0)
	{
		include (phpAds_path."/maintenance/maintenance-reports.php");
		include (phpAds_path."/maintenance/maintenance-activation.php");
		include (phpAds_path."/maintenance/maintenance-autotargeting.php");
		include (phpAds_path."/maintenance/maintenance-geotargeting.php");
		include (phpAds_path."/maintenance/maintenance-cleantables.php");
		include (phpAds_path."/maintenance/maintenance-openadssync.php");
	}
	
	include (phpAds_path."/maintenance/maintenance-priority.php");
	
	
	// Rebuild cache
	if (!defined('LIBVIEWCACHE_INCLUDED')) 
		include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
	
	phpAds_cacheDelete();
}

?>