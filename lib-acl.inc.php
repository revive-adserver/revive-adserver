<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Check if the ACL is valid                             */
/*********************************************************/

function phpAds_aclCheck($request, $row) 
{
	global $phpAds_config;
	
	$bannerID = $row['bannerID'];
	
	// Execute Query
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_acls']."
					 	   WHERE bannerID = $bannerID ORDER by acl_order");
	
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
		switch ($aclrow['acl_type']) 
		{
			case 'clientip':
				$result = phpAds_aclCheckClientIP($request, $aclrow);
				break;
			case 'useragent':
				$result = phpAds_aclCheckUseragent($request, $aclrow);
				break;
			case 'language':
				$result = phpAds_aclCheckLanguage($request, $aclrow);
				break;
			case 'weekday':
				$result = phpAds_aclCheckWeekday($request, $aclrow);
				break;
			case 'domain':
				$result = phpAds_aclCheckDomain($request, $aclrow);
				break;
			case 'source':
				$result = phpAds_aclCheckSource($request, $aclrow);
				break;
			case 'time':
				$result = phpAds_aclCheckTime($request, $aclrow);
				break;
			default:
				return(0);
		}
		
		if ($i == 0)
			$expression .= ($result == true ? 'true' : 'false').' ';
		else
			$expression .= $aclrow['acl_con'].' '.($result == true ? 'true' : 'false').' ';
		
		$i++;
	}
	
	// Evaluate expression and return
	eval('$result = ('.$expression.');');
	return($result);
}



/*********************************************************/
/* Check if the Weekday ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckWeekday($request, $aclrow) 
{
	$data = $aclrow['acl_data'];
	$day = $request['weekday'];
	
	$expression = ($data == "*" || $data == $day || in_array ($day, explode(',', $data)));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Useragent ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckUseragent($request, $aclrow) 
{
	$data = $aclrow['acl_data'];
	$agent = $request['user_agent'];
	
	$expression = ($data == "*" || eregi($data, $agent));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Client IP ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckClientip($request, $aclrow) 
{
	$data = $aclrow['acl_data'];
	$host = $request['remote_host'];
	
	list ($net, $mask) = explode('/', $data);
	
	if ($mask == '')
	{
		$net 	= explode('.', $net);
		
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
		$net 	= explode('.', $net);
		$pnet 	= pack('C4', $net[0], $net[1], $net[2], $net[3]);
		$mask 	= explode('.', $mask);
		$pmask 	= pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
	}
	
	$host 	= explode('.', $host);
	$phost 	= pack('C4', $host[0], $host[1], $host[2], $host[3]);
	
	$expression = ($data == "*" || ($phost & $pmask) == $pnet);
	$operator   = ($aclrow['acl_ad'] == 'allow');
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Domain ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckDomain($request, $aclrow) 
{
	$data 		= $aclrow['acl_data'];
	$ip 		= $request['remote_host'];
	$host 		= @gethostbyaddr($ip);
	
	if ($host == $ip)
		return (true);
	
	$domain 	= substr($host,-(strlen($data)+1));
	$expression = ($data == "*" || strtolower($domain) == strtolower(".$data")) ;
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Language ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckLanguage($request, $aclrow) 
{
	$data = $aclrow['acl_data'];
	$source = $request['accept-language'];
	
	$expression = ($data == "*" || eregi("^".$data, $source));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Source ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckSource($request, $aclrow) 
{
	$data = $aclrow['acl_data'];
	$source = $request['source'];
	
	$expression = ($data == "*" || strtolower($source) == strtolower($data));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Time ACL is valid                        */
/*********************************************************/

function phpAds_aclCheckTime($request, $aclrow) 
{
	$data = $aclrow['acl_data'];
	$time = $request['time'];
	
	$expression = ($data == "*" || $data == $time || in_array ($time, explode(',', $data)));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}

?>
