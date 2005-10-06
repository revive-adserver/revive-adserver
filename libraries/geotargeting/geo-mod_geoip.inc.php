<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


/* PUBLIC FUNCTIONS */

$GLOBALS['phpAds_geoPluginID'] = 'mod_geoip';

function phpAds_mod_geoip_getInfo()
{
	global $HTTP_SERVER_VARS;

	return (array (
		'name'			=> 'MaxMind GeoIP (mod)',
		'db'			=> false,
		'country'		=> true,
		'continent'		=> true,
		'region'		=> isset($HTTP_SERVER_VARS['GEOIP_REGION']),
		'fips_code'		=> false,
		'city'			=> false,
		'postal_code'	=> false,
		'latitude'		=> false,
		'longitude'		=> false,
		'dma_code'		=> false,
		'area_code'		=> false,
		'org_isp'		=> false,
		'netspeed'		=> false
	));
}


function phpAds_mod_geoip_getFingerprint()
{
	global $phpAds_geoPluginID;

	return $phpAds_geoPluginID;
}


function phpAds_mod_geoip_getGeo($addr, $db)
{
	// $addr and $db parameter is ignored and is here for API consistency only
	
	global $HTTP_SERVER_VARS;
	
	if (isset($HTTP_SERVER_VARS['GEOIP_COUNTRY_CODE']))
		$country = $HTTP_SERVER_VARS['GEOIP_COUNTRY_CODE'];
	else
		$country = '';
	
	if (isset($HTTP_SERVER_VARS['GEOIP_REGION']))
		$region = $HTTP_SERVER_VARS['GEOIP_REGION'];	
	else
		$region = false;
	
	if ($country != '' && $country != '--')
	{
		// Get continent code
		@include_once (phpAds_path.'/libraries/resources/res-continent.inc.php');
		$continent = $phpAds_continent[$country];
		
		return (array (
			'country' => $country,
			'continent' => $continent,
			'region' => $region
		));
	}
	else
		return (false);
}

?>
