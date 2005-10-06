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

$GLOBALS['phpAds_geoPluginID'] = 'ip2country';

function phpAds_ip2country_getInfo()
{
	return (array (
		'name'			=> 'IP2Country',
		'db'			=> true,
		'country'		=> true,
		'continent'		=> true,
		'region'		=> false,
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


function phpAds_ip2country_getFingerprint()
{
	global $phpAds_geoPluginID;

	return $phpAds_geoPluginID;
}


function phpAds_ip2country_getGeo($addr, $db)
{
	if ($db == '')
		return false;
	
	$zz 	= explode('.', $addr);
	$offset = (($zz[0]<<16)+($zz[1]<<8)+$zz[2])*2;
	
	// Lookup IP in database
	if ($fp = @fopen($db, 'rb'))
	{
		fseek($fp, $offset, SEEK_SET);
		$country = fread($fp, 2);
		fclose($fp);
		
		// Correct UK to GB
		if ($country == 'UK') $country = 'GB';
		
		if ($country == "\0\0")
			return (false);
		else
		{
			// Get continent code
			@include_once (phpAds_path.'/libraries/resources/res-continent.inc.php');
			$continent = $phpAds_continent[$country];
			
			return (array (
				'country' => $country,
				'continent' => $continent,
				'region' => false
			));
		}
	}
	else
		return (false);
}

?>