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



// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, strpos(__FILE__, 'admin') - 1));
else
    define ('phpAds_path', '.');



// Include config file and check need to upgrade
require ("../config.inc.php");


if (!defined('phpAds_installed'))
{
	// Old style configuration present
	header('Location: upgrade.php');
	exit;
}
elseif (!phpAds_installed)
{
	// Post configmanager, but not installed -> install
	header('Location: install.php');
	exit;
}


// Include required files
include ("../lib-db.inc.php");
include ("../lib-dbconfig.inc.php");
include ("lib-gui.inc.php");
include ("lib-permissions.inc.php");



// Open the database connection
$link = phpAds_dbConnect();
if (!$link)
{
	// Can't connect to database
	phpAds_PageHeader('');
	phpAds_Die ("A fatal error occurred", "phpAdsNew can't connect to the database, 
 										   please make sure you the database is running and 
										   phpAdsNew is configured correctly.");
}


// Load settings from the database
phpAds_LoadDbConfig();


if (!isset($phpAds_config['config_version']) ||
	$phpAds_version > $phpAds_config['config_version'] || $has_old_config_inc)
{
	// Post configmanager, but not up to date -> update
	header("Location: upgrade.php");
	exit;
}







// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
unset($Session);

// Authorize the user
phpAds_Start();

// Load language strings
require ("../language/".strtolower($phpAds_config['language'])."/default.lang.php");


if (!isset($clientid))    $clientid = '';
if (!isset($campaignid))  $campaignid = '';
if (!isset($bannerid))    $bannerid = '';
if (!isset($zoneid))   	  $zoneid = '';
if (!isset($affiliateid)) $affiliateid = '';
if (!isset($day))		  $day = '';


// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		"2"					=>  array("stats-index.php" => $strStats),
 	  	  "2.1"				=>  array("stats-index.php" => $strClientsAndCampaigns),
		    "2.1.1"			=>  array("stats-client.php?clientid=$clientid" => $strClientStats),
		    "2.1.2"			=> 	array("stats-campaign.php?campaignid=$campaignid" => $strCampaignStats),
    	      "2.1.2.1" 	=> 	array("stats-details.php?campaignid=$campaignid&bannerid=$bannerid" => $strDetailStats),
		        "2.1.2.1.1" => 	array("stats-daily.php?day=$day&campaignid=$campaignid&bannerid=$bannerid" => $strDailyStats),
		    "2.1.3"		 	=> 	array("stats-campaign-history.php?campaignid=$campaignid" => $strHistory),
	        "2.1.4" 		=> 	array("stats-weekly.php?campaignid=$campaignid" => $strWeeklyStats),
		  "2.2"				=>  array("stats-history.php" => $strHistory),
	      "2.3"		 		=> 	array("stats-weekly.php?campaignid=0" => $strWeeklyStats),
	      "2.4"		 		=> 	array("stats-affiliates.php" => $strAffiliatesAndZones),
		    "2.4.1"			=>  array("stats-affiliate-zones.php?affiliateid=$affiliateid" => $strZones),
		    "2.4.2"			=>  array("stats-affiliate-history.php?affiliateid=$affiliateid" => $strHistory),
		"3"					=>  array("report-index.php" => $strReports),
		"4"					=>	array("client-index.php" => $strAdminstration),
		  "4.1"				=>	array("client-index.php" => $strClientsAndCampaigns),
		    "4.1.1"			=> 	array("client-edit.php?clientid=0" => $strAddClient),
		    "4.1.2"			=> 	array("client-edit.php?clientid=$clientid" => $strClientProperties),
		    "4.1.3"			=>  array("campaign-edit.php?campaignid=0" => $strCreateNewCampaign),
		    "4.1.4"			=>	array("campaign-edit.php?campaignid=$campaignid" => $strCampaignProperties),
		    "4.1.5"			=> 	array("campaign-index.php?campaignid=$campaignid" => $strBannerOverview),
		      "4.1.5.1"		=> 	array("banner-edit.php?campaignid=$campaignid&bannerid=0" => $strAddBanner),
		      "4.1.5.2"		=> 	array("banner-edit.php?campaignid=$campaignid&bannerid=$bannerid" => $strBannerProperties),
		      "4.1.5.3"		=> 	array("banner-acl.php?campaignid=$campaignid&bannerid=$bannerid" => $strModifyBannerAcl),
		      "4.1.5.4"		=> 	array("banner-zone.php?campaignid=$campaignid&bannerid=$bannerid" => $strLinkedZones),
		  "4.2" 			=> 	array("affiliate-index.php" => $strAffiliatesAndZones),
		    "4.2.1" 		=> 	array("affiliate-edit.php?affiliateid=0" => $strAddAffiliate),
		    "4.2.2" 		=> 	array("affiliate-edit.php?affiliateid=$affiliateid" => $strAffiliateProperties),
		    "4.2.3" 		=> 	array("zone-index.php?affiliateid=$affiliateid" => $strZoneOverview),
		      "4.2.3.1"		=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=0" => $strAddZone),
  		      "4.2.3.2"		=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneProperties),
		      "4.2.3.3"		=> 	array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strIncludedBanners),
		      "4.2.3.4"		=> 	array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strProbability),
		      "4.2.3.5"		=> 	array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strInvocationcode),
		  "4.3" 			=> 	array("admin-generate.php" => $strGenerateBannercode),
		  "4.4"				=>  array("admin-priority.php" => 'Priority'),
		"5"					=> 	array("settings-index.php" => $strSettings),
		  "5.1" 			=> 	array("settings-db.php" => "Main settings"),
		  "5.2" 			=> 	array("settings-admin.php" => "Administration settings")
	),

	"client" => array (
		"1"					=>  array("index.php" => $strHome),
		  "1.1"				=>  array("index.php" => $strOverview),
		    "1.1.1"			=> 	array("stats-campaign.php?campaignid=$campaignid" => $strCampaignStats),
		  	  "1.1.1.1"		=> 	array("stats-details.php?campaignid=$campaignid&bannerid=$bannerid" => $strDetailStats),
		        "1.1.1.1.1"	=> 	array("stats-daily.php" => $strDailyStats),
		      "1.1.1.2"		=> 	array("banner-edit.php?campaignid=$campaignid&bannerid=$bannerid" => $strModifyBanner),
		    "1.1.2"			=> 	array("stats-campaign-history.php?campaignid=$campaignid" => $strHistory),
	  	    "1.1.3"			=> 	array("stats-weekly.php?campaignid=$campaignid" => $strWeeklyStats),
	      "1.2"				=>  array("stats-client.php" => $strHistory)
	),

	"affiliate" => array (
		"1"					=>  array("stats-affiliate-zones.php?affiliateid=$affiliateid" => $strHome),
		  "1.1"				=>  array("stats-affiliate-zones.php?affiliateid=$affiliateid" => $strZones),
		  "1.2"				=>  array("stats-affiliate-history.php?affiliateid=$affiliateid" => $strHistory),
	    "2" 				=> 	array("zone-index.php?affiliateid=$affiliateid" => $strAdminstration),
	      "2.1" 			=> 	array("zone-index.php?affiliateid=$affiliateid" => $strZones),
		    "2.1.1"			=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=0" => $strAddZone),
  		    "2.1.2"			=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strModifyZone),
		    "2.1.3"			=> 	array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strIncludedBanners),
		    "2.1.4"			=> 	array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strProbability),
		    "2.1.5"			=> 	array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strInvocationcode),
	      "2.2" 			=> 	array("affiliate-edit.php?affiliateid=$affiliateid" => $strPreferences)
	)
);

if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyInfo))
	$phpAds_nav["client"]["2"] =  array("client-edit.php" => $strPreferences);


?>