<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (isset($Session['prefs']['client-index.php']['listorder']))
	$navorder = $Session['prefs']['client-index.php']['listorder'];
else
	$navorder = '';

if (isset($Session['prefs']['client-index.php']['orderdirection']))
	$navdirection = $Session['prefs']['client-index.php']['orderdirection'];
else
	$navdirection = '';


// Get other clients
$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent = 0
	".phpAds_getListOrder ($navorder, $navdirection)."
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		phpAds_buildClientName ($row['clientid'], $row['clientname']),
		"client-campaigns.php?clientid=".$row['clientid'],
		$clientid == $row['clientid']
	);
}

phpAds_PageShortcut($strClientHistory, 'stats-client-history.php?clientid='.$clientid, 'images/icon-statistics.gif');

phpAds_PageHeader("4.1.3");
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
	phpAds_ShowSections(array("4.1.2", "4.1.3"));



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($hideinactive))
{
	if (isset($Session['prefs']['client-campaigns.php'][$clientid]['hideinactive']))
		$hideinactive = $Session['prefs']['client-campaigns.php'][$clientid]['hideinactive'];
	else
		$hideinactive = ($phpAds_config['gui_hide_inactive'] == 't');
}

if (!isset($listorder))
{
	if (isset($Session['prefs']['client-campaigns.php'][$clientid]['listorder']))
		$listorder = $Session['prefs']['client-campaigns.php'][$clientid]['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['client-campaigns.php'][$clientid]['orderdirection']))
		$orderdirection = $Session['prefs']['client-campaigns.php'][$clientid]['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['client-campaigns.php'][$clientid]['nodes']))
	$node_array = explode (",", $Session['prefs']['client-campaigns.php'][$clientid]['nodes']);
else
	$node_array = array();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get clients & campaign and build the tree
$res_clients = phpAds_dbQuery("
	SELECT 
		*,
		DATE_FORMAT(expire, '$date_format') AS expire_f,
		DATE_FORMAT(activate, '$date_format') AS activate_f
	FROM 
		".$phpAds_config['tbl_clients']."
	WHERE
		parent = ".$clientid."
	".phpAds_getListOrder ($listorder, $orderdirection)."
") or phpAds_sqlDie();


while ($row_clients = phpAds_dbFetchArray($res_clients))
{
	$campaigns[$row_clients['clientid']] = $row_clients;
	$campaigns[$row_clients['clientid']]['expand'] = 0;
	$campaigns[$row_clients['clientid']]['count'] = 0;
}


// Get the banners for each campaign
$res_banners = phpAds_dbQuery("
	SELECT 
		bannerid,
		clientid,
		alt,
		description,
		active,
		storagetype
	FROM 
		".$phpAds_config['tbl_banners']."
		".phpAds_getBannerListOrder ($listorder, $orderdirection)."
	") or phpAds_sqlDie();

while ($row_banners = phpAds_dbFetchArray($res_banners))
{
	if (isset($campaigns[$row_banners['clientid']]))
	{
		$banners[$row_banners['bannerid']] = $row_banners;
		$campaigns[$row_banners['clientid']]['count']++;
	}
}



// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{
	switch ($expand)
	{
		case 'all' :	$node_array   = array();
						if (isset($campaigns)) while (list($key,) = each($campaigns)) $node_array[] = $key;
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
		if (isset($campaigns[$node_array[$i]]))
			$campaigns[$node_array[$i]]['expand'] = 1;
	}
}


// Build Tree
$campaignshidden = 0;

if (isset($banners) && is_array($banners) && count($banners) > 0)
{
	// Add banner to campaigns
	reset ($banners);
	while (list ($bkey, $banner) = each ($banners))
		if ($hideinactive == false || $banner['active'] == 't')
			$campaigns[$banner['clientid']]['banners'][$bkey] = $banner;
	
	unset ($banners);
}

if (isset($campaigns) && is_array($campaigns) && count($campaigns) > 0)
{
	reset ($campaigns);
	while (list ($key, $campaign) = each ($campaigns))
		if ($hideinactive == true && ($campaign['active'] == 'f' || $campaign['active'] == 't' && 
			count($campaign['banners']) == 0 && count($campaign['banners']) < $campaign['count']))
		{
			$campaignshidden++;
			unset($campaigns[$key]);
		}
}


echo "<img src='images/icon-campaign.gif' border='0' align='absmiddle'>&nbsp;";
echo "<a href='campaign-edit.php?clientid=".$clientid."' accesskey='".$keyAddNew."'>".$strAddCampaign_Key."</a>&nbsp;&nbsp;";
phpAds_ShowBreak();



echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo "<td height='25' width='40%'><b>&nbsp;&nbsp;<a href='client-campaigns.php?clientid=".$clientid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="client-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="client-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="client-campaigns.php?clientid='.$clientid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="client-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="client-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
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


if (!isset($campaigns) || !is_array($campaigns) || count($campaigns) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	echo "&nbsp;&nbsp;".$strNoCampaigns;
	echo "</td></tr>";
	
	echo "<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}
else
{
	$i=0;
	
	
	for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
	{
		// Icon & name
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
		echo "&nbsp;";
		
		if (isset($campaigns[$ckey]['banners']))
		{
			if ($campaigns[$ckey]['expand'] == '1')
				echo "<a href='client-campaigns.php?clientid=".$clientid."&collapse=".$campaigns[$ckey]['clientid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "<a href='client-campaigns.php?clientid=".$clientid."&expand=".$campaigns[$ckey]['clientid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
		
		
		if ($campaigns[$ckey]['active'] == 't')
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
		else
			echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
		
		echo "<a href='campaign-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."'>".$campaigns[$ckey]['clientname']."</td>";
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$campaigns[$ckey]['clientid']."</td>";
		
		// Button 1
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		if ($campaigns[$ckey]['expand'] == '1' || !isset($campaigns[$ckey]['banners']))
			echo "<a href='banner-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."'><img src='images/icon-banner-stored.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			echo "&nbsp;";
		echo "</td>";
		
		// Button 2
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		echo "<a href='campaign-banners.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td>";
		
		// Button 3
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
		echo "<a href='campaign-delete.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."&returnurl=client-campaigns.php'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td></tr>";
		
		if ($campaigns[$ckey]['expand'] == '1' && isset($campaigns[$ckey]['banners']))
		{
			$banners = $campaigns[$ckey]['banners'];
			for (reset($banners);$bkey=key($banners);next($banners))
			{
				$name = $strUntitled;
				if (isset($banners[$bkey]['alt']) && $banners[$bkey]['alt'] != '') $name = $banners[$bkey]['alt'];
				if (isset($banners[$bkey]['description']) && $banners[$bkey]['description'] != '') $name = $banners[$bkey]['description'];
				
				$name = phpAds_breakString ($name, '30');
				
				// Divider
				echo "<tr height='1'>";
				echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
				echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
				echo "</tr>";
				
				// Icon & name
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				echo "<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
				if ($banners[$bkey]['active'] == 't' && $campaigns[$ckey]['active'] == 't')
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
				
				echo "&nbsp;<a href='banner-edit.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."&bannerid=".$banners[$bkey]['bannerid']."'>".$name."</a></td>";
				
				// ID
				echo "<td height='25'>".$banners[$bkey]['bannerid']."</td>";
				
				// Empty
				echo "<td>&nbsp;</td>";
				
				// Button 2
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
				echo "<a href='banner-acl.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."&bannerid=".$banners[$bkey]['bannerid']."'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td>";
				
				// Button 3
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
				echo "<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."&bannerid=".$banners[$bkey]['bannerid']."&returnurl=client-campaigns.php'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td></tr>";
			}
		}
		
		if ($phpAds_config['gui_show_campaign_info'])
		{
			echo "<tr height='1'>";
			echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
			echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
			echo "</tr>";
			
			echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td colspan='1'>&nbsp;</td><td colspan='4'>";
			echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
			
			echo "<tr height='25'><td width='50%'>".$strViewsPurchased.": ".($campaigns[$ckey]['views'] > 0 ? $campaigns[$ckey]['views'] : $strUnlimited)."</td>";
			echo "<td width='50%'>".$strClicksPurchased.": ".($campaigns[$ckey]['clicks'] > 0 ? $campaigns[$ckey]['clicks'] : $strUnlimited)."</td></tr>";
			
			echo "<tr height='15'><td width='50%'>".$strActivationDate.": ".($campaigns[$ckey]['activate'] != '0000-00-00' ? $campaigns[$ckey]['activate_f'] : '-')."</td>";
			echo "<td width='50%'>".$strExpirationDate.": ".($campaigns[$ckey]['expire'] != '0000-00-00' ? $campaigns[$ckey]['expire_f'] : '-')."</td></tr>";
			
			echo "<tr height='25'><td width='50%'>".$strPriority.": ".($campaigns[$ckey]['target'] > 0 ? $strHigh : $strLow)."</td>";
			
			if ($campaigns[$ckey]['target'] > 0)
				echo "<td width='50%'>".$strCampaignTarget.": ".$campaigns[$ckey]['target']."</td></tr>";
			else
				echo "<td width='50%'>".$strWeight.": ".$campaigns[$ckey]['weight']."</td></tr>";
			
			echo "</table><br></td></tr>";
		}
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
}

echo "<tr height='25'><td colspan='2' height='25' nowrap>";

if ($hideinactive == true)
{
	echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='client-campaigns.php?clientid=".$clientid."&hideinactive=0'>".$strShowAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$campaignshidden." ".$strInactiveCampaignsHidden;
}
else
{
	echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='client-campaigns.php?clientid=".$clientid."&hideinactive=1'>".$strHideInactiveCampaigns."</a>";
}

echo "</td>";
echo "<td colspan='3' height='25' align='".$phpAds_TextAlignRight."' nowrap>";
echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
echo "&nbsp;<a href='client-campaigns.php?clientid=".$clientid."&expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
echo "&nbsp;<a href='client-campaigns.php?clientid=".$clientid."&expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>&nbsp;&nbsp;";
echo "</td>";
echo "</tr>";

if (isset($campaigns) && count($campaigns))
{
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr height='25'>";
	echo "<td colspan='5' height='25' align='".$phpAds_TextAlignRight."'>";
	echo "<img src='images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;<a href='campaign-delete.php?clientid=".$clientid."&returnurl=client-campaigns.php'".phpAds_DelConfirm($strConfirmDeleteAllCampaigns).">$strDeleteAllCampaigns</a>&nbsp;&nbsp;";
	echo "</td>";
	echo "</tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['client-campaigns.php'][$clientid]['hideinactive'] = $hideinactive;
$Session['prefs']['client-campaigns.php'][$clientid]['listorder'] = $listorder;
$Session['prefs']['client-campaigns.php'][$clientid]['orderdirection'] = $orderdirection;
$Session['prefs']['client-campaigns.php'][$clientid]['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>