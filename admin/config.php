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



// Include config file and check need to upgrade
require ("../config.inc.php");


// Figure out our location
if (!defined("phpAds_path"))
{
	if (strlen(__FILE__) > strlen(basename(__FILE__)))
	    define ('phpAds_path', ereg_replace("[/\\\\]admin[/\\\\][^/\\\\]+$", '', __FILE__));
	else
	    define ('phpAds_path', '..');
}



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
include ("../libraries/lib-io.inc.php");
include ("../libraries/lib-db.inc.php");
include ("../libraries/lib-dbconfig.inc.php");
include ("lib-gui.inc.php");
include ("lib-permissions.inc.php");
include ("../libraries/lib-userlog.inc.php");



// Open the database connection
$link = phpAds_dbConnect();
if (!$link)
{
	// Can't connect to database
	phpAds_Die ("A fatal error occurred", $phpAds_productname." can't connect to the database, 
 										  please make sure you the database is running and 
										  ".$phpAds_productname." is configured correctly.");
}


// Load settings from the database
phpAds_LoadDbConfig();


if (!isset($phpAds_config['config_version']) ||
	$phpAds_version > $phpAds_config['config_version'])
{
	// Post configmanager, but not up to date -> update
	header("Location: upgrade.php");
	exit;
}




// Check for SLL requirements
if ($phpAds_config['ui_forcessl'] && 
	$HTTP_SERVER_VARS['SERVER_PORT'] != 443)
{
	header ('Location: https://'.$HTTP_SERVER_VARS['SERVER_NAME'].$HTTP_SERVER_VARS['PHP_SELF']);
	exit;
}

// Adjust url_prefix if SLL is used
if ($HTTP_SERVER_VARS['SERVER_PORT'] == 443)
	$phpAds_config['url_prefix'] = str_replace ('http://', 'https://', $phpAds_config['url_prefix']);



// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
unset($Session);

// Authorize the user
phpAds_Start();


// Load language strings
@include (phpAds_path.'/language/english/default.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');


// Register variables
phpAds_registerGlobal ('bannerid', 'campaignid', 'clientid',
					   'zoneid', 'affiliateid', 'userlogid', 'day');

if (!isset($clientid))    $clientid = '';
if (!isset($campaignid))  $campaignid = '';
if (!isset($bannerid))    $bannerid = '';
if (!isset($zoneid))   	  $zoneid = '';
if (!isset($affiliateid)) $affiliateid = '';
if (!isset($userlogid))   $userlogid = '';
if (!isset($day))		  $day = '';


// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		"2"							=>  array("stats-global-client.php" => $strStats),
 	  	  "2.1"						=>  array("stats-global-client.php" => $strClientsAndCampaigns),
		    "2.1.1"					=>  array("stats-client-history.php?clientid=$clientid" => $strClientHistory),
		      "2.1.1.1"				=> 	array("stats-client-daily.php?clientid=$clientid&day=$day" => $strDailyStats),
		      "2.1.1.2"				=> 	array("stats-client-daily-hosts.php?clientid=$clientid&day=$day" => $strHosts),
		    "2.1.2"					=>  array("stats-client-campaigns.php?clientid=$clientid" => $strCampaignOverview),
    	      "2.1.2.1"		 		=> 	array("stats-campaign-history.php?clientid=$clientid&campaignid=$campaignid" => $strCampaignHistory),
		        "2.1.2.1.1"			=> 	array("stats-campaign-daily.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strDailyStats),
		        "2.1.2.1.2"			=> 	array("stats-campaign-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strHosts),
			  "2.1.2.2"				=> 	array("stats-campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $strBannerOverview),
			    "2.1.2.2.1" 		=> 	array("stats-banner-history.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerHistory),
		          "2.1.2.2.1.1"		=> 	array("stats-banner-daily.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strDailyStats),
		          "2.1.2.2.1.2"		=> 	array("stats-banner-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strHosts),
    	        "2.1.2.2.2" 		=> 	array("stats-banner-affiliates.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strDistribution),
		  "2.2"						=>  array("stats-global-history.php" => $strGlobalHistory),
		    "2.2.1"					=> 	array("stats-global-daily.php?day=$day" => $strDailyStats),
		    "2.2.2"					=> 	array("stats-global-daily-hosts.php?day=$day" => $strHosts),
	      "2.4"		 				=> 	array("stats-global-affiliates.php" => $strAffiliatesAndZones),
		    "2.4.1"					=>  array("stats-affiliate-history.php?affiliateid=$affiliateid" => $strAffiliateHistory),
			  "2.4.1.1"				=>  array("stats-affiliate-daily.php?affiliateid=$affiliateid&day=$day" => $strDailyStats),
			  "2.4.1.2"				=>  array("stats-affiliate-daily-hosts.php?affiliateid=$affiliateid&day=$day" => $strHosts),
		    "2.4.2"					=>  array("stats-affiliate-zones.php?affiliateid=$affiliateid" => $strZoneOverview),
		      "2.4.2.1"				=>  array("stats-zone-history.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneHistory),
		        "2.4.2.1.1"			=>  array("stats-zone-daily.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strDailyStats),
		        "2.4.2.1.2"			=>  array("stats-zone-daily-hosts.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strHosts),
		      "2.4.2.2"				=>  array("stats-zone-linkedbanners.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strLinkedBannersOverview),
		        "2.4.2.2.1"			=>  array("stats-linkedbanner-history.php?affiliateid=$affiliateid&zoneid=$zoneid&bannerid=$bannerid" => $strLinkedBannerHistory),
	      "2.5"		 				=> 	array("stats-global-misc.php" => $strMiscellaneous),
		"3"							=>  array("report-index.php" => $strReports),
		"4"							=>	array("client-index.php" => $strAdminstration),
		  "4.1"						=>	array("client-index.php" => $strClientsAndCampaigns),
		    "4.1.1"					=> 	array("client-edit.php" => $strAddClient),
		    "4.1.2"					=> 	array("client-edit.php?clientid=$clientid" => $strClientProperties),
		    "4.1.3"					=> 	array("client-campaigns.php?clientid=$clientid" => $strCampaignOverview),
		      "4.1.3.1"				=>  array("campaign-edit.php?clientid=$clientid" => $strAddCampaign),
		      "4.1.3.2"				=>	array("campaign-edit.php?clientid=$clientid&campaignid=$campaignid" => $strCampaignProperties),
		      "4.1.3.3"				=> 	array("campaign-zone.php?clientid=$clientid&campaignid=$campaignid" => $strLinkedZones),
		      "4.1.3.4"				=> 	array("campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $strBannerOverview),
		        "4.1.3.4.1"			=> 	array("banner-edit.php?clientid=$clientid&campaignid=$campaignid" => $strAddBanner),
		        "4.1.3.4.2"			=> 	array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerProperties),
		        "4.1.3.4.3"			=> 	array("banner-acl.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strModifyBannerAcl),
		        "4.1.3.4.4"			=> 	array("banner-zone.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strLinkedZones),
			    "4.1.3.4.5"			=>  array("banner-swf.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strConvertSWFLinks),
		  "4.2" 					=> 	array("affiliate-index.php" => $strAffiliatesAndZones),
		    "4.2.1" 				=> 	array("affiliate-edit.php" => $strAddNewAffiliate),
		    "4.2.2" 				=> 	array("affiliate-edit.php?affiliateid=$affiliateid" => $strAffiliateProperties),
		    "4.2.3" 				=> 	array("affiliate-zones.php?affiliateid=$affiliateid" => $strZoneOverview),
		      "4.2.3.1"				=> 	array("zone-edit.php?affiliateid=$affiliateid" => $strAddNewZone),
  		      "4.2.3.2"				=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneProperties),
		      "4.2.3.3"				=> 	array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strIncludedBanners),
		      "4.2.3.4"				=> 	array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strProbability),
		      "4.2.3.5"				=> 	array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strInvocationcode),
  		      "4.2.3.6"				=> 	array("zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strAdvanced),
		  "4.3" 					=> 	array("admin-generate.php" => $strGenerateBannercode),
		"5"							=> 	array("settings-index.php" => $strSettings),
		  "5.1" 					=> 	array("settings-db.php" => $strMainSettings),
		  "5.3" 					=> 	array("maintenance-index.php" => $strMaintenance),
		  "5.2" 					=> 	array("userlog-index.php" => $strUserLog),
		  	"5.2.1" 				=> 	array("userlog-details.php?userlogid=$userlogid" => $strUserLogDetails),
		  "5.4" 					=> 	array("maintenance-updates.php" => $strProductUpdates)
	),

	"client" => array (
		"1"							=>  array("stats-client-history.php?clientid=$clientid" => $strHome),
		  "1.1"						=>  array("stats-client-history.php?clientid=$clientid" => $strClientHistory),
	        "1.1.1"					=> 	array("stats-client-daily.php?clientid=$clientid&day=$day" => $strDailyStats),
		    "1.1.2"					=> 	array("stats-client-daily-hosts.php?clientid=$clientid&day=$day" => $strHosts),
		  "1.2"						=>  array("stats-client-campaigns.php?clientid=$clientid" => $strCampaignOverview),
    	    "1.2.1"		 			=> 	array("stats-campaign-history.php?clientid=$clientid&campaignid=$campaignid" => $strCampaignHistory),
		      "1.2.1.1"				=> 	array("stats-campaign-daily.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strDailyStats),
		      "1.2.1.2"				=> 	array("stats-campaign-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strHosts),
			"1.2.2"					=> 	array("stats-campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $strBannerOverview),
			  "1.2.2.1" 			=> 	array("stats-banner-history.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerHistory),
		        "1.2.2.1.1"			=> 	array("stats-banner-daily.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strDailyStats),
		        "1.2.2.1.2"			=> 	array("stats-banner-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strHosts),
		      "1.2.2.2"				=> 	array("banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerProperties),
			  "1.2.2.3"				=>  array("banner-swf.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strConvertSWFLinks),
		"3"							=>  array("report-index.php" => $strReports)
	),

	"affiliate" => array (
		"1"						=>  array("stats-affiliate-zones.php?affiliateid=$affiliateid" => $strHome),
		  "1.1"					=>  array("stats-affiliate-zones.php?affiliateid=$affiliateid" => $strZones),
		    "1.1.1"  			=>  array("stats-zone-history.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneHistory),
		      "1.1.1.1"			=>  array("stats-zone-daily.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strDailyStats),
		      "1.1.1.2"			=>  array("stats-zone-daily-hosts.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strHosts),
		    "1.1.2"  			=>  array("stats-zone-linkedbanners.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strLinkedBannersOverview),
		      "1.1.2.1"			=>  array("stats-linkedbanner-history.php?affiliateid=$affiliateid&zoneid=$zoneid&bannerid=$bannerid" => $strLinkedBannerHistory),
		  "1.2"					=>  array("stats-affiliate-history.php?affiliateid=$affiliateid" => $strAffiliateHistory),
			"1.2.1"				=>  array("stats-affiliate-daily.php?affiliateid=$affiliateid&day=$day" => $strDailyStats),
			"1.2.2"				=>  array("stats-affiliate-daily-hosts.php?affiliateid=$affiliateid&day=$day" => $strHosts),
		"3"						=>  array("report-index.php" => $strReports),
	    "2" 					=> 	array("affiliate-zones.php?affiliateid=$affiliateid" => $strAdminstration),
	      "2.1" 				=> 	array("affiliate-zones.php?affiliateid=$affiliateid" => $strZones),
		    "2.1.1"				=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=0" => $strAddZone),
  		    "2.1.2"				=> 	array("zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strModifyZone),
		    "2.1.3"				=> 	array("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strIncludedBanners),
		    "2.1.4"				=> 	array("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strProbability),
		    "2.1.5"				=> 	array("zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strInvocationcode),
  		    "2.1.6"				=> 	array("zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strChains),
	      "2.2" 				=> 	array("affiliate-edit.php?affiliateid=$affiliateid" => $strPreferences)
	)
);

if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyInfo))
	$phpAds_nav["client"]["2"] =  array("client-edit.php" => $strPreferences);

?>