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
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-expiration.inc.php");
require ("lib-gd.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$clientID = $Session["clientID"];
	
	phpAds_PageHeader($strStats);
	
	$res_banners = db_query("
		SELECT
			banner,
			bannerID,
			width,
			height,
			format
		FROM
			$phpAds_tbl_banners
		WHERE
			clientID = $clientID
		") or mysql_die();
		
	phpAds_ShowNav("2");
}

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader($strStats);
	
	$extra = '';
	
	$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_clients  
	") or mysql_die();
	
	while ($row = mysql_fetch_array($res))
	{
		if ($clientID == $row['clientID'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=stats-client.php?clientID=".$row['clientID'].">".phpAds_buildClientName ($row['clientID'], $row['clientname'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=banner-client.php?clientID=$clientID>$strBannerAdmin</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_ShowNav("1.4", $extra);
}



/*********************************************************/
/* Store sorting order and view                          */
/*********************************************************/

$UpdateSession = false;

if (empty($Session["stats_compact"]))
	$Session["stats_compact"] = "";
if (!isset($compact))
	$compact = $Session["stats_compact"];
elseif ($compact != $Session["stats_compact"])
{
	$Session["stats_compact"] = $compact;
	$UpdateSession = true;
}

if (empty($Session["stats_view"]))
	$Session["stats_view"] = "";
if (!isset($view))
	$view = $Session["stats_view"];
elseif ($view != $Session["stats_view"])
{
	$Session["stats_view"] = $view;
	$UpdateSession = true;
}

if (empty($Session["stats_order"]))
	$Session["stats_order"] = "";
if (!isset($order))
	$order = $Session["stats_order"];
elseif ($order != $Session["stats_order"])
{
	$Session["stats_order"] = $order;
	$UpdateSession = true;
}

if ($UpdateSession == true)
	phpAds_SessionDataStore();


require("./stats-client.inc.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>