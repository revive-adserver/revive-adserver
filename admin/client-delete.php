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
require ("lib-statistics.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientID) && $clientID != '')
{
	// Delete Client
	$res = phpAds_dbQuery("
		DELETE FROM
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or phpAds_sqlDie();
	
	
	// Loop thourgh each campaign
	$res_campaign = phpAds_dbQuery("
		SELECT
			clientID
		FROM
			$phpAds_tbl_clients
		WHERE
			parent = $clientID
		") or phpAds_sqlDie();
	
	while ($row_campaign = phpAds_dbFetchArray($res_campaign))
	{
		// Delete Campaign
		$res = phpAds_dbQuery("
			DELETE FROM
				$phpAds_tbl_clients
			WHERE
				clientID = ".$row_campaign['clientID']."
			") or phpAds_sqlDie();
		
		
		// Loop through each banner
		$res_banners = phpAds_dbQuery("
			SELECT
				bannerID,
				format,
				banner
			FROM
				$phpAds_tbl_banners
			WHERE
				clientID = ".$row_campaign['clientID']."
			") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res_banners))
		{
			// Cleanup webserver stored images for each banner
			if ($row['format'] == 'web' && $row['banner'] != '')
				phpAds_Cleanup (basename($row['banner']));		
			
			
			// Delete Banner ACLs
			phpAds_dbQuery("
				DELETE FROM
					$phpAds_tbl_acls
				WHERE
					bannerID = ".$row['bannerID']."
				") or phpAds_sqlDie();
			
			
			// Delete stats for each banner
			phpAds_deleteStats($row['bannerID']);
		}
		
		
		// Delete Banners
		phpAds_dbQuery("
			DELETE FROM
				$phpAds_tbl_banners
			WHERE
				clientID = ".$row_campaign['clientID']."
			") or phpAds_sqlDie();
	}
}

// Rebuild zone cache
if ($phpAds_zone_cache)
	phpAds_RebuildZoneCache ();

header("Location: client-index.php");

?>
