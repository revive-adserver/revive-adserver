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




// Log clicks
if ($phpAds_log_adclicks)
{
	$getclientID=db_query("SELECT clientID FROM $phpAds_tbl_banners WHERE bannerID='$bannerID'");
	if($gotclientID=mysql_fetch_array($getclientID))
	{
		$clientID=$gotclientID["clientID"];
	}
	
	if($phpAds_reverse_lookup)
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
		$res = db_log_click($bannerID, "null", $host);
		phpAds_expire ($clientID, phpAds_Clicks);
	}
}


// Redirect
Header("Location: ".urldecode($dest));

?>
