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
	if (isset($retrieval_method))
		phpAds_SettingsWriteAdd('retrieval_method', $retrieval_method);
	if (isset($con_key))
		phpAds_SettingsWriteAdd('con_key', $con_key);
	if (isset($mult_key))
		phpAds_SettingsWriteAdd('mult_key', $mult_key);
	if (isset($acl))
		phpAds_SettingsWriteAdd('acl', $acl);
	if (isset($zone_cache))
		phpAds_SettingsWriteAdd('zone_cache', $zone_cache);
	if (isset($zone_cache_limit))
		phpAds_SettingsWriteAdd('zone_cache_limit', $zone_cache_limit);
	if (isset($p3p_policies))
		phpAds_SettingsWriteAdd('p3p_policies', $p3p_policies);
	if (isset($p3p_compact_policy))
		phpAds_SettingsWriteAdd('p3p_compact_policy', $p3p_compact_policy);
	if (isset($p3p_policy_location))
		phpAds_SettingsWriteAdd('p3p_policy_location', $p3p_policy_location);

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
phpAds_SettingsSelection("main", "invocation");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

phpAds_StartSettings();
phpAds_AddSettings('start_section', "1.2.1");
phpAds_AddSettings('select', 'retrieval_method',
	array($strBannerRetrieval, array($strRetrieveRandom, $strRetrieveNormalSeq, $strWeightSeq, $strFullSeq)));
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'con_key', $strUseConditionalKeys);
phpAds_AddSettings('checkbox', 'mult_key', $strUseMultipleKeys);
phpAds_AddSettings('checkbox', 'acl', $strUseAcl);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.2.2");
phpAds_AddSettings('checkbox', 'zone_cache',
	array($strZoneCache, array('zone_cache_limit')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'zone_cache_limit',
	array($strZoneCacheLimit, 25, 'text', 0, 'zone_cache'));
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.2.3");
phpAds_AddSettings('checkbox', 'p3p_policies',
	array($strUseP3P, array('p3p_compact_policy', 'p3p_policy_location')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'p3p_compact_policy',
	array($strP3PCompactPolicy, 35, 'text', 0, 'p3p_policies'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'p3p_policy_location',
	array($strP3PPolicyLocation, 35, 'text', 0, 'p3p_policies'));
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
