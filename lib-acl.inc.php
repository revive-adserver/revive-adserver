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

function phpAds_aclCheck($row, $source)
{
	global $phpAds_config;
	
	$bannerid = $row['bannerid'];
	
	// Execute Query
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_acls']."
					 	   WHERE bannerid = $bannerid ORDER by acl_order");
	
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
				$result = phpAds_aclCheckClientIP($aclrow);
				break;
			case 'useragent':
				$result = phpAds_aclCheckUseragent($aclrow);
				break;
			case 'language':
				$result = phpAds_aclCheckLanguage($aclrow);
				break;
			case 'weekday':
				$result = phpAds_aclCheckWeekday($aclrow);
				break;
			case 'domain':
				$result = phpAds_aclCheckDomain($aclrow);
				break;
			case 'source':
				$result = phpAds_aclCheckSource($aclrow, $source);
				break;
			case 'time':
				$result = phpAds_aclCheckTime($aclrow);
				break;
			default:
				return(0);
		}
		
		if ($i == 0)
			$expression .= ($result == true ? 'tr'.'ue' : 'fa'.'lse').' ';
		else
			$expression .= $aclrow['acl_con'].' '.($result == true ? 'tr'.'ue' : 'fa'.'lse').' ';
		
		$i++;
	}
	
	// Evaluate expression and return
	eval('$result = ('.$expression.');');
	return($result);
}



/*********************************************************/
/* Check if the Weekday ACL is valid                     */
/*********************************************************/

function phpAds_aclCheckWeekday($aclrow)
{
	$data = $aclrow['acl_data'];
	$day = date('w');
	
	$expression = ($data == "*" || $data == $day || in_array ($day, explode(',', $data)));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Useragent ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckUseragent($aclrow)
{
	$data = $aclrow['acl_data'];
	$agent = $GLOBALS['HTTP_USER_AGENT'];
	
	$expression = ($data == "*" || eregi($data, $agent));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Client IP ACL is valid                   */
/*********************************************************/

function phpAds_aclCheckClientip($aclrow)
{
	$data = $aclrow['acl_data'];
	$host = $GLOBALS['REMOTE_ADDR'];
	
	
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
	$operator   = ($aclrow['acl_ad'] == 'allow');
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Domain ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckDomain($aclrow)
{
	$data = $aclrow['acl_data'];
	$host = $GLOBALS['REMOTE_HOST'];
	
	$domain 	= substr($host,-(strlen($data)+1));
	$expression = ($data == "*" || strtolower($domain) == strtolower(".$data")) ;
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Language ACL is valid                    */
/*********************************************************/

function phpAds_aclCheckLanguage($aclrow)
{
	$data = $aclrow['acl_data'];
	$source = $GLOBALS['HTTP_ACCEPT_LANGUAGE'];
	
	$expression = ($data == "*" || eregi("^".$data, $source));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Source ACL is valid                      */
/*********************************************************/

function phpAds_aclCheckSource($aclrow, $source)
{
	$data = $aclrow['acl_data'];
	
	$expression = ($data == "*" || strtolower($source) == strtolower($data));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}



/*********************************************************/
/* Check if the Time ACL is valid                        */
/*********************************************************/

function phpAds_aclCheckTime($aclrow)
{
	$data = $aclrow['acl_data'];
	$time = date('G');
	
	$expression = ($data == "*" || $data == $time || in_array ($time, explode(',', $data)));
	$operator   = $aclrow['acl_ad'] == 'allow';
	return ($expression == $operator);
}

?>
