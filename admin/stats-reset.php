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
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('all');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Banner
if (isset($bannerid) && $bannerid != '')
{
    // Delete stats for this banner
	phpAds_deleteStats($bannerid);
	
	// Return to campaign statistics
	Header("Location: stats-campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);
}


// Campaign
elseif (isset($campaignid) && $campaignid != '')
{
	// Get all banners for this client
	$idresult = phpAds_dbQuery(" SELECT
								bannerid
							  FROM
							  	".$phpAds_config['tbl_banners']."
							  WHERE
								clientid = '$campaignid'
		  				 ");
	
	// Loop to all banners for this client
	while ($row = phpAds_dbFetchArray($idresult))
	{
		// Delete stats for the banner
		phpAds_deleteStats($row['bannerid']);
	}
	
	// Return to campaign statistics
	Header("Location: stats-client-campaigns.php?clientid=".$clientid);
}


// Client
elseif (isset($clientid) && $clientid != '')
{
	// Get all banners for this client
	$idresult = phpAds_dbQuery("
		SELECT
			b.bannerid
		FROM
			".$phpAds_config['tbl_banners']." AS b,
			".$phpAds_config['tbl_clients']." AS c
		WHERE
			c.parent = $clientid AND
			c.clientid = b.clientid
	");
	
	// Loop to all banners for this client
	while ($row = phpAds_dbFetchArray($idresult))
	{
		// Delete stats for the banner
		phpAds_deleteStats($row['bannerid']);
	}
	
	// Return to campaign statistics
	Header("Location: stats-global-client.php");
}


// All
elseif (isset($all) && $all == 'tr'.'ue')
{
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adviews']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adclicks']) or phpAds_sqlDie();
    phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adstats']) or phpAds_sqlDie();
	
	// Return to campaign statistics
	Header("Location: stats-global-client.php");
}
?>