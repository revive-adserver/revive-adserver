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



/*********************************************************/
/* Check if the ACL is valid                             */
/*********************************************************/

function phpAds_aclCheck($row, $source)
{
	global $phpAds_config;
	
	if (isset($row['compiledlimitation']) &&
		$row['compiledlimitation'] != '')
	{
		eval('$result = ('.$row['compiledlimitation'].');');
		return($result);
	}
	else
	{
		$bannerid = $row['bannerid'];
		
		// Execute Query
		$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_acls']."
						 	   WHERE bannerid = '$bannerid' ORDER by acl_order");
		
		if (phpAds_dbNumRows($res) == 0)
		{
			// No ACLs, show banner
			return(true);
		}
		
		// Check all ACLs
		$expression = '';
		$i = 0;
		
		while ($aclrow = phpAds_dbFetchArray($res)) 
		{
			if ($i > 0)
				$expression .= ' '.$aclrow['acl_con'].' ';
			
			switch ($aclrow['acl_type'])
			{
				case 'clientip':
					$expression .= "phpAds_aclCheckClientIP('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'useragent':
					$expression .= "phpAds_aclCheckUseragent('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'browser':
					$expression .= "phpAds_aclCheckUseragent('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'os':
					$expression .= "phpAds_aclCheckUseragent('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'language':
					$expression .= "phpAds_aclCheckLanguage('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'country':
					$expression .= "phpAds_aclCheckCountry('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'continent':
					$expression .= "phpAds_aclCheckContinent('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'weekday':
					$expression .= "phpAds_aclCheckWeekday('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'domain':
					$expression .= "phpAds_aclCheckDomain('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				case 'source':
					$expression .= "phpAds_aclCheckSource('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."', '".$source."')";
					break;
				case 'time':
					$expression .= "phpAds_aclCheckTime('".addslashes($aclrow['acl_data'])."', '".$aclrow['acl_ad']."')";
					break;
				default:
					return(0);
			}
			
			$i++;
		}
		
		// Evaluate expression and return
		@eval('$result = ('.$expression.');');
		
		return($result);
	}
}



/*********************************************************/
/* Check if the Weekday ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckWeekday($data, $ad)
{
	if ($data == '')
		return (true);
	
	$day = date('w');
	
	$expression = ($data == "*" || $data == $day || in_array ($day, explode(',', $data)));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Useragent ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckUseragent($data, $ad)
{
	global $HTTP_SERVER_VARS;
	
	if ($data == '')
		return (true);
	
	$agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	
	$expression = ($data == "*" || eregi($data, $agent));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Client IP ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckClientip($data, $ad)
{
	global $HTTP_SERVER_VARS;
	
	if ($data == '')
		return (true);
	
	$host = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	
	if (!strpos($data, '/'))
	{
		$net = explode('.', $data);
		
		for ($i=0;$i<sizeof($net);$i++)
		{
			if ($net[$i] == '*')
			{
				$net[$i] = 0;
				$mask[$i] = 0;
			}
			else
				$mask[$i] = 255;
		}
		
		$pnet 	= pack('C4', $net[0], $net[1], $net[2], $net[3]);
		$pmask 	= pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
	}
	else
	{
		list ($net, $mask) = explode('/', $data);
		
		$net 	= explode('.', $net);
		$pnet 	= pack('C4', $net[0], $net[1], $net[2], $net[3]);
		$mask 	= explode('.', $mask);
		$pmask 	= pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
	}
	
	$host 	= explode('.', $host);
	$phost 	= pack('C4', $host[0], $host[1], $host[2], $host[3]);
	
	$expression = ($data == "*" || ($phost & $pmask) == $pnet);
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Domain ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckDomain($data, $ad)
{
	global $HTTP_SERVER_VARS;
	
	if ($data == '')
		return (true);
	
	$host = $HTTP_SERVER_VARS['REMOTE_HOST'];
	
	$domain 	= substr($host,-(strlen($data)));
	$expression = ($data == "*" || strtolower($domain) == strtolower($data)) ;
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Language ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckLanguage($data, $ad)
{
	global $HTTP_SERVER_VARS;
	
	if ($data == '')
		return (true);
	
	$source = $HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE'];
	
	$expression = ($data == "*" || eregi('^('.$data.')', $source));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Source ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckSource($data, $ad, $source)
{
	if ($data == '')
		return (true);
	
	$expression = ($data == "*" || strtolower($source) == strtolower($data) || 
				   eregi('^'.str_replace('*', '[a-z0-9]*', $data).'$', $source));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Time ACL is valid                        */
/*********************************************************/

function phpAds_aclCheckTime($data, $ad)
{
	if ($data == '')
		return (true);
	
	$time = date('G');
	
	$expression = ($data == "*" || $data == $time || in_array ($time, explode(',', $data)));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Country ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckCountry($data, $ad)
{
	global $HTTP_SERVER_VARS, $phpAds_CountryLookup, $phpAds_config;
	
	// Geotracking not enabled, return true
	if ($phpAds_config['geotracking_type'] == 0)
		return (true);
	
	if (!isset($phpAds_CountryLookup))
	{
		switch ($phpAds_config['geotracking_type'])
		{
			case 1:	@include_once (phpAds_path."/libraries/geotargeting/geo-ip2country.inc.php");
					$phpAds_CountryLookup = phpAds_countryCodeByAddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
					break;
				
			case 2:	@include_once (phpAds_path."/libraries/geotargeting/geo-geoip.inc.php");
					$phpAds_CountryLookup = phpAds_countryCodeByAddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
					break;
				
			case 3:	@include_once (phpAds_path."/libraries/geotargeting/geo-mod_geoip.inc.php");
					$phpAds_CountryLookup = phpAds_countryCodeByAddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
					break;
				
			default: $phpAds_CountryLookup = false;
		}
	}
	
	// Allow if no info is available
	if ($phpAds_CountryLookup == false)	return (true);
	
	// Evaluate country code
	$expression = ($data == $phpAds_CountryLookup || in_array ($phpAds_CountryLookup, explode(',', $data)));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Continent ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckContinent($data, $ad)
{
	global $HTTP_SERVER_VARS, $phpAds_CountryLookup, $phpAds_ContinentLookup, $phpAds_config;
	
	// Geotracking not enabled, return true
	if ($phpAds_config['geotracking_type'] == 0)
		return (true);
	
	if (!isset($phpAds_ContinentLookup))
	{
		if (!isset($phpAds_CountryLookup))
		{
			switch ($phpAds_config['geotracking_type'])
			{
				case 1:	@include_once (phpAds_path."/libraries/geotargeting/geo-ip2country.inc.php");
						$phpAds_CountryLookup = phpAds_countryCodeByAddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
						break;
					
				case 2:	@include_once (phpAds_path."/libraries/geotargeting/geo-geoip.inc.php");
						$phpAds_CountryLookup = phpAds_countryCodeByAddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
						break;
					
				case 3:	@include_once (phpAds_path."/libraries/geotargeting/geo-mod_geoip.inc.php");
						$phpAds_CountryLookup = phpAds_countryCodeByAddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
						break;
					
				default: $phpAds_CountryLookup = false;
			}
		}
		
		// Allow if no info is available
		if ($phpAds_CountryLookup == false)	return (true);
		
		// Get continent code
		@include_once (phpAds_path.'/libraries/resources/res-continent.inc.php');
		$phpAds_ContinentLookup = $phpAds_continent[$phpAds_CountryLookup];
	}
	
	// Evaluate continent code
	$expression = ($data == $phpAds_ContinentLookup || in_array ($phpAds_ContinentLookup, explode(',', $data)));
	$operator   = $ad == 'allow';
	return ($expression == $operator);
}

?>