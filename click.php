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


// Log clicks
if ($phpAds_log_adclicks)
{
	if ($phpAds_reverse_lookup)
		$host = isset($REMOTE_HOST) ? $REMOTE_HOST : @gethostbyaddr($REMOTE_ADDR);
	else
		$host = $REMOTE_ADDR;
	
	// Check if host is on list of hosts to ignore
	$found=0;
	while (($found == 0) && (list ($key, $ignore_host)=each($phpAds_ignore_hosts)))
		if (eregi("$host|$REMOTE_ADDR", $ignore_host)) // host found in ignore list
			$found=1;
	
	if ($found == 0)
	{
		db_log_click($bannerID, $host);
		phpAds_expire ($clientID, phpAds_Clicks);
	}
}


// Cache buster
if (eregi ("\{random(:([1-9])){0,1}\}", $url, $matches))
{
	if ($cb == "")
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


// Redirect
Header("Location: $url");

?>
