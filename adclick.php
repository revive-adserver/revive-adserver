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



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");

if ($phpAds_config['log_adclicks'])
{
	require (phpAds_path."/libraries/lib-remotehost.inc.php");
	require (phpAds_path."/libraries/lib-log.inc.php");
}



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('bannerid', 'bannerID', 'n', 'log',
					   'zoneid', 'source', 'dest', 'ismap',
					   'trackonly');



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
	
	if (isset($_COOKIE['phpAds_banner'][$n]) && 
		$_COOKIE['phpAds_banner'][$n] != 'DEFAULT')
	{
		$cookie = unserialize (stripslashes($_COOKIE['phpAds_banner'][$n]));
		
		if (isset($cookie['bannerid'])) 
			$bannerid = addslashes($cookie['bannerid']);
		else
			$bannerid = 'DEFAULT';
		
		if (isset($cookie['zoneid']))
			$zoneid = addslashes($cookie['zoneid']);
		
		if (isset($cookie['source']))
			$source = addslashes($cookie['source']);
		
		if (isset($cookie['dest']))
			$dest =addslashes($cookie['dest']);
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
				bannerid = '$bannerid'
		") or die();
		
		$url 	  = phpAds_dbResult($res, 0, 0);
		$clientid = phpAds_dbResult($res, 0, 1);
		
		
		// If destination is a parameter don't use
		// url from database
		if (isset($dest) && $dest != '')
		{
			// Prevent HTTP response splitting
			if (preg_match('#^https?://#', $dest) && !preg_match('/[\r\n]/', $dest))
				$url = stripslashes($dest);
		}
		
		// If zoneid is not set, log it as a regular banner
		if (!isset($zoneid)) $zoneid = 0;
		if (!isset($source)) $source = '';
		
		
		// Log clicks
		if (!isset($log) || $log != 'no')
		{
			if ($phpAds_config['block_adclicks'] == 0 ||
			   ($phpAds_config['block_adclicks'] > 0 && 
			   (!isset($_COOKIE['phpAds_blockClick'][$bannerid]) ||
			   $_COOKIE['phpAds_blockClick'][$bannerid] <= time())))
			{
				if ($phpAds_config['log_adclicks'])
					phpAds_logClick($bannerid, $clientid, $zoneid, $source);
				
				// Send block cookies
				if ($phpAds_config['block_adclicks'] > 0)
				{
					phpAds_setCookie ("phpAds_blockClick[".$bannerid."]", time() + $phpAds_config['block_adclicks'], 
									  time() + $phpAds_config['block_adclicks'] + 43200);
					phpAds_flushCookie ();
				}
			}
		}
		
		
		// Get vars
		if (isset($_GET))
			foreach (array_keys($_GET) as $key)
			{
				if ($key != 'bannerid' &&
					$key != 'zoneid' &&
					$key != 'source' &&
					$key != 'dest' &&
					$key != 'ismap' &&
					$key != 'log' &&
					$key != 'trackonly' &&
					$key != 'n' &&
					$key != 'cb')
					$vars[] = $key.'='.$_GET[$key];
			}
		
		if (isset($_POST))
			foreach (array_keys($_POST) as $key)
			{
				if ($key != 'bannerid' &&
					$key != 'zoneid' &&
					$key != 'source' &&
					$key != 'dest' &&
					$key != 'ismap' &&
					$key != 'log' &&
					$key != 'trackonly' &&
					$key != 'n' &&
					$key != 'cb')
					$vars[] = $key.'='.$_POST[$key];
			}
		
		if (isset($vars) && is_array($vars) && sizeof($vars) > 0)
		{
			if (strpos ($url, '?') > 0)
				$url = $url.'&'.implode ('&', $vars);
			else
				$url = $url.'?'.implode ('&', $vars);
		}
		
		
		// Referer
		if (isset($_SERVER['HTTP_REFERER']))
			$url = str_replace ("{referer}", urlencode($_SERVER['HTTP_REFERER']), $url);
		else
			$url = str_replace ("{referer}", '', $url);
		
		// ISMAP click location
		if (isset($ismap) && $ismap != '')
		{
			$url .= $ismap;
		}
		


		// If track-only do not redirect
		if (isset($trackonly) && $trackonly)
		{
			exit;
		}
		
		// Redirect
		if ($url != '')
			header ("Location: ".$url);
		else
		{
			// No URL found, redirect to the original page
			if (isset($_SERVER['HTTP_REFERER']))
				header ("Location: ".$_SERVER['HTTP_REFERER']);
		}
		
		exit;
	}
}


// Redirect
if ($phpAds_config['default_banner_target'] != '')
	header ("Location: ".$phpAds_config['default_banner_target']);
else
{
	// No URL found, redirect to the original page, preventing HTTP response splitting
	if (isset($_SERVER['HTTP_REFERER']) && !preg_match('/[\r\n]/', $_SERVER['HTTP_REFERER']))
		header ("Location: ".$_SERVER['HTTP_REFERER']);
}

?>