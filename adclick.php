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



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-io.inc.php");
require (phpAds_path."/lib-db.inc.php");

if ($phpAds_config['log_adclicks'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	require (phpAds_path."/lib-log.inc.php");
}



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('bannerid', 'bannerID', 'n',
					   'zoneid', 'source', 'dest', 'ismap');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($bannerid) && isset($bannerID)) $bannerid = $bannerID;
if (!isset($n)) $n = 'default';


// Fetch BannerID
if (!isset($bannerid))
{
 	// Bannerid and destination not known, try to get
	// values from the phpAds_banner cookie.
	
	if (isset($HTTP_COOKIE_VARS['phpAds_banner'][$n]) && 
		$HTTP_COOKIE_VARS['phpAds_banner'][$n] != 'DEFAULT')
	{
		$cookie = unserialize (stripslashes($HTTP_COOKIE_VARS['phpAds_banner'][$n]));
		
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
if (phpAds_dbConnect())
{
	if ($bannerid != "DEFAULT")
	{
		// Get target URL and ClientID
		$res = phpAds_dbQuery("
			SELECT
				url, clientid
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
		   ($phpAds_config['block_adclicks'] > 0 && 
		   !isset($HTTP_COOKIE_VARS['phpAds_blockClick'][$bannerid])))
		{
			if ($phpAds_config['log_adclicks'])
				phpAds_logClick($bannerid, $clientid, $zoneid, $source);
			
			// Send block cookies
			if ($phpAds_config['block_adclicks'] > 0)
			{
				phpAds_setCookie ("phpAds_blockClick[".$bannerid."]", time(), time() + $phpAds_config['block_adclicks']);
				phpAds_flushCookie ();
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
		if (isset($HTTP_SERVER_VARS['HTTP_REFERER']))
			$url = str_replace ("{referer}", urlencode($HTTP_SERVER_VARS['HTTP_REFERER']), $url);
		else
			$url = str_replace ("{referer}", '', $url);
		
		// ISMAP click location
		if (isset($ismap) && $ismap != '')
		{
			$url .= $ismap;
		}
		
		
		// Redirect
		header ("Location: $url");
		exit;
	}
}


// Redirect
if ($phpAds_config['default_banner_target'] != '')
	header ("Location: ".$phpAds_config['default_banner_target']);

?>