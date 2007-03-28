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
		include('../libraries/lib-openadssync.inc.php');
		
		if ($phpAds_config['updates_cache'])
			$update_check = unserialize($phpAds_config['updates_cache']);

		
		// If cache timestamp not set or older than 24hrs, re-sync
		if (isset($phpAds_config['updates_timestamp']) && $phpAds_config['updates_timestamp'] + 86400 < time())
		{
			$res = phpAds_checkForUpdates();
			
			if ($res[0] == 0)
				$update_check = $res[1];
		}
		
		if (!is_array($update_check) || $update_check['config_version'] <= $phpAds_config['updates_last_seen'])
			$update_check = array(800, false);
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

			// Register data inside a session var, so it doesn't need to be re-downloaded
			phpAds_SessionDataRegister('maint_update', $update_check);
			phpAds_SessionDataStore();
		}
	}
	
	phpAds_SessionDataRegister('maint_update_js', true);
	phpAds_SessionDataStore();
	
	// Add Product Update redirector
	if (isset($update_check[0]) && $update_check[0] == 0)
	{
		header("Content-Type: application/x-javascript");
		
		if ($update_check[1]['security_fix'])
			echo "alert('".$strUpdateAlertSecurity."');\n";
		else
			echo "if (confirm('".$strUpdateAlert."'))\n\t";
		
		echo "document.location.replace('maintenance-updates.php');\n";
	}
}

?>