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
		
		header ("Location: zone-index.php?affiliateid=$affiliateid");
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
				description,
				width,
				height
				)
			 VALUES (
			 	'".$affiliateid."',
				'".$zonename."',
				'".$description."',
				'".$width."',
				'".$height."'
				)
			") or phpAds_sqlDie();
		
		$zoneid = phpAds_dbInsertID();
		
		header ("Location: zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid");
		exit;
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($zoneid != "")
{
	$extra = '';
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = ".$affiliateid."
		") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($zoneid == $row['zoneid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='zone-edit.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid']."'>".phpAds_buildZoneName ($row['zoneid'], $row['zonename'])."</a>";
		$extra .= "<br>"; 
	}
	
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	
	if (phpAds_isUser(phpAds_Admin))
	{
		$extra .= "<form action='zone-modify.php'>";
		$extra .= "<input type='hidden' name='zoneid' value='$zoneid'>";
		$extra .= "<input type='hidden' name='returnurl' value='zone-edit.php'>";
		$extra .= "<br><br>";
		$extra .= "<b>$strModifyZone</b><br>";
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
		$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='zone-delete.php?affiliateid=$affiliateid&zoneid=$zoneid'".phpAds_DelConfirm($strConfirmDeleteZone).">$strDelete</a><br>";
		$extra .= "</form>";
		
		
		$extra .= "<br><br><br>";
		$extra .= "<b>$strShortcuts</b><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<a href=affiliate-edit.php?affiliateid=$affiliateid>$strAffiliateProperties</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-affiliate-zones.php?affiliateid=$affiliateid>$strStats</a><br>";
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		
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
		
		phpAds_PageHeader("2.1.2", $extra);
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
	$zone['width'] = '468';
	$zone['height'] = '60';
}

?>

<script language="JavaScript">
<!--

	function selectsize(o)
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
	
	function editsize()
	{
		document.zoneform.sizetype[0].checked = false;
		document.zoneform.sizetype[1].checked = true;
		document.zoneform.size.selectedIndex = document.zoneform.size.options.length - 1;
	}		

//-->
</script>

<br><br>

<form name="zoneform" method="post" action="zone-edit.php">
<input type="hidden" name="zoneid" value="<?php if(isset($zoneid) && $zoneid != '') echo $zoneid;?>">
<input type="hidden" name="affiliateid" value="<?php if(isset($affiliateid) && $affiliateid != '') echo $affiliateid;?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strName;?></td>
		<td><input class='flat' type="text" name="zonename" size='35' style="width:350px;" value="<?php if(isset($zone["zonename"]))echo $zone["zonename"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strDescription;?></td>
    	<td><input class='flat' size="35" type="text" name="description" style="width:350px;" value="<?php if(isset($zone["description"])) echo htmlspecialchars(stripslashes ($zone["description"]));?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strSize;?></td>
		<td>
			<?php
				$exists = phpAds_sizeExists ($zone['width'], $zone['height']);
				
				echo "<table><tr><td>";
				echo "<input type='radio' name='sizetype' value='default'".($exists ? ' CHECKED' : '').">&nbsp;";
				echo "<select name='size' onchange='selectsize(this)'>"; 
				
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
				
				echo "<input type='radio' name='sizetype' value='custom'".(!$exists ? ' CHECKED' : '')." onclick='editsize()'>&nbsp;";
				echo $strWidth.": <input class='flat' size='5' type='text' name='width' value='".(isset($zone["width"]) ? $zone["width"] : '')."' onkeydown='editsize()'>";
				echo "&nbsp;&nbsp;&nbsp;";
				echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".(isset($zone["height"]) ? $zone["height"] : '')."' onkeydown='editsize()'>";
				echo "</td></tr></table>";
			?>
		</td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>


	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>


<br><br>

<input type="submit" name="submit" value="<?php if (isset($zoneid) && $zoneid != '') echo $strSaveChanges; else echo ' Next > '; ?>">
</form>



<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
