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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$result = phpAds_dbQuery("
		SELECT
			clientid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($result);
	
	if ($row["clientid"] == '' || phpAds_getUserID() != phpAds_getParentID ($row["clientid"]))
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$campaignid = $row["clientid"];
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
			bannerid = $bannerid
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
			bannerid = $bannerid
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
		"stats-banner-daily-hosts.php?day=".$row['date']."&campaignid=".$campaignid."&bannerid=".$bannerid,
		$day == $row['date']
	);
}

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.phpAds_getParentID($campaignid), 'images/icon-client.gif');
	phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?campaignid='.$campaignid, 'images/icon-campaign.gif');
	phpAds_PageShortcut($strBannerProperties, 'banner-edit.php?campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-banner-stored.gif');
	
	if ($phpAds_config['acl'])
		phpAds_PageShortcut($strModifyBannerAcl, 'banner-acl.php?campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-acl.gif');
	
	
	phpAds_PageHeader("2.1.2.2.1.2");
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;".phpAds_getBannerName($bannerid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br>";
		echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
		phpAds_ShowSections(array("2.1.2.2.1.1", "2.1.2.2.1.2"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.2.2.1.2");
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;".phpAds_getBannerName($bannerid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;<b>".date(str_replace('%', '', $date_format), mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)))."</b><br><br>";
		echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
		phpAds_ShowSections(array("1.2.2.1.1","1.2.2.1.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$lib_hourly_where     = "bannerid = ".$bannerid;

include ("lib-hourly-hosts.inc.php");



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>