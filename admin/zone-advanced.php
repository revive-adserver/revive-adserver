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


// Register input variables
phpAds_registerGlobal ('chaintype', 'chainzone', 'chainwhat', 'append', 'prepend', 'submitbutton');
phpAds_registerGlobal ('appendtype', 'appendid', 'appenddelivery', 'appendsave');


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

		// Do not save append until not finished with zone appending, if present
		if (isset($appendsave) && $appendsave)
		{
			if (!isset($append)) $append = '';
			if (!isset($appendtype)) $appendtype = phpAds_ZoneAppendZone;
			if (!isset($appenddelivery)) $appenddelivery = phpAds_ZonePopup;
			
			if ($appendtype == phpAds_ZoneAppendZone)
			{
				$what = 'zone:'.(isset($appendid) ? $appendid : 0);
				
				if ($appenddelivery == phpAds_ZonePopup)
					$codetype = 'popup';
				else
				{
					$codetype = 'adlayer';
					if (!isset($layerstyle)) $layerstyle = 'geocities';
					include ('../misc/layerstyles/'.$layerstyle.'/invocation.inc.php');
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
				zoneid=".$zoneid."
			") or phpAds_sqlDie();
		
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
	
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE affiliateid != ".$affiliateid) or phpAds_sqlDie();
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
{
	$zone = phpAds_dbFetchArray($res);
}


echo "<br><br>";

echo "<form name='zoneform' method='post' action='zone-advanced.php' onSubmit='return phpAds_formZoneAdvSubmit() && phpAds_formCheck(this);'>";
echo "<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strChainSettings."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";


if (ereg("^zone:([0-9]+)$", $zone['chain'], $regs))
	$chainzone = $regs[1];
else
	$chainzone = '';

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneNoDelivery."</td><td>";
echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>";

echo "<tr><td><input type='radio' name='chaintype' value='0'".($zone['chain'] == '' ? ' CHECKED' : '').">&nbsp;</td><td>";
echo $strZoneStopDelivery."</td></tr>";
echo "<tr><td colspan='2'><img src='images/break-l.gif' height='1' width='100%' align='absmiddle' vspace='8'></td></tr>";

echo "<tr><td><input type='radio' name='chaintype' value='1'".($zone['chain'] != '' && $chainzone != '' ? ' CHECKED' : '').">&nbsp;</td><td>";
echo $strZoneOtherZone.":</td></tr>";
echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

if ($zone['delivery'] == phpAds_ZoneBanner) echo "<img src='images/icon-zone.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZoneInterstitial) echo "<img src='images/icon-interstitial.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZonePopup) echo "<img src='images/icon-popup.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZoneText) echo "<img src='images/icon-textzone.gif' align='top'>";

echo "&nbsp;&nbsp;<select name='chainzone' style='width: 200;' onchange='phpAds_formSelectZone()'>";
	
	$available = array();
	
	// Get list of public publishers
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE ".
						  "publiczones = 't' OR affiliateid = '".$affiliateid."'");
	
	while ($row = phpAds_dbFetchArray($res))
		$available[] = "affiliateid = '".$row['affiliateid']."'";
	
	$available = implode ($available, ' OR ');
	
	// Get list of zones to link to
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE ".
						  ($zone['width'] == -1 ? "" : "width = ".$zone['width']." AND ").
						  ($zone['height'] == -1 ? "" : "height = ".$zone['height']." AND ").
						  "delivery = ".$zone['delivery']." AND (".$available.") AND zoneid != ".$zoneid);
	
	while ($row = phpAds_dbFetchArray($res))
		if ($chainzone == $row['zoneid'])
			echo "<option value='".$row['zoneid']."' selected>".phpAds_buildZoneName($row['zoneid'], $row['zonename'])."</option>";
		else
			echo "<option value='".$row['zoneid']."'>".phpAds_buildZoneName($row['zoneid'], $row['zonename'])."</option>";
	
echo "</select></td></tr>";
echo "<tr><td colspan='2'><img src='images/break-l.gif' height='1' width='100%' align='absmiddle' vspace='8'></td></tr>";

echo "<tr><td><input type='radio' name='chaintype' value='2'".($zone['chain'] != '' && $chainzone == '' ? ' CHECKED' : '').">&nbsp;</td><td>";
echo $strZoneUseKeywords.":</td></tr>";
echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";
echo "<img src='images/icon-edit.gif' align='top'>&nbsp;&nbsp;<textarea name='chainwhat' rows='3' cols='55' style='width: 200;' onkeydown='phpAds_formEditWhat()'>".($chainzone == '' ? htmlspecialchars($zone['chain']) : '')."</textarea>";
echo "</td></tr></table></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";


if ($zone['delivery'] == phpAds_ZoneBanner)
{
	echo "<br><br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$strAppendSettings."</b></td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

	//echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppend."</td><td>";
	//echo "<textarea name='append' rows='6' cols='55' style='width: 100%;'>".htmlspecialchars($zone['append'])."</textarea>";

	// Get available zones
	$available = array();
	
	// Get list of public publishers
	$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_affiliates']." WHERE ".
						  "publiczones = 't' OR affiliateid = '".$affiliateid."'");
	
	while ($row = phpAds_dbFetchArray($res))
		$available[] = "affiliateid = '".$row['affiliateid']."'";
	
	$available = implode ($available, ' OR ');
	
	// Get list of zones to link to
	$res = phpAds_dbQuery("SELECT zoneid, zonename, delivery FROM ".$phpAds_config['tbl_zones']." WHERE ".
						  "(delivery = ".phpAds_ZonePopup." OR delivery = ".phpAds_ZoneInterstitial.
						  ") AND (".$available.") ORDER BY zoneid");
	
	$available = array(phpAds_ZonePopup => array(), phpAds_ZoneInterstitial => array());
	while ($row = phpAds_dbFetchArray($res))
		$available[$row['delivery']][$row['zoneid']] = phpAds_buildZoneName($row['zoneid'], $row['zonename']);
	

	if (isset($appendtype)) $zone['appendtype'] = $appendtype;

	// Select
	echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>". 'Append type' ."</td><td>";
	echo "<select name='appendtype' style='width: 200;' onchange='phpAds_formSelectAppendType()'>";
	echo "<option value='".phpAds_ZoneAppendRaw."'".($zone['appendtype'] == phpAds_ZoneAppendRaw ? ' selected' : '').">". 'HTML Code' ."</option>";

	if (count($available[phpAds_ZonePopup]) || count($available[phpAds_ZoneInterstitial]))
		echo "<option value='".phpAds_ZoneAppendZone."'".($zone['appendtype'] == phpAds_ZoneAppendZone ? ' selected' : '').">". 'Zone selection' ."</option>";
	else
		$zone['appendtype'] = phpAds_ZoneAppendRaw;

	echo "</select></td></tr>";

	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

	if ($zone['appendtype'] == phpAds_ZoneAppendZone)
	{
		if (!isset($appendid) || empty($appendid))
		{
			$appendvars = phpAds_ZoneParseAppendCode($zone['append']);

			$appendid = $appendvars[0]['zoneid'];
			$appenddelivery = $appendvars[0]['delivery'];
			if ($appenddelivery == phpAds_ZonePopup && !count($available[phpAds_ZonePopup]))
				$appenddelivery = phpAds_ZoneInterstitial;
			elseif ($appenddelivery == phpAds_ZoneInterstitial && !count($available[phpAds_ZoneInterstitial]))
				$appenddelivery = phpAds_ZonePopup;
			else
			{
				// Add globals for lib-invocation
				while (list($k, $v) = each($appendvars[1]))
				{
					if ($k != 'n' && $k != 'what')
						$GLOBALS[$k] = addslashes($v);
				}
			}
		}

		
		echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>". 'Select zone' ."</td><td>";
		echo "<input type='hidden' name='appendsave' value='1'>";
		echo "<input type='hidden' name='appendid' value='".$appendid."'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>";
		
		// Popup
		echo "<tr><td><input type='radio' name='appenddelivery' value='".phpAds_ZonePopup."'".
			(count($available[phpAds_ZonePopup]) ? ' onClick="phpAds_formSelectAppendDelivery(0)"' : ' DISABLED').
			($appenddelivery == phpAds_ZonePopup ? ' CHECKED' : '').">&nbsp;</td><td>";
		echo $GLOBALS['strPopup'].":</td></tr>";
		echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

		if (count($available[phpAds_ZonePopup]))
			echo "<img src='images/icon-popup.gif' align='top'>";
		else
			echo "<img src='images/icon-popup-d.gif' align='top'>";
		
		echo "&nbsp;&nbsp;<select name='appendpopup' style='width: 200;'".
			" onchange='phpAds_formSelectAppendZone(0)'".
			(count($available[phpAds_ZonePopup]) ? '' : ' DISABLED').">";
			
		while (list($k, $v) = each($available[phpAds_ZonePopup]))
		{
			if ($appendid == $row['zoneid'])
				echo "<option value='".$k."' selected>".$v."</option>";
			else
				echo "<option value='".$k."'>".$v."</option>";

		}
			
		echo "</select></td></tr>";

		// Interstitial
		echo "<tr><td><input type='radio' name='appenddelivery' value='".phpAds_ZoneInterstitial."'".
			(count($available[phpAds_ZoneInterstitial]) ? ' onClick="phpAds_formSelectAppendDelivery(1)"' : ' DISABLED').
			($appenddelivery == phpAds_ZoneInterstitial ? ' CHECKED' : '').">&nbsp;</td><td>";
		echo $GLOBALS['strInterstitial'].":</td></tr>";
		echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";
		
		if (count($available[phpAds_ZoneInterstitial]))
			echo "<img src='images/icon-interstitial.gif' align='top'>";
		else
			echo "<img src='images/icon-interstitial-d.gif' align='top'>";
		
		echo "&nbsp;&nbsp;<select name='appendinterstitial' style='width: 200;'".
			" onchange='phpAds_formSelectAppendZone(1)'".
			(count($available[phpAds_ZoneInterstitial]) ? '' : ' DISABLED').">";
			
		while (list($k, $v) = each($available[phpAds_ZoneInterstitial]))
		{
			if ($appendid == $row['zoneid'])
				echo "<option value='".$k."' selected>".$v."</option>";
			else
				echo "<option value='".$k."'>".$v."</option>";
		}
			
		echo "</select></td></tr></table></td></tr>";

		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

		// It shouldn't be necessary to load zone attributes from db
		$extra = array('what' => '',
					   //'width' => $zone['width'],
					   //'height' => $zone['height'],
					   'delivery' => $appenddelivery,
					   //'website' => $affiliate['website'],
					   'zoneadvanced' => true
		);
		
		// Set codetype
		$codetype = $appenddelivery == 'popup' ? 'popup' : 'adlayer';
		phpAds_placeInvocationForm($extra, true);
		
		echo "</td></tr>";
	}
	
	else
	{
		echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppend."</td><td>";
		echo "<input type='hidden' name='appendsave' value='1'>";
		echo "<textarea name='append' rows='6' cols='55' style='width: 100%;'>".htmlspecialchars($zone['append'])."</textarea>";
		echo "</td></tr>";
	}
	
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}


elseif ($zone['delivery'] == phpAds_ZoneText )
{
	echo "<br><br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='3'><b>".$strAppendSettings."</b></td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZonePrependHTML."</td><td>";
	echo "<textarea name='prepend' rows='6' cols='55' style='width: 100%;'>".htmlspecialchars($zone['prepend'])."</textarea>";
	echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppendHTML."</td><td>";
	echo "<input type='hidden' name='appendsave' value='1'>";
	echo "<input type='hidden' name='appendtype' value='".phpAds_ZoneAppendRaw."'>";
	echo "<textarea name='append' rows='6' cols='55' style='width: 100%;'>".htmlspecialchars($zone['append'])."</textarea>";
	echo "</td></tr>";
	
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table>";
}

echo "<br><br>";
echo "<input type='submit' name='submitbutton' value='".$strSaveChanges."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

?>

<script language='JavaScript'>
<!--
	function phpAds_formSelectZone()
	{
		document.zoneform.chaintype[0].checked = false;
		document.zoneform.chaintype[1].checked = true;
		document.zoneform.chaintype[2].checked = false;
	}
	
	function phpAds_formEditWhat()
	{
		document.zoneform.chaintype[0].checked = false;
		document.zoneform.chaintype[1].checked = false;
		document.zoneform.chaintype[2].checked = true;
	}		

	function phpAds_formSelectAppendType()
	{
		if (document.zoneform.appendid)
			document.zoneform.appendid.value = '-1';
		document.zoneform.appendsave.value = '0';
		document.zoneform.submit();
	}

	function phpAds_formSelectAppendDelivery(type)
	{
		document.zoneform.appendid.value = '-1';
		document.zoneform.appendsave.value = '0';
		document.zoneform.submit();
	}
	

	function phpAds_formSelectAppendZone(type)
	{
		var x;

		if (document.zoneform.appenddelivery[type] && 
			!document.zoneform.appenddelivery[type].checked)
		{
			document.zoneform.appendid.value = '-1';
			document.zoneform.appendsave.value = '0';
			document.zoneform.submit();
		}
/*		else
		{
			if (type == 0)
				x = document.zoneform.appendpopup;
			else
				x = document.zoneform.appendinterstitial;
			
			document.zoneform.appendid.value = x.options[x.selectedIndex];
		}
*/	}

	function phpAds_formZoneAdvSubmit()
	{
		if (document.zoneform.appenddelivery)
		{
			if (document.zoneform.appenddelivery[0].checked)
				x = document.zoneform.appendpopup;
			else
				x = document.zoneform.appendinterstitial;
			
			document.zoneform.appendid.value = x.options[x.selectedIndex].value;
		}

		return true;
	}

//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>