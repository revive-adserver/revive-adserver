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
		$res = db_query("
			UPDATE
				$phpAds_tbl_zones
			SET
				zonename='$zonename',
				description='$description',
				width='$width',
				height='$height'
			WHERE
				zoneid=$zoneid
			") or mysql_die();
		
		header ("Location: zone-index.php");
		exit;
	}
	
	
	// Add
	else
	{
		$res = db_query("
			INSERT INTO
				$phpAds_tbl_zones
			SET
				zonename='$zonename',
				description='$description',
				width='$width',
				height='$height'
			") or mysql_die();
		
		$zoneid = @mysql_insert_id ($phpAds_db_link);
		
		header ("Location: zone-include.php?zoneid=$zoneid");
		exit;
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($zoneid != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$extra = '';
		
		$res = db_query("
			SELECT
				*
			FROM
				$phpAds_tbl_zones
			") or mysql_die();
		
		$extra = "";
		while ($row = mysql_fetch_array($res))
		{
			if ($zoneid == $row['zoneid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href='zone-edit.php?zoneid=". $row['zoneid']."'>".phpAds_buildZoneName ($row['zoneid'], $row['zonename'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("4.2.2", $extra);
		phpAds_ShowSections(array("4.2.2", "4.2.3", "4.2.4", "4.2.5"));
	}
}
else
{
	phpAds_PageHeader("4.2.1");
	phpAds_ShowSections(array("4.2.1"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($zoneid) && $zoneid != '')
{
	$res = @db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_zones
		WHERE
			zoneid = $zoneid
		") or mysql_die();
	
	if (@mysql_num_rows($res))
	{
		$zone = @mysql_fetch_array($res);
	}
	
	if ($zone['width'] == -1) $zone['width'] = '*';
	if ($zone['height'] == -1) $zone['height'] = '*';
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

<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b><?php echo phpAds_getZoneName($zoneid);?></b><br>

<br><br>
<br><br>
<br><br>

<form name="zoneform" method="post" action="zone-edit.php">
<input type="hidden" name="zoneid" value="<?php if(isset($zoneid) && $zoneid != '') echo $zoneid;?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strName;?></td>
		<td><input type="text" name="zonename" size='35' style="width:350px;" value="<?php if(isset($zone["zonename"]))echo $zone["zonename"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strDescription;?></td>
    	<td><input size="35" type="text" name="description" style="width:350px;" value="<?php if(isset($zone["description"])) echo htmlentities(stripslashes ($zone["description"]));?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>	
		<td width='200'><?php echo $strSize;?></td>
		<td>
			<?
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
				echo $strWidth.": <input size='5' type='text' name='width' value='".(isset($zone["width"]) ? $zone["width"] : '')."' onkeydown='editsize()'>";
				echo "&nbsp;&nbsp;&nbsp;";
				echo $strHeight.": <input size='5' type='text' name='height' value='".(isset($zone["height"]) ? $zone["height"] : '')."' onkeydown='editsize()'>";
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
