<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Disable E_ALL warnings...
ini_set("error_reporting", E_ALL & ~E_NOTICE);


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
	// This text isn't translated, because if it is shown the language files are not yet loaded
	phpAds_Die ("A fatal error occurred", $phpAds_productname." can't connect to the database.
				Because of this it isn't possible to use the administrator interface. The delivery
				of banners might also be affected. Possible reasons for the problem are:
				<ul><li>The database server isn't functioning at the moment</li>
				<li>The location of the database server has changed</li>
				<li>The username or password used to contact the database server are not correct</li>
				</ul>");
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
	$_SERVER['SERVER_PORT'] != 443)
{
	header ('Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	exit;
}

// Adjust url_prefix if SLL is used
if ($_SERVER['SERVER_PORT'] == 443)
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

// Check for missing required parameters
phpAds_checkIds();


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
    	      "2.1.2.3"		 		=> 	array("stats-campaign-target.php?clientid=$clientid&campaignid=$campaignid" => $strTargetStats),
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
			    "4.1.3.4.6"			=>  array("banner-append.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strAppendOthers),
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
    	    "1.2.3"					=> 	array("stats-campaign-target.php?clientid=$clientid&campaignid=$campaignid" => $strTargetStats),
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

$GLOBALS['docs_url'] = 'http://docs.openads.org/openads-2.0-guide';

$GLOBALS['aHelpPages'] = array( 'elements' => array() );

$GLOBALS['aHelpPages']['elements']['inventory'] = array(
    'link' => 'inventory-overview.html',
    'name' => 'Inventory overview',
    'anchors' => array(),
    'elements' => array(),
);

define( 'OPENADS_HELP_PAGES_ROTATE_CONSTRAINT_ANCHOR',        1 );

$GLOBALS['aHelpPages']['elements']['inventory']['elements']['banners'] = array(
    'link' => 'banners.html',
    'name' => 'Banners',
    'anchors' => array(
        'Local banner',
        'External banner',
        'Html banner',
        'Text ads',
        'Keywords and description',
        'Banner weight',        
        'Duplicating an existing banner',        
        'Moving a banner',        
        'Deactivating or activating a banner',        
        'Deleting a banner',        
    ),
    'rotate' => array(
        'constraint_type' => OPENADS_HELP_PAGES_ROTATE_CONSTRAINT_ANCHOR,
        '_storagetype' => array(
            'url'  => 1,
            'sql'  => 0,
            'html' => 2,
            'txt'  => 3,
            '__default' => 0
        ),
    ),
);

$GLOBALS['aHelpPages']['elements']['inventory']['elements']['flash_banners'] = array(
    'link' => 'advanced-flash-banners.html',
    'name' => 'Advanced Flash banners',
    'anchors' => array(
        'Converting hard-coded URLs',
        'The MFAA ClickTAG',
    ),
);

$GLOBALS['aHelpPages']['elements']['inventory']['elements']['campaigns'] = array(
    'link' => 'campaigns.html',
    'name' => 'Campaigns',
    'anchors' => array(
        'Priorities',
        'High priority campaigns',
        'Low priority campaigns',
        'Moving a campaign to another advertiser',
        'Deleting a campaign',
    ),
);

$GLOBALS['aHelpPages']['elements']['inventory']['elements']['advertisers'] = array(
    'link' => 'advertisers.html',
    'name' => 'Advertisers',
    'anchors' => array(),
);

$GLOBALS['aHelpPages']['elements']['inventory']['elements']['delivery_limitations'] = array(
    'link' => 'delivery-limitations.html',
    'name' => 'Delivery limitations',
    'anchors' => array(
        'Managing delivery limitations',
        'Creating a new limitation',
        'Changing an existing limitation',
        'Moving a limitation',
        'Deleting a limitation',
        'Applying a set of limitations to another banner',
        'Limiting delivery by weekday',
        'Limiting delivery by time',
        'Limiting delivery by date',
        'Limiting delivery by client IP',
        'Limiting delivery by domain',
        'Limiting delivery by language',
        'Limiting delivery by browser',
        'Limiting delivery by operating system',
        'Limiting delivery by the source parameter',
        'Limiting delivery by referring page',
        'Comparison expressions',
        'Logical operators',
    ),

    'rotate' => array(
        'constraint_type' => OPENADS_HELP_PAGES_ROTATE_CONSTRAINT_ANCHOR,
        '_type' => array(
            'weekday'    => 6,
            'time'       => 7,
            'date'       => 8,
            'clientip'   => 9,
            'domain'     => 10,
            'language'   => 11,
            'browser'    => 12,
            'os'         => 13,
            'useragent'  => 14,
            'url'        => 15,
            'referer'    => 17,
            'source'     => 16,
        )
    ),
);

$GLOBALS['aHelpPages']['elements']['display_using_zones'] = array(
    'elements' => array(),
    'name' => 'Displaying banners using zones',
    'link' => 'displaying-banners-using-zones.html',
    'anchors' => array(),
);

$GLOBALS['aHelpPages']['elements']['display_using_zones']['elements']['zones'] = array(
    'link' => 'zones.html',
    'name' => 'Zones',
    'anchors' => array(
        'Creating chains',
        'Stop delivery and don\'t show a banner',
        'Display the selected zone instead',
        'Select a banner using the keywords below',
        'Appending other invocation codes',
        'Configuring the layout of Text ads',
        'Linking banners to a zone',
        'Campaign selection',
        'Banner selection',
        'Keyword',
        'Probability',
    ),
    'rotate' => array(
        '_zonetype' => array(
            3 => 7,
            0 => 8,
            2 => 9,
        ),
    ),
);

$GLOBALS['aHelpPages']['elements']['display_using_zones']['elements']['publishers'] = array(
    'link' => 'publishers.html',
    'name' => 'Publishers',
    'anchors' => array(),
);

$GLOBALS['aHelpPages']['elements']['display_using_direct_selection'] = array(
    'elements' => array(),
    'name' => 'Displaying banners using direct selection ',
    'link' => 'displaying-banners-using-zones.html',
    'anchors' => array(),
);

$GLOBALS['aHelpPages']['elements']['display_using_direct_selection']['elements']['statements'] = array(
    'link' => 'statements.html',
    'name' => 'Statements',
    'anchors' => array(
        'Banner id',
        'Campaign id',
        'Width',
        'Height',
        'Dimensions',
        'Textads',
        'Keywords',
    ),
);

$GLOBALS['aHelpPages']['elements']['display_using_direct_selection']['elements']['selection_strings'] = array(
    'link' => 'selection-strings.html',
    'name' => 'Selection strings',
    'anchors' => array(
        'Selection Paths',
        'Advanced selection strings',
        'Logical operators',
        'Multiple expressions',
        'The global keyword (deprecated)',
        'key1',
        'key1|global',
        'Examples',
    ),
);

$GLOBALS['aHelpPages']['elements']['maintenance'] = array(
    'link' => 'maintenance.html',
    'name' => 'Automatic maintenance',
    'anchors' => array(
    	'Built-in Automatic Maintenance',
    	'Scheduled Maintenance',
    	'Scheduling tasks on Linux and UNIX based servers',
    	'Using cPanel to schedule maintenance tasks on Linux and UNIX based servers',
    	'Scheduling tasks on Windows 2000 and XP servers',
    	'Creating the scheduled task',
    	'Using an external cron server',
    ),
    'elements' => array(),
);

$GLOBALS['aHelpPages']['elements']['configuration'] = array(
    'link' => 'introduction.html',
    'name' => 'Configuration',
    'anchors' => array(),
    'elements' => array(),
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['db_settings'] = array(
    'link' => 'database-settings.html',
    'name' => 'Database settings',
    'anchors' => array(
        'Connect to local server using sockets',
        'Database port number',
        'Database username',
        'Database password',
        'Database name',
        'Use persistent connections',
        'Use delayed inserts',
        'Use database compatibility mode',
    ),
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['invocation_and_delivery'] = array(
    'link' => 'invocation-and-delivery.html',
    'name' => 'Invocation and delivery',
    'anchors' => array(
        'Delivery settings',
        'Delivery cache type',
        'Evaluate delivery limitations during delivery',
        'Allow logical operators when using direct selection',
        'Allow multiple keywords when using direct selection',
        'Allow ....',
        'Use P3P Policies',
        'P3P Compact Policy',
        'P3P Policy Location',
        'Pack cookies to avoid cookie overpopulations',
    ),
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['host_info_and_geotargeting'] = array(
    'link' => 'host-info-and-geotargeting.html',
    'name' => 'Host info and geotargeting',
    'anchors' => array(
    	'Try to determine the hostname of the visitor...',
    	'Try to determine the real IP address of the visitor...',
    	'Type of geotargeting database',
    	'Geotargeting database location',
    	'Store the result in a cookie for future reference',
    ),
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['statistics'] = array(
    'link' => 'statistics.html',
    'name' => 'Statistics',
    'anchors' => array(
        'Statistics format',
        'Log an AdView everytime a banner is delivered',
        'Log an AdClick everytime a visitor clicks on a banner',
        'Log the source parameter specified during invocation',
        'Log the country of the visitor in the statistics',
        'Log the hostname or IP address of the visitor',
        'Only log the IP address of the visitor even if the hostname is known',
        'Use a small beacon image to log AdViews...',
        'Don\'t store statistics for visitors using one of the following....',
        'Don\'t log AdViews if the visitor....',
        'Send a warning to the administrator...',
        'Send a warning to the advertiser...',
        'Send a warning when the number of impressions...',
        'Add the following headers to each e-mail message sent by Openads',
        'Enable qmail patch',
        'Prune statistics',
        'Prune userlog',
    ),
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['banners'] = array(
    'link' => 'banner-settings.html',
    'name' => 'Banner Settings',
    'anchors' => array(
        'Default image URL and Default destination URL',
        'Allow local banners (SQL), Allow local banners (Webserver), Allow external banners and Allow HTML banners, Allow Text ads',
        'Storing method',
        'Public URL',
        'Local directory',
        'Moving banner files from the database to a local directory',
        'FTP Host, Host directory, Login and Password',
        'Automatically alter HTML banners in order to force click tracking',
        'Allow PHP expressions to be executed from within a HTML banner',
        'Administrator',
        'Admin\'s username',
        'Password',
        'Admin\'s full name',
        'Admin\'s email address',
        'Company Name',
        'Language',
        'Check for updates',
        'Prompt for newly released development versions',
        'Admin\'s delete actions need confirmation for safety',
        'Log all outgoing email messages',
        'Log hourly priority calculations',
        'Log automatic cleaning of database',
    ),    
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['admin'] = array(
    'link' => 'administrator-settings.html',
    'name' => 'Administrator settings',
    'anchors' => array(
        'Administrator settings',
        'Admin\'s username',
        'Password',
        'Admin\'s full name',
        'Admin\'s email address',
        'Company Name',
        'Language',
        'Check for updates',
        'Prompt for newly released development versions',
        'Admin\'s delete actions need confirmation for safety',
        'Log all outgoing email messages',
        'Log hourly priority calculations',
        'Log automatic cleaning of database',
    ),    
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['user_interface'] = array(
    'link' => 'user-interface.html',
    'name' => 'User interface',
    'anchors' => array(
        'Application Name',
        'My header and My Footer',
        'Use GZIP content compression',
        'Enable advertiser welcome message',
        'Welcome text',
    ),    
);

$GLOBALS['aHelpPages']['elements']['configuration']['elements']['interface_defaults'] = array(
    'link' => 'interface-defaults.html',
    'name' => 'Interface defaults',
    'anchors' => array(
        'Show extra campaign info on Campaign overview page',
        'Show extra banner info on Banner overview page',
        'Show preview of all banner on Banner overview page',
        'Show actual banner instead of plain HTML code for HTML banner preview',
        'Show banner preview at the top of pages which deals banners',
        'Hide inactive items from all overview pages',
        'Show matching banner on the Linked banner pages',
        'Show parent campaign on the Linked banner pages',
        'Hide non-linked campaigns or banners on the Linked banner pages...',
        'Begin of Week',
        'Percentage Decimals',
        'Default banner weight',
        'Default campaign weight',
   ),
);

$GLOBALS['aHelpPages']['elements']['invocation_generation'] = array(
    'link' => 'invocation-overview.html',
    'name' => 'Invocation Overview',
    'anchors' => array(
        'The invocation code generator',
        'Publishers and zones',
        'Direct selection',
        'Banner selection',
        'Different types of invocation codes',
    ),
    'elements' => array(),
);

$GLOBALS['aHelpPages']['elements']['invocation_generation']['elements']['banner_button_rectangle'] = array(
    'link' => 'banner-button-or-rectangle.html',
    'name' => 'Banner, button or rectangle',
    'anchors' => array(
        'Remote invocation',
        'Target frame',
        'Source',
        'Remote invocation for JavaScript',
        'Target frame',
        'Source',
        'Show text below banner',
        'Don\'t show the banner again on the same page',
        'Remote invocation for Frames',
        'Target frame',
        'Source',
        'Refresh after',
        'Frame size',
        'Resize iframe to banner dimensions',
        'Make iframe transparent',
        'Include Netscape 4 compatible ilayer',
    ),
);

$GLOBALS['aHelpPages']['elements']['invocation_generation']['elements']['interstitial_floating_dhtml'] = array(
    'link' => 'interstitial-or-floating-dhtml.html',
    'name' => 'Interstitial or floating DHTML',
    'anchors' => array(
        'Target frame',
        'Source',
        'Style',
        'Simple',
        'Horizontal alignment',
        'Vertical alignment',
        'Show close button',
        'Automatically close after',
        'Banner padding',
        'Horizontal shift',
        'Vertical shift',
        'Background color',
        'Border color',
        'Geocities',
        'Alignment',
        'Close text',
        'Automatically collapse after',
        'Banner padding',
        'Floater',
        'Direction',
        'Looping',
        'Speed',
        'Pause',
        'Vertical shift',
        'Limited',
        'Left margin',
        'Right margin',
        'Transparent background',
        'Background color',
        'Cursor',
        'Smooth movement',
        'Speed',
        'Hide the banner when the cursor is not moving',
        'Delay before banner is hidden',
        'Transparency of hidden banner',
        'Horizontal shift & vertical shift',
    ),
);

$GLOBALS['aHelpPages']['elements']['invocation_generation']['elements']['popup'] = array(
    'link' => 'popup.html',
    'name' => 'Popup',
    'anchors' => array(
        'Target frame',
        'Source',
        'Pop-up type',
        'Initial position',
        'Automatically close',
    ),
);

$GLOBALS['aHelpPages']['elements']['invocation_generation']['elements']['local_mode'] = array(
    'link' => 'local-mode.html',
    'name' => 'Local mode',
    'anchors' => array(
        'Target frame',
        'Source',
        'Show text below banner',
        'Don\'t show the banner again on the same page',
        'Store the banner inside a variable so it can be used in a template',
        'The Context parameter',
    ),
);

$GLOBALS['aHelpPages']['elements']['statistics_and_reports'] = array(
    'link' => 'statistics-overview.html',
    'name' => 'Statistics Overview',
    'anchors' => array(
        'Viewing statistics',
        'Advertisers & Campaigns tab',
        'Advertiser history',
        'Daily History',
        'Publishers & Zones tab',
        'Publisher history',
        'Zone history page',
        'Global history',
        'Miscellaneous',
        'Distribution by size',
    ),
    'elements' => array(),
);

$GLOBALS['aHelpPages']['elements']['statistics_and_reports']['elements']['statistics_overview'] = array(
    'link' => 'statistics-overview.html',
    'name' => 'Statistics Overview',
    'anchors' => array(
        'Viewing statistics',
        'Advertisers & Campaigns tab',
        'Advertiser history',
        'Daily History',
        'Publishers & Zones tab',
        'Publisher history',
        'Zone history page',
        'Global history',
        'Miscellaneous',
        'Distribution by size',
    ),
    'elements' => array(),
);

$GLOBALS['aHelpPages']['elements']['statistics_and_reports']['elements']['reports_overview'] = array(
    'link' => 'reports-overview.html',
    'name' => 'Reports Overview',
    'anchors' => array(
        'Creating reports',
        'Data Source',
        'Delimiter',
        'Use quotes',
        'Generating the report',
    ),
    'elements' => array(),
);

$GLOBALS['navi2help'] = array(    
	"admin"    => array (
		"2"                     => array( 'statistics_and_reports' ),
          "2.1"                 => array( 'statistics_and_reports' ),
            "2.1.1"             => array( 'statistics_and_reports' ),
              "2.1.2"           => array( 'display_using_zones.zones' ),
            "2.1.3"             => array( 'display_using_zones.zones', 9 ),
            "2.1.4"             => array( 'display_using_zones.zones', 11 ),
            "2.1.5"             => array( 'invocation_generation' ),
              "2.1.6"           => array( 'display_using_zones.zones' ),
          "2.2"                 => array( 'statistics_and_reports.statistics_overview' ),
          "2.4"                 => array( 'statistics_and_reports.statistics_overview' ),
          "2.5"                 => array( 'statistics_and_reports.statistics_overview' ),
		"3"						=> array( 'statistics_and_reports.reports_overview' ),
        "4"                     => array( 'inventory' ),
          "4.1"                 => array( 'inventory' ),
            "4.1.1"             => array( 'inventory.advertisers' ),
            "4.1.2"             => array( 'inventory.advertisers' ),
            "4.1.3"             => array( 'inventory.campaigns' ),
              "4.1.3.1"         => array( 'inventory.campaigns' ),
              "4.1.3.2"         => array( 'inventory.campaigns' ),
              "4.1.3.3"         => array( 'display_using_zones.zones' ),
              "4.1.3.4"         => array( 'inventory.banners' ),
                "4.1.3.4.1"     => array( 'inventory.banners' ),
                "4.1.3.4.2"     => array( 'inventory.banners' ),
                "4.1.3.4.3"     => array( 'inventory.delivery_limitations' ),
                "4.1.3.4.4"     => array( 'display_using_zones.zones' ),
                "4.1.3.4.5"     => array( 'inventory.flash_banners' ),
                "4.1.3.4.6"     => array(),
          "4.2"                 => array( 'display_using_zones.publishers' ),
            "4.2.1"             => array( 'display_using_zones.publishers' ),
            "4.2.2"             => array( 'display_using_zones.publishers' ),
            "4.2.3"             => array( 'display_using_zones.zones'),
              "4.2.3.1"         => array( 'display_using_zones.zones' ), 
                "4.2.3.2"       => array( 'display_using_zones.zones' ),
              "4.2.3.3"         => array( 'display_using_zones.zones', 9 ),
              "4.2.3.4"         => array( 'display_using_zones.zones', 11 ),
              "4.2.3.5"         => array( 'invocation_generation' ),
                "4.2.3.6"       => array( 'display_using_zones.zones' ),
          "4.3"                 => array( 'display_using_zones' ),
        "5"                     => array( 'configuration.invocation_and_delivery' ),
          "5.1"                 => array( 'configuration.db_settings',
          							'use_file' => array(
          								'settings-db.php' 			=> array( 'configuration.db_settings' ),
          								'settings-invocation.php' 	=> array( 'configuration.invocation_and_delivery' ),
          								'settings-host.php'			=> array( 'configuration.host_info_and_geotargeting' ),
          								'settings-stats.php'		=> array( 'configuration.statistics' ),
          								'settings-banner.php'		=> array( 'configuration.banners' ),
          								'settings-admin.php'		=> array( 'configuration.admin' ),
          								'settings-interface.php'	=> array( 'configuration.user_interface' ),
          								'settings-defaults.php'		=> array( 'configuration.interface_defaults' ),
          							)
          						),
          "5.3"                 => array( 'maintenance' ),
          "5.2"                 => array(), // array("userlog-index.php" => $strUserLog),
              "5.2.1"           => array(), // array("userlog-details.php?userlogid=$userlogid" => $strUserLogDetails),
          "5.4"                 => array(), // array("maintenance-updates.php" => $strProductUpdates)
    ),

    "client" => array (
		"3"						=> array( 'statistics_and_reports.reports_overview' ),
              "1.2.2.2"         => array( 'inventory.banners' ),
              "1.2.2.3"         => array( 'inventory.flash_banners' ),
    ),

    "affiliate" => array (
		"3"						=> array( 'statistics_and_reports.reports_overview' ),
        "2"                     => array( 'display_using_zones.publishers' ),
          "2.1"                 => array( 'display_using_zones.publishers' ),
            "2.1.1"             => array( 'display_using_zones.zones' ),
              "2.1.2"           => array( 'display_using_zones.zones' ),
            "2.1.3"             => array( 'display_using_zones.zones', 9 ),
            "2.1.4"             => array( 'display_using_zones.zones', 11 ),
            "2.1.5"             => array( 'invocation_generation' ),
              "2.1.6"           => array( 'display_using_zones.zones' ),
          "2.2"                 => array( 'display_using_zones.publishers' )
    )
);

if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyInfo))
	$phpAds_nav["client"]["2"] =  array("client-edit.php" => $strPreferences);

?>
