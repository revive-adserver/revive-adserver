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



// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', ereg_replace("[/\\\\]maintenance[/\\\\][^/\\\\]+$", '', __FILE__));
else
    define ('phpAds_path', '..');



// Include required files
require (phpAds_path."/config.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");
require (phpAds_path."/libraries/lib-dbconfig.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");
require (phpAds_path."/libraries/lib-userlog.inc.php");
require (phpAds_path."/maintenance/lib-maintenance.inc.php");



// Make database connection and load config
phpAds_dbConnect();
phpAds_LoadDbConfig();

// Set maintenance usertype
phpAds_userlogSetUser (phpAds_userMaintenance);


// Sometimes cron jobs could start before the exact minute they were set,
// especially if many are scheduled at the same time (e.g. midnight)
//
// Wait a few seconds if needed, to ensure all goes well, otherwise
// maintenance won't work as it should

if (date('i') == 59 && date('s') >= 45)
	sleep(60 - date('s'));


// Finally run maintenance
if (phpAds_performMaintenance())
{
	// Update the timestamp
	$res = phpAds_dbQuery ("
		UPDATE
			".$phpAds_config['tbl_config']."
		SET
			maintenance_cron_timestamp = '".time()."'
	");
}

?>