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
require("config.inc.php");
require("dblib.php");

// Open a connection to the database
db_connect();


// Fetch ClientID
if(!isset($bannerID))
	php_die("hu?", "Where is my ID? I've lost my ID! Moooommmeee... I want my ID back!");


$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners  
	WHERE
		bannerID = $bannerID
	") or mysql_die();

if(mysql_num_rows($res) == 0)
{
	print "$strNoBanners";
}
else
{
	$row = mysql_fetch_array($res);
	if($row["format"] == "url" || $row["format"] == "web")   // bkl
	{
		Header("Location: $row[banner]");
	} 
	else 
	{
		Header("Content-type: image/$row[format]");
		print $row["banner"];
	}
}

?>
