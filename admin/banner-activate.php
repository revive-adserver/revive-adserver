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
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if ($value == "true")
	$value = "false";
else
	$value = "true";

if (phpAds_isUser(phpAds_Client))
{
	if (($value == 'false' && phpAds_isAllowed(phpAds_DisableBanner)) || 
	    ($value == 'true' && phpAds_isAllowed(phpAds_ActivateBanner)))
	{
		$result = phpAds_dbQuery("
			SELECT
				clientID
			FROM
				$phpAds_tbl_banners
			WHERE
				bannerID = $bannerID
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["clientID"] == '' || phpAds_clientID() != phpAds_getParentID ($row["clientID"]))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignID = $row["clientID"];
			
			$res = phpAds_dbQuery("
				UPDATE
					$phpAds_tbl_banners
				SET
					active = '$value'
				WHERE
					bannerID = $bannerID
				") or phpAds_sqlDie();
			
			// Rebuild zone cache
			if ($phpAds_zone_cache)
				phpAds_RebuildZoneCache ();
			
			Header("Location: stats-campaign.php?campaignID=$campaignID&message=".urlencode($strBannerChanged));
		}
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}


if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery("
		UPDATE
			$phpAds_tbl_banners
		SET
			active = '$value'
		WHERE
			bannerID = $bannerID
		") or phpAds_sqlDie();
	
	// Rebuild zone cache
	if ($phpAds_zone_cache)
		phpAds_RebuildZoneCache ();
	
	Header("Location: campaign-index.php?campaignID=$campaignID&message=".urlencode($strBannerChanged));
}


?>
