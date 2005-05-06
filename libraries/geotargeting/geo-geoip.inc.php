<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* Based on MaxMind GeoIP C API - Copyright (C) 2003 MaxMind LLC        */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


/* PUBLIC FUNCTIONS */

$phpAds_geoPluginID = 'geoip';

function phpAds_geoip_getInfo($db = false)
{
	$ret = array (
		'name'	    	=> 'MaxMind GeoIP Unified Plug-In (supports any database type)',
		'db'	    	=> true
	);
		
	if ($db && ($fp = @fopen($db, "rb")))
	{
		$info = phpAds_geoip_get_info($fp);
		
		$ret = array_merge($ret, $info['capabilities']);
		
		@fclose($fp);
	}

	return $ret;
}


function phpAds_geoip_getConf($db)
{
	$ret = '';
	
	if ($db && ($fp = @fopen($db, "rb")))
	{
		$info = phpAds_geoip_get_info($fp);
		
		$ret = serialize($info['plugin_conf']);
		
		@fclose($fp);
	}

	return $ret;
}


function phpAds_geoip_getGeo($addr, $db)
{
	if ($db == '')
		return false;
	
	$ipnum = ip2long($addr);
	
	if ($fp = @fopen($db, "rb"))
	{
		$continent = false;
		
		$res = phpAds_geoip_seek($fp, $ipnum);
		
		if (!is_array($res))
			return false;
		
		list($country,
			$region,
			$fips_code,
			$city,
			$postal_code,
			$latitude,
			$longitude,
			$dma_code,
			$area_code,
			$org_isp,
			$netspeed
		) = $res;
		
		@fclose($fp);
		
		if ($country != '' && $country != '--')
		{
			// Get continent code
			@include_once (phpAds_path.'/libraries/resources/res-continent.inc.php');
			$continent = $phpAds_continent[$country];
		}
		
		return (array (
			'country'		=> $country,
			'continent'		=> $continent,
			'region'		=> $region,
			'fips'			=> $fips_code,
			'city'			=> $city,
			'postal_code'	=> $postal_code,
			'latitude'		=> $latitude,
			'longitude'		=> $longitude,
			'dma_code'		=> $dma_code,
			'area_code'		=> $area_code,
			'org_isp'		=> $org_isp,
			'netspeed'		=> $netspeed
		));
	}
	else
		return false;
}




/* PRIVATE FUNCTIONS */

function phpAds_geoip_get_defaults()
{
	return array(
		'COUNTRY_BEGIN'				=> 16776960,
		'STATE_BEGIN_REV0'			=> 16700000,
		'STATE_BEGIN_REV1'			=> 16000000,
		'GEOIP_STANDARD'			=> 0,
		'GEOIP_MEMORY_CACHE'		=> 1,
		'GEOIP_SHARED_MEMORY'		=> 2,
		'STRUCTURE_INFO_MAX_SIZE'	=> 20,
		'DATABASE_INFO_MAX_SIZE'	=> 100,
		
		'GEOIP_COUNTRY_EDITION'		=> 1,
		'GEOIP_PROXY_EDITION'		=> 8,
		'GEOIP_ASNUM_EDITION'		=> 9,
		'GEOIP_NETSPEED_EDITION'	=> 10,
		'GEOIP_REGION_EDITION_REV0'	=> 7,
		'GEOIP_REGION_EDITION_REV1'	=> 3,
		'GEOIP_CITY_EDITION_REV0'	=> 6,
		'GEOIP_CITY_EDITION_REV1'	=> 2,
		'GEOIP_ORG_EDITION'			=> 5,
		'GEOIP_ISP_EDITION'			=> 4,
		
		'SEGMENT_RECORD_LENGTH'		=> 3,
		'STANDARD_RECORD_LENGTH'	=> 3,
		'ORG_RECORD_LENGTH'			=> 4,
		'MAX_RECORD_LENGTH'			=> 4,
		'MAX_ORG_RECORD_LENGTH'		=> 300,
		'FULL_RECORD_LENGTH'		=> 50,
	
		'US_OFFSET'					=> 1,
		'CANADA_OFFSET'				=> 677,
		'WORLD_OFFSET'				=> 1353,
		'FIPS_RANGE'				=> 360,
		
		'GEOIP_UNKNOWN_SPEED'		=> 0,
		'GEOIP_DIALUP_SPEED'		=> 1,
		'GEOIP_CABLEDSL_SPEED'		=> 2,
		'GEOIP_CORPORATE_SPEED'		=> 3
	);
}

function phpAds_geoip_get_info($fp)
{
	// Default variables
	extract(phpAds_geoip_get_defaults());

	/* default to GeoIP Country Edition */
	$databaseType = $GEOIP_COUNTRY_EDITION;
	$record_length = $STANDARD_RECORD_LENGTH;
	fseek($fp, -3, SEEK_END);
	
	$buf = str_repeat('\0', $SEGMENT_RECORD_LENGTH);
	
	for ($i = 0; $i < $STRUCTURE_INFO_MAX_SIZE; $i++)
	{
		$delim = fread($fp, 3);
		
		if ($delim == "\xFF\xFF\xFF")
		{
		
			$databaseType = ord(fread($fp, 1));

			if ($databaseType >= 106)
			{
				/* backwards compatibility with databases from April 2003 and earlier */
				$databaseType -= 105;
			}

			if ($databaseType == $GEOIP_REGION_EDITION_REV0)
			{
				/* Region Edition, pre June 2003 */
				$databaseSegments = $STATE_BEGIN_REV0;
			}
			elseif ($databaseType == $GEOIP_REGION_EDITION_REV1)
			{
				/* Region Edition, post June 2003 */
				$databaseSegments = $STATE_BEGIN_REV1;
			}
			elseif ($databaseType == $GEOIP_CITY_EDITION_REV0 ||
					$databaseType == $GEOIP_CITY_EDITION_REV1 ||
					$databaseType == $GEOIP_ORG_EDITION ||
					$databaseType == $GEOIP_ISP_EDITION ||
					$databaseType == $GEOIP_ASNUM_EDITION)
			{
				/* City/Org Editions have two segments, read offset of second segment */
				$databaseSegments = 0;
				$buf = fread($fp, $SEGMENT_RECORD_LENGTH);
				for ($j = 0; $j < $SEGMENT_RECORD_LENGTH; $j++)
				{
					$databaseSegments |= (ord($buf{$j}) << ($j << 3));
				}
				if ($databaseType == $GEOIP_ORG_EDITION ||
					$databaseType == $GEOIP_ISP_EDITION)
				{
					$record_length = $ORG_RECORD_LENGTH;
				}
			}
			break;
		}
		else
		{
			fseek($fp, -4, SEEK_CUR);
		}
	}
	
	if ($databaseType == $GEOIP_COUNTRY_EDITION ||
		$databaseType == $GEOIP_PROXY_EDITION ||
		$databaseType == $GEOIP_NETSPEED_EDITION)
	{
		$databaseSegments = $COUNTRY_BEGIN;
	}
	
	if (!isset($databaseSegments))
	{
		// There was an error: db not supported?
		return false;
	}
	
	return array(
		'plugin_conf'	=> array(
			'databaseType' 		=> $databaseType,
			'databaseSegments'	=> $databaseSegments,
			'record_length'		=> $record_length
		),
		'capabilities'	=> array(
			'country'		=> in_array($databaseType, array($GEOIP_COUNTRY_EDITION, $GEOIP_REGION_EDITION_REV0, $GEOIP_REGION_EDITION_REV1, $GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'continent'		=> in_array($databaseType, array($GEOIP_COUNTRY_EDITION, $GEOIP_REGION_EDITION_REV0, $GEOIP_REGION_EDITION_REV1, $GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'region'		=> in_array($databaseType, array($GEOIP_REGION_EDITION_REV0, $GEOIP_REGION_EDITION_REV1, $GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'fips_code'		=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'city'			=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'postal_code'	=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'latitude'		=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'longitude'		=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'dma_code'		=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'area_code'		=> in_array($databaseType, array($GEOIP_CITY_EDITION_REV0, $GEOIP_CITY_EDITION_REV1)),
			'org_isp'		=> in_array($databaseType, array($GEOIP_ORG_EDITION, $GEOIP_ISP_EDITION)),
			'netspeed'		=> $databaseType == $GEOIP_NETSPEED_EDITION
		)
	);
}



function phpAds_geoip_seek($fp, $ipnum)
{
	global $phpAds_config;
	
	// Default variables
	extract(phpAds_geoip_get_defaults());
	
	if ($phpAds_config['geotracking_conf'])
	{
		$conf = @unserialize($phpAds_config['geotracking_conf']);
		if (is_array($conf))
			extract($conf);
	}
		
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
		'VU', 'WF', 'WS', 'YE', 'YT', 'YU', 'ZA', 'ZM', 'ZR', 'ZW', 'A1', 'A2', 'O1'
	);

	$us2fips = array (
		'AL' => '01', 'AK' => '02', 'AZ' => '04', 'AR' => '05', 'CA' => '06', 'CO' => '08',
		'CT' => '09', 'DE' => '10', 'DC' => '11', 'FL' => '12', 'GA' => '13', 'GU' => '14',
		'HI' => '15', 'ID' => '16', 'IL' => '17', 'IN' => '18', 'IA' => '19', 'KS' => '20',
		'KY' => '21', 'LA' => '22', 'ME' => '19', 'MD' => '24', 'MA' => '25', 'MI' => '26',
		'MN' => '27', 'MS' => '28', 'MO' => '29', 'MT' => '30', 'NE' => '31', 'NV' => '32',
		'NH' => '33', 'NJ' => '34', 'NM' => '35', 'NY' => '36', 'NC' => '37', 'ND' => '38',
		'OH' => '39', 'OK' => '40', 'OR' => '41', 'PA' => '42', 'PR' => '43', 'RI' => '44',
		'SC' => '45', 'SD' => '46', 'TN' => '47', 'TX' => '48', 'UT' => '49', 'VT' => '50',
		'VA' => '51', 'VI' => '52', 'WA' => '53', 'WV' => '54', 'WI' => '55', 'WY' => '56'
	);
	
	$ca2fips = array (
		'AB' => '01', 'BC' => '02', 'MB' => '03', 'NB' => '04', 'NF' => '05', 'NS' => '07',
		'NU' => '14', 'ON' => '08', 'PE' => '09', 'QC' => '10', 'SK' => '11', 'NT' => '13',
		'YT' => '12'
	);



	$offset = 0;
	$x = 0 ;
	
	for ($depth = 31; $depth >= 0; $depth--)
	{
		/* read from disk */
		fseek($fp, $record_length * 2 * $offset, SEEK_SET);
		$buf = fread($fp, $record_length * 2);

		if ($ipnum & (1 << $depth))
		{
			/* Take the right-hand branch */
			if ( $record_length == 3 )
			{
				/* Most common case is completely unrolled and uses constants. */
				$x =  (ord($buf{3*1 + 0}) << (0*8))
					+ (ord($buf{3*1 + 1}) << (1*8))
					+ (ord($buf{3*1 + 2}) << (2*8));
			}
			else
			{
				/* General case */
				$j = $record_length;
				$p = 2 * $j;
				$x = 0;
				do {
					$x <<= 8;
					$x += ord($buf{--$p});
				} while ( --$j );
			}

		}
		else
		{
			/* Take the left-hand branch */
			if ( $record_length == 3 )
			{
				/* Most common case is completely unrolled and uses constants. */
				$x =  (ord($buf{3*0 + 0}) << (0*8))
					+ (ord($buf{3*0 + 1}) << (1*8))
					+ (ord($buf{3*0 + 2}) << (2*8));
			}
			else
			{
				/* General case */
				$j = $record_length;
				$p = $j;
				$x = 0;
				do {
					$x <<= 8;
					$x += ord($buf{--$p});
				} while ( --$j );
			}
		}

		if ($x >= $databaseSegments)
		{
			break;
		}
		
		$offset = $x;
	}
	
	// Determine state
	$country		= false;
	$region			= false;
	$fips_code		= false;
	$city			= false;
	$postal_code	= false;
	$latitude		= false;
	$longitude		= false;
	$dma_code		= false;
	$area_code		= false;
	$org_isp		= false;
	$netspeed		= false;
	$proxy			= false;
	
	if ($databaseType == $GEOIP_COUNTRY_EDITION)
	{
		$country = $countrycodes[$x - $COUNTRY_BEGIN];
	}
	elseif ($databaseType == $GEOIP_PROXY_EDITION)
	{
		$proxy = $x - $COUNTRY_BEGIN;
	}
	elseif ($databaseType == $GEOIP_NETSPEED_EDITION)
	{			
		$netspeed = $x - $COUNTRY_BEGIN;
	}
	elseif ($databaseType == $GEOIP_REGION_EDITION_REV0) 
	{
		/* Region Edition, pre June 2003 */
		$seek_region = $x - $STATE_BEGIN_REV0;
		if ($seek_region >= 1000)
		{
			$country = 'US';
			$region = chr(floor(($seek_region - 1000) / 26) + 65).chr(($seek_region - 1000) % 26 + 65);
		}
		else
		{
			$country = $countrycodes[$seek_region];
		}
	}
	elseif ($databaseType == $GEOIP_REGION_EDITION_REV1)
	{
		/* Region Edition, post June 2003 */
		$seek_region = $x - $STATE_BEGIN_REV1;
		if ($seek_region < $US_OFFSET)
		{
			/* Unknown */
			/* we don't need to do anything here b/c we set country and region to 0 */
		}
		elseif ($seek_region < $CANADA_OFFSET)
		{
			/* USA State */
			$country = 'US';
			$region = chr(floor(($seek_region - $US_OFFSET) / 26) + 65).chr(($seek_region - $US_OFFSET) % 26 + 65);
		}
		elseif (seek_region < WORLD_OFFSET)
		{
			/* Canada Province */
			$country = 'US';
			$region = chr(floor(($seek_region - $CANADA_OFFSET) / 26) + 65).chr(($seek_region - $CANADA_OFFSET) % 26 + 65);
		} else {
			/* Not US or Canada */
			$country = $countrycodes[floor(($seek_region - $WORLD_OFFSET) / $FIPS_RANGE)];
			$fips_code = sprintf("%02d", ($seek_region - $WORLD_OFFSET) % $FIPS_RANGE);
		}
	}
	elseif ($databaseType == $GEOIP_ORG_EDITION ||
			$databaseType == $GEOIP_ISP_EDITION ||
			$databaseType == $GEOIP_ASNUM_EDITION)
	{
		$seek_org = $x;
		if ($seek_org != $databaseSegments)
		{
			$record_pointer = $seek_org + (2 * $record_length - 1) * $databaseSegments;
			
			fseek($fp, $record_pointer, SEEK_SET);
			$buf = fread($fp, $MAX_ORG_RECORD_LENGTH);
			
			switch ($databaseType)
			{
				case $GEOIP_ORG_EDITION:
				case $GEOIP_ISP_EDITION:	$var = 'org_isp'; break;
				case $GEOIP_ASNUM_EDITION:	$var = 'asnum'; break;
			}
			
			$$var = substr($buf, 0, strpos($buf, "\0"));
		}
	}
	elseif ($databaseType == $GEOIP_CITY_EDITION_REV0 ||
			$databaseType == $GEOIP_CITY_EDITION_REV1)
	{
		$record_pointer = $x + (2 * $record_length - 1) * $databaseSegments;
	
		fseek($fp, $record_pointer, SEEK_SET);

		$record_buf = fread($fp, $FULL_RECORD_LENGTH);
		if (!strlen($record_buf)) {
			/* eof or other error */
			return false;
		}
	
		/* get country */
		$country = $countrycodes[ord($record_buf{0})];
		$record_buf = substr($record_buf, 1);
	
		/* get region */
		$region = substr($record_buf, 0, strpos($record_buf, "\0"));
		if ($country != 'US' && $country != 'CA')
		{
			$fips_code = $region;
			$region = false;
		}
		else
		{
			if ($country == 'US' && isset($us2fips[$region]))
				$fips_code = $us2fips[$region];
			elseif ($country == 'CA' && isset($ca2fips[$region]))
				$fips_code = $ca2fips[$region];
		}
		
		$record_buf = substr($record_buf, strpos($record_buf, "\0") + 1);
	
		/* get city */
		$city = substr($record_buf, 0, strpos($record_buf, "\0"));
		$record_buf = substr($record_buf, strpos($record_buf, "\0") + 1);
	
		/* get postal code */
		$postal_code = substr($record_buf, 0, strpos($record_buf, "\0"));
		$record_buf = substr($record_buf, strpos($record_buf, "\0") + 1);
	
		/* get latitude */
		$latitude = 0;
		for ($j = 0; $j < 3; ++$j)
			$latitude += (ord($record_buf{$j}) << ($j * 8));
		$latitude = $latitude/10000 - 180;
		$record_buf = substr($record_buf, 3);
	
		/* get longitude */
		$longitude = 0;
		for ($j = 0; $j < 3; ++$j)
			$longitude += (ord($record_buf{$j}) << ($j * 8));
		$longitude = $longitude/10000 - 180;
	
		/* get area code and dma code for post April 2002 databases and for US locations */
		if ($GEOIP_CITY_EDITION_REV1 == $databaseType)
		{
			if ($country == "US")
			{
				$record_buf = substr($record_buf, 3);
				$dmaarea_combo = 0;
				for ($j = 0; $j < 3; ++$j)
					$dmaarea_combo += (ord($record_buf{$j}) << ($j * 8));
				$dma_code	= floor($dmaarea_combo / 1000);
				$area_code	= $dmaarea_combo % 1000;
			}
		}
	}
	
	return array(
		$country,
		$region,
		$fips_code,
		$city,
		$postal_code,
		$latitude,
		$longitude,
		$dma_code,
		$area_code,
		$org_isp,
		$netspeed
	);
}


?>