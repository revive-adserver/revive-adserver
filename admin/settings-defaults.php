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
include ("lib-settings.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($gui_show_campaign_info))
		phpAds_SettingsWriteAdd('gui_show_campaign_info', $gui_show_campaign_info);
	if (isset($gui_show_banner_info))
		phpAds_SettingsWriteAdd('gui_show_banner_info', $gui_show_banner_info);
	if (isset($gui_show_campaign_preview))
		phpAds_SettingsWriteAdd('gui_show_campaign_preview', $gui_show_campaign_preview);
	if (isset($gui_show_banner_html))
		phpAds_SettingsWriteAdd('gui_show_banner_html', $gui_show_banner_html);
	if (isset($gui_show_banner_preview))
		phpAds_SettingsWriteAdd('gui_show_banner_preview', $gui_show_banner_preview);
		
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
			header("Location: $PHP_SELF");
			exit;
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.2"));
phpAds_SettingsSelection("defaults");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

phpAds_StartSettings();
phpAds_AddSettings('start_section', "2.3.1");
phpAds_AddSettings('checkbox', 'gui_show_campaign_info', $strShowCampaignInfo);
phpAds_AddSettings('checkbox', 'gui_show_banner_info', $strShowBannerInfo);
phpAds_AddSettings('checkbox', 'gui_show_campaign_preview', $strShowCampaignPreview);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'gui_show_banner_html', $strShowBannerHTML);
phpAds_AddSettings('checkbox', 'gui_show_banner_preview', $strShowBannerPreview);
phpAds_AddSettings('end_section', '');


phpAds_StartSettings();
phpAds_AddSettings('start_section', "2.3.2");
phpAds_AddSettings('select', 'begin_of_week',
	array($strBeginOfWeek, array($strDayFullNames[0], $strDayFullNames[1])));
phpAds_AddSettings('break', '');
phpAds_AddSettings('select', 'percentage_decimals',
	array($strPercentageDecimals, array(0, 1, 2, 3)));
phpAds_AddSettings('end_section', '');


phpAds_AddSettings('start_section', "2.3.3");
phpAds_AddSettings('text', 'default_banner_weight',
	array($strDefaultBannerWeight, 12));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'default_campaign_weight',
	array($strDefaultCampaignWeight, 12));
phpAds_AddSettings('end_section', '');

phpAds_EndSettings();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>
<form name="settingsform" method="post" action="<?php echo $PHP_SELF;?>">
<?php

phpAds_FlushSettings();

?>
</form>
<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
