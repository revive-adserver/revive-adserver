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
	global $strAddClient;
	
	if ($clientID != '' && $clientID != 0)
	{
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
	else
		return ($strAddClient);
}



/*********************************************************/
/* Fetch the ID of the parent of a campaign              */
/*********************************************************/

function phpAds_getParentID ($clientID)
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
	
	return ($row['parent']);
}



/*********************************************************/
/* Fetch the name of the parent of a campaign            */
/*********************************************************/

function phpAds_getParentName ($clientID)
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
	
	return (phpAds_getClientName ($row['parent']));
}



/*********************************************************/
/* Build the banner name from ID, Description and Alt    */
/*********************************************************/

function phpAds_buildBannerName ($bannerID, $description, $alt)
{
	global $strUntitled;
	
	$name = "[id$bannerID] ";
	
	if ($description != "")
		$name .= $description;
	elseif ($alt != "")
		$name .= $alt;
	else
		$name .= $strUntitled;
	
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
			$htmlcode   = strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
			$htmlcode	= chunk_split ($htmlcode, 70, "<br>\n");
			
			$buffer		= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
			$buffer    .= "<td width='80%' valign='top' align='left'>\n";
			$buffer	   .= $htmlcode;
			$buffer    .= "\n</td>";
			$buffer    .= "<td width='20%' valign='top' align='right' nowrap>&nbsp;&nbsp;";
			$buffer	   .= "<a href='banner-htmlpreview.php?bannerID=$bannerID' target='_new' ";
			$buffer	   .= "onClick=\"return openWindow('banner-htmlpreview.php?bannerID=$bannerID', '', 'status=no,scrollbars=no,resizable=no,width=$width,height=$height');\">";
			$buffer    .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;Show banner</a>&nbsp;&nbsp;</td>";
			$buffer	   .= "</tr></table>";
		}
		elseif($format == "url" || $format == "web")
			$buffer = "<img src='$banner' width='$width' height='$height'>";
		else
			$buffer = "<img src='../adview.php?bannerID=$bannerID' width='$width' height='$height'>";
	}
	else
	{
		if ($format == "html")
		{
			$htmlcode 	= htmlspecialchars (stripslashes ($banner));
			$htmlcode   = strlen($htmlcode) > 500 ? substr ($htmlcode, 0, 500)."..." : $htmlcode;
			$htmlcode	= chunk_split ($htmlcode, 70, "<br>\n");
			
			$buffer		= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
			$buffer    .= "<td width='80%' valign='top' align='left' style='filter: Alpha(Opacity=50)'>\n";
			$buffer	   .= $htmlcode;
			$buffer    .= "\n</td>";
			$buffer    .= "<td width='20%' valign='top' align='right' nowrap>&nbsp;&nbsp;";
			$buffer	   .= "<a href='banner-htmlpreview.php?bannerID=$bannerID' target='_new' ";
			$buffer	   .= "onClick=\"return openWindow('banner-htmlpreview.php?bannerID=$bannerID', '', 'status=no,scrollbars=no,resizable=no,width=$width,height=$height');\">";
			$buffer    .= "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;Show banner</a>&nbsp;&nbsp;</td>";
			$buffer	   .= "</tr></table>";
		}
		elseif($format == "url" || $format == "web")
			$buffer = "<img src='$banner' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
		else
			$buffer = "<img src='../adview.php?bannerID=$bannerID' width='$width' height='$height' style='filter: Alpha(Opacity=50)'>";
	}
	
	if (!$bannertext == "")
		$buffer .= "<br>".$bannertext;
	
	return ($buffer);
}



/*********************************************************/
/* Build Click-Thru ratio                                */
/*********************************************************/

function phpAds_buildCTR ($views, $clicks)
{
	global $phpAds_percentage_decimals;
	
	if ($views > 0)
		$ctr = number_format(($clicks*100)/$views, $phpAds_percentage_decimals)."%";
	else
		$ctr="0.00%";
		
	return ($ctr);
}

?>
