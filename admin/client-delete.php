<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-storage.inc.php");
require ("lib-zones.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientID) && $clientID != '')
{
	// Delete Client
	$res = db_query("
		DELETE FROM
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or mysql_die();
	
	
	// Loop thourgh each campaign
	$res_campaign = db_query("
		SELECT
			clientID
		FROM
			$phpAds_tbl_clients
		WHERE
			parent = $clientID
		") or mysql_die();
	
	while ($row_campaign = mysql_fetch_array($res_campaign))
	{
		// Delete Campaign
		$res = db_query("
			DELETE FROM
				$phpAds_tbl_clients
			WHERE
				clientID = ".$row_campaign['clientID']."
			") or mysql_die();
		
		
		// Loop through each banner
		$res_banners = db_query("
			SELECT
				bannerID,
				format,
				banner
			FROM
				$phpAds_tbl_banners
			WHERE
				clientID = ".$row_campaign['clientID']."
			") or mysql_die();
		
		while ($row = mysql_fetch_array($res_banners))
		{
			// Cleanup webserver stored images for each banner
			if ($row['format'] == 'web' && $row['banner'] != '')
				phpAds_Cleanup (basename($row['banner']));		
			
			
			// Delete Banner ACLs
			db_query("
				DELETE FROM
					$phpAds_tbl_acls
				WHERE
					bannerID = ".$row['bannerID']."
				") or mysql_die();
			
			
			// Delete stats for each banner
			db_delete_stats($row['bannerID']);
		}
		
		
		// Delete Banners
		db_query("
			DELETE FROM
				$phpAds_tbl_banners
			WHERE
				clientID = ".$row_campaign['clientID']."
			") or mysql_die();
	}
}

// Rebuild zone cache
if ($phpAds_zone_cache)
	phpAds_RebuildZoneCache ();

header("Location: client-index.php");

?>
