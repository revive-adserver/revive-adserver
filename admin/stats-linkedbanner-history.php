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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	if (isset($zoneid) && $zoneid > 0)
	{
		$result = phpAds_dbQuery("
			SELECT
				affiliateid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"])
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$affiliateid = phpAds_getUserID();
		}
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	if ($phpAds_config['compact_stats'])
	{
		$res = phpAds_dbQuery("
			SELECT
				DISTINCT bannerid
			FROM
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid = ".$zoneid."
		") or phpAds_sqlDie();
	}
	else
	{
		$res = phpAds_dbQuery("
			SELECT
				DISTINCT bannerid
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid = ".$zoneid."
		") or phpAds_sqlDie();
	}
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($bannerid == $row['bannerid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$row['bannerid'].">".phpAds_getBannerName ($row['bannerid'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	
	phpAds_PageHeader("2.4.2.2.1", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;".phpAds_getZoneName($zoneid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.2.2.1"));
}
else
{
	phpAds_PageHeader("1.1.2.1");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;".phpAds_getZoneName($zoneid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br><br>";
		phpAds_ShowSections(array("1.1.2.1"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$lib_history_where     = "zoneid = ".$zoneid." AND bannerid = ".$bannerid;
$lib_history_params    = array ('affiliateid' => $affiliateid,
								'zoneid' => $zoneid,
								'bannerid' => $bannerid
						 );

include ("lib-history.inc.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>