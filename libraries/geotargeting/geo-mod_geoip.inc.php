<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
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
	return (array (
		'name'			=> 'MaxMind GeoIP (mod)',
		'db'			=> false,
		'country'		=> true,
		'continent'		=> true,
		'region'		=> isset($_SERVER['GEOIP_REGION']),
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
	
	if (isset($_SERVER['GEOIP_COUNTRY_CODE']))
		$country = $_SERVER['GEOIP_COUNTRY_CODE'];
	else
		$country = '';
	
	if (isset($_SERVER['GEOIP_REGION']))
		$region = $_SERVER['GEOIP_REGION'];	
	else
		$region = false;
	
	if ($country != '' && $country != '--')
	{
		// Get continent code
		@include_once (phpAds_path.'/libraries/resources/res-continent.inc.php');
		$continent = isset($phpAds_continent[$country]) ? $phpAds_continent[$country] : '';
		
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
