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
$link = db_connect();
if (!$link)
{
	phpAds_PageHeader('');
	php_die ("An fatal error occurred", "phpAdsNew can't connect to the database, 
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
		"2"					=>  array("stats-index.php" => "$strStats"),
		  "2.1"				=> 	array("stats-campaign.php?campaignID=$campaignID" => "$strCampaignStats"),
    	    "2.1.1" 		=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => "$strDetailStats"),
		      "2.1.1.1" 	=> 	array("stats-daily.php" => "$strDailyStats"),
		    "2.1.2" 		=> 	array("stats-weekly.php?campaignID=$campaignID" => "$strWeeklyStats"),
		  "2.2"		 		=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => "$strDetailStats"),
		  "2.3"		 		=> 	array("stats-weekly.php?campaignID=0" => "$strWeeklyStats"),
		  "2.4"				=>  array("stats-client.php?clientID=$clientID" => "$strClientStats"),
		"3"					=>  array("report-index.php" => "Reports"),
		"4"					=>	array("client-index.php" => "$strAdminstration"),
		  "4.1" 			=> 	array("campaign-index.php?campaignID=$campaignID" => "$strBanners"),
		    "4.1.1"			=> 	array("banner-edit.php" => "$strAddBanner"),
		    "4.1.2"			=> 	array("banner-edit.php" => "$strModifyBanner"),
		    "4.1.3"			=> 	array("banner-acl.php" => "$strModifyBannerAcl"),
		  "4.2"				=>  array("campaign-edit.php" => "$strCreateNewCampaign"),
		  "4.3"				=>	array("campaign-edit.php" => "$strEditCampaign"),
		  "4.4" 			=> 	array("client-edit.php" => "$strAddClient"),
		  "4.5" 			=> 	array("client-edit.php" => "$strModifyClient"),
		  "4.6" 			=> 	array("admin-generate.php" => "$strGenerateBannercode")
	),

	"client" => array (
		"1"					=>  array("index.php" => "$strHome"),
		  "1.1"				=> 	array("stats-campaign.php?campaignID=$campaignID" => "$strCampaignStats"),
		  	"1.1.1"			=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => "$strDetailStats"),
		      "1.1.1.1"		=> 	array("stats-daily.php" => "$strDailyStats"),
		  	"1.1.2"			=> 	array("stats-weekly.php" => "$strWeeklyStats"),
		    "1.1.3"			=> 	array("banner-edit.php?campaignID=$campaignID&bannerID=$bannerID" => "$strModifyBanner"),
		  "1.2"				=>  array("stats-client.php" => "$strClientStats")
	)
);

if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyInfo))
	$phpAds_nav["client"]["2"] =  array("client-edit.php" => "$strPreferences");


?>