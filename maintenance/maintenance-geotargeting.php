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



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



// Recreate geotargeting configuration
if ($phpAds_config['geotracking_type'] && phpAds_isConfigWritable())
{
	include(phpAds_path.'/libraries/geotargeting/geo-'.$phpAds_config['geotracking_type'].'.inc.php');
				
	if (function_exists('phpAds_'.$phpAds_geoPluginID.'_getConf'))
		$geoconf = call_user_func('phpAds_'.$phpAds_geoPluginID.'_getConf', $phpAds_config['geotracking_location']);
	else
		$geoconf = '';
	
	if ($geoconf != $phpAds_config['geotracking_conf'])
	{
		phpAds_SettingsWriteAdd('geotracking_conf', $geoconf);
	
		phpAds_SettingsWriteFlush();
		
		phpAds_userlogAdd (phpAds_actionGeotargeting, 0);
	}
}


?>