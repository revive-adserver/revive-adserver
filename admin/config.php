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
require ("lib-gui.inc.php");
require ("../view.inc.php");


// Open the database connection
$link = db_connect();
if (!$link)
{
	echo  "phpAdsNew can't connect to the database";
	exit;
}

// Authorize the user and load user specific settings.
require ("lib-permissions.inc.php");
phpAds_Start();


// Load language strings
require ("../language/$phpAds_language.inc.php");


if (!isset($clientID))   $clientID = '';
if (!isset($campaignID)) $campaignID = '';
if (!isset($bannerID))   $bannerID = '';


// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		//"1"					=>	array("admin.php" => "$strHome"),
		"2"					=>  array("stats-index.php" => "$strStats"),
		  "2.1"				=> 	array("stats-campaign.php?campaignID=$campaignID" => "$strStats"),
    	    "2.1.1" 		=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => "$strDetailStats"),
		      "2.1.1.1" 	=> 	array("stats-daily.php" => "$strDailyStats"),
		    "2.1.2" 		=> 	array("stats-weekly.php?campaignID=$campaignID" => "$strWeeklyStats"),
		  "2.2"		 		=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => "$strDetailStats"),
		  "2.3"		 		=> 	array("stats-weekly.php?campaignID=0" => "$strWeeklyStats"),
		"3"					=>  array("report-index.php" => "Reports"),
		"4"					=>	array("client-index.php" => "$strAdminstration"),
		  "4.1" 			=> 	array("campaign-index.php?campaignID=$campaignID" => "$strBanners"),
		    "4.1.1"			=> 	array("banner-edit.php" => "$strAddBanner"),
		    "4.1.2"			=> 	array("banner-edit.php" => "$strModifyBanner"),
		    "4.1.3"			=> 	array("banner-acl.php" => "$strModifyBannerAcl"),
		  "4.2"				=>  array("campaign-edit.php" => "$strCreateNewCampaign"),
		  "4.3"				=>	array("campaign-edit.php" => "$strEditCampaign"),
		  "4.4" 			=> 	array("client-edit.php" => "$strAddClient"),
		  "4.5" 			=> 	array("client-edit.php" => "$strModifyClient")
	),

	"client" => array (
		"1"					=>  array("index.php" => "$strHome"),
		  "1.1"				=> 	array("stats-campaign.php?campaignID=$campaignID" => "$strStats"),
		  	"1.1.1"			=> 	array("stats-details.php?campaignID=$campaignID&bannerID=$bannerID" => "$strDetailStats"),
		      "1.1.1.1"		=> 	array("stats-daily.php" => "$strDailyStats"),
		  	"1.1.2"			=> 	array("stats-weekly.php" => "$strWeeklyStats"),
		    "1.1.3"			=> 	array("banner-edit.php?campaignID=$campaignID&bannerID=$bannerID" => "$strModifyBanner"),
		"2"					=>  array("client-edit.php" => "$strPreferences")
	)
);


?>
