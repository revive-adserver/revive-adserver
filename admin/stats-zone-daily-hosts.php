<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
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
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($phpAds_config['compact_stats']) 
{
	$res = phpAds_dbQuery("
		SELECT
			DATE_FORMAT(day, '%Y%m%d') as date,
			DATE_FORMAT(day, '$date_format') as date_formatted
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			zoneid = '$zoneid'
		GROUP BY
			day
		ORDER BY
			day DESC
		LIMIT 7
	") or phpAds_sqlDie();
}
else
{
	$res = phpAds_dbQuery("
		 SELECT
			DATE_FORMAT(t_stamp, '%Y%m%d') as date,
			DATE_FORMAT(t_stamp, '$date_format') as date_formatted
		 FROM
			".$phpAds_config['tbl_adviews']."
		 WHERE
			zoneid = '$zoneid'
		 GROUP BY
			date
		 ORDER BY
			date DESC
		 LIMIT 7
	") or phpAds_sqlDie();
}

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		$row['date_formatted'],
		"stats-zone-daily-hosts.php?day=".$row['date']."&affiliateid=".$affiliateid."&zoneid=".$zoneid,
		$day == $row['date']
	);
}

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');	
	phpAds_PageShortcut($strZoneProperties, 'zone-edit.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-zone.gif');	
	phpAds_PageShortcut($strIncludedBanners, 'zone-include.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-zone-linked.gif');	
	
	
	phpAds_PageHeader("2.4.2.1.2");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-date.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.2.1.1", "2.4.2.1.2"));
}

if (phpAds_isUser(phpAds_Affiliate))
{
	phpAds_PageHeader("1.1.1.2");
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-date.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br><br>";
		phpAds_ShowSections(array("1.1.1.1", "1.1.1.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$lib_hourly_where     = "zoneid = ".$zoneid;

include ("lib-hourly-hosts.inc.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>