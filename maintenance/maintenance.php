<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', ereg_replace("[/\\\\]maintenance[/\\\\][^/\\\\]+$", '', __FILE__));
else
    define ('phpAds_path', '..');


// Set time limit and ignore user abort
if (!get_cfg_var ('safe_mode')) 
{
	@set_time_limit (300);
	@ignore_user_abort(1);
}



// Include required files
require (phpAds_path."/config.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");
require (phpAds_path."/libraries/lib-dbconfig.inc.php");
require (phpAds_path."/libraries/lib-mail.inc.php");
require (phpAds_path."/libraries/lib-userlog.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");
require (phpAds_path."/admin/lib-statistics.inc.php");



// Make database connection and load config
phpAds_dbConnect();
phpAds_LoadDbConfig();

// Load language strings
@include (phpAds_path.'/language/english/default.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');

// Set maintenance usertype
phpAds_userlogSetUser (phpAds_userMaintenance);


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
	include ("maintenance-reports.php");
	include ("maintenance-activation.php");
	include ("maintenance-autotargeting.php");
	include ("maintenance-cleantables.php");
}

include ("maintenance-priority.php");


// Rebuild cache
if (!defined('LIBVIEWCACHE_INCLUDED')) 
	include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');

phpAds_cacheDelete();

?>