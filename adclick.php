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



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-db.inc.php");

if ($phpAds_config['log_adclicks'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	require (phpAds_path."/lib-log.inc.php");
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($bannerID) && !isset($bannerid))	$bannerid = $bannerID;
if (!isset($n)) $n = 'default';


// Fetch BannerID
if (!isset($bannerid) && isset($phpAds_banner[$n]))
{
	// Bannerid and destination not known, try to get
	// values from the phpAds_banner cookie.
	
	if ($phpAds_banner[$n] != 'DEFAULT')
	{
		$cookie = unserialize (stripslashes($phpAds_banner[$n]));
		
		if (isset($cookie['bannerid'])) 
			$bannerid = $cookie['bannerid'];
		else
			$bannerid = 'DEFAULT';
		
		if (isset($cookie['zoneid']))
			$zoneid = $cookie['zoneid'];
		
		if (isset($cookie['source']))
			$source = $cookie['source'];
		
		if (isset($cookie['dest']))
			$dest = $cookie['dest'];
	}
	else
		$bannerid = 'DEFAULT';
}


// Open a connection to the database
phpAds_dbConnect();

if ($bannerid != "DEFAULT")
{
	// Get target URL and ClientID
	$res = phpAds_dbQuery("
		SELECT
			url,clientid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
		") or die();
		
	$url 	  = phpAds_dbResult($res, 0, 0);
	$clientid = phpAds_dbResult($res, 0, 1);
	
	
	// If destination is a parameter don't use
	// url from database
	if (isset($dest) && $dest != '')
		$url = stripslashes($dest);
	
	
	
	// If zoneid is not set, log it as a regular banner
	if (!isset($zoneid)) $zoneid = 0;
	if (!isset($source)) $source = '';
	
	
	// Log clicks
	if ($phpAds_config['block_adclicks'] == 0 ||
	   ($phpAds_config['block_adclicks'] > 0 && !isset($phpAds_blockClick[$bannerid])))
	{
		if ($phpAds_config['log_adclicks'])
			phpAds_logClick($bannerid, $clientid, $zoneid, $source);
		
		// Send block cookies
		if ($phpAds_config['block_adclicks'] > 0)
		{
			if ($phpAds_config['p3p_policies'])
			{
				$p3p_header = '';
				
				if ($phpAds_config['p3p_policy_location'] != '')
					$p3p_header .= " policyref=\"".$phpAds_config['p3p_policy_location']."\"";
				
				if ($phpAds_config['p3p_compact_policy'] != '')
					$p3p_header .= " CP=\"".$phpAds_config['p3p_compact_policy']."\"";
				
				if ($p3p_header != '')
					header ("P3P: $p3p_header");
			}
			
			$url_prefix = parse_url($phpAds_config['url_prefix']);
			setcookie ("phpAds_blockClick[".$bannerid."]", time(), time() + $phpAds_config['block_adclicks'], $url_prefix["path"]);
		}
	}
	
	
	
	// Get vars
	if (isset($HTTP_GET_VARS))
		for (reset ($HTTP_GET_VARS); $key = key($HTTP_GET_VARS); next($HTTP_GET_VARS))
		{
			if ($key != 'bannerid' &&
				$key != 'zoneid' &&
				$key != 'source' &&
				$key != 'dest' &&
				$key != 'ismap' &&
				$key != 'n' &&
				$key != 'cb')
				$vars[] = $key.'='.$HTTP_GET_VARS[$key];
		}
	
	if (isset($HTTP_POST_VARS))
		for (reset ($HTTP_POST_VARS); $key = key($HTTP_POST_VARS); next($HTTP_POST_VARS))
		{
			if ($key != 'bannerid' &&
				$key != 'zoneid' &&
				$key != 'source' &&
				$key != 'dest' &&
				$key != 'ismap' &&
				$key != 'n' &&
				$key != 'cb')
				$vars[] = $key.'='.$HTTP_POST_VARS[$key];
		}
	
	if (isset($vars) && is_array($vars) && sizeof($vars) > 0)
	{
		if (strpos ($url, '?') > 0)
			$url = $url.'&'.implode ('&', $vars);
		else
			$url = $url.'?'.implode ('&', $vars);
	}
	
	
	// Referer
	if (isset($HTTP_REFERER))
		$url = str_replace ("{referer}", urlencode($HTTP_REFERER), $url);
	else
		$url = str_replace ("{referer}", '', $url);
	
	// ISMAP click location
	if (isset($ismap) && $ismap != '')
	{
		$url .= $ismap;
	}
}
else
{
	// Banner displayed was the default banner, now 
	// redirect to the default location
	$url = $phpAds_config['default_banner_target'];
}

// Redirect
header ("Location: $url");

?>