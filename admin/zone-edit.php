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

if (isset($submit))
{
	if (isset($description)) $description = addslashes ($description);
	
	if ($sizetype == 'custom')
	{
		if (isset($width) && $width == '*') $width = -1;
		if (isset($height) && $height == '*') $height = -1;
	}
	else
	{
		list ($width, $height) = explode ('x', $size);
	}
	
	
	// Edit
	if (isset($zoneid) && $zoneid != '')
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_zones']."
			SET
				zonename='".$zonename."',
				description='".$description."',
				width='".$width."',
				height='".$height."'
			WHERE
				zoneid=".$zoneid."
			") or phpAds_sqlDie();
		
		header ("Location: zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
		exit;
	}
	
	
	// Add
	else
	{
		$res = phpAds_dbQuery("
			INSERT INTO
				".$phpAds_config['tbl_zones']."
				(
				affiliateid,
				zonename,
				zonetype,
				description,
				width,
				height
				)
			 VALUES (
			 	'".$affiliateid."',
				'".$zonename."',
				'".phpAds_ZoneCampaign."',
				'".$description."',
				'".$width."',
				'".$height."'
				)
			") or phpAds_sqlDie();
		
		$zoneid = phpAds_dbInsertID();
		
		header ("Location: zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
		exit;
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($zoneid != "")
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = ".$affiliateid."
		");
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildZoneName ($row['zoneid'], $row['zonename']),
			"zone-edit.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid'],
			$zoneid == $row['zoneid']
		);
	}
	
	
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');
		phpAds_PageShortcut($strZoneHistory, 'stats-zone-history.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-statistics.gif');
		
		
		$extra  = "<form action='zone-modify.php'>";
		$extra .= "<input type='hidden' name='zoneid' value='$zoneid'>";
		$extra .= "<input type='hidden' name='affiliateid' value='$affiliateid'>";
		$extra .= "<input type='hidden' name='returnurl' value='zone-edit.php'>";
		$extra .= "<br><br>";
		$extra .= "<b>$strModifyZone</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-duplicate-zone.gif' align='absmiddle'>&nbsp;<a href='zone-modify.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&duplicate=true&returnurl=zone-edit.php'>$strDuplicate</a><br>";
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
		$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='zone-delete.php?affiliateid=$affiliateid&zoneid=$zoneid&returnurl=zone-index.php'".phpAds_DelConfirm($strConfirmDeleteZone).">$strDelete</a><br>";
		$extra .= "</form>";
		
		
		phpAds_PageHeader("4.2.3.2", $extra);
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.2.3.2", "4.2.3.3", "4.2.3.4", "4.2.3.5"));
	}
	else
	{
		$sections[] = "2.1.2";
		if (phpAds_isAllowed(phpAds_LinkBanners)) $sections[] = "2.1.3";
		$sections[] = "2.1.4";
		$sections[] = "2.1.5";
		
		phpAds_PageHeader("2.1.2");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections($sections);
	}
}
else
{
	if (phpAds_isUser(phpAds_Admin))
	{
		phpAds_PageHeader("4.2.3.1");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.2.3.1"));
	}
	else
	{
		phpAds_PageHeader("2.1.1");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
			echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
			phpAds_ShowSections(array("2.1.1"));
	}
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($zoneid) && $zoneid != '')
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			zoneid = ".$zoneid."
		") or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res))
	{
		$zone = phpAds_dbFetchArray($res);
	}
	
	if ($zone['width'] == -1) $zone['width'] = '*';
	if ($zone['height'] == -1) $zone['height'] = '*';
}
else
{
	$zone['zonename'] 		= $strDefault;
	$zone['description'] 	= '';
	$zone['width'] 			= '468';
	$zone['height'] 		= '60';
}



echo "<br><br>";

echo "<form name='zoneform' method='post' action='zone-edit.php' onSubmit='return phpAds_formCheck(this);'>";
echo "<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='phpAds_formUpdate(this);' class='flat' type='text' name='zonename' size='35' style='width:350px;' value='".phpAds_htmlQuotes($zone['zonename'])."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strDescription."</td><td>";
echo "<input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($zone["description"])."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strSize."</td><td>";

$exists = phpAds_sizeExists ($zone['width'], $zone['height']);

echo "<table><tr><td>";
echo "<input type='radio' name='sizetype' value='default'".($exists ? ' CHECKED' : '').">&nbsp;";
echo "<select name='size' onchange='phpAds_formSelectSize(this)'>"; 

for (reset($phpAds_BannerSize);$key=key($phpAds_BannerSize);next($phpAds_BannerSize))
{
	if ($phpAds_BannerSize[$key]['width'] == $zone['width'] &&
		$phpAds_BannerSize[$key]['height'] == $zone['height'])
		echo "<option value='".$phpAds_BannerSize[$key]['width']."x".$phpAds_BannerSize[$key]['height']."' selected>".$key."</option>";
	else
		echo "<option value='".$phpAds_BannerSize[$key]['width']."x".$phpAds_BannerSize[$key]['height']."'>".$key."</option>";
}

echo "<option value='-'".(!$exists ? ' SELECTED' : '').">Custom</option>";
echo "</select>";

echo "</td></tr><tr><td>";

echo "<input type='radio' name='sizetype' value='custom'".(!$exists ? ' CHECKED' : '')." onclick='phpAds_formEditSize()'>&nbsp;";
echo $strWidth.": <input class='flat' size='5' type='text' name='width' value='".(isset($zone["width"]) ? $zone["width"] : '')."' onkeydown='phpAds_formEditSize()' onBlur='phpAds_formUpdate(this);'>";
echo "&nbsp;&nbsp;&nbsp;";
echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".(isset($zone["height"]) ? $zone["height"] : '')."' onkeydown='phpAds_formEditSize()' onBlur='phpAds_formUpdate(this);'>";
echo "</td></tr></table>";

echo "</td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br><br>";
echo "<input type='submit' name='submit' value='".(isset($zoneid) && $zoneid != '' ? $strSaveChanges : ' Next > ')."'>";
echo "</form>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

// Get unique affiliate
$unique_names = array();

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_zones']." WHERE affiliateid = ".$affiliateid." AND zoneid != '".$zoneid."'");
while ($row = phpAds_dbFetchArray($res))
	$unique_names[] = $row['zonename'];

?>

<script language='JavaScript'>
<!--
	phpAds_formSetRequirements('zonename', '<?php echo $strName; ?>', true, 'unique');
	phpAds_formSetRequirements('width', '<?php echo $strWidth; ?>', true, 'number*');
	phpAds_formSetRequirements('height', '<?php echo $strHeight; ?>', true, 'number*');
	
	phpAds_formSetUnique('zonename', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');


	function phpAds_formSelectSize(o)
	{
		// Get size from select
		size   = o.options[o.selectedIndex].value;

		if (size != '-')
		{
			// Get width and height
			sarray = size.split('x');
			height = sarray.pop();
			width  = sarray.pop();
		
			// Set width and height
			document.zoneform.width.value = width;
			document.zoneform.height.value = height;
		
			// Set radio
			document.zoneform.sizetype[0].checked = true;
			document.zoneform.sizetype[1].checked = false;
		}
		else
		{
			document.zoneform.sizetype[0].checked = false;
			document.zoneform.sizetype[1].checked = true;
		}
	}
	
	function phpAds_formEditSize()
	{
		document.zoneform.sizetype[0].checked = false;
		document.zoneform.sizetype[1].checked = true;
		document.zoneform.size.selectedIndex = document.zoneform.size.options.length - 1;
	}		

//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
