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

$phpAds_geoPluginID = 'geoipregion';

function phpAds_geoipregion_getInfo()
{
	return (array (
		'name'	    	=> 'MaxMind GeoIP Region Edition',
		'db'	    	=> true,
		'country'   	=> true,
		'continent' 	=> true,
		'region'    	=> true
	));
}


function phpAds_geoipregion_getGeo($addr, $db)
{
	if ($db == '')
		return false;
	
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
	
	if ($fp = @fopen($db,"rb"))
	{
		list($country, $region) = phpAds_geoipregion_seek_country($fp, $ipnum);
		
		@fclose($fp);
		
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
			return false;
	}
	else
		return false;
}




/* PRIVATE FUNCTIONS */

function phpAds_geoipregion_seek_country($fp, $ipnum)
{
	// Default variables
	$record_length_segment = 3;
	$record_length_standard = 3;
	$record_length_org = 4;
	$record_length_max = 4;
	$record_length_max_org = 300;
	$structure_info_max_size = 20;
	$database_info_max_size = 100;
	
	$geoip_country_edition = 106;
	$geoip_region_edition_rev0 = 112;
	$geoip_region_edition_rev1 = 3;
	$geoip_city_edition = 111;
	$geoip_org_edition = 110;
	
	$geoip_state_begin_rev0 = 16700000;
	$geoip_state_begin_rev1 = 16000000;
	$geoip_country_begin = 16776960;
	
	$geoip_us_offset = 1;
	$geoip_canada_offset = 677;
	$geoip_world_offset = 1353;
	$geoip_fips_range = 360;	
	

	
	// Setup segments
	$filepos = @ftell($fp);
	@fseek($fp, -3, SEEK_END);
	
	// Setup defaults
	$type = $geoip_country_edition;
	$record_length = $record_length_standard;
		
			
	for ($i = 0; $i < $structure_info_max_size; $i++) 
	{
		$delim = @fread($fp, 3);
	    
		if ($delim == (chr(255).chr(255).chr(255)))
		{
			$type = ord(@fread($fp, 1));
			
			if ($type == $geoip_region_edition_rev0)
			{
		        	$seg = $geoip_state_begin_rev0;
		    	}
		    	elseif ($type == $geoip_region_edition_rev1)
		    	{
		    		$seg = $geoip_state_begin_rev1;	
		    	}
			elseif ($type == $geoip_city_edition ||
				$type == $geoip_org_edition)
			{
		        	$seg = 0;
		        	$buf = @fread($fp, $record_length_segment);
		        
				for ($j = 0; $j < $record_length_segment; $j++)
		        		$seg += (ord($buf[$j]) << ($j * 8));
		        	
		        	if ($type == $geoip_org_edition)
		        		$record_length = $record_length_org;
		    	}
		    
			break;
		}
		else
			@fseek($fp, -4, SEEK_CUR);
	}
	
	if ($type == $geoip_country_edition)
		$seg = $geoip_country_begin;
	
	@fseek($fp, $filepos, SEEK_SET);
	
	
	// Seek country
	$offset = 0;
	$reg = -1;
	
	for ($depth = 31; $depth >= 0; --$depth)
	{
		if (@fseek($fp, 2 * $record_length * $offset, SEEK_SET) == 0)
			$buf = @fread($fp, 2 * $record_length);
		else
		{
			$reg = -1;
			break;
		}
		
		$x = array(0,0);
		
		for ($i = 0; $i < 2; ++$i)
			for ($j = 0; $j < $record_length; ++$j)
        			$x[$i] += ord($buf[$record_length * $i + $j]) << ($j * 8);
		
    		if ($ipnum & (1 << $depth))
		{
			if ($x[1] >= $seg)
			{
				$reg = $x[1];
				break;
			}
			
			$offset = $x[1];
		}
    		else
		{
			if ($x[0] >= $seg)
			{
				$reg = $x[0];
				break;
			}
      		
			$offset = $x[0];
		}
	}
	

	// Determine state
	$country = false;
	$region = false;

	if ($type == $geoip_region_edition_rev0)
	{
		$reg = $reg - $geoip_state_begin_rev0;
		
		if ($reg < 0)
		{
	  		$country = false;
			$region = false;
		}
		elseif ($reg >= 1000)
		{
			$country = 'US';
			$region = chr(($reg - 1000) / 26 + 65) . chr(($reg - 1000) % 26 + 65);
		}
		else
		{
			$country = $countrycodes[$reg];
			$region = false;
		}
	}
	elseif ($type == $geoip_region_edition_rev1)
	{
		$reg = $reg - $geoip_state_begin_rev1;
		
		if ($reg < $geoip_us_offset)
		{
	  		$country = false;
			$region = false;
		}
		elseif ($reg < $geoip_canada_offset)
		{
			$country = 'US';
			$region = chr(($reg - $geoip_us_offset) / 26 + 65) . chr(($reg - $geoip_us_offset) % 26 + 65);
		}
		elseif ($reg < $geoip_world_offset)
		{
			$country = 'CA';
			$region = chr(($reg - $geoip_canada_offset) / 26 + 65) . chr(($reg - $geoip_canada_offset) % 26 + 65);
		}
		else
		{
			$country = $countrycodes[($reg - $geoip_world_offset) / $geoip_fips_range];
			$region = false;
		}
	}

	return (array($country, $region));
}


?>