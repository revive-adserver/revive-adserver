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
require ("lib-zones.inc.php");
require ("lib-invocation.inc.php");
require ("lib-size.inc.php");
require ("lib-append.inc.php");


// Register input variables
phpAds_registerGlobal ('chaintype', 'chainzone', 'chainwhat', 'append', 'prepend', 'submitbutton');
phpAds_registerGlobal ('appendtype', 'appendtype_previous', 'appendsave', 'appendselection', 'appendwhat');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	if (isset($zoneid) && $zoneid > 0)
	{
		$result = phpAds_dbQuery("
			SELECT
				affiliateid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"] || !phpAds_isAllowed(phpAds_EditZone))
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$affiliateid = phpAds_getUserID();
		}
	}
	else
	{
		if (phpAds_isAllowed(phpAds_AddZone))
		{
			$affiliateid = phpAds_getUserID();
		}
		else
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
	}
}



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submitbutton))
{
	if (isset($zoneid) && $zoneid != '')
	{
		$sqlupdate = array();
		
		
		// Determine chain
		if ($chaintype == '1' && $chainzone != '')
			$chain = 'zone:'.$chainzone;
		elseif ($chaintype == '2' && $chainwhat != '')
			$chain = $chainwhat;
		else
			$chain = '';
		
		$sqlupdate[] = "chain='".$chain."'";
		
		
		if (!isset($prepend)) $prepend = '';
		$sqlupdate[] = "prepend='".$prepend."'";
		
		
		// Do not save append until not finished with appending, if present
		if (isset($appendsave) && $appendsave)
		{
			if ($appendtype == phpAds_AppendNone)
			{
				$append = '';
			}
			
			if ($appendtype == phpAds_AppendPopup ||
				$appendtype == phpAds_AppendInterstitial)
			{
				if ($appendselection == phpAds_AppendBanner)
					$what = isset($appendwhat[phpAds_AppendBanner]) ? implode (',', $appendwhat[phpAds_AppendBanner]) : '';
				elseif ($appendselection == phpAds_AppendZone)
					$what = isset($appendwhat[phpAds_AppendZone]) ? 'zone:'.$appendwhat[phpAds_AppendZone] : 'zone:0';
				else
					$what = $appendwhat[phpAds_AppendKeyword];
				
				if ($appendtype == phpAds_AppendPopup)
				{
					$codetype = 'popup';
				}
				else
				{
					$codetype = 'adlayer';
					if (!isset($layerstyle)) $layerstyle = 'geocities';
					include ('../libraries/layerstyles/'.$layerstyle.'/invocation.inc.php');
				}
				
				$append = addslashes(phpAds_GenerateInvocationCode());
			}
			
			$sqlupdate[] = "append='".$append."'";
			$sqlupdate[] = "appendtype='".$appendtype."'";
		}
		
		
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_zones']."
			SET
				".join(', ', $sqlupdate)."
			WHERE
				zoneid='".$zoneid."'
		") or phpAds_sqlDie();
		
		
		
		// Rebuild Cache
		if (!defined('LIBVIEWCACHE_INCLUDED'))  include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
		
		phpAds_cacheDelete('what=zone:'.$zoneid);
		
		
		// Do not redirect until not finished with zone appending, if present
		if (!isset($appendsave) || $appendsave)
		{
			if (phpAds_isUser(phpAds_Affiliate))
			{
				if (phpAds_isAllowed(phpAds_LinkBanners))
					header ("Location: zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
				else
					header ("Location: zone-probability.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
			}
			else
				header ("Location: zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
			
			exit;
		}
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (isset($Session['prefs']['affiliate-zones.php']['listorder']))
	$navorder = $Session['prefs']['affiliate-zones.php']['listorder'];
else
	$navorder = '';

if (isset($Session['prefs']['affiliate-zones.php']['orderdirection']))
	$navdirection = $Session['prefs']['affiliate-zones.php']['orderdirection'];
else
	$navdirection = '';


// Get other zones
$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_zones']."
	WHERE
		affiliateid = '".$affiliateid."'
		".phpAds_getZoneListOrder ($navorder, $navdirection)."
");

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		phpAds_buildZoneName ($row['zoneid'], $row['zonename']),
		"zone-advanced.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid'],
		$zoneid == $row['zoneid']
	);
}

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');
	phpAds_PageShortcut($strZoneHistory, 'stats-zone-history.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-statistics.gif');
	
	
	$extra  = "<form action='zone-modify.php'>";
	$extra .= "<input type='hidden' name='zoneid' value='$zoneid'>";
	$extra .= "<input type='hidden' name='returnurl' value='zone-advanced.php'>";
	$extra .= "<br><br>";
	$extra .= "<b>$strModifyZone</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-duplicate-zone.gif' align='absmiddle'>&nbsp;<a href='zone-modify.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&duplicate=true&returnurl=zone-advanced.php'>$strDuplicate</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-move-zone.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
	$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$extra .= "<select name='moveto' style='width: 110;'>";
	
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE affiliateid <> '".$affiliateid."'") or phpAds_sqlDie();
	while ($row = phpAds_dbFetchArray($res))
		$extra .= "<option value='".$row['affiliateid']."'>".phpAds_buildAffiliateName($row['affiliateid'], $row['name'])."</option>";
	
	$extra .= "</select>&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='zone-delete.php?affiliateid=$affiliateid&zoneid=$zoneid&returnurl=affiliate-zones.php'".phpAds_DelConfirm($strConfirmDeleteZone).">$strDelete</a><br>";
	$extra .= "</form>";
	
	
	phpAds_PageHeader("4.2.3.6", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.3.2", "4.2.3.6", "4.2.3.3", "4.2.3.4", "4.2.3.5"));
}
else
{
	$sections[] = "2.1.2";
	$sections[] = "2.1.6";
	if (phpAds_isAllowed(phpAds_LinkBanners)) $sections[] = "2.1.3";
	$sections[] = "2.1.4";
	$sections[] = "2.1.5";
		
	phpAds_PageHeader("2.1.6");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections($sections);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_zones']."
	WHERE
		zoneid = '".$zoneid."'
") or phpAds_sqlDie();

if (phpAds_dbNumRows($res))
	$zone = phpAds_dbFetchArray($res);

$tabindex = 1;


if (!isset($chaintype))
{
	$chainwhat = '';
	$chainzone = '';
	
	if ($zone['chain'] == '')
	{
		$chaintype = 0;
	}
	else
	{
		if (ereg("^zone:([0-9]+)$", $zone['chain'], $regs))
		{
			$chaintype = 1;
			$chainzone = $regs[1];
		}
		else
		{
			$chaintype = 2;
			$chainwhat = $zone['chain'];
		}
	}
}


echo "<form name='zoneform' method='post' action='zone-advanced.php' onSubmit='return phpAds_formSubmit();'>";
echo "<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";

echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strChainSettings."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneNoDelivery."</td><td>";
echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>";

echo "<tr><td><input type='radio' name='chaintype' value='0'".($chaintype == 0 ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td><td>";
echo $strZoneStopDelivery."</td></tr>";
echo "<tr><td colspan='2'><img src='images/break-l.gif' height='1' width='100%' align='absmiddle' vspace='8'></td></tr>";

echo "<tr><td><input type='radio' name='chaintype' value='1'".($chaintype == 1 ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td><td>";
echo $strZoneOtherZone.":</td></tr>";
echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

if ($zone['delivery'] == phpAds_ZoneBanner) echo "<img src='images/icon-zone.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZoneInterstitial) echo "<img src='images/icon-interstitial.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZonePopup) echo "<img src='images/icon-popup.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZoneText) echo "<img src='images/icon-textzone.gif' align='top'>";

echo "&nbsp;&nbsp;<select name='chainzone' style='width: 200;' onchange='phpAds_formSelectZone()' tabindex='".($tabindex++)."'>";

	$available = array();
	
	// Get list of public publishers
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE ".
						  "publiczones = 't' OR affiliateid = '".$affiliateid."'");
	
	while ($row = phpAds_dbFetchArray($res))
		$available[] = "affiliateid = '".$row['affiliateid']."'";
	
	$available = implode ($available, ' OR ');
	
	$allowothersizes = $zone['delivery'] == phpAds_ZoneInterstitial || $zone['delivery'] == phpAds_ZonePopup;
	
	// Get list of zones to link to
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE ".
						  ($zone['width'] == -1 || $allowothersizes ? "" : "width = ".$zone['width']." AND ").
						  ($zone['height'] == -1 || $allowothersizes ? "" : "height = ".$zone['height']." AND ").
						  "delivery = ".$zone['delivery']." AND (".$available.") AND zoneid != ".$zoneid);
	
	while ($row = phpAds_dbFetchArray($res))
		if ($chainzone == $row['zoneid'])
			echo "<option value='".$row['zoneid']."' selected>".phpAds_buildZoneName($row['zoneid'], $row['zonename'])."</option>";
		else
			echo "<option value='".$row['zoneid']."'>".phpAds_buildZoneName($row['zoneid'], $row['zonename'])."</option>";

echo "</select></td></tr>";
echo "<tr><td colspan='2'><img src='images/break-l.gif' height='1' width='100%' align='absmiddle' vspace='8'></td></tr>";

echo "<tr><td><input type='radio' name='chaintype' value='2'".($chaintype == 2 ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td><td>";
echo $strZoneUseKeywords.":</td></tr>";
echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";
echo "<img src='images/icon-edit.gif' align='top'>&nbsp;&nbsp;<textarea name='chainwhat' rows='3' cols='55' style='width: 200;' onkeydown='phpAds_formEditWhat()' tabindex='".($tabindex++)."'>".htmlspecialchars($chainwhat)."</textarea>";
echo "</td></tr></table></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";


if ($zone['delivery'] == phpAds_ZoneBanner)
{
	echo "<br><br><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$strAppendSettings."</b></td></tr>";
	echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
	echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
	echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	
	// Get available zones
	$available = array();
	
	
	// Get list of public publishers
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE publiczones = 't' OR affiliateid = '".$affiliateid."'");
	while ($row = phpAds_dbFetchArray($res)) 
		$available[] = "affiliateid = '".$row['affiliateid']."'";
	
	$available = implode ($available, ' OR ');
	
	
	// Get public zones
	$res = phpAds_dbQuery("SELECT zoneid, zonename, delivery FROM ".$phpAds_config['tbl_zones']." WHERE ".
						  "(delivery = ".phpAds_ZonePopup." OR delivery = ".phpAds_ZoneInterstitial.
						  ") AND (".$available.") ORDER BY zoneid");
	
	$available = array(phpAds_ZonePopup => array(), phpAds_ZoneInterstitial => array());
	while ($row = phpAds_dbFetchArray($res))
		$available[$row['delivery']][$row['zoneid']] = phpAds_buildZoneName($row['zoneid'], $row['zonename']);
	
	
	
	// Get available zones
	$available_banners = array();
	
	
	// Get campaigns from same advertiser
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent != 0 AND active = 't'");
	while ($row = phpAds_dbFetchArray($res))
		$available_banners[] = "clientid = '".$row['clientid']."'";
		
	$available_banners = implode ($available_banners, ' OR ');
	
	
	// Get banners from same advertiser
	$res = phpAds_dbQuery("SELECT bannerid, clientid, description, alt FROM ".$phpAds_config['tbl_banners']." WHERE ".
						  "active = 't' AND (".$available_banners.") ORDER BY clientid, bannerid");
	
	$available_banners = array();
	while ($row = phpAds_dbFetchArray($res))
		$available_banners[$row['bannerid']] = phpAds_buildBannerName($row['bannerid'], $row['description'], $row['alt']);
	
	
	// Determine the candidates for each type
	$candidates[phpAds_AppendPopup] 	   = count($available[phpAds_ZonePopup]) + count($available_banners);
	$candidates[phpAds_AppendInterstitial] = count($available[phpAds_ZoneInterstitial]) + count($available_banners);
	
	
	
	// Determine appendtype
	if (!isset($appendtype)) 
		$appendtype = $zone['appendtype'];
	
	if (!isset($appendtype_previous))
		$appendtype_previous = '';
		
	echo "<input type='hidden' name='appendtype_previous' value='".$appendtype."'>";
	echo "<input type='hidden' name='appendsave' value='1'>";
	
	
	// Appendtype choices
	echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$GLOBALS['strAppendType']."</td><td>";
	echo "<select name='appendtype' style='width: 200;' onchange='phpAds_formSelectAppendType()' tabindex='".($tabindex++)."'>";
	echo "<option value='".phpAds_AppendNone."'".($appendtype == phpAds_AppendNone ? ' selected' : '').">".$GLOBALS['strNone']."</option>";
	
	if ($candidates[phpAds_AppendPopup])
		echo "<option value='".phpAds_AppendPopup."'".($appendtype == phpAds_AppendPopup ? ' selected' : '').">".$GLOBALS['strPopup']."</option>";
	
	if ($candidates[phpAds_AppendInterstitial])
		echo "<option value='".phpAds_AppendInterstitial."'".($appendtype == phpAds_AppendInterstitial ? ' selected' : '').">".$GLOBALS['strInterstitial']."</option>";
	
	echo "<option value='".phpAds_AppendRaw."'".($appendtype == phpAds_AppendRaw ? ' selected' : '').">".$GLOBALS['strAppendHTMLCode']."</option>";
	echo "</select></td></tr>";
	
	
	// Line
	if ($appendtype != phpAds_AppendNone)
	{
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	}
	
	
	if ($appendtype == phpAds_AppendPopup ||
		$appendtype == phpAds_AppendInterstitial)
	{
		// Append zones
		if ($appendtype != $appendtype_previous)
		{
			// Admin chose a different append type or this is the first
			// time this page is shown to the admin
			
			if ($appendtype == $zone['appendtype'])
			{
				// Admin chose the original append type, or this is the
				// first time this page is shown to the admin.
				// Load all data from the invocation code
				
				$appendvars = phpAds_ParseAppendCode($zone['append']);
				
				$appendwhat		 = $appendvars[0]['what'];			// id's
				$appendselection = $appendvars[0]['selection'];		// keyword, banner or zone
				
				while (list($k, $v) = each($appendvars[1]))
				{
					if ($k != 'n' && $k != 'what')
						$GLOBALS[$k] = addslashes($v);
				}
			}
			else
			{
				// Admin chose a different append type from the original
				// In this case it is not possible to reuse anything, set to defaults
				
				if (count($available_zones))
				{
					$appendselection = phpAds_AppendZone;
					$appendwhat      = '';
				}
				elseif (count($available_banners))
				{
					$appendselection = phpAds_AppendBanner;
					$appendwhat      = array();
				}
				else
				{
					$appendselection = phpAds_AppendKeyword;
					$appendwhat      = '';
				}
			}
		}
		else
		{
			// Admin changed on of the lower options, reuse all of
			// info from the submitted form
			
			if ($appendselection == phpAds_AppendBanner)
			{
				if (isset($appendwhat[$appendselection]))
					$appendwhat = $appendwhat[$appendselection];
				else
					$appendwhat = array();
			}
			else
			{
				if (isset($appendwhat[$appendselection]))
					$appendwhat = $appendwhat[$appendselection];
				else
					$appendwhat = '';
			}
		}
		
		
		$available_zones = ($appendtype == phpAds_AppendPopup) ? $available[phpAds_ZonePopup] : $available[phpAds_ZoneInterstitial];
		
		
		// Header
		echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strAppendWhat."</td><td>";
		
		echo "<select name='appendselection' onChange=\"phpAds_formSelectBox(this.options[this.selectedIndex].value);\"";
		echo "tabindex='".($tabindex++)."'>";
		
		if (count($available_zones))
		{
			echo "<option value='".phpAds_AppendZone."'".($appendselection == phpAds_AppendZone ? ' SELECTED' : '').">";
			echo $strAppendZone."</option>";
		}
		
		if (count($available_banners))
		{
			echo "<option value='".phpAds_AppendBanner."'".($appendselection == phpAds_AppendBanner ? ' SELECTED' : '').">";
			echo $strAppendBanner."</option>";
		}
		
		echo "<option value='".phpAds_AppendKeyword."'".($appendselection == phpAds_AppendKeyword ? ' SELECTED' : '').">";
		echo $strAppendKeyword."</option>";
		echo "</select><br><br>";
		
		
		
		// Show all banners
		echo "<div class='box' id='box_".phpAds_AppendBanner."'".($appendselection == phpAds_AppendBanner ? '' : ' style="display: none;"').">";
		while (list($id,$name) = each ($available_banners))
		{
			echo "<div class='boxrow' onMouseOver='boxrow_over(this);' onMouseOut='boxrow_leave(this);' onClick='o=findObj(\"banner_".$id."\"); o.checked = !o.checked;'>";
			echo "<input onClick='boxrow_nonbubble();' tabindex='".($tabindex++)."' ";
			echo "type='checkbox' id='banner_".$id."' name='appendwhat[".phpAds_AppendBanner."][]' value='$id'".($appendselection == phpAds_AppendBanner && in_array ($id, $appendwhat) ? ' checked' : '').">";
			echo "&nbsp;<img src='images/icon-banner-stored.gif'>&nbsp;".$name;
			echo "</div>";
		}
		echo "</div>";
		
		
		// Show all zones
		echo "<div class='box' id='box_".phpAds_AppendZone."'".($appendselection == phpAds_AppendZone ? '' : ' style="display: none;"').">";
		
		if ($appendselection != phpAds_AppendZone || $appendwhat == '')
		{
			list($selected,) = each ($available_zones);
			reset($available_zones);
		}
		else
			$selected = $appendwhat;
		
		while (list($id,$name) = each ($available_zones))
		{
			echo "<div class='boxrow' onMouseOver='boxrow_over(this);' onMouseOut='boxrow_leave(this);' onClick='o=findObj(\"zone_".$id."\"); if (!o.checked) { o.checked = !o.checked; }'>";
			echo "<input onClick='boxrow_nonbubble();' tabindex='".($tabindex++)."' ";
			echo "type='radio' id='zone_".$id."' name='appendwhat[".phpAds_AppendZone."]' value='$id'".($id == $selected ? ' checked' : '').">";
			
			if ($appendtype == phpAds_AppendPopup)
				echo "&nbsp;<img src='images/icon-popup.gif'>";
			else
				echo "&nbsp;<img src='images/icon-interstitial.gif'>";
			
			echo "&nbsp;".$name;
			echo "</div>";
		}
		echo "</div>";
		
		
		// Show all keywords
		echo "<div id='box_".phpAds_AppendKeyword."'".($appendselection == phpAds_AppendKeyword ? '' : ' style="display: none;"').">";
		echo "<textarea class='box' name='appendwhat[".phpAds_AppendKeyword."]' tabindex='".($tabindex++)."'>".($appendselection == phpAds_AppendKeyword ? $appendwhat : '')."</textarea>";
		echo "</div>";
		
		
		
		// Line
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
		
		
		
		// Invocation options
		$extra = array('what' 		  => '',
					   'delivery' 	  => $appendtype == phpAds_AppendPopup ? phpAds_ZonePopup : phpAds_ZoneInterstitial,
					   'zoneadvanced' => true
		);
		
		phpAds_placeInvocationForm($extra, true);
		
		echo "</td></tr>";
	}
	elseif ($appendtype == phpAds_AppendRaw)
	{
		// Regular HTML append
		echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppend."</td><td>";
		echo "<textarea name='append' class='code' rows='15' cols='55' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['append'])."</textarea>";
		echo "</td></tr>";
	}
	
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}


// It isn't possible to append other banners to text zones, but
// it is possible to prepend and append regular HTML code for
// determining the layout of the text ad zone

elseif ($zone['delivery'] == phpAds_ZoneText )
{
	echo "<br><br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$strAppendSettings."</b></td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZonePrependHTML."</td><td>";
	echo "<textarea name='prepend' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['prepend'])."</textarea>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppendHTML."</td><td>";
	echo "<input type='hidden' name='appendsave' value='1'>";
	echo "<input type='hidden' name='appendtype' value='".phpAds_ZoneAppendRaw."'>";
	echo "<textarea name='append' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['append'])."</textarea>";
	echo "</td></tr>";
	
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

echo "<br><br>";
echo "<input type='submit' name='submitbutton' value='".$strSaveChanges."' tabindex='".($tabindex++)."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

?>

<script language='JavaScript'>
<!--

	// Set the name of the form
	formname = 'zoneform';


	function phpAds_formSelectZone()
	{
		form = findObj(formname);
		
		form.chaintype[0].checked = false;
		form.chaintype[1].checked = true;
		form.chaintype[2].checked = false;
	}
	
	function phpAds_formEditWhat()
	{
		if (event.keyCode != 9) 
		{
			form = findObj(formname);
			
			form.chaintype[0].checked = false;
			form.chaintype[1].checked = false;
			form.chaintype[2].checked = true;
		}
	}		

	function phpAds_formSelectAppendType()
	{
		form = findObj(formname);
		
		form.appendsave.value = '0';
		form.submit();
	}

	function phpAds_formSelectAppendDelivery(type)
	{
		form = findObj(formname);
		
		form.appendsave.value = '0';
		form.submit();
	}
	
	function phpAds_formSubmit()
	{
		// Defaults
		errors = '';
		
		// Get the type of append
		obj = findObj ('appendtype');
		appendtype = obj.options[obj.selectedIndex].value;

		if (appendtype == <?php echo phpAds_AppendPopup ?> ||
			appendtype == <?php echo phpAds_AppendInterstitial ?>)
		{
			// Get the way banners are appended
			obj = findObj ('appendselection');
			appendselection = obj.options[obj.selectedIndex].value;
			
			form = findObj(formname);

			// Check if a zone is selected
			if (appendselection == <?php echo phpAds_AppendZone ?>)
			{
				checked = false;
				
				for (i=0; i<form.elements.length; i++) 
				{
					if (form.elements.item(i).name == 'appendwhat[<?php echo phpAds_AppendZone ?>]' &&
						form.elements.item(i).checked == true) 
					{
						checked = true;
					}
				}
				
				if (!checked)
					errors = '<?php echo $strAppendErrorZone ?>';
			}
			
			// Check if one or more banners are selected
			if (appendselection == <?php echo phpAds_AppendBanner ?>)
			{
				checked = false;
				
				for (i=0; i<form.elements.length; i++) 
				{
					if (form.elements.item(i).name == 'appendwhat[<?php echo phpAds_AppendBanner ?>][]' &&
						form.elements.item(i).checked == true) 
					{
						checked = true;
					}
				}
				
				if (!checked)
					errors = '<?php echo $strAppendErrorBanner ?>';
			}
			
			// Check if there are any keywords specified
			if (appendselection == <?php echo phpAds_AppendKeyword ?>)
			{
				obj = findObj('appendwhat[<?php echo phpAds_AppendKeyword ?>]')
				
				if (obj.value == '')
				{
					errors = '<?php echo $strAppendErrorKeyword ?>';
				}
			}
		}
		
		if (errors != '')
		{
			alert (errors + "\n");
			return false;
		}
		
		return true;
	}

	function phpAds_formSelectBox(s)
	{
	 	// Hide all the boxes
		hideLayer(findObj('box_<?php echo phpAds_AppendZone ?>'));
		hideLayer(findObj('box_<?php echo phpAds_AppendBanner ?>'));
		hideLayer(findObj('box_<?php echo phpAds_AppendKeyword ?>'));
	 	
		// Show the selected box
		showLayer(findObj('box_' + s));
		
		if (s == <?php echo phpAds_AppendKeyword ?>)
		{
			obj = findObj('appendwhat[<?php echo phpAds_AppendKeyword ?>]')
			obj.focus();
		}
	}

//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>