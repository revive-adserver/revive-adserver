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



// Include required files
require ("config.inc.php");
require ("dblib.php");
require ("lib-expire.inc.php");

// Open a connection to the database
db_connect();




// Fetch BannerID
if (!isset($bannerID))
{
	if(isset($bannerNum) && !empty($bannerNum)) $bannerID = $bannerNum;
	if(isset($n) && is_array($banID)) $bannerID = $banID[$n];
}


if ($bannerID != "DEFAULT")
{
	// Get target URL and ClientID
	$res = db_query("
		SELECT
			url,clientID
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or die();
		
	$url 	  = mysql_result($res, 0, 0);
	$clientID = mysql_result($res, 0, 1);
	
	
	// If destination is a parameter don't use
	// url from database
	if (isset($dest) && $dest != '')
	{
		$url = urldecode($dest);
	}
	
	
	// Log clicks
	if ($phpAds_log_adclicks)
	{
		if ($host = phpads_ignore_host())
		{
			db_log_click($bannerID, $host);
			phpAds_expire ($clientID, phpAds_Clicks);
		}
	}
	
	
	// Referer
	$url = str_replace ("{referer}", urlencode($HTTP_REFERER), $url);
	
	
	// Cache buster
	if (eregi ('\{random(:([1-9])){0,1}\}', $url, $matches))
	{
		if (!isset($cb) || $cb == "")
		{
			// calculate random number
			
			if ($matches[1] == "")
				$randomdigits = 8;
			else
				$randomdigits = $matches[2];
			
			$cb = sprintf ("%0".$randomdigits."d", mt_rand (0, pow (10, $randomdigits) - 1));
		}
		
		$url = str_replace ($matches[0], $cb, $url);
	}
	
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
	$url = $phpAds_default_banner_target;
}

// Redirect
Header("Location: $url");

?>
