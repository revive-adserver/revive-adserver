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
require ("../config.inc.php");
require ("lib-permissions.inc.php");
require ("lib-gui.inc.php");
require ("../view.inc.php");


// Open the database connection
$link = phpAds_dbConnect();
if (!$link)
{
	phpAds_PageHeader('');
	phpAds_Die ("An fatal error occurred", "phpAdsNew can't connect to the database, 
										 please make sure the database is working 
										 and phpAdsNew is configured correctly");
}




// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
unset($Session);

// Authorize the user and load user specific settings.
phpAds_Start();


// Load language strings
require ("../language/".strtolower($phpAds_language).".inc.php");


if (!isset($clientID))   $clientID = '';
if (!isset($campaignID)) $campaignID = '';
if (!isset($bannerID))   $bannerID = '';


// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		"2"					=>  array("stats-index.php" => $strStats),
 	  	  "2.1"				=>  array("stats-index.php" => $strClientsAndCampaigns),
		    "2.1.1"			=>  array("stats-client.php?clientID=$clientID" => $strClientStats),
		    "2.1.2"			=> 	array("stats-campaign.php?campaignID=$campaignID" => $strCampaignStats),
    	      "2.1.2.1" 	=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => $strDetailStats),
		        "2.1.2.1.1" => 	array("stats-daily.php" => $strDailyStats),
		    "2.1.3"		 	=> 	array("stats-campaign-history.php?campaignID=$campaignID" => $strHistory),
	        "2.1.4" 		=> 	array("stats-weekly.php?campaignID=$campaignID" => $strWeeklyStats),
		  "2.2"				=>  array("stats-history.php" => $strHistory),
	      "2.3"		 		=> 	array("stats-weekly.php?campaignID=0" => $strWeeklyStats),
		"3"					=>  array("report-index.php" => $strReports),
		"4"					=>	array("client-index.php" => $strAdminstration),
		  "4.1"				=>	array("client-index.php" => $strClientsAndCampaigns),
		    "4.1.1"			=> 	array("client-edit.php?clientID=0" => $strAddClient),
		    "4.1.2"			=> 	array("client-edit.php?clientID=$clientID" => $strModifyClient),
		    "4.1.3"			=>  array("campaign-edit.php?campaignID=0" => $strCreateNewCampaign),
		    "4.1.4"			=>	array("campaign-edit.php?campaignID=$campaignID" => $strModifyCampaign),
		    "4.1.5"			=> 	array("campaign-index.php?campaignID=$campaignID" => $strCampaignOverview),
		      "4.1.5.1"		=> 	array("banner-edit.php?campaignID=$campaignID&bannerID=0" => $strAddBanner),
		      "4.1.5.2"		=> 	array("banner-edit.php?campaignID=$campaignID&bannerID=$bannerID" => $strModifyBanner),
		      "4.1.5.3"		=> 	array("banner-acl.php?campaignID=$campaignID&bannerID=$bannerID" => $strModifyBannerAcl),
		      "4.1.5.4"		=> 	array("banner-zone.php?campaignID=$campaignID&bannerID=$bannerID" => $strLinkedZones),
		  "4.2" 			=> 	array("zone-index.php" => $strZones),
		    "4.2.1"			=> 	array("zone-edit.php?zoneid=0" => $strAddZone),
		    "4.2.2"			=> 	array("zone-edit.php?zoneid=$zoneid" => $strModifyZone),
		    "4.2.3"			=> 	array("zone-include.php?zoneid=$zoneid" => $strIncludedBanners),
		    "4.2.4"			=> 	array("zone-probability.php?zoneid=$zoneid" => $strProbability),
		    "4.2.5"			=> 	array("zone-invocation.php?zoneid=$zoneid" => $strInvocationcode),
		  "4.3" 			=> 	array("admin-generate.php" => $strGenerateBannercode)
	),

	"client" => array (
		"1"					=>  array("index.php" => $strHome),
		  "1.1"				=>  array("index.php" => $strOverview),
		    "1.1.1"			=> 	array("stats-campaign.php?campaignID=$campaignID" => $strCampaignStats),
		  	  "1.1.1.1"		=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => $strDetailStats),
		        "1.1.1.1.1"	=> 	array("stats-daily.php" => $strDailyStats),
		      "1.1.1.2"		=> 	array("banner-edit.php?campaignID=$campaignID&bannerID=$bannerID" => $strModifyBanner),
		    "1.1.2"			=> 	array("stats-campaign-history.php?campaignID=$campaignID" => $strHistory),
	  	    "1.1.3"			=> 	array("stats-weekly.php?campaignID=$campaignID" => $strWeeklyStats),
	      "1.2"				=>  array("stats-client.php" => $strHistory)
	)
);

if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyInfo))
	$phpAds_nav["client"]["2"] =  array("client-edit.php" => $strPreferences);


?>