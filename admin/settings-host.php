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
					   'geotracking_cookie');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	phpAds_SettingsWriteAdd('reverse_lookup', isset($reverse_lookup));
	phpAds_SettingsWriteAdd('proxy_lookup', isset($proxy_lookup));
	
	if (isset($geotracking_type)) phpAds_SettingsWriteAdd('geotracking_type', $geotracking_type);
	phpAds_SettingsWriteAdd('geotracking_cookie', isset($geotracking_cookie));
	
	
	if (isset($geotracking_location))
	{
		if (file_exists($geotracking_location) || $geotracking_location == '')
			phpAds_SettingsWriteAdd('geotracking_location', $geotracking_location);
		else
			$errormessage[1][] = $strGeotrackingLocationError;
	}
	
	
	
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


$settings = array (

array (
	'text' 	  => $strRemoteHost,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'reverse_lookup',
			'text'	  => $strReverseLookup
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'proxy_lookup',
			'text'	  => $strProxyLookup
		)
	)
),
array (
	'text' 	  => $strGeotargeting,
	'items'	  => array (
		array (
			'type' 	  => 'select', 
			'name' 	  => 'geotracking_type',
			'text' 	  => $strGeotrackingType,
			'items'   => array($strNone, 'IP2Country', 'MaxMind GeoIP', 'MaxMind GeoIP (mod_geoip)')
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'geotracking_location',
			'text' 	  => $strGeotrackingLocation,
			'size'	  => 35,
			'depends' => 'geotracking_type>0 && geotracking_type!=3'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'geotracking_cookie',
			'text'	  => $strGeoStoreCookie,
			'depends' => 'geotracking_type>0'
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