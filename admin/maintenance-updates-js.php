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



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");


/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Check for product updates when the admin logs in
if (phpAds_isUser(phpAds_Admin))
{
	$update_check = false;
	
	// Check accordingly to user preferences
	if ($phpAds_config['updates_enabled'])
	{
		include('../libraries/lib-liveupdate.inc.php');
		
		if ($phpAds_config['updates_cache'])
			$update_check = unserialize($phpAds_config['updates_cache']);
		
		if (!is_array($update_check) || $update_check['config_version'] <= $phpAds_config['updates_last_seen'])
			$update_check = false;
		else
		{
			// Make sure that the alert doesn't display everytime
			phpAds_dbQuery("
				UPDATE
					".$phpAds_config['tbl_config']."
				SET
					updates_last_seen = '".addslashes($update_check['config_version'])."'
			");
		
			// Format like the XML-RPC response
			$update_check = array(0, $update_check);
		}
	}
	
	phpAds_SessionDataRegister('update_check', $update_check);
	phpAds_SessionDataStore();
	
	// Add Product Update redirector
	if ($update_check)
	{
		Header("Content-Type: application/x-javascript");
		
		if ($Session['update_check'][1]['security_fix'])
			echo "\t\t\talert('".$strUpdateAlertSecurity."');\n";
		else
			echo "\t\t\tif (confirm('".$strUpdateAlert."'))\n\t";
		
		echo "\t\tdocument.location.replace('maintenance-updates.php');\n";
	}
}

?>