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
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_getUserID() == phpAds_getParentID ($campaignid))
	{
		$extra = '';
		
		$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = ".phpAds_getUserID()."
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($campaignid == $row['clientid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=stats-campaign.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("1.1.2", $extra);
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
			phpAds_ShowSections(array("1.1.1", "1.1.2"));
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent > 0
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($campaignid == $row['clientid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=stats-campaign-history.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBannerOverview</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.3", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.2", "2.1.3"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$idresult = phpAds_dbQuery ("
	SELECT
		bannerid
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = $campaignid
");

if (phpAds_dbNumRows($idresult) > 0)
{
	while ($row = phpAds_dbFetchArray($idresult))
	{
		$bannerids[] = "bannerid = ".$row['bannerid'];
	}
	
	$lib_history_where     = "(".implode(' OR ', $bannerids).")";
	$lib_history_params    = array ('campaignid' => $campaignid);
	
	include ("lib-history.inc.php");
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>