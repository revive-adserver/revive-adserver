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



// Include required files
include ("lib-settings.inc.php");


// Register input variables
phpAds_registerGlobal ('save_settings', 'gui_show_campaign_info', 'gui_show_banner_info', 'gui_show_campaign_preview', 'gui_show_banner_html', 
					   'gui_show_banner_preview', 'gui_hide_inactive', 'gui_show_matching', 'gui_show_parents', 
					   'gui_link_compact_limit', 'begin_of_week', 'percentage_decimals', 'default_banner_weight', 'default_campaign_weight');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($save_settings) && $save_settings != '')
{
	phpAds_SettingsWriteAdd('gui_show_campaign_info', isset($gui_show_campaign_info));
	phpAds_SettingsWriteAdd('gui_show_banner_info', isset($gui_show_banner_info));
	phpAds_SettingsWriteAdd('gui_show_campaign_preview', isset($gui_show_campaign_preview));
	phpAds_SettingsWriteAdd('gui_show_banner_html', isset($gui_show_banner_html));
	phpAds_SettingsWriteAdd('gui_show_banner_preview', isset($gui_show_banner_preview));
	phpAds_SettingsWriteAdd('gui_hide_inactive', isset($gui_hide_inactive));
	phpAds_SettingsWriteAdd('gui_show_matching', isset($gui_show_matching));
	phpAds_SettingsWriteAdd('gui_show_parents', isset($gui_show_parents));
	
	if (isset($gui_link_compact_limit))
		phpAds_SettingsWriteAdd('gui_link_compact_limit', $gui_link_compact_limit);
	
	
	if (isset($begin_of_week))
		phpAds_SettingsWriteAdd('begin_of_week', $begin_of_week);
	if (isset($percentage_decimals))
		phpAds_SettingsWriteAdd('percentage_decimals', $percentage_decimals);
	
	
	if (isset($default_banner_weight))
		phpAds_SettingsWriteAdd('default_banner_weight', $default_banner_weight);
	if (isset($default_campaign_weight))
		phpAds_SettingsWriteAdd('default_campaign_weight', $default_campaign_weight);
	
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-defaults.php");
			exit;
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_SettingsSelection("defaults");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

$settings = array (

array (
	'text' 	  => $strInventory,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_campaign_info',
			'text'	  => $strShowCampaignInfo
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_banner_info',
			'text'	  => $strShowBannerInfo
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_campaign_preview',
			'text'	  => $strShowCampaignPreview
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_banner_html',
			'text'	  => $strShowBannerHTML
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_banner_preview',
			'text'	  => $strShowBannerPreview
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_hide_inactive',
			'text'	  => $strHideInactive
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_matching',
			'text'	  => $strGUIShowMatchingBanners
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'gui_show_parents',
			'text'	  => $strGUIShowParentCampaigns
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'gui_link_compact_limit',
			'text' 	  => $strGUILinkCompactLimit,
			'size'	  => 12,
			'check'	  => 'number+'
		)
	)
),
array (
	'text' 	  => $strStatisticsDefaults,
	'items'	  => array (
		array (
			'type' 	  => 'select', 
			'name' 	  => 'begin_of_week',
			'text' 	  => $strBeginOfWeek,
			'items'   => array($strDayFullNames[0], $strDayFullNames[1])
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'select', 
			'name' 	  => 'percentage_decimals',
			'text' 	  => $strPercentageDecimals,
			'items'   => array(0, 1, 2, 3)
		)
	)
),
array (
	'text' 	  => $strWeightDefaults,
	'items'	  => array (
		array (
			'type' 	  => 'text', 
			'name' 	  => 'default_banner_weight',
			'text' 	  => $strDefaultBannerWeight,
			'size'	  => 12,
			'check'	  => 'number+'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'default_campaign_weight',
			'text' 	  => $strDefaultCampaignWeight,
			'size'	  => 12,
			'check'	  => 'number+'
		)
	)
));



/*********************************************************/
/* Main code                                             */
/*********************************************************/

phpAds_ShowSettings($settings, $errormessage);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>