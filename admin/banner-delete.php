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

if (isset($bannerID) && $bannerID != '')
{
	// Cleanup webserver stored image
	$res = db_query("
		SELECT
			banner, format
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	if ($row = mysql_fetch_array($res))
	{
		if ($row['format'] == 'web' && $row['banner'] != '')
			phpAds_Cleanup (basename($row['banner']));
	}
	
	// Delete banner
	$res = db_query("
		DELETE FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	
	// Delete banner ACLs
	$res = db_query("
		DELETE FROM
			$phpAds_tbl_acls
		WHERE
			bannerID = $bannerID
		") or mysql_die();
	
	// Delete statistics for this banner
	db_delete_stats($bannerID);
}

// Rebuild zone cache
if ($phpAds_zone_cache)
	phpAds_RebuildZoneCache ();

Header("Location: campaign-index.php?campaignID=$campaignID&message=".urlencode($strBannerDeleted));

?>
