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


/* PUBLIC FUNCTIONS */

$phpAds_geoPluginID = 'mod_geoip';

function phpAds_mod_geoip_getInfo()
{
	return (array (
		'name'	    => 'MaxMind GeoIP (mod)',
		'db'	    => false,
		'country'   => true,
		'continent' => true,
		'region'	=> false
	));
}


function phpAds_mod_geoip_getGeo($addr, $db)
{
	// $addr and $db parameter is ignored and is here for API consistency only
	
	$country = @apache_note('GEOIP_COUNTRY_CODE');
	
	if ($country != '' && $country != '--')
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
	else
		return (false);
}

?>