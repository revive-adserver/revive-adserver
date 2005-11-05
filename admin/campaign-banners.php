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
require ("lib-expiration.inc.php");
require ("lib-gd.inc.php");


// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'listorder', 'orderdirection');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (isset($Session['prefs']['client-campaigns.php'][$clientid]['listorder']))
	$navorder = $Session['prefs']['client-campaigns.php'][$clientid]['listorder'];
else
	$navorder = '';

if (isset($Session['prefs']['client-campaigns.php'][$clientid]['orderdirection']))
	$navdirection = $Session['prefs']['client-campaigns.php'][$clientid]['orderdirection'];
else
	$navdirection = '';


// Get other campaigns
$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent = ".$clientid."
	".phpAds_getListOrder ($navorder, $navdirection)."
");

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		phpAds_buildClientName ($row['clientid'], $row['clientname']),
		"campaign-banners.php?clientid=".$clientid."&campaignid=".$row['clientid'],
		$campaignid == $row['clientid']
	);
}

phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
phpAds_PageShortcut($strCampaignHistory, 'stats-campaign-history.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-statistics.gif');



$extra  = "<form action='campaign-modify.php'>";
$extra .= "<input type='hidden' name='clientid' value='$clientid'>";
$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
$extra .= "<input type='hidden' name='returnurl' value='campaign-banners.php'>";
$extra .= "<br><br>";
$extra .= "<b>$strModifyCampaign</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-move-campaign.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$extra .= "<select name='moveto' style='width: 110;'>";

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent = 0 AND clientid != ".phpAds_getParentID ($campaignid)) or phpAds_sqlDie();
while ($row = phpAds_dbFetchArray($res))
	$extra .= "<option value='".$row['clientid']."'>".phpAds_buildClientName($row['clientid'], $row['clientname'])."</option>";

$extra .= "</select>&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='campaign-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&returnurl=client-index.php'".phpAds_DelConfirm($strConfirmDeleteCampaign).">$strDelete</a><br>";
$extra .= "</form>";



phpAds_PageHeader("4.1.3.4", $extra);
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
	phpAds_ShowSections(array("4.1.3.2", "4.1.3.3", "4.1.3.4"));



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['listorder']))
		$listorder = $Session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection']))
		$orderdirection = $Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['nodes']))
	$node_array = explode (",", $Session['prefs']['campaign-banners.php'][$campaignid]['nodes']);
else
	$node_array = array();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = '$campaignid'
	".phpAds_getBannerListOrder($listorder, $orderdirection)."
") or phpAds_sqlDie();

$count_active = 0;

while ($row = phpAds_dbFetchArray($res))
{
	$banners[$row['bannerid']] = $row;
	$banners[$row['bannerid']]['expand'] = 0;
	
	if ($row['active'] == 't') $count_active++;
}


// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{
	switch ($expand)
	{
		case 'all' :	$node_array   = array();
						if (isset($banners)) foreach (array_keys($banners) as $key)	$node_array[] = $key;
						break;
						
		case 'none':	$node_array   = array();
						break;
						
		default:		$node_array[] = $expand;
						break;
	}
}

$node_array_size = sizeof($node_array);
for ($i=0; $i < $node_array_size;$i++)
{
	if (isset($collapse) && $collapse == $node_array[$i])
		unset ($node_array[$i]);
	else
	{
		if (isset($banners[$node_array[$i]]))
			$banners[$node_array[$i]]['expand'] = 1;
	}
}



echo "<img src='images/icon-banner-new.gif' align='absmiddle'>&nbsp;";
echo "<a href='banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."' accesskey='".$keyAddNew."'>".$strAddBanner_Key."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
phpAds_ShowBreak();

echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo "<td height='25' width='40%'><b>&nbsp;&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="campaign-banners.php?clientid='.$clientid.'&campaignid='.$campaignid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


if (!isset($banners) || !is_array($banners) || count($banners) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	echo "&nbsp;&nbsp;".$strNoBanners;
	echo "</td></tr>";
}
else
{
	$i=0;
	
	foreach (array_keys($banners) as $bkey)
	{
		if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		
		// Icon & name
		$name = $strUntitled;
		if (isset($banners[$bkey]['alt']) && $banners[$bkey]['alt'] != '') $name = $banners[$bkey]['alt'];
		if (isset($banners[$bkey]['description']) && $banners[$bkey]['description'] != '') $name = $banners[$bkey]['description'];
		
		$name = phpAds_breakString ($name, '30');
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
		echo "&nbsp;";
		
		
		if (!$phpAds_config['gui_show_campaign_preview'])
		{
			if ($banners[$bkey]['expand'] == '1')
				echo "<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&collapse=".$banners[$bkey]['bannerid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=".$banners[$bkey]['bannerid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;";
		
		if ($banners[$bkey]['active'] == 't')
		{
			if ($banners[$bkey]['storagetype'] == 'html')
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
			elseif ($banners[$bkey]['storagetype'] == 'txt')
				echo "<img src='images/icon-banner-text.gif' align='absmiddle'>";
			elseif ($banners[$bkey]['storagetype'] == 'url')
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
			else
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
		}
		else
		{
			if ($banners[$bkey]['storagetype'] == 'html')
				echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
			elseif ($banners[$bkey]['storagetype'] == 'txt')
				echo "<img src='images/icon-banner-text-d.gif' align='absmiddle'>";
			elseif ($banners[$bkey]['storagetype'] == 'url')
				echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
			else
				echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
		}
		
		echo "&nbsp;<a href='banner-edit.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bkey."'>".$name."</td>";
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$bkey."</td>";
		
		
		// Button 1
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		echo "<a href='banner-acl.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]['bannerid']."'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td>";
		
		// Button 2
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		if ($banners[$bkey]["active"] == "t")
		{
			echo "<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]["bannerid"]."&value=".$banners[$bkey]["active"]."'><img src='images/icon-deactivate.gif' align='absmiddle' border='0'>&nbsp;";
			echo $strDeActivate;
		}
		else
		{
			echo "<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]["bannerid"]."&value=".$banners[$bkey]["active"]."'><img src='images/icon-activate.gif' align='absmiddle' border='0'>&nbsp;";
			echo $strActivate;
		}
		echo "</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		
		// Button 3
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		echo "<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$banners[$bkey]['bannerid']."&returnurl=campaign-banners.php'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td></tr>";
		
		
		// Extra banner info
		if ($phpAds_config['gui_show_banner_info'])
		{
			echo "<tr height='1'>";
			echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
			echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
			echo "</tr>";
			
			echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='1'>&nbsp;</td><td colspan='4'>";
			echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
			
			echo "<tr height='25'><td colspan='2'>".($banners[$bkey]['url'] != '' ? $banners[$bkey]['url'] : '-')."</td></tr>";
			echo "<tr height='15'><td colspan='2'>".$strKeyword.": ".($banners[$bkey]['keyword'] != '' ? $banners[$bkey]['keyword'] : '-')."</td></tr>";
			
			if ($banners[$bkey]['storagetype'] == 'txt')
				echo "<tr height='25'><td width='50%'>".$strSize.": -</td>";
			else
				echo "<tr height='25'><td width='50%'>".$strSize.": ".$banners[$bkey]['width']." x ".$banners[$bkey]['height']."</td>";
			
			echo "<td width='50%'>".$strWeight.": ".$banners[$bkey]['weight']."</td></tr>";
			
			echo "</table><br></td></tr>";
		}
		
		
		// Banner preview
		if ($banners[$bkey]['expand'] == 1 || $phpAds_config['gui_show_campaign_preview'])
		{
			if (!$phpAds_config['gui_show_banner_info'])
			{
				echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='1'>&nbsp;</td><td colspan='4'>";
			}
			
			echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='5'>";
			echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr>";
		   	echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "<td width='100%'>".phpAds_buildBannerCode ($banners[$bkey]['bannerid'], true)."</td>";
			echo "</tr></table><br><br>";
			echo "</td></tr>";
		}
		
		$i++;
	}
}

echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr height='25'><td colspan='3' height='25' nowrap>";

if (isset($banners) && count($banners))
	echo "<img src='images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&returnurl=campaign-banners.php'".phpAds_DelConfirm($strConfirmDeleteAllBanners).">$strDeleteAllBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";

if (isset($banners) && $count_active < count($banners))
	echo "<img src='images/icon-activate.gif' border='0' align='absmiddle'>&nbsp;<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&value=f'>$strActivateAllBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";

if ($count_active > 0)
	echo "<img src='images/icon-deactivate.gif' border='0' align='absmiddle'>&nbsp;<a href='banner-activate.php?clientid=".$clientid."&campaignid=".$campaignid."&value=t'>$strDeactivateAllBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";

echo "</td>";

if (!$phpAds_config['gui_show_campaign_preview'])
{
	echo "<td colspan='2' align='".$phpAds_TextAlignRight."' nowrap>";
	echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>";
	echo "</td>";
}
else
	echo "<td colspan='2'>&nbsp;</td>";


echo "</tr>";
echo "</table>";
echo "<br><br>";
echo "<br><br>";



echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='2'><b>$strCreditStats</b></td></tr>";
echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

list($desc,$enddate,$daysleft)=days_left($campaignid);
$adclicksleft = adclicks_left($campaignid);
$adviewsleft  = adviews_left($campaignid);

echo "<tr><td height='25'>$strViewCredits: <b>$adviewsleft</b></td>";
echo "<td height='25'>$strClickCredits: <b>$adclicksleft</b></td></tr>";
echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='25' colspan='2'>$desc</td></tr>";

echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";
echo "<br><br>";



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['campaign-banners.php'][$campaignid]['listorder'] = $listorder;
$Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'] = $orderdirection;
$Session['prefs']['campaign-banners.php'][$campaignid]['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>