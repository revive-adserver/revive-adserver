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
include ("lib-settings.inc.php");


// Register input variables
phpAds_registerGlobal ('reverse_lookup', 'proxy_lookup', 'geotracking_location', 'geotracking_type', 
					   'geotracking_stats', 'geotracking_cookie');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($reverse_lookup))
		phpAds_SettingsWriteAdd('reverse_lookup', $reverse_lookup);
	if (isset($proxy_lookup))
		phpAds_SettingsWriteAdd('proxy_lookup', $proxy_lookup);
	
	if (isset($geotracking_type))
		phpAds_SettingsWriteAdd('geotracking_type', $geotracking_type);
	if (isset($geotracking_location))
		phpAds_SettingsWriteAdd('geotracking_location', $geotracking_location);	
	if (isset($geotracking_stats))
		phpAds_SettingsWriteAdd('geotracking_stats', $geotracking_stats);
	if (isset($geotracking_cookie))
		phpAds_SettingsWriteAdd('geotracking_cookie', $geotracking_cookie);	
	
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-stats.php");
			exit;
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_SettingsSelection("host");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

phpAds_StartSettings();
phpAds_AddSettings('start_section', "1.5.1");
phpAds_AddSettings('checkbox', 'reverse_lookup', $strReverseLookup);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'proxy_lookup', $strProxyLookup);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.5.2");
phpAds_AddSettings('select', 'geotracking_type',
	array($strGeotrackingType, array($strNone, 'IP2Country', 'MaxMind GeoIP', 'MaxMind GeoIP (mod_geoip)')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'geotracking_location',
	array($strGeotrackingLocation, 35, 'text', 0));
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'geotracking_cookie', $strGeoStoreCookie);
phpAds_AddSettings('end_section', '');

phpAds_EndSettings();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>
<form name="settingsform" method="post" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF'];?>">
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