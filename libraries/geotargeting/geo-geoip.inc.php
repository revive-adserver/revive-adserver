<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Portions Copyright (c) 2000-2003 by the phpAdsNew developers         */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* Adapted from software created by Jim Winstead <jimw@apache.org>      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/* PUBLIC FUNCTIONS */

$phpAds_geoPluginID = 'geoip';

function phpAds_geoip_getInfo()
{
	return (array (
		'name'	    => 'MaxMind GeoIP Country Edition',
		'db'	    => true,
		'country'   => true,
		'continent' => true,
		'region'    => false
	));
}

function phpAds_geoip_getGeo($addr, $db)
{
	if ($db == '')
		return false;
	
	$countrybegin = 16776960;
	$countrycodes = array(
		false, 'AP', 'EU', 'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'AN', 'AO', 'AQ',
		'AR', 'AS', 'AT', 'AU', 'AW', 'AZ', 'BA', 'BB', 'BD', 'BE', 'BF', 'BG', 'BH',
		'BI', 'BJ', 'BM', 'BN', 'BO', 'BR', 'BS', 'BT', 'BV', 'BW', 'BY', 'BZ', 'CA',
		'CC', 'CD', 'CF', 'CG', 'CH', 'CI', 'CK', 'CL', 'CM', 'CN', 'CO', 'CR', 'CU',
		'CV', 'CX', 'CY', 'CZ', 'DE', 'DJ', 'DK', 'DM', 'DO', 'DZ', 'EC', 'EE', 'EG',
		'EH', 'ER', 'ES', 'ET', 'FI', 'FJ', 'FK', 'FM', 'FO', 'FR', 'FX', 'GA', 'GB',
		'GD', 'GE', 'GF', 'GH', 'GI', 'GL', 'GM', 'GN', 'GP', 'GQ', 'GR', 'GS', 'GT',
		'GU', 'GW', 'GY', 'HK', 'HM', 'HN', 'HR', 'HT', 'HU', 'ID', 'IE', 'IL', 'IN',
		'IO', 'IQ', 'IR', 'IS', 'IT', 'JM', 'JO', 'JP', 'KE', 'KG', 'KH', 'KI', 'KM',
		'KN', 'KP', 'KR', 'KW', 'KY', 'KZ', 'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS',
		'LT', 'LU', 'LV', 'LY', 'MA', 'MC', 'MD', 'MG', 'MH', 'MK', 'ML', 'MM', 'MN',
		'MO', 'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ', 'NA',
		'NC', 'NE', 'NF', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU', 'NZ', 'OM', 'PA',
		'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN', 'PR', 'PS', 'PT', 'PW', 'PY',
		'QA', 'RE', 'RO', 'RU', 'RW', 'SA', 'SB', 'SC', 'SD', 'SE', 'SG', 'SH', 'SI',
		'SJ', 'SK', 'SL', 'SM', 'SN', 'SO', 'SR', 'ST', 'SV', 'SY', 'SZ', 'TC', 'TD',
		'TF', 'TG', 'TH', 'TJ', 'TK', 'TM', 'TN', 'TO', 'TP', 'TR', 'TT', 'TV', 'TW',
		'TZ', 'UA', 'UG', 'UM', 'US', 'UY', 'UZ', 'VA', 'VC', 'VE', 'VG', 'VI', 'VN',
		'VU', 'WF', 'WS', 'YE', 'YT', 'YU', 'ZA', 'ZM', 'ZR', 'ZW'
	);
	
	$ipnum = ip2long($addr);
	
	if ($fp = @fopen($db, 'rb'))
	{
		$country = $countrycodes[phpAds_geoip_seekCountry($fp, 0, $ipnum, 31, $countrybegin)];
		@fclose ($fp);
		
		
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



/* PRIVATE FUNCTIONS */

function phpAds_geoip_seekCountry($gi, $offset, $ipnum, $depth, $countrybegin)
{
	if ($depth < 0)
		return (false);
	
	if (@fseek($gi, 6 * $offset, SEEK_SET) != 0) return (false);
	$buf = @fread($gi,6);
	
	$x = array(0,0);
	for ($i = 0; $i < 2; ++$i)
		for ($j = 0; $j < 3; ++$j)
			$x[$i] += ord($buf[($i*3)+$j]) << ($j * 8);
	
	if ($ipnum & (1 << $depth))
	{
		if ($x[1] >= $countrybegin)
			return $x[1] - $countrybegin;
		
		return phpAds_geoip_seekCountry($gi, $x[1], $ipnum, $depth - 1, $countrybegin);
	}
	else
	{
		if ($x[0] >= $countrybegin)
			return $x[0] - $countrybegin;
		
		return phpAds_geoip_seekCountry($gi, $x[0], $ipnum, $depth - 1, $countrybegin);
	}
}

?>