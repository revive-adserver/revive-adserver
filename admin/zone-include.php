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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	$result = phpAds_dbQuery("
		SELECT
			affiliateid
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			zoneid = $zoneid
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($result);
	
	if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"] || !phpAds_isAllowed(phpAds_LinkBanners))
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$affiliateid = $row["affiliateid"];
	}
}



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	// Edit
	if (isset($zoneid) && $zoneid != '')
	{
		if (isset($description)) $description = addslashes ($description);
		
		if ($zonetype == phpAds_ZoneBanners)
		{
			if (isset($bannerid) && is_array($bannerid))
			{
				for ($i=0;$i<sizeof($bannerid);$i++)
					$bannerid[$i] = 'bannerid:'.$bannerid[$i];
				
				$what = implode (',', $bannerid);
			}
		}
		
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_zones']."
			SET
				what = '$what',
				zonetype = $zonetype
			WHERE
				zoneid=$zoneid
			") or phpAds_sqlDie();
		
		// Rebuild Cache
		phpAds_RebuildZoneCache ($zoneid);
		
		header ("Location: zone-index.php?affiliateid=".$affiliateid);
		exit;
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
	
	$extra .= "<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid']."'>".phpAds_buildZoneName ($row['zoneid'], $row['zonename'])."</a>";
	$extra .= "<br>"; 
}

$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader("4.2.3.3", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.3.2", "4.2.3.3", "4.2.3.4", "4.2.3.5"));
}
else
{
	if (phpAds_isAllowed(phpAds_EditZone)) $sections[] = "2.1.2";
	$sections[] = "2.1.3";
	$sections[] = "2.1.4";
	$sections[] = "2.1.5";
	
	phpAds_PageHeader("2.1.3", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections($sections);
}




/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_showZoneBanners ($width, $height, $what)
{
	global $phpAds_config;
	global $strName, $strID, $strUntitled;
	global $strEdit, $strCheckAllNone;
	
	
	$what_array = explode(",",$what);
	for ($k=0; $k < count($what_array); $k++)
	{
		if (substr($what_array[$k],0,9)=="bannerid:")
		{
			$bannerid = substr($what_array[$k],9);
			$bannerids[$bannerid] = true;
		}
	}
	
	$query = "
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		";
	
	if ($width != -1 && $height != -1)
		$query .= "WHERE width = $width AND height = $height";
	elseif ($width != -1)
		$query .= "WHERE width = $width";
	elseif ($height != -1)
		$query .= "WHERE height = $height";
	
	$query .= "
		ORDER BY
			bannerid";
		
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	
	
	// Header
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
	echo "<tr height='25'>";
	echo "<td height='25'><b>&nbsp;&nbsp;$strName</b></td>";
	echo "<td height='25'><b>$strID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$i = 0;
	$checkedall = true;
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$name = $strUntitled;
		if (isset($row['alt']) && $row['alt'] != '') $name = $row['alt'];
		if (isset($row['description']) && $row['description'] != '') $name = $row['description'];
			
		$name = phpAds_breakString ($name, '60');
		
		if ($i > 0) echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		
	    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Begin row
		echo "<td height='25'>";
		echo "&nbsp;&nbsp;";
		
		// Show checkbox
		if (isset($bannerids[$row['bannerid']]) && $bannerids[$row['bannerid']] == true)
			echo "<input type='checkbox' name='bannerid[]' value='".$row['bannerid']."' checked onclick='reviewall();'>"; 
		else
		{
			echo "<input type='checkbox' name='bannerid[]' value='".$row['bannerid']."' onclick='reviewall();'>"; 
			$checkedall = false;
		}
		
		// Space
		echo "&nbsp;&nbsp;";
		
		// Banner icon
		if ($row['active'] == 't')
		{
			if ($row['format'] == 'html')
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
			elseif ($row['format'] == 'url')
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
		}
		else
		{
			if ($row['format'] == 'html')
				echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>&nbsp;";
			elseif ($row['format'] == 'url')
				echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>&nbsp;";
		}
		
		// Name
		echo $name;
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$row['bannerid']."</td>";
		
		// Edit
		echo "<td height='25'>";
		echo "<a href='banner-edit.php?bannerid=".$row['bannerid']."&campaignid=".$row['clientid']."'><img src='images/icon-edit.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strEdit</a>&nbsp;&nbsp;";
		echo "</td>";
		
		// End row
		echo "</tr>";
		$i++;
	}
	
	// Footer
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr><td height='25'>";
	echo "&nbsp;&nbsp;<input type='checkbox' name='checkall' value=''".($checkedall == true ? ' checked' : '')." onclick='toggleall();'>";
	echo "&nbsp;&nbsp;".$strCheckAllNone;
	echo "</td></tr>";
	
	echo "</table>";
	
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>

<script language='Javascript'>
<!--
	function toggleall()
	{
		allchecked = false;
		
		for (var i=0; i<document.zonetypeselection.elements.length; i++)
		{
			if (document.zonetypeselection.elements[i].name == 'bannerid[]')
			{
				if (document.zonetypeselection.elements[i].checked == false)
				{
					allchecked = true;
				}
			}
		}
		
		for (var i=0; i<document.zonetypeselection.elements.length; i++)
		{
			if (document.zonetypeselection.elements[i].name == 'bannerid[]')
			{
				document.zonetypeselection.elements[i].checked = allchecked;
			}
		}
	}
	
	function reviewall()
	{
		allchecked = true;
		
		for (var i=0; i<document.zonetypeselection.elements.length; i++)
		{
			if (document.zonetypeselection.elements[i].name == 'bannerid[]')
			{
				if (document.zonetypeselection.elements[i].checked == false)
				{
					allchecked = false;
				}
			}
		}
		
				
		document.zonetypeselection.checkall.checked = allchecked;
	}	
//-->
</script>

<?php

if (isset($zoneid) && $zoneid != '')
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			zoneid = $zoneid
		") or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res))
	{
		$zone = phpAds_dbFetchArray($res);
	}
}

// Set the default zonetype
if (!isset($zonetype) || $zonetype == '')
	$zonetype = $zone['zonetype'];




echo "<br><br>";

echo "<form name='zonetypes' method='post' action='zone-include.php'>";
echo "<input type='hidden' name='zoneid' value='".$zoneid."'>";
echo "<input type='hidden' name='affiliateid' value='".$affiliateid."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strSelectZoneType."</b></td></tr>";
echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='35'>";

echo "<select name='zonetype' onChange='this.form.submit();'>";
	echo "<option value='".phpAds_ZoneBanners."'".(($zonetype == phpAds_ZoneBanners) ? " selected" : "").">".$strBannerSelection."</option>";
	//echo "<option value='".phpAds_ZoneInteractive."'".(($zonetype == phpAds_ZoneInteractive) ? " selected" : "").">".$strInteractive."</option>";
	echo "<option value='".phpAds_ZoneRaw."'".(($zonetype == phpAds_ZoneRaw) ? " selected" : "").">".$strRawQueryString."</option>";
echo "</select>";
echo "&nbsp;<a href='javascript:document.zonetypes.submit();'><img src='images/go_blue.gif' border='0'></a>";

echo "</td></tr>";
echo "</table>";
echo "<br><br>";

echo "</form>";



echo "<form name='zonetypeselection' method='post' action='zone-include.php'>";
echo "<input type='hidden' name='zoneid' value='".$zoneid."'>";
echo "<input type='hidden' name='affiliateid' value='".$affiliateid."'>";
echo "<input type='hidden' name='zonetype' value='$zonetype'>";


if ($zonetype == phpAds_ZoneBanners)
{
	phpAds_showZoneBanners($zone["width"], $zone["height"], $zone["what"]);
}

if ($zonetype == phpAds_ZoneRaw)
{
	echo "<textarea cols='50' rows='16' name='what' style='width:600px;'>".(isset($zone['what']) ? $zone['what'] : '')."</textarea>";
}


echo "<br><br>";
echo "<br><br>";

echo "<input type='submit' name='submit' value='$strSaveChanges'>";
echo "</form>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
