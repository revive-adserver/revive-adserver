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
require ("lib-zones.inc.php");
require ("lib-size.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	if (isset($previouszone) && is_array($previouszone))
	{
		for (reset($previouszone);$key=key($previouszone);next($previouszone))
		{
			if (($previouszone[$key] == 't' && $includezone[$key] != 't') or
			    ($previouszone[$key] != 't' && $includezone[$key] == 't'))
			{
				phpAds_ToggleBannerInZone ($bannerid, $key);
			}
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra = '';

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = $campaignid
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($bannerid == $row['bannerid'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	$extra .= "<a href='banner-zone.php?campaignid=$campaignid&bannerid=".$row['bannerid']."'>";
	$extra .= phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']);
	$extra .= "</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

$extra .= "<form action='banner-modify.php'>";
$extra .= "<input type='hidden' name='bannerid' value='$bannerid'>";
$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
$extra .= "<input type='hidden' name='returnurl' value='banner-zone.php'>";
$extra .= "<br><br>";
$extra .= "<b>$strModifyBanner</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-duplicate-banner.gif' align='absmiddle'>&nbsp;<a href='banner-modify.php?campaignid=$campaignid&bannerid=$bannerid&duplicate=true&returnurl=banner-zone.php'>$strDuplicate</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-move-banner.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$extra .= "<select name='moveto' style='width: 110;'>";

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent != 0 AND clientid != ".$campaignid."") or phpAds_sqlDie();
while ($row = phpAds_dbFetchArray($res))
	$extra .= "<option value='".$row['clientid']."'>".phpAds_buildClientName($row['clientid'], $row['clientname'])."</option>";

$extra .= "</select>&nbsp;<input type='image' name='moveto' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='banner-delete.php?campaignid=$campaignid&bannerid=$bannerid&returnurl=campaign-index.php'".phpAds_DelConfirm($strConfirmDeleteBanner).">$strDelete</a><br>";
$extra .= "</form>";


$extra .= "<br><br><br>";
$extra .= "<b>$strShortcuts</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-banner-history.php?campaignid=$campaignid&bannerid=$bannerid>$strBannerHistory</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

$sections = array ("4.1.5.2");
if ($phpAds_config['acl']) $sections[] = "4.1.5.3";
$sections[] = "4.1.5.4";

phpAds_PageHeader("4.1.5.4", $extra);
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
	echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
	phpAds_ShowSections($sections);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>

<script language='Javascript'>
<!--
	function toggleZones()
	{
		var args=toggleZones.arguments;
		affiliateid = args[0];
		
		allchecked = true;
		for (var i=0; i<document.zones.elements.length; i++)
		{
			if (document.zones.elements[i].name == 'affiliate[' + affiliateid + ']')
			{
				if (document.zones.elements[i].checked == false)
				{
					allchecked = false;
				}
			}
		}
		
		for (i=1; i<(args.length); i++) 
		{
			zoneid = args[i];
			
			for (var j=0; j<document.zones.elements.length; j++)
			{
				if (document.zones.elements[j].name == 'includezone[' + zoneid + ']')
				{
					document.zones.elements[j].checked = allchecked;
				}
			}
		}
	}
	
	function toggleAffiliate()
	{
		var args=toggleAffiliate.arguments;
		
		allchecked = true;
		for (i=1; i<(args.length); i++) 
		{
			zoneid = args[i];
			for (var j=0; j<document.zones.elements.length; j++)
			{
				if (document.zones.elements[j].name == 'includezone[' + zoneid + ']')
				{
					if (document.zones.elements[j].checked == false)
					{
						allchecked = false;
					}
				}
			}
		}
		
		affiliateid = args[0];
		for (var i=0; i<document.zones.elements.length; i++)
		{
			if (document.zones.elements[i].name == 'affiliate[' + affiliateid + ']')
			{
				document.zones.elements[i].checked = allchecked;
			}
		}
	}
//-->
</script>

<?php



$res = phpAds_dbQuery ("
	SELECT
		affiliateid,
		name
	FROM
		".$phpAds_config['tbl_affiliates']."
	ORDER BY
		affiliateid
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	$affiliates[$row['affiliateid']] = $row;
}


$res = phpAds_dbQuery("
	SELECT 
		z.zoneid as zoneid,
		z.affiliateid as affiliateid,
		z.zonename as zonename,
		z.description as description,
		z.width as width,
		z.height as height,
		z.what as what
	FROM 
		".$phpAds_config['tbl_zones']." AS z,
		".$phpAds_config['tbl_banners']." AS b
	WHERE
		b.bannerid = $bannerid AND
		(z.width = b.width OR z.width = -1) AND
		(z.height = b.height OR z.height = -1) AND
		z.zonetype = ".phpAds_ZoneBanners."
	ORDER BY
		z.affiliateid, z.zoneid
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if (isset($affiliates[$row['affiliateid']]))
	{
		$row['linked'] = (phpAds_IsBannerInZone ($bannerid, $row['zoneid']));
		$affiliates[$row['affiliateid']]['zones'][$row['zoneid']] = $row;
	}
}


echo "<br><br>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<form name='zones' action='banner-zone.php' method='post'>";
echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
echo "<input type='hidden' name='bannerid' value='".$bannerid."'>";

echo "<tr height='25'>";
echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
echo "<td height='25'><b>".$GLOBALS['strID']."</b>&nbsp;&nbsp;&nbsp;</td>";
echo "<td height='25'><b>".$GLOBALS['strDescription']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


if (isset($affiliates) || is_array($affilates))
{
	$i=0;
	for (reset($affiliates); $akey = key($affiliates); next($affiliates))
	{
		$affiliate = $affiliates[$akey];
		
		if (isset($affiliate['zones']))
		{
			$zones 	   = $affiliate['zones'];
			
			if ($i > 0) echo "<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
			echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			$zoneids = array();
			$zoneslinked = 0;
			for (reset($zones); $zkey = key($zones); next($zones))
			{
				$zoneids[] = $zones[$zkey]['zoneid'];
				
				if ($zones[$zkey]['linked']) $zoneslinked++;
			}
			
			
			echo "<td height='25'>";
			
			if (count($zones) == $zoneslinked)
				echo "&nbsp;&nbsp;<input name='affiliate[".$affiliate['affiliateid']."]' type='checkbox' value='t' checked ";
			else
				echo "&nbsp;&nbsp;<input name='affiliate[".$affiliate['affiliateid']."]' type='checkbox' value='t' ";
			
			echo "onClick='toggleZones(".$affiliate['affiliateid'].",".implode(',', $zoneids).");'>";
			echo "&nbsp;&nbsp;<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";
			echo "<a href='affiliate-edit.php?affiliateid=".$affiliate['affiliateid']."'>".$affiliate['name']."</a>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
			
			// ID
			echo "<td height='25'>".$affiliate['affiliateid']."</td>";
			
			// Description
			echo "<td height='25'>&nbsp;</td>";
			echo "</tr>";
			
			
			for (reset($zones); $zkey = key($zones); next($zones))
			{
				$zone = $zones[$zkey];
				
				
				echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' height=1'></td>";
				echo "<td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				
				echo "<td height='25'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
			    if ($zone['linked'])
					echo "&nbsp;&nbsp;<input name='includezone[".$zone['zoneid']."]' type='checkbox' value='t' checked ";
				else
					echo "&nbsp;&nbsp;<input name='includezone[".$zone['zoneid']."]' type='checkbox' value='t' ";
				
				echo "onClick='toggleAffiliate(".$affiliate['affiliateid'].",".implode(',', $zoneids).");'>";
				echo "<input type='hidden' name='previouszone[".$zone['zoneid']."]' value='".($zone['linked'] ? 't' : 'f')."'>";
				
				echo "&nbsp;&nbsp;<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
				echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zone['zoneid']."'>".$zone['zonename']."</a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td>";
				
				// ID
				echo "<td height='25'>".$zone['zoneid']."</td>";
				
				// Description
				echo "<td height='25'>".stripslashes($zone['description'])."</td>";
				echo "</tr>";
			}
			
			$i++;
		}
	}
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}
else
{
	echo "<tr height='25' bgcolor='#F6F6F6'>";
	echo "<td colspan='4'>";
	echo "&nbsp;&nbsp;".$strNoZonesToLink;
	echo "</td>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";

if (count($affiliates) > 0)
{
	echo "<br><br>";
	echo "<input type='submit' name='submit' value='$strSaveChanges'>";
}

echo "</form>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
