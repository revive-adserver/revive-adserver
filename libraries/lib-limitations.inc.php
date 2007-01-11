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



/*********************************************************/
/* Check if the ACL is valid                             */
/*********************************************************/

function phpAds_aclCheck($row, $source)
{
	global $phpAds_config;
	
	if (isset($row['compiledlimitation']) &&
		$row['compiledlimitation'] != '')
	{
		// Set to true in case of error in eval
		$result = true;
		
		@eval('$result = ('.$row['compiledlimitation'].');');
		return ($result);
	}
	else
		return (true);
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
	$operator   = $ad == '==';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Useragent ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckUseragent($data, $ad)
{
	if ($data == '')
		return (true);
	
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	$expression = ($data == "*" || preg_match('#'.$data.'#', $agent));
	$operator   = $ad == '==';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Client IP ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckClientip($data, $ad)
{
	if ($data == '')
		return (true);
	
	$host = $_SERVER['REMOTE_ADDR'];
	
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
	$operator   = $ad == '==';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Domain ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckDomain($data, $ad)
{
	if ($data == '')
		return (true);
	
	$host = $_SERVER['REMOTE_HOST'];
	
	$domain 	= substr($host,-(strlen($data)));
	$expression = ($data == "*" || strtolower($domain) == strtolower($data)) ;
	$operator   = $ad == '==';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Language ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckLanguage($data, $ad)
{
	if ($data == '')
		return (true);
	
	$source = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
	
	// Split languages list, removing quality values
	$source = preg_split('/, */', preg_replace('/;q=[0-9.]+/', '', $source));

	if ($data != "*")
	{
		$expression = false;

		foreach ($source as $s)
		{
			if (preg_match('/^'.$data.'/', $s))
			{
				$expression = true;
				break;
			}
		}
	}
	else
		$expression = true;

	$operator   = $ad == '==';
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
				   preg_match('#^'.str_replace('*', '.*', $data).'$#i', $source));
	$operator   = $ad == '==';
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
	$operator   = $ad == '==';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Date ACL is valid                        */
/*********************************************************/

function phpAds_aclCheckDate($data, $ad)
{
	if ($data == '' && $data == '00000000')
		return (true);
	
	$date = date('Ymd');
	
	switch ($ad)
	{
		case '==':
			return ($date == $data); break;
		
		case '!=':
			return ($date != $data); break;
		
		case '<=':
			return ($date <= $data); break;
		
		case '>=':
			return ($date >= $data); break;
		
		case '<':
			return ($date < $data);  break;
		
		case '>':
			return ($date > $data);  break;
	}
	
	return (true);
}



/*********************************************************/
/* Check if the Country ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckCountry($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['country'])
	{
		// Evaluate country code
		$expression = ($data == $phpAds_geo['country'] || in_array ($phpAds_geo['country'], explode(',', $data)));
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the Continent ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckContinent($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['continent'])
	{
		// Evaluate continent code
		$expression = ($data == $phpAds_geo['continent'] || in_array ($phpAds_geo['continent'], explode(',', $data)));
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the US State ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckRegion($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['country'] && $phpAds_geo['region'])
	{
		// Evaluate region code
		$expression = ($data == $phpAds_geo['country'].$phpAds_geo['region'] || in_array ($phpAds_geo['country'].$phpAds_geo['region'], explode(',', $data)));
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the FIPS code ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckFipsCode($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['country'] && $phpAds_geo['fips_code'])
	{
		// Evaluate region code
		$expression = ($data == $phpAds_geo['country'].$phpAds_geo['fips_code'] || in_array ($phpAds_geo['country'].$phpAds_geo['fips_code'], explode(',', $data)));
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the city ACL is valid                        */
/*********************************************************/

function phpAds_aclCheckCity($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['city'])
	{
		$data = strtolower($data);
		$expression = strpos(strtolower($phpAds_geo['city']), $data) !== false;
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the postal code ACL is valid                 */
/*********************************************************/

function phpAds_aclCheckPostalCode($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['postal_code'])
	{
		$data = strtolower($data);
		$expression = strpos(strtolower($phpAds_geo['postal_code']), $data) !== false;
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the DMA Code ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckDmaCode($data, $ad)
{
	global $phpAds_geo;
		
	if ($phpAds_geo && $phpAds_geo['dma_code'])
	{
		// Evaluate DMA code
		$expression = ($data == $phpAds_geo['dma_code'] || in_array ($phpAds_geo['dma_code'], explode(',', $data)));
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the area code ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckAreaCode($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['area_code'])
	{
		$data = strtolower($data);
		$expression = strpos(strtolower($phpAds_geo['area_code']), $data) !== false;
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the org/isp ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckOrgISP($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['org_isp'])
	{
		$data = strtolower($data);
		$expression = strpos(strtolower($phpAds_geo['org_isp']), $data) !== false;
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the netspeed ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckNetspeed($data, $ad)
{
	global $phpAds_geo;
	
	if ($phpAds_geo && $phpAds_geo['netspeed'] !== false)
	{
		// Evaluate netspeed code
		$expression = ($data == $phpAds_geo['netspeed'] || in_array ($phpAds_geo['netspeed'], explode(',', $data)));
		$operator   = $ad == '==';
		return ($expression == $operator);
	}
	else
		return ($ad != '==');
}



/*********************************************************/
/* Check if the Referer ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckReferer($data, $ad)
{
	if ($data == '')
		return (true);
	
	$referer = isset($_SERVER['HTTP_REFERER']) ? strtolower($_SERVER['HTTP_REFERER']) : '';
	$expression = strpos($referer, strtolower($data));
	$expression = is_int($expression);
	$operator   = $ad == '==';
	return ($expression == $operator);
}

?>