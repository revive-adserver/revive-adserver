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
require ("../lib-priority.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_DeleteBanner($bannerid)
{
	global $phpAds_config;
	
	// Cleanup webserver stored image
	$res = phpAds_dbQuery("
		SELECT
			storagetype, filename
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
	") or phpAds_sqlDie();
	
	if ($row = phpAds_dbFetchArray($res))
	{
		if (($row['storagetype'] == 'web' || $row['storagetype'] == 'sql') && $row['filename'] != '')
			phpAds_ImageDelete ($row['storagetype'], $row['filename']);
	}
	
	// Delete banner
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
		") or phpAds_sqlDie();
	
	// Delete banner ACLs
	$res = phpAds_dbQuery("
		DELETE FROM
			".$phpAds_config['tbl_acls']."
		WHERE
			bannerid = $bannerid
		") or phpAds_sqlDie();
	
	// Delete statistics for this banner
	phpAds_deleteStats($bannerid);
}

if (isset($bannerid) && $bannerid != '')
{
	phpAds_DeleteBanner($bannerid);
}
elseif (isset($campaignid) && $campaignid != '')
{
	$res = phpAds_dbQuery("
		SELECT
			bannerid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = $campaignid
	");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_DeleteBanner($row['bannerid']);
	}
}


// Rebuild zone cache
if ($phpAds_config['zone_cache'])
	phpAds_RebuildZoneCache ();

// Rebuild priorities
phpAds_PriorityCalculate ();

Header("Location: ".$returnurl."?clientid=".$clientid."&campaignid=".$campaignid);

?>
