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
	if (isset($which) && $which > 0)
	{
		$result = phpAds_dbQuery("
			SELECT
				clientid
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = $which
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row['clientid'] == '')
		{
			phpAds_PageHeader('1');
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$campaignid = $row['clientid'];
		}
	}
	
	if (phpAds_clientid() != phpAds_getParentID ($campaignid))
	{
		phpAds_PageHeader('1');
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = ".phpAds_getParentID ($campaignid)."
		") or phpAds_sqlDie();
		
		$extra = "";
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($campaignid == $row['clientid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=stats-weekly.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader('1.1.3', $extra);
		phpAds_ShowSections(array("1.1.1", "1.1.2", "1.1.3"));
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	if ($campaignid > 0)
	{
		$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent > 0
		") or phpAds_sqlDie();
		
		$extra = "";
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($campaignid == $row['clientid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=stats-weekly.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		$extra .= "<br><br><br><br><br>";
		$extra .= "<b>$strShortcuts</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strModifyClient</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strModifyCampaign</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBanners</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-campaign.php?campaignid=$campaignid>$strStats</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader('2.1.4', $extra);
		phpAds_ShowSections(array("2.1.2", "2.1.3", "2.1.4"));
		
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid);
		echo "</b>";
	}
	else
	{
		phpAds_PageHeader('2.3');
		phpAds_ShowSections(array("2.1", "2.2", "2.3"));
	}
}

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if ($clientid > 0)
	$clientwhere = "WHERE clientid=$campaignid";
else
	$clientwhere = '';

// Check for banners
$res = phpAds_dbQuery("
	SELECT
		count(*) as count
	FROM
		".$phpAds_config['tbl_banners']."
	$clientwhere
") or phpAds_sqlDie();
$row = phpAds_dbFetchArray($res);

if ($row['count'] > 0)
{
	require('stats-weekly.html.php');
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();
?>
