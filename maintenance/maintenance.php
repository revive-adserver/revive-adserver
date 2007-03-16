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



// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', ereg_replace("[/\\\\]maintenance[/\\\\][^/\\\\]+$", '', __FILE__));
else
    define ('phpAds_path', '..');



// Include required files
require (phpAds_path."/config.inc.php");
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");
require (phpAds_path."/libraries/lib-dbconfig.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");

if (!defined('LIBUSERLOG_INCLUDED'))
	require (phpAds_path."/libraries/lib-userlog.inc.php");

require (phpAds_path."/libraries/lib-log.inc.php");
require (phpAds_path."/maintenance/lib-maintenance.inc.php");


// Register input variables
phpAds_registerGlobal ('priority_only');



// Make database connection and load config
phpAds_dbConnect();
phpAds_LoadDbConfig();

// Set maintenance usertype
phpAds_userlogSetUser (phpAds_userMaintenance);

// Check if we only need to recalculate priorities
$priority_only = !empty($priority_only);

if (!$priority_only)
{
	// Sometimes cron jobs could start before the exact minute they were set,
	// especially if many are scheduled at the same time (e.g. midnight)
	//
	// Wait a few seconds if needed, to ensure all goes well, otherwise
	// maintenance won't work as it should
	
	if (date('i') == 59 && date('s') >= 45)
		sleep(60 - date('s'));
	
	// Run distributed stats maintenance
	if ($phpAds_config['lb_enabled'])
		include (phpAds_path."/maintenance/maintenance-distributed.php");
}

// Finally run maintenance
if (phpAds_performMaintenance($priority_only))
{
	if (!$priority_only)
	{
		// Update the timestamp
		$res = phpAds_dbQuery ("
			UPDATE
				".$phpAds_config['tbl_config']."
			SET
				maintenance_cron_timestamp = '".time()."'
		");
	}
}

?>