<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
require ("../lib-priority.inc.php");


// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientid) && $clientid != '')
{
	// Delete Client
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			clientid = '$clientid'
		") or phpAds_sqlDie();
	
	
	// Loop thourgh each campaign
	$res_campaign = phpAds_dbQuery("
		SELECT
			clientid
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = $clientid
		") or phpAds_sqlDie();
	
	
	while ($row_campaign = phpAds_dbFetchArray($res_campaign))
	{
		// Delete Campaign
		$res = phpAds_dbQuery("
			DELETE FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				clientid = ".$row_campaign['clientid']."
			") or phpAds_sqlDie();
		
		
		// Loop through each banner
		$res_banners = phpAds_dbQuery("
			SELECT
				bannerid,
				storagetype,
				filename
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				clientid = ".$row_campaign['clientid']."
			") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res_banners))
		{
			// Cleanup stored images for each banner
			if (($row['storagetype'] == 'web' || $row['storagetype'] == 'sql') && $row['filename'] != '')
				phpAds_ImageDelete ($row['storagetype'], $row['filename']);
			
			
			// Delete Banner ACLs
			phpAds_dbQuery("
				DELETE FROM
					".$phpAds_config['tbl_acls']."
				WHERE
					bannerid = ".$row['bannerid']."
				") or phpAds_sqlDie();
			
			
			// Delete stats for each banner
			phpAds_deleteStats($row['bannerid']);
		}
		
		
		// Delete Banners
		phpAds_dbQuery("
			DELETE FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				clientid = ".$row_campaign['clientid']."
			") or phpAds_sqlDie();
	}
}

// Rebuild priorities
phpAds_PriorityCalculate ();


// Rebuild cache
if (!defined('LIBVIEWCACHE_INCLUDED')) 
	include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');

phpAds_cacheDelete();


if (!isset($returnurl) && $returnurl == '')
	$returnurl = 'client-index.php';

header("Location: ".$returnurl);

?>