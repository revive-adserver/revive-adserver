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



// Define defaults
$clientCache = array();
$bannerCache = array();



/*********************************************************/
/* Build the client name from ID and name                */
/*********************************************************/

function phpAds_buildClientName ($clientID, $clientName)
{
	return ("[id$clientID] $clientName");
}


/*********************************************************/
/* Fetch the client name from the database               */
/*********************************************************/

function phpAds_getClientName ($clientID)
{
	global $clientCache, $phpAds_tbl_clients;
	
	if (isset($clientCache[$clientID]) && is_array($clientCache[$clientID]))
	{
		$row = $clientCache[$clientID];
	}
	else
	{
		$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_clients
		WHERE
			clientID = $clientID
		") or mysql_die();
		
		$row = @mysql_fetch_array($res);
		
		$clientCache[$clientID] = $row;
	}
	
	return (phpAds_BuildClientName ($clientID, $row['clientname']));
}



/*********************************************************/
/* Build the banner name from ID, Description and Alt    */
/*********************************************************/

function phpAds_buildBannerName ($bannerID, $description, $alt)
{
	$name = "[id$bannerID] ";
	
	if ($description != "")
		$name .= $description;
	else
		$name .= $alt;
	
	return ($name);
}



/*********************************************************/
/* Fetch the banner name from the database               */
/*********************************************************/

function phpAds_getBannerName ($bannerID)
{
	global $bannerCache, $phpAds_tbl_banners;
	
	if (isset($bannerCache[$bannerID]) && is_array($bannerCache[$bannerID]))
	{
		$row = $bannerCache[$bannerID];
	}
	else
	{
		$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
		
		$row = @mysql_fetch_array($res);
		
		$bannerCache[$bannerID] = $row;
	}
	
	return (phpAds_buildBannerName ($bannerID, $row['description'], $row['alt']));
}


/*********************************************************/
/* Fetch the HTML needed to display a banner from the db */
/*********************************************************/

function phpAds_getBannerCode ($bannerID)
{
	global $bannerCache, $phpAds_tbl_banners;
	
	if (is_array($bannerCache[$bannerID]))
	{
		$row = $bannerCache[$bannerID];
	}
	else
	{
		$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or mysql_die();
		
		$row = @mysql_fetch_array($res);
		
		$bannerCache[$bannerID] = $row;
	}
	
	return (phpAds_buildBannerCode ($bannerID, $row['banner'], $row['active'], $row['format'], $row['width'], $row['height'], $row['bannertext']));
}


/*********************************************************/
/* Build the HTML needed to display a banner             */
/*********************************************************/

function phpAds_buildBannerCode ($bannerID, $banner, $active, $format, $width, $height, $bannertext)
{
	if ($active == "true")
	{
		if ($format == "html")
		{
			$htmlcode 	= htmlspecialchars (stripslashes ($banner));
			$buffer		= "<table border='0' cellspacing='0' cellpadding='0'><tr>";
			$buffer    .= "<td width='66%' valign='top' align='right'>";
			$buffer	   .= strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
			$buffer    .= "</td>";
			$buffer    .= "<td width='33%' valign='top' align='center' nowrap>&nbsp;&nbsp;<a href='banner-htmlpreview.php?bannerID=$bannerID' target='_new'>[ Show banner ]</a>&nbsp;&nbsp;</td>";
			$buffer	   .= "</tr></table>";
		}
		elseif($format == "url" || $format == "web")
			$buffer = "<img src='$banner' width='$width' height='$height'>";
		else
			$buffer = "<img src='../viewbanner.php?bannerID=$bannerID' width='$width' height='$height'>";
	}
	else
	{
		if ($format == "html")
		{
			$htmlcode 	= htmlspecialchars (stripslashes ($banner));
			$buffer		= "<table border='0' cellspacing='0' cellpadding='0'><tr>";
			$buffer    .= "<td width='66%' valign='top' align='right' style='filter: Alpha(Opacity=50)'>";
			$buffer	   .= strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
			$buffer    .= "</td>";
			$buffer    .= "<td width='33%' valign='top' align='center' nowrap>&nbsp;&nbsp;<a href='banner-htmlpreview.php?bannerID=$bannerID' target='_new'>[ Show banner ]</a>&nbsp;&nbsp;</td>";
			$buffer	   .= "</tr></table>";
		}
		elseif($format == "url" || $format == "web")
			$buffer = "<img src='$banner' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
		else
			$buffer = "<img src='../viewbanner.php?bannerID=$bannerID' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
	}
	
	if (!$bannertext == "")
		$buffer .= "<br>".$bannertext;
	
	return ($buffer);
}

?>
