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
require ("lib-size.inc.php");
require ("lib-zones.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	$affiliateid = phpAds_getUserID();
}



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['affiliate-zones.php']['listorder']))
		$listorder = $Session['prefs']['affiliate-zones.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['affiliate-zones.php']['orderdirection']))
		$orderdirection = $Session['prefs']['affiliate-zones.php']['orderdirection'];
	else
		$orderdirection = '';
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	if (isset($Session['prefs']['affiliate-index.php']['listorder']))
		$navorder = $Session['prefs']['affiliate-index.php']['listorder'];
	else
		$navorder = '';
	
	if (isset($Session['prefs']['affiliate-index.php']['orderdirection']))
		$navdirection = $Session['prefs']['affiliate-index.php']['orderdirection'];
	else
		$navdirection = '';
	
	
	// Get other affiliates
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
		".phpAds_getAffiliateListOrder ($navorder, $navdirection)."
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
			"affiliate-zones.php?affiliateid=".$row['affiliateid'],
			$affiliateid == $row['affiliateid']
		);
	}
	
	phpAds_PageShortcut($strAffiliateHistory, 'stats-affiliate-history.php?affiliateid='.$affiliateid, 'images/icon-statistics.gif');	
	
	phpAds_PageHeader("4.2.3");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.2", "4.2.3"));
}
else
{
	$sections[] = "2.1";
	if (phpAds_isAllowed(phpAds_ModifyInfo)) $sections[] = "2.2";
	
	phpAds_PageHeader("2.1");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections($sections);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get clients & campaign and build the tree

$res_zones = phpAds_dbQuery("
		SELECT 
			*
		FROM 
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = ".$affiliateid."
		".phpAds_getZoneListOrder ($listorder, $orderdirection)."
		") or phpAds_sqlDie();




if (phpAds_isUser(phpAds_Admin) || phpAds_isAllowed(phpAds_AddZone))
{
	echo "<img src='images/icon-zone.gif' border='0' align='absmiddle'>&nbsp;";
	echo "<a href='zone-edit.php?affiliateid=".$affiliateid."'>$strAddNewZone</a>&nbsp;&nbsp;";
	phpAds_ShowBreak();
}



echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	


echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;</td>';
echo '<td height="25"><b><a href="affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=size">'.$GLOBALS['strSize'].'</a>';

if ($listorder == "size")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


if (phpAds_dbNumRows($res_zones) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='4'>";
	echo "&nbsp;&nbsp;".$strNoZones;
	echo "</td></tr>";
	
	echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}

$i=0;
while ($row_zones = phpAds_dbFetchArray($res_zones))
{
	if ($i > 0) echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	echo "<td height='25'>&nbsp;&nbsp;";
	
	if ($row_zones['what'] != '')
	{
		if ($row_zones['delivery'] == phpAds_ZoneBanner)
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
		elseif ($row_zones['delivery'] == phpAds_ZoneInterstitial)
			echo "<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
		elseif ($row_zones['delivery'] == phpAds_ZonePopup)
			echo "<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;";
	}
	else
	{
		if ($row_zones['delivery'] == phpAds_ZoneBanner)
			echo "<img src='images/icon-zone-d.gif' align='absmiddle'>&nbsp;";
		elseif ($row_zones['delivery'] == phpAds_ZoneInterstitial)
			echo "<img src='images/icon-interstitial-d.gif' align='absmiddle'>&nbsp;";
		elseif ($row_zones['delivery'] == phpAds_ZonePopup)
			echo "<img src='images/icon-popup-d.gif' align='absmiddle'>&nbsp;";
	}
	
	if (phpAds_isUser(phpAds_Admin) || phpAds_isAllowed(phpAds_EditZone))
		echo "<a href='zone-edit.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'>".$row_zones['zonename']."</a>";
	else
		echo $row_zones['zonename'];
	
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td>";
	
	// ID
	echo "<td height='25'>".$row_zones['zoneid']."</td>";
	
	// Size
	if ($row_zones['width'] == -1) $row_zones['width'] = '*';
	if ($row_zones['height'] == -1) $row_zones['height'] = '*';
	
	echo "<td height='25'>".phpAds_getBannerSize($row_zones['width'], $row_zones['height'])."</td>";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
	
	// Description
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	echo "<td>&nbsp;</td>";
	echo "<td height='25' colspan='3'>".stripslashes($row_zones['description'])."</td>";
	echo "</tr>";
	
	echo "<tr height='1'>";
	echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
	echo "<td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
	echo "</tr>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	// Empty
	echo "<td>&nbsp;</td>";
	
	// Button 1, 2 & 3
	echo "<td height='25' colspan='3'>";
	if (phpAds_isUser(phpAds_Admin) || phpAds_isAllowed(phpAds_LinkBanners)) echo "<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-probability.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'><img src='images/icon-zone-probability.gif' border='0' align='absmiddle' alt='$strProbability'>&nbsp;$strProbability</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-invocation.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'><img src='images/icon-generatecode.gif' border='0' align='absmiddle' alt='$strInvocationcode'>&nbsp;$strInvocationcode</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	if (phpAds_isUser(phpAds_Admin) || phpAds_isAllowed(phpAds_DeleteZone)) echo "<a href='zone-delete.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."&returnurl=affiliate-zones.php'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	
	$i++;
}

if (phpAds_dbNumRows($res_zones) > 0)
{
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['affiliate-zones.php']['listorder'] = $listorder;
$Session['prefs']['affiliate-zones.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
