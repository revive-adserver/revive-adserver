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


// Include needed resources
require ("resources/res-iso639.inc.php");
require ("resources/res-iso3166.inc.php");
require ("resources/res-useragent.inc.php");
require ("resources/res-continent.inc.php");


// Register input variables
phpAds_registerGlobal ('submit', 'action', 'acl', 'type', 'time', 'cap');


// Security check
phpAds_checkAccess(phpAds_Admin);


// Define variable types
$acl_types['weekday']   = $strWeekDay;
$acl_types['time']		= $strTime;
$acl_types['clientip']	= $strClientIP;
$acl_types['domain']	= $strDomain;
$acl_types['language']	= $strLanguage;

if ($phpAds_config['geotracking_type'] != 0)
{
	$acl_types['country']	= $strCountry;
	$acl_types['continent']	= $strContinent;
}

$acl_types['browser']   = $strBrowser;
$acl_types['os']		= $strOS;
$acl_types['useragent']	= $strUserAgent;
$acl_types['source']	= $strSource;


$aclad_types = array(
		'allow' => $strEqualTo,
		'deny'  => $strDifferentFrom
	);

$aclcon_types = array(
		'or'  => $strOR,
		'and' => $strAND
	);



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($action))
{
	if (!isset($acl))
		$acl = array();
	
	if (isset($action['down']))
	{
		// Move limitation down
		$source = key($action['down']);
		$destination = $source + 1;
		
		$tmp = $acl[$source];
		$acl[$source] = $acl[$destination];
		$acl[$destination] = $tmp;
	}
	
	if (isset($action['up']))
	{
		// Move limitation up
		$source = key($action['up']);
		$destination = $source - 1;
		
		$tmp = $acl[$source];
		$acl[$source] = $acl[$destination];
		$acl[$destination] = $tmp;
	}
	
	if (isset($action['del']))
	{
		// Delete limitation
		$first = key($action['del']);
		$last  = count($acl) - 1;
		$tmp   = array();
		
		for ($i=0; $i < $first; $i++)
			$tmp[$i] = $acl[$i];
		
		for ($i=$first; $i < $last; $i++)
			$tmp[$i] = $acl[$i + 1];
		
		$acl = $tmp;
	}
	
	if (isset($action['new']))
	{
		// Create new limitation
		$last  = count($acl);
		
		$acl[$last]['con']  = 'and';
		$acl[$last]['type'] = $type;
		$acl[$last]['ad']   = 'allow';
		
		if ($type == 'time' || $type == 'weekday' || 
			$type == 'browser' || $type == 'os' ||
			$type == 'country' || $type == 'continent' ||
			$type == 'language')
			$acl[$last]['data'] = array();
		else
			$acl[$last]['data'] = '';
	}
}
elseif (isset($submit))
{
	if ($phpAds_config['acl'])
	{
		// First delete existing limitations
		phpAds_dbQuery ("
			DELETE FROM 
				".$phpAds_config['tbl_acls']." 
			WHERE 
				bannerid='".$bannerid."'
		");
		
		// Store limitations
		if (isset($acl) && count($acl))
		{
			reset($acl);
			while (list ($key,) = each ($acl))
			{
				if (isset($acl[$key]['data']))
				{
					if ($acl[$key]['type'] == 'time' || $acl[$key]['type'] == 'weekday' || 
						$acl[$key]['type'] == 'country' || $acl[$key]['type'] == 'continent')
					{
						$acl[$key]['data'] = implode (',', $acl[$key]['data']);
					}
					elseif ($acl[$key]['type'] == 'language')
					{
						$acl[$key]['data'] = '('.implode (')|(', $acl[$key]['data']).')';
					}
					elseif ($acl[$key]['type'] == 'browser')
					{
						// Collect regular expressions
						$regs = array();
						
						reset ($acl[$key]['data']);
						while (list($k,$v) = each ($acl[$key]['data']))
						{
							reset ($phpAds_Browser);
							while (list($tk,$tv) = each ($phpAds_Browser))
								if ($tk == $v) $regs[] = $tv;
						}
						
						// Use addslashes because these values are not yet slashes by registerGlobal
						$acl[$key]['data'] = addslashes('('.implode (')|(', $regs).')');
					}
					elseif ($acl[$key]['type'] == 'os')
					{
						// Collect regular expressions
						$regs = array();
						
						reset ($acl[$key]['data']);
						while (list($k,$v) = each ($acl[$key]['data']))
						{
							reset ($phpAds_OS);
							while (list($tk,$tv) = each ($phpAds_OS))
								if ($tk == $v) $regs[] = $tv;
						}
						
						// Use addslashes because these values are not yet slashes by registerGlobal
						$acl[$key]['data'] = addslashes('('.implode (')|(', $regs).')');
					}
				}
				else
					$acl[$key]['data'] = '';
				
				phpAds_dbQuery ("
					INSERT INTO
						".$phpAds_config['tbl_acls']."
					SET
						bannerid  = '".$bannerid."',
						acl_con   = '".$acl[$key]['con']."',
						acl_type  = '".$acl[$key]['type']."',
						acl_data  = '".$acl[$key]['data']."',
						acl_ad    = '".$acl[$key]['ad']."',
						acl_order = '".$key."'
				");
			}
		}
		
		
		// Precompile limitation
		$expression = '';
		$i = 0;
		
		if (isset($acl) && count($acl))
		{
			reset($acl);
			while (list ($key,) = each ($acl))
			{
				if ($i > 0)
					$expression .= ' '.$acl[$key]['con'].' ';
				
				switch ($acl[$key]['type'])
				{
					case 'clientip':
						$expression .= "phpAds_aclCheckClientIP(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'browser':
						$expression .= "phpAds_aclCheckUseragent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'os':
						$expression .= "phpAds_aclCheckUseragent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'useragent':
						$expression .= "phpAds_aclCheckUseragent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'language':
						$expression .= "phpAds_aclCheckLanguage(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'country':
						$expression .= "phpAds_aclCheckCountry(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'continent':
						$expression .= "phpAds_aclCheckContinent(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'weekday':
						$expression .= "phpAds_aclCheckWeekday(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'domain':
						$expression .= "phpAds_aclCheckDomain(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					case 'source':
						$expression .= "phpAds_aclCheckSource(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\', $"."source)";
						break;
					case 'time':
						$expression .= "phpAds_aclCheckTime(\'".addslashes($acl[$key]['data'])."\', \'".$acl[$key]['ad']."\')";
						break;
					default:
						return(0);
				}
				
				$i++;
			}
		}
		
		if ($expression == '')
			$expression = 'true';
		
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_banners']."
			SET
				compiledlimitation='".$expression."'
			WHERE
				bannerid='".$bannerid."'
		") or phpAds_sqlDie();
	}
	
	
	// Set time limit
	if (isset($time))
	{
		$block = 0;
		if ($time['second'] != '-') $block += (int)$time['second'];
		if ($time['minute'] != '-') $block += (int)$time['minute'] * 60;
		if ($time['hour'] != '-') 	$block += (int)$time['hour'] * 3600;
	}
	else
		$block = 0;
	
	// Set capping
	if (isset($cap) && $cap != '-')
		$cap = (int)$cap;
	else
		$cap = 0;
	
	
	$res = phpAds_dbQuery("
		UPDATE
			".$phpAds_config['tbl_banners']."
		SET
			block='".$block."', capping='".$cap."'
		WHERE
			bannerid='".$bannerid."'
	") or phpAds_sqlDie();
	
	
	
	// Rebuild zone cache
	if ($phpAds_config['zone_cache'])
		phpAds_RebuildZoneCache ();	
	
	
	Header ('Location: banner-zone.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid);
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['listorder']))
	$navorder = $Session['prefs']['campaign-banners.php'][$campaignid]['listorder'];
else
	$navorder = '';

if (isset($Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection']))
	$navdirection = $Session['prefs']['campaign-banners.php'][$campaignid]['orderdirection'];
else
	$navdirection = '';


// Get other banners
$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = '$campaignid'
	".phpAds_getBannerListOrder($navorder, $navdirection)."
");

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']),
		"banner-acl.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$row['bannerid'],
		$bannerid == $row['bannerid']
	);
}

phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
phpAds_PageShortcut($strBannerHistory, 'stats-banner-history.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-statistics.gif');



$extra  = "<form action='banner-modify.php'>";
$extra .= "<input type='hidden' name='clientid' value='$clientid'>";
$extra .= "<input type='hidden' name='campaignid' value='$campaignid'>";
$extra .= "<input type='hidden' name='bannerid' value='$bannerid'>";
$extra .= "<input type='hidden' name='returnurl' value='banner-acl.php'>";
$extra .= "<br><br>";
$extra .= "<b>$strModifyBanner</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-duplicate-banner.gif' align='absmiddle'>&nbsp;<a href='banner-modify.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&duplicate=true&returnurl=banner-acl.php'>$strDuplicate</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-move-banner.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";
$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$extra .= "<select name='moveto' style='width: 110;'>";

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE parent != 0 AND clientid != '".$campaignid."'") or phpAds_sqlDie();
while ($row = phpAds_dbFetchArray($res))
	$extra .= "<option value='".$row['clientid']."'>".phpAds_buildClientName($row['clientid'], $row['clientname'])."</option>";

$extra .= "</select>&nbsp;<input type='image' name='moveto' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-duplicate-acl.gif' align='absmiddle'>&nbsp;$strApplyLimitationsTo<br>";
$extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$extra .= "<select name='applyto' style='width: 110;'>";

$res = phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_banners']." WHERE bannerid != '".$bannerid."' AND clientid = '".$campaignid."'") or phpAds_sqlDie();
while ($row = phpAds_dbFetchArray($res))
	$extra .= "<option value='".$row['bannerid']."'>".phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt'])."</option>";

$extra .= "</select>&nbsp;<input type='image' name='applyto' src='images/".$phpAds_TextDirection."/go_blue.gif'><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='banner-delete.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&returnurl=campaign-banners.php'".phpAds_DelConfirm($strConfirmDeleteBanner).">$strDelete</a><br>";
$extra .= "</form>";



phpAds_PageHeader("4.1.3.4.3", $extra);
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
	echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
	phpAds_ShowSections(array("4.1.3.4.2", "4.1.3.4.3", "4.1.3.4.4"));




/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($acl) && $phpAds_config['acl'])
{
	// Fetch all ACLs from the database
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_acls']."
		WHERE
			bannerid = '".$bannerid."'
		ORDER BY acl_order
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray ($res))
	{
		$acl[$row['acl_order']]['con'] 	= $row['acl_con'];
		$acl[$row['acl_order']]['type'] = $row['acl_type'];
		$acl[$row['acl_order']]['ad'] 	= $row['acl_ad'];
		
		if ($row['acl_type'] == 'time' || $row['acl_type'] == 'weekday' || 
			$row['acl_type'] == 'country' || $row['acl_type'] == 'continent')
		{
			$acl[$row['acl_order']]['data'] = explode (',', $row['acl_data']);
		}
		elseif ($row['acl_type'] == 'language')
		{
			if (ereg("^\(.*\)$", $row['acl_data']))
				$row['acl_data'] = substr($row['acl_data'], 1, strlen($row['acl_data']) - 2);
			
			$acl[$row['acl_order']]['data'] = explode (')|(', $row['acl_data']);
		}
		elseif ($row['acl_type'] == 'browser')
		{
			if (ereg("^\(.*\)$", $row['acl_data']))
				$row['acl_data'] = substr($row['acl_data'], 1, strlen($row['acl_data']) - 2);
			
			$keys = explode (')|(', $row['acl_data']);
			
			while (list($k,$v) = each($keys))
			{
				reset ($phpAds_Browser);
				while (list($tk,$tv) = each ($phpAds_Browser))
					if ($tv == $v) $acl[$row['acl_order']]['data'][] = $tk;
			}
		}
		elseif ($row['acl_type'] == 'os')
		{
			if (ereg("^\(.*\)$", $row['acl_data']))
				$row['acl_data'] = substr($row['acl_data'], 1, strlen($row['acl_data']) - 2);
			
			$keys = explode (')|(', $row['acl_data']);
			
			while (list($k,$v) = each($keys))
			{
				reset ($phpAds_OS);
				while (list($tk,$tv) = each ($phpAds_OS))
					if ($tv == $v) $acl[$row['acl_order']]['data'][] = $tk;
			}
		}
		else
			$acl[$row['acl_order']]['data'] = addslashes($row['acl_data']);
	}
}

if (!isset($time) || !isset($cap))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = '".$bannerid."'
	");
	
	if ($row = phpAds_dbFetchArray ($res))
	{
		if (!isset($time))
		{
			$seconds = $row['block'];
			
			$time['hour'] = ($seconds - ($seconds % 3600)) / 3600;
			$seconds = $seconds % 3600;
			
			$time['minute'] = ($seconds - ($seconds % 60)) / 60;
			$seconds = $seconds % 60;
			
			$time['second'] = $seconds;
		}
		
		if (!isset($cap))
		{
			$cap = $row['capping'];
		}
	}
}

if ($time['hour'] == 0 && $time['minute'] == 0 && $time['second'] == 0) $time['second'] = '-'; 
if ($time['hour'] == 0 && $time['minute'] == 0) $time['minute'] = '-'; 
if ($time['hour'] == 0) $time['hour'] = '-';
if ($cap == 0) $cap = '-';



// Begin form
echo "<form action='banner-acl.php' method='get'>";
echo "<input type='hidden' name='clientid' value='".$clientid."'>";
echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
echo "<input type='hidden' name='bannerid' value='".$bannerid."'>";

// Workaround: Include dummy submit image to
// prevent first del button to be used when
// pressing enter in a text field
echo "<input type='image' name='dummy' src='images/spacer.gif' border='0' width='1' height='1'><br><br>";


if ($phpAds_config['acl'])
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr><td height='25' colspan='4' bgcolor='#FFFFFF'><b>".$strDeliveryLimitations."</b></td></tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	// Display all ACLs
	if (isset($acl) && count($acl))
	{
		echo "<tr><td height='25' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$strOnlyDisplayWhen."</td></tr>";
		echo "<tr><td colspan='4'><img src='images/break-el.gif' width='100%' height='1'></td></tr>";
		
		$current_i = 0;
		$previous_i = 0;
		$previous_type = '';
		
		reset($acl);
		while (list ($key,) = each ($acl))
		{
			if ($acl[$key]['con'] == 'or' && $current_i > 0)
			{
				echo "<tr><td colspan='4'><img src='images/break-el.gif' width='100%' height='1'></td></tr>";
				$previous_i++;
			}
			else
				if ($previous_type != '') echo "<tr><td colspan='4'><img src='images/break-el.gif' width='100%' height='1'></td></tr>";
			
			
			$bgcolor = $previous_i % 2 == 0 ? "#F6F6F6" : "#FFFFFF";
			
			
			echo "<tr height='35' bgcolor='$bgcolor'>";
			echo "<td width='100'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($key == 0)
				echo "<input type='hidden' name='acl[".$key."][con]' value='".$acl[$key]['con']."'>&nbsp;";
			else
			{
				echo "<select name='acl[".$key."][con]'>";
				
				reset($aclcon_types);
				while (list ($aclcon_type, $aclcon_name) = each ($aclcon_types))
				{
					echo "<option value=";
					printf("\"%s\" %s>", $aclcon_type, $aclcon_type == $acl[$key]['con'] ? 'selected' : '');
					echo "$aclcon_name\n";
				}
				
				echo "</select>";
			}
			
			echo "</td><td width='130'>";
			echo "<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;".$acl_types[$acl[$key]['type']];
			echo "<input type='hidden' name='acl[".$key."][type]' value='".$acl[$key]['type']."'>";
			echo "</td><td >";
			echo "<select name='acl[".$key."][ad]'>";
			
			reset($aclad_types);
			while (list ($acl_ad, $acl_name) = each ($aclad_types))
			{
				echo "<option value=";
				printf("\"%s\" %s>", $acl_ad, $acl_ad == $acl[$key]['ad'] ? 'selected' : '');
				echo "$acl_name\n";
			}
			echo "</select></td>";
			
			
			// Show buttons
			echo "<td align='".$phpAds_TextAlignRight."'>";
			echo "<input type='image' name='action[del][".$key."]' src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>";
			echo "&nbsp;&nbsp;";
			echo "<img src='images/break-el.gif' width='1' height='35'>";
			echo "&nbsp;&nbsp;";
			
			if ($key && $key < count($acl))
				echo "<input type='image' name='action[up][".$key."]' src='images/triangle-u.gif' border='0' alt='$strUp' align='absmiddle'>";
			else
				echo "<img src='images/triangle-u-d.gif' alt='$strUp' align='absmiddle'>";
			
			if ($key < count($acl) - 1)
				echo "<input type='image' name='action[down][".$key."]' src='images/triangle-d.gif' border='0' alt='$strDown' align='absmiddle'>";
			else
				echo "<img src='images/triangle-d-d.gif' alt='$strDown' align='absmiddle'>";
			
			echo "&nbsp;&nbsp;</td></tr>";
			echo "<tr bgcolor='$bgcolor'><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>";
			
			if ($acl[$key]['type'] == 'weekday')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
				for ($i = 0; $i < 7; $i++)
				{
					if ($i % 4 == 0) echo "<tr>";
					echo "<td><input type='checkbox' name='acl[".$key."][data][]' value='$i'".(in_array ($i, $acl[$key]['data']) ? ' CHECKED' : '').">&nbsp;".$strDayShortCuts[$i]."&nbsp;&nbsp;</td>";
					if (($i + 1) % 4 == 0) echo "</tr>";
				}
				if (($i + 1) % 4 != 0) echo "</tr>";
				echo "</table>";
			}
			elseif ($acl[$key]['type'] == 'time')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
				for ($i = 0; $i < 24; $i++)
				{
					if ($i % 4 == 0) echo "<tr>";
					echo "<td><input type='checkbox' name='acl[".$key."][data][]' value='$i'".(in_array ($i, $acl[$key]['data']) ? ' CHECKED' : '').">&nbsp;".$i.":00&nbsp;&nbsp;</td>";
					if (($i + 1) % 4 == 0) echo "</tr>";
				}
				if (($i + 1) % 4 != 0) echo "</tr>";
				echo "</table>";
			}
			elseif ($acl[$key]['type'] == 'language')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<select name='acl[".$key."][data][]' multiple size='6' style='width: 275;'>";
				
				while (list($iso,$fullname) = each ($phpAds_ISO639))
					echo "<option value='$iso'".(in_array ($iso, $acl[$key]['data']) ? ' selected' : '').">".$fullname."</option>";
				
				echo "</select>";
			}
			elseif ($acl[$key]['type'] == 'country')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<select name='acl[".$key."][data][]' multiple size='6' style='width: 275;'>";
				
				while (list($iso,$fullname) = each ($phpAds_ISO3166))
					echo "<option value='$iso'".(in_array ($iso, $acl[$key]['data']) ? ' selected' : '').">".$fullname."</option>";
				
				echo "</select>";
			}
			elseif ($acl[$key]['type'] == 'continent')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<select name='acl[".$key."][data][]' multiple size='6' style='width: 275;'>";
				
				while (list($iso,$fullname) = each ($phpAds_cont_name))
					echo "<option value='$iso'".(in_array ($iso, $acl[$key]['data']) ? ' selected' : '').">".$fullname."</option>";
				
				echo "</select>";
			}
			elseif ($acl[$key]['type'] == 'browser')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<table width='350' cellpadding='0' cellspacing='0' border='0'>";
				$i = 0;
				
				reset ($phpAds_Browser);
				while (list($ukey, $uvalue) = each ($phpAds_Browser))
				{
					if ($i % 3 == 0) echo "<tr>";
					echo "<td><input type='checkbox' name='acl[".$key."][data][]' value='".$ukey."'".(in_array ($ukey, $acl[$key]['data']) ? ' CHECKED' : '').">&nbsp;".$ukey."&nbsp;&nbsp;</td>";
					if (($i + 1) % 3 == 0) echo "</tr>";
					$i++;
				}
				if (($i + 1) % 3 != 0) echo "</tr>";
				echo "</table>";
			}
			elseif ($acl[$key]['type'] == 'os')
			{
				if (!isset($acl[$key]['data']))
					$acl[$key]['data'] = array();
				
				echo "<table width='350' cellpadding='0' cellspacing='0' border='0'>";
				$i = 0;
				
				reset ($phpAds_OS);
				while (list($ukey, $uvalue) = each ($phpAds_OS))
				{
					if ($i % 3 == 0) echo "<tr>";
					echo "<td><input type='checkbox' name='acl[".$key."][data][]' value='".$ukey."'".(in_array ($ukey, $acl[$key]['data']) ? ' CHECKED' : '').">&nbsp;".$ukey."&nbsp;&nbsp;</td>";
					if (($i + 1) % 3 == 0) echo "</tr>";
					$i++;
				}
				if (($i + 1) % 3 != 0) echo "</tr>";
				echo "</table>";
			}
			else
				echo "<input type='text' size='40' name='acl[".$key."][data]' value='".phpAds_htmlQuotes(stripslashes(isset($acl[$key]['data']) ? $acl[$key]['data'] : ""))."'>";
			
			echo "<br><br></td></tr>";
			
			
			$previous_type = $acl[$key]['type'];
			$current_i++;
		}
		
		// Show Footer
		if (!isset($acl[$key]['type']) || $acl[$key]['type'] != $previous_type && $previous_type != '')
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	else
	{
		echo "<tr><td height='24' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$strNoLimitations."</td></tr>";
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	
	
	echo "<tr><td height='30' colspan='2'>";
	
	if (isset($acl) && count($acl) > 1)
	{
		echo "<img src='images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;";
		echo "<a href='banner-acl.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&action[clear]=true'>";
		echo $strRemoveAllLimitations."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	
	echo "</td><td height='30' colspan='2' align='".$phpAds_TextAlignRight."'>";
	echo "<img src='images/icon-acl-add.gif' align='absmiddle'>&nbsp;";
	echo "<select name='type'>";
	
	reset($acl_types);
	while (list ($acl_type, $acl_name) = each ($acl_types))
	{
		echo "<option value=";
		printf("\"%s\" %s>", $acl_type, $acl_type == 'weekday' ? 'selected':''); 
		echo "$acl_name\n";
	}
	
	echo "</select>";
	echo "&nbsp;";
	echo "<input type='image' name='action[new]' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0' align='absmiddle' alt='$strSave'>";
	echo "</td></tr>";
	
	echo "</table>";
	echo "<br><br><br>";
}


echo "<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>";
echo "<tr><td height='25' colspan='3' bgcolor='#FFFFFF'><b>".$strDeliveryCapping."</b></td></tr>";
echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strTimeCapping."</td>";
echo "<td valign='top'>";
echo "<input id='timehour' class='flat' type='text' size='3' name='time[hour]' value='".$time['hour']."' onKeyUp=\"phpAds_formLimitUpdate(this);\"> ".$strHours." &nbsp;&nbsp;";
echo "<input id='timeminute' class='flat' type='text' size='3' name='time[minute]' value='".$time['minute']."' onKeyUp=\"phpAds_formLimitUpdate(this);\"> ".$strMinutes." &nbsp;&nbsp;";
echo "<input id='timesecond' class='flat' type='text' size='3' name='time[second]' value='".$time['second']."' onBlur=\"phpAds_formLimitBlur(this);\" onKeyUp=\"phpAds_formLimitUpdate(this);\"> ".$strSeconds." &nbsp;&nbsp;";
echo "</td></tr>";
echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strImpressionCapping."</td>";
echo "<td valign='top'>";
echo "<input class='flat' type='text' size='3' name='cap' value='".$cap."' onBlur=\"phpAds_formCapBlur(this);\" > ".$strTimes;
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";



echo "<br><br><br>";
echo "<input type='submit' name='submit' value='$strSaveChanges'>";
echo "</form><br><br>";



/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

?>

<script language='JavaScript'>
<!--
	
	function phpAds_formCapBlur (i)
	{
		if (i.value == '' || i.value == '0') i.value = '-'
	}
	
	function phpAds_formLimitBlur (i)
	{
		f = i.form;
		
		if (f.timehour.value == '') f.timehour.value = '0';
		if (f.timeminute.value == '') f.timeminute.value = '0';
		if (f.timesecond.value == '') f.timesecond.value = '0';
		
		phpAds_formLimitUpdate (i);
	}
			
	function phpAds_formLimitUpdate (i)
	{
		f = i.form;
		
		// Set -
		if (f.timeminute.value == '-' && f.timehour.value != '-') f.timeminute.value = '0';
		if (f.timesecond.value == '-' && f.timeminute.value != '-') f.timesecond.value = '0';
		
		// Set 0
		if (f.timehour.value == '0') f.timehour.value = '-';
		if (f.timehour.value == '-' && f.timeminute.value == '0') f.timeminute.value = '-';
		if (f.timeminute.value == '-' && f.timesecond.value == '0') f.timesecond.value = '-';
	}
	
//-->
</script>

<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>