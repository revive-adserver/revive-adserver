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
require ("lib-gd.inc.php");
require ("stats-weekly.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader($GLOBALS['strWeeklyStats']);
	
	$clientID = phpAds_clientID();
	
	if (isset($which) && $which > 0)
	{
		$result = db_query("
			SELECT
				clientID
			FROM
				$phpAds_tbl_banners
			WHERE
				bannerID = $which
			") or mysql_die();
		$row = mysql_fetch_array($result);
		
		if ($row['clientID'] != phpAds_clientID())
		{
			php_die ($strAccessDenied, $strNotAdmin);
		}
	}
	
	phpAds_ShowNav('2.2');
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader($GLOBALS['strWeeklyStats']);
	
	if ($clientID > 0)
	{
		$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_clients  
		") or mysql_die();
		
		$extra = "";		
		while ($row = mysql_fetch_array($res))
		{
			if ($clientID == $row['clientID'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=stats-weekly.php?clientID=".$row['clientID'].">".phpAds_buildClientName ($row['clientID'], $row['clientname'])."</a>";
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
		
		phpAds_ShowNav('1.4.2', $extra);
	}
	else
	{
		phpAds_ShowNav('1.6');
	}
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if ($clientID > 0)
	$clientwhere = "WHERE clientID='$clientID'";
else
	$clientwhere = '';

// Check for banners
$res = db_query("
	SELECT
		count(*) as count
	FROM
		$phpAds_tbl_banners  
	$clientwhere
") or mysql_die();
$row = mysql_fetch_array($res);

if ($row['count'] > 0)
{
	require('./stats-weekly.html.php');
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();
?>
