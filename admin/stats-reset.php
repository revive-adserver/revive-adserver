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


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Banner
if (isset($bannerID) && $bannerID != '')
{
    // Delete stats for this banner
	db_delete_stats($bannerID);
	
	// Return to campaign statistics
	Header("Location: stats-campaign.php?campaignID=$campaignID");
}


// Campaign
elseif (isset($campaignID) && $campaignID != '')
{
	// Get all banners for this client
	$idresult = db_query (" SELECT
								bannerID
							  FROM
							  	$phpAds_tbl_banners
							  WHERE
								clientID = $campaignID
		  				 ");
	
	// Loop to all banners for this client
	while ($row = mysql_fetch_array($idresult))
	{
		// Delete stats for the banner
		db_delete_stats($row['bannerID']);
	}
	
	// Return to campaign statistics
	Header("Location: stats-campaign.php?campaignID=$campaignID");
}


// Client
elseif (isset($clientID) && $clientID != '')
{
	// Get all banners for this client
	$idresult = db_query (" SELECT
								$phpAds_tbl_banners.bannerID
							  FROM
							  	$phpAds_tbl_banners, $phpAds_tbl_clients
							  WHERE
							  	$phpAds_tbl_clients.parent = $clientID AND
								$phpAds_tbl_clients.clientID = $phpAds_tbl_banners.clientID
		  				 ");
	
	// Loop to all banners for this client
	while ($row = mysql_fetch_array($idresult))
	{
		// Delete stats for the banner
		db_delete_stats($row['bannerID']);
	}
	
	// Return to campaign statistics
	Header("Location: stats-client.php?clientID=$clientID");
}


// All
elseif (isset($all) && $all == 'true')
{
    @db_query("DELETE FROM $phpAds_tbl_adviews") or mysql_die();
    @db_query("DELETE FROM $phpAds_tbl_adclicks") or mysql_die();
    @db_query("DELETE FROM $phpAds_tbl_adstats") or mysql_die();
	
	// Return to campaign statistics
	Header("Location: stats-index.php");
}
?>
