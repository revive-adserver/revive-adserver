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
require ("lib-banner.inc.php");


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
	
	
	if ($row['storagetype'] == 'sql' || $row['storagetype'] == 'web')
		$swf_file = phpAds_ImageRetrieve ($row['storagetype'], $row['filename']);
	
	if ($swf_file)
	{
		if (phpAds_SWFVersion($swf_file) >= 3 &&
			phpAds_SWFInfo($swf_file))
		{
			list($result, $parameters) = phpAds_SWFConvert($swf_file);
			
			if ($result != $swf_file &&
				strlen($result) == strlen($swf_file))
			{
				// Prepare the parameters
				for ($i=0;$i<count($parameters);$i++)
					$parameters[$i] = 'alink'.($i+1).'={targeturl:'.$parameters[$i].'}';
				
				$parameter = implode ('&', $parameters);
				$row['htmltemplate'] = str_replace ('{swf_param}', $parameter, $row['htmltemplate']);
				$row['htmlcache']    = addslashes (phpAds_getBannerCache($row));
				$row['htmltemplate'] = addslashes ($row['htmltemplate']);
				
				// Store the HTML Template
				$res = phpAds_dbQuery ("
					UPDATE ".$phpAds_config['tbl_banners']." 
					SET htmltemplate='".$row['htmltemplate']."', htmlcache='".$row['htmlcache']."'
					WHERE bannerid = ".$bannerid."
				");
				
				// Store the banner
				phpAds_ImageStore ($row['storagetype'], $row['filename'], $result, true);
			}
		}
	}
	
	
	if (phpAds_isUser(phpAds_Client))
		Header('Location: stats-campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid);
	else
	{
		if ($phpAds_config['acl'])
			Header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
		else
			Header('Location: banner-zone.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
	}
	
	exit;
}

if (isset($cancel))
{
	if (phpAds_isUser(phpAds_Client))
		Header('Location: stats-campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid);
	else
	{
		if ($phpAds_config['acl'])
			Header('Location: banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
		else
			Header('Location: banner-zone.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
	}
	
	exit;
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($bannerid != '')
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = $campaignid
	");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']),
			"banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$row['bannerid'],
			$bannerid == $row['bannerid']
		);
	}
	
	
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
		phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
		phpAds_PageShortcut($strBannerHistory, 'stats-banner-history.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-statistics.gif');
		
		
		phpAds_PageHeader("4.1.3.4.5");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
			phpAds_ShowSections(array("4.1.3.4.5"));
	}
	else
	{
		phpAds_PageHeader("1.1.1.3");
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
			echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
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
	
	
	if ($row['contenttype'] == 'swf')
	{
		if ($row['storagetype'] == 'sql' || $row['storagetype'] == 'web')
			$swf_file = phpAds_ImageRetrieve ($row['storagetype'], $row['filename']);
	}
	else
	{
		// Banner is not a flash banner, return to banner-edit.php
		header ("Location: banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid);
		exit;
	}
}
else
{
	// Banner does not exist, return to banner-edit.php
	header ("Location: banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid);
	exit;
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$result = phpAds_SWFInfo($swf_file);

if ($result)
{
	echo $strConvertSWF;
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	echo "<tr>";
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;<b>".$strURL2."</b></td>";
	echo "<td height='25' bgcolor='$bgcolor'><b>".$strTarget."</b></td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	for ($i=0;$i<count($result);$i++)
	{
		list ($offset, $url, $target) = $result[$i];
		
		echo "<tr>";
		echo "<td height='25' bgcolor='".($i % 2 ? '#FFFFFF' : '#F6F6F6')."'>&nbsp;";
		echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle'>&nbsp;".$url."</td>";
		echo "<td height='25' bgcolor='".($i % 2 ? '#FFFFFF' : '#F6F6F6')."'>".$target."</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	echo "</table>";
	echo "<br><br>";
	
	echo "<form action='banner-swf.php' method='post'>";
	echo "<input type='hidden' name='clientid' value='$clientid'>";
	echo "<input type='hidden' name='campaignid' value='$campaignid'>";
	echo "<input type='hidden' name='bannerid' value='$bannerid'>";
	echo "<input type='submit' name='convert' value='".$strConvert."'>&nbsp;&nbsp;";
	echo "<input type='submit' name='cancel' value='".$strCancel."'>";
	echo "</form>";
	
	echo "<br><br>";
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>