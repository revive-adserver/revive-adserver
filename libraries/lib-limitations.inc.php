<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
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
	global $HTTP_SERVER_VARS;
	
	if ($data == '')
		return (true);
	
	$agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	
	$expression = ($data == "*" || preg_match('#'.$data.'#', $agent));
	$operator   = $ad == '==';
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
	$operator   = $ad == '==';
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
	$operator   = $ad == '==';
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
	
	$expression = ($data == "*" || preg_match('#^('.$data.')#', $source));
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
/* Check if the Referer ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckReferer($data, $ad)
{
	global $HTTP_SERVER_VARS;
	
	if ($data == '')
		return (true);
	
	$referer = isset($HTTP_SERVER_VARS['HTTP_REFERER']) ? strtolower($HTTP_SERVER_VARS['HTTP_REFERER']) : '';
	$expression = strpos($referer, strtolower($data));
	$expression = is_int($expression);
	$operator   = $ad == '==';
	return ($expression == $operator);
}

?>