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
require ("lib-size.inc.php");


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
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
		") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($affiliateid == $row['affiliateid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='zone-index.php?affiliateid=". $row['affiliateid']."'>".phpAds_buildAffiliateName ($row['affiliateid'], $row['name'])."</a>";
		$extra .= "<br>"; 
	}
	
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	
	phpAds_PageHeader("4.2.3", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.2", "4.2.3"));
}
else
{
	phpAds_PageHeader("2.1");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1", "2.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($listorder)) 	 $listorder = '';
if (!isset($orderdirection)) $orderdirection = '';


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


echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	


echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=name&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=name&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=id&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=id&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;</td>';
echo '<td height="25"><b><a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=size">'.$GLOBALS['strSize'].'</a>';

if ($listorder == "size")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=size&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="'.$PHP_SELF.'?affiliateid='.$affiliateid.'&listorder=size&orderdirection=down">';
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
	
	echo "<td height='25'>";
	echo "&nbsp;&nbsp;<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
	echo "<a href='zone-edit.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'>".$row_zones['zonename']."</a>";
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
	echo "<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-probability.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'><img src='images/icon-zone-probability.gif' border='0' align='absmiddle' alt='$strProbability'>&nbsp;$strProbability</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-invocation.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'><img src='images/icon-generatecode.gif' border='0' align='absmiddle' alt='$strInvocationcode'>&nbsp;$strInvocationcode</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-delete.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	
	$i++;
}

if (phpAds_dbNumRows($res_zones) > 0)
{
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr height='25'><td colspan='4' height='25'>";
echo "<img src='images/icon-zone.gif' border='0' align='absmiddle'>&nbsp;<a href='zone-edit.php?affiliateid=".$affiliateid."'>$strAddNewZone</a>&nbsp;&nbsp;";
echo "</td></tr>";

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
