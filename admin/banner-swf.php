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
require ("lib-storage.inc.php");
require ("lib-swf.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_isAllowed(phpAds_ModifyBanner))
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
	else
	{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}




/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($convert))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
	") or phpAds_sqlDie();
	
	$row = phpAds_dbFetchArray($res);
	
	
	
	if ($row['format'] == 'swf')
	{
		if (phpAds_SWFVersion($row['banner']) >= 3 &&
			phpAds_SWFInfo($row['banner']))
		{
			$result = phpAds_SWFConvert($row['banner']);
			
			if ($result != $row['banner'] &&
				strlen($result) == strlen($row['banner']))
			{
				// Store the banner
				$res = phpAds_dbQuery("
					UPDATE
						".$phpAds_config['tbl_banners']."
					SET
						banner = '".addslashes($result)."'
					WHERE
						bannerid = $bannerid
				") or phpAds_sqlDie();
			}
		}
	}
	elseif ($row['format'] == 'web' && eregi('swf$', $row['banner']))
	{
		$swf_file = phpAds_ImageRetrieve ($row['banner']);
		
		if (phpAds_SWFVersion($swf_file) >= 3 &&
			phpAds_SWFInfo($swf_file))
		{
			$result = phpAds_SWFConvert($swf_file);
			
			if ($result != $swf_file &&
				strlen($result) == strlen($swf_file))
			{
				// Store the banner
				phpAds_ImageStore ($row['banner'], $result, true);
			}
		}
	}
	
	if (phpAds_isUser(phpAds_Client))
		Header("Location: stats-campaign.php?campaignid=$campaignid");
	else
		Header("Location: campaign-index.php?campaignid=$campaignid");
	
	exit;
}

if (isset($cancel))
{
	if (phpAds_isUser(phpAds_Client))
		Header("Location: stats-campaign.php?campaignid=$campaignid");
	else
		Header("Location: campaign-index.php?campaignid=$campaignid");
	
	exit;
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($bannerid != '')
{
	$extra = '';
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = $campaignid
	") or phpAds_sqlDie();
	
	$extra = "";	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($bannerid == $row['bannerid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='banner-edit.php?campaignid=$campaignid&bannerid=".$row['bannerid']."'>";
		$extra .= phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']);		
		$extra .= "</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	if (phpAds_isUser(phpAds_Admin))
	{
		$extra .= "<br><br><br>";
		$extra .= "<b>$strShortcuts</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-campaign.php?campaignid=$campaignid>$strStats</a><br>";
		$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-weekly.gif' align='absmiddle'>&nbsp;<a href=stats-weekly.php?campaignid=$campaignid>$strWeeklyStats</a><br>";
		$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-zoom.gif' align='absmiddle'>&nbsp;<a href=stats-details.php?campaignid=$campaignid&bannerid=$bannerid>$strDetailStats</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		
		phpAds_PageHeader("4.1.5.5", $extra);
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
			echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_getBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("4.1.5.5"));
	}
	else
	{
		phpAds_PageHeader("1.1.1.3", $extra);
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
			echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_getBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("1.1.1.3"));
	}
	
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($res);
	
	
	if ($row['format'] == 'swf')
	{
		$swf_file = $row['banner'];
	}
	elseif ($row['format'] == 'web' && eregi('swf$', $row['banner']))
	{
		$swf_file = phpAds_ImageRetrieve ($row['banner']);
	}
	else
	{
		// Banner is not a flash banner, return to banner-edit.php
		header ("Location: banner-edit.php?campaignid=$campaignid&bannerid=$bannerid");
		exit;
	}
}
else
{
	// Banner does not exist, return to banner-edit.php
	header ("Location: banner-edit.php?campaignid=$campaignid");
	exit;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$result = phpAds_SWFInfo($swf_file);

if ($result)
{
	echo "<br>The Flash file you just uploaded contains hard-coded urls. phpAdsNew won't be ";
	echo "able to track the number of AdClicks for this banner unless you convert these ";
	echo "hard-coded urls. Below you will find a list of all urls inside the Flash file. ";
	echo "If you want to convert the urls, simply click <b>Convert</b>, otherwise click ";
	echo "<b>Cancel</b>.<br><br>If you decide to convert the hard-coded urls in this Flash file ";
	echo "every click on this banner will refer the browser to the url you specified as the url you ";
	echo "specified when you created this banner (".$row['url'].").<br><br>";
	echo "Please note: if you click <b>Convert</b> the Flash file ";
	echo "you just uploaded will be physically altered. <br>Please keep a backup of the ";
	echo "original file. Regardless of in which version this banner was created, the resulting ";
	echo "file will need the Flash 4 player (or higher) to display correctly.<br><br>";
	
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	echo "<tr>";
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;<b>URL</b></td>";
	echo "<td height='25' bgcolor='$bgcolor'><b>Target</b></td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	for ($i=0;$i<count($result);$i++)
	{
		list ($offset, $url, $target) = $result[$i];
		
		echo "<tr>";
		echo "<td height='25' bgcolor='".($i % 2 ? '#FFFFFF' : '#F6F6F6')."'>&nbsp;";
		echo "<img src='images/icon-undo.gif' align='absmiddle'>&nbsp;".$url."</td>";
		echo "<td height='25' bgcolor='".($i % 2 ? '#FFFFFF' : '#F6F6F6')."'>".$target."</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	echo "</table>";
	echo "<br><br>";
	
	echo "<form action='banner-swf.php' method='post'>";
	echo "<input type='hidden' name='bannerid' value='$bannerid'>";
	echo "<input type='hidden' name='campaignid' value='$campaignid'>";
	echo "<input type='submit' name='convert' value='Convert'>&nbsp;&nbsp;";
	echo "<input type='submit' name='cancel' value='Cancel'>";
	echo "</form>";
	
	echo "<br><br>";
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>