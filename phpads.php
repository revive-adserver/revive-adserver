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
require ("view.inc.php");
require ("acl.inc.php");

// Open a connection to the database
db_connect();


if (!isset($what))
	$what = '';

if (!isset($clientID))
	$clientID = 0;

if (!isset($source))
	$source = '';


$row = get_banner($what, $clientID, 0, $source);

if (is_array($row))
{
	if(!empty($row["bannerID"]))
	{
		$url = parse_url($GLOBALS["phpAds_url_prefix"]);
		SetCookie("bannerNum", $row["bannerID"], 0, $url["path"]);
		if(isset($n)) SetCookie("banID[$n]", $row["bannerID"], 0, $url["path"]);
		
		if ($row["format"] == "html")
		{
			echo $row["banner"];
			log_adview($row["bannerID"], $row["clientID"]);
		}
		else
		{
			if($row["format"] == "url" || $row["format"] == "web")
			{
				Header("Location: $row[banner]");
				log_adview($row["bannerID"], $row["clientID"]);
			}
			else
			{
				Header("Content-type: image/$row[format]; name=".microtime());
				echo $row["banner"];
				log_adview($row["bannerID"], $row["clientID"]);
			}
		}
	}
	else
	{
		Header( "Content-type: image/$row[format]");
		echo $row["banner"];
	}
}
else
{
	SetCookie("bannerNum", "DEFAULT", 0, $url["path"]);
	if(isset($n)) SetCookie("banID[$n]", "DEFAULT", 0, $url["path"]);
	
	Header ("Location: $phpAds_default_banner_url");
}

db_close();
?>
