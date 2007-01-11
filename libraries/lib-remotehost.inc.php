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



// Check for proxyserver
phpAds_proxyLookup();

// Reverse lookup
phpAds_reverseLookup();

// Geotargeting lookup
// Use global var in case the script is called from a function
$GLOBALS['phpAds_geo'] = phpAds_geoLookup();



/*********************************************************/
/* Do the proxy lookup                                   */
/*********************************************************/

function phpAds_proxyLookup()
{
	global $phpAds_config;
	
	if (!$phpAds_config['proxy_lookup'])
		return;
	
	$proxy = false;
	if (isset ($_SERVER['HTTP_VIA']) && $_SERVER['HTTP_VIA'] != '') $proxy = true;
	
	if (isset ($_SERVER['REMOTE_HOST']))
	{
		if (is_int (strpos ($_SERVER['REMOTE_HOST'], 'proxy')))	$proxy = true;
		if (is_int (strpos ($_SERVER['REMOTE_HOST'], 'cache')))	$proxy = true;
		if (is_int (strpos ($_SERVER['REMOTE_HOST'], 'inktomi')))	$proxy = true;
	}
	
	if ($proxy)
	{
		$IP = '';

		// Overwrite host address if a suitable header is found
		if (isset($_SERVER['HTTP_FORWARDED']) && 		$_SERVER['HTTP_FORWARDED'] != '') 		 $IP = $_SERVER['HTTP_FORWARDED'];
		if (isset($_SERVER['HTTP_FORWARDED_FOR']) &&	$_SERVER['HTTP_FORWARDED_FOR'] != '') 	 $IP = $_SERVER['HTTP_FORWARDED_FOR'];
		if (isset($_SERVER['HTTP_X_FORWARDED']) &&		$_SERVER['HTTP_X_FORWARDED'] != '') 	 $IP = $_SERVER['HTTP_X_FORWARDED'];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) &&	$_SERVER['HTTP_X_FORWARDED_FOR'] != '') $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if (isset($_SERVER['HTTP_CLIENT_IP']) &&		$_SERVER['HTTP_CLIENT_IP'] != '') 		 $IP = $_SERVER['HTTP_CLIENT_IP'];
		
		// Get last item from list
		$IP = explode (',', $IP);
		$IP = trim($IP[count($IP) - 1]);
		
		if ($IP && $IP != 'unknown' && !phpAds_PrivateSubnet($IP))
		{
			$_SERVER['REMOTE_ADDR'] = $IP;
			$_SERVER['REMOTE_HOST'] = '';
		}
	}
}



/*********************************************************/
/* Do the reverse lookup                                 */
/*********************************************************/

function phpAds_reverseLookup()
{
	global $phpAds_config;
	
	if (!isset($_SERVER['REMOTE_HOST']) || $_SERVER['REMOTE_HOST'] == '')
	{
		if ($phpAds_config['reverse_lookup'])
			$_SERVER['REMOTE_HOST'] = @gethostbyaddr ($_SERVER['REMOTE_ADDR']);
		else
			$_SERVER['REMOTE_HOST'] = $_SERVER['REMOTE_ADDR'];
	}
}



/*********************************************************/
/* Do the geotargeting lookup                            */
/*********************************************************/

function phpAds_geoLookup()
{
	global $phpAds_config, $phpAds_geoPluginID;
	
	if (!$phpAds_config['geotracking_type'])
		return;
	
	// Load plugin
	$phpAds_geoPlugin = phpAds_path."/libraries/geotargeting/geo-".$phpAds_config['geotracking_type'].".inc.php";
	if (@file_exists($phpAds_geoPlugin))
	{
		include_once ($phpAds_geoPlugin);
		
		if (isset($_COOKIE['phpAds_geoInfo']))
		{
			// Use cookie if available
			$geoinfo = explode('|', $_COOKIE['phpAds_geoInfo']);
			
			if (count($geoinfo) == 13)
			{
				$geoinfo = array(
						'country'		=> $geoinfo[0] != '' ?	$geoinfo[0] :	false,
						'continent'		=> $geoinfo[1] != '' ?	$geoinfo[1] :	false,
						'region'		=> $geoinfo[2] != '' ?	$geoinfo[2] :	false,
						'fips_code'		=> $geoinfo[3] != '' ?	$geoinfo[3] :	false,
						'city'			=> $geoinfo[4] != '' ?	$geoinfo[4] :	false,
						'postal_code'	=> $geoinfo[5] != '' ?	$geoinfo[5] :	false,
						'latitude'		=> $geoinfo[6] != '' ?	$geoinfo[6] :	false,
						'longitude'		=> $geoinfo[7] != '' ?	$geoinfo[7] :	false,
						'dma_code'		=> $geoinfo[8] != '' ?	$geoinfo[8] :	false,
						'area_code'		=> $geoinfo[9] != '' ?	$geoinfo[9] :	false,
						'org_isp'		=> $geoinfo[10] != '' ? $geoinfo[10] :	false,
						'netspeed'		=> $geoinfo[11] != '' ? $geoinfo[11] :	false,
						'fingerprint'	=> $geoinfo[12] != '' ? $geoinfo[12] :	false
					);
				
				// Check cookie validity
				$fingerprint = call_user_func('phpAds_'.$phpAds_geoPluginID.'_getFingerprint');
				
				if ($geoinfo['fingerprint'] == $fingerprint)
					return $geoinfo;
			}
		}
	
		// No cookie or invalid cookie
		$geoinfo =  call_user_func('phpAds_'.$phpAds_geoPluginID.'_getGeo',
				$_SERVER['REMOTE_ADDR'],
				$phpAds_config['geotracking_location']
			);
		
		// Add fingerprint
		$geoinfo['fingerprint'] = call_user_func('phpAds_'.$phpAds_geoPluginID.'_getFingerprint');
		
		return $geoinfo;
	}
	
	return false;
}


/*********************************************************/
/* Match an IP address against a subnet                  */
/*********************************************************/

function phpAds_matchSubnet($ip, $net, $mask)
{
	if (!is_integer($ip)) $ip = ip2long($ip);
	$net = ip2long($net);
	
	if (!$ip || !$net)
		return false;
	
	if (is_integer($mask))
	{
		// Netmask notation x.x.x.x/y used
		
		if ($mask > 32 || $mask <= 0)
			return false;
		elseif ($mask == 32)
			$mask = ~0;
		else
			$mask = ~((1 << (32 - $mask)) - 1);
	}
	elseif (!($mask = ip2long($mask)))
		return false;
	
	return ($ip & $mask) == ($net & $mask) ? true : false;
}



/*********************************************************/
/* Check if an IP address is not publicly routable       */
/*********************************************************/

function phpAds_PrivateSubnet($ip)
{
	$ip = ip2long($ip);
	
	if (!$ip) return false;
	
	return (phpAds_matchSubnet($ip, '10.0.0.0', 8) || 
		phpAds_matchSubnet($ip, '172.16.0.0', 12) ||
		phpAds_matchSubnet($ip, '192.168.0.0', 16) ||
		phpAds_matchSubnet($ip, '127.0.0.0', 24)
		);
}

?>