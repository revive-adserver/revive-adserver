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


// Register input variables
phpAds_registerGlobal ('action', 'zonetype', 'what', 'submit',
					   'showbanners', 'showcampaigns', 'hideinactive');


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

if (isset($zoneid) && $zoneid != '')
{
	if (isset($action) && $action == 'toggle')
	{
		// Update zonetype
		$result = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = ".$zoneid."
		") or phpAds_sqlDie();
		
		if ($row = phpAds_dbFetchArray($result))
		{
			if ($row['zonetype'] != $zonetype)
			{
				$res = phpAds_dbQuery("
					UPDATE
						".$phpAds_config['tbl_zones']."
					SET
						zonetype = ".$zonetype.",
						what = ''
					WHERE
						zoneid = ".$zoneid."
				") or phpAds_sqlDie();
			}
		}
		
		if ($zonetype == phpAds_ZoneBanners)
		{
			if (isset($bannerid) && $bannerid != '')
			{
				phpAds_ToggleBannerInZone ($bannerid, $zoneid);
			}
		}
		
		if ($zonetype == phpAds_ZoneCampaign)
		{
			if (isset($campaignid) && $campaignid != '')
			{
				phpAds_ToggleCampaignInZone ($campaignid, $zoneid);
			}
		}
		
		header ("Location: zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&clientid=".$clientid."&campaignid=".$campaignid);
		exit;
	}
	
	if (isset($action) && $action == 'set')
	{
		if (!isset($what)) $what = '';
		
		if ($zonetype == phpAds_ZoneBanners)
		{
			if (isset($bannerid) && is_array($bannerid))
			{
				for ($i=0;$i<sizeof($bannerid);$i++)
					$bannerid[$i] = 'bannerid:'.$bannerid[$i];
				
				$what .= implode (',', $bannerid);
			}
		}
		
		if ($zonetype == phpAds_ZoneCampaign)
		{
			if (isset($clientid) && is_array($clientid))
			{
				for ($i=0;$i<sizeof($clientid);$i++)
					$clientid[$i] = 'clientid:'.$clientid[$i];
				
				$what .= implode (',', $clientid);
			}
		}
		
		if (isset($zonetype))
		{
			$res = phpAds_dbQuery("
				UPDATE
					".$phpAds_config['tbl_zones']."
				SET
					what = '$what',
					zonetype = $zonetype
				WHERE
					zoneid=$zoneid
			") or phpAds_sqlDie();
		}
		
		// Rebuild Cache
		phpAds_RebuildZoneCache ($zoneid);
		
		header ("Location: zone-probability.php?affiliateid=".$affiliateid."&zoneid=".$zoneid);
		exit;
	}
}



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($hideinactive))
{
	if (isset($Session['prefs']['zone-include.php']['hideinactive']))
		$hideinactive = $Session['prefs']['zone-include.php']['hideinactive'];
	else
		$hideinactive = ($phpAds_config['gui_hide_inactive'] == 't');
}

if (!isset($showbanners))
{
	if (isset($Session['prefs']['zone-include.php']['showbanners']))
		$showbanners = $Session['prefs']['zone-include.php']['showbanners'];
	else
		$showbanners = ($phpAds_config['gui_show_matching'] == 't');
}

if (!isset($showcampaigns))
{
	if (isset($Session['prefs']['zone-include.php']['showcampaigns']))
		$showcampaigns = $Session['prefs']['zone-include.php']['showcampaigns'];
	else
		$showcampaigns = ($phpAds_config['gui_show_parents'] == 't');
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
		affiliateid = ".$affiliateid."
		".phpAds_getZoneListOrder ($navorder, $navdirection)."
");

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		phpAds_buildZoneName ($row['zoneid'], $row['zonename']),
		"zone-include.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid'],
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
	$extra .= "<input type='hidden' name='returnurl' value='zone-include.php'>";
	$extra .= "<br><br>";
	$extra .= "<b>$strModifyZone</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-duplicate-zone.gif' align='absmiddle'>&nbsp;<a href='zone-modify.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&duplicate=true&returnurl=zone-include.php'>$strDuplicate</a><br>";
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
	
	
	phpAds_PageHeader("4.2.3.3", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.3.2", "4.2.3.6", "4.2.3.3", "4.2.3.4", "4.2.3.5"));
}
else
{
	if (phpAds_isAllowed(phpAds_EditZone)) $sections[] = "2.1.2";
	if (phpAds_isAllowed(phpAds_EditZone)) $sections[] = "2.1.6";
	$sections[] = "2.1.3";
	$sections[] = "2.1.4";
	$sections[] = "2.1.5";
	
	phpAds_PageHeader("2.1.3");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections($sections);
}




/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_showZoneCampaign ($width, $height, $what, $delivery)
{
	global $affiliateid, $zoneid;
	global $phpAds_config, $showbanners, $hideinactive;
	global $strName, $strID, $strDescription, $strUntitled, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
	global $strEdit, $strCheckAllNone, $strSaveChanges, $strShowBanner;
	global $strNoCampaignsToLink, $strMatchingBanners, $strSelectCampaignToLink;
	global $strHideInactiveCampaigns, $strInactiveCampaignsHidden, $strShowAll;
	global $strHideMatchingBanners, $strShowMatchingBanners;
	
	$what_array = explode(",",$what);
	for ($k=0; $k < count($what_array); $k++)
	{
		if (substr($what_array[$k],0,9)=="clientid:")
		{
			$clientid = substr($what_array[$k],9);
			$clientids[$clientid] = true;
		}
	}
	
	// Fetch all campaigns
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent > 0
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
		$campaigns[$row['clientid']] = $row;
	
	$compact = (phpAds_dbNumRows($res) > $phpAds_config['gui_link_compact_limit']);
	
	
	// Fetch all banners which can be linked
	$query = "
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		";
	
	if ($delivery != phpAds_ZoneText)
	{
		if ($width != -1 && $height != -1)
			$query .= "WHERE width = $width AND height = $height AND contenttype != 'txt'";
		elseif ($width != -1)
			$query .= "WHERE width = $width AND contenttype != 'txt'";
		elseif ($height != -1)
			$query .= "WHERE height = $height AND contenttype != 'txt'";
		else
			$query .= "WHERE contenttype != 'txt'";
	}
	else
	{
		$query .= "WHERE contenttype = 'txt'";
	}
	
	$query .= "
		ORDER BY
			bannerid";
	
	$res = phpAds_dbQuery($query);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$campaigns[$row['clientid']]['banners'][$row['bannerid']] = $row;
	}
	
	
	
	if (!$compact)
	{
		echo "<form name='zonetypeselection' method='post' action='zone-include.php'>";
		echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
		echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
		echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneCampaign."'>";
		echo "<input type='hidden' name='action' value='set'>";
	}
	else
	{
		echo "<br>".$strSelectCampaignToLink."<br><br>";
		echo "<table cellpadding='0' cellspacing='0' border='0'><tr>";
		
		echo "<form name='zonetypeselection' method='get' action='zone-include.php'>";
		echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
		echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
		echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneCampaign."'>";
		
		echo "<td><img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
		echo "<select name='clientid' onChange='this.form.submit();'>";
		
		if (!isset($GLOBALS['clientid']) || $GLOBALS['clientid'] == '')
			echo "<option value='' selected></option>";
		
		// Fetch all campaigns
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = 0
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			if (isset($GLOBALS['clientid']) && $GLOBALS['clientid'] == $row['clientid'])
				echo "<option value='".$row['clientid']."' selected>[id".$row['clientid']."] ".$row['clientname']."</option>";
			else
				echo "<option value='".$row['clientid']."'>[id".$row['clientid']."] ".$row['clientname']."</option>";
		}
		
		echo "</select>";
		echo "</td></form>";
		
		if (isset($GLOBALS['clientid']) && $GLOBALS['clientid'] != '')
		{
			echo "<form name='zonetypeselection' method='get' action='zone-include.php'>";
			echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
			echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
			echo "<input type='hidden' name='clientid' value='".$GLOBALS['clientid']."'>";
			echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneCampaign."'>";
			echo "<input type='hidden' name='action' value='toggle'>";
			echo "<td>&nbsp;&nbsp;<img src='images/caret-r.gif' align='absmiddle'>&nbsp;&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
			echo "<select name='campaignid'>";
			
			// Fetch all campaigns
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_clients']."
				WHERE
					parent = ".$GLOBALS['clientid']."
			") or phpAds_sqlDie();
			
			while ($row = phpAds_dbFetchArray($res))
			{
				if (!isset($clientids[$row['clientid']]) || $clientids[$row['clientid']] != true)
					echo "<option value='".$row['clientid']."'>[id".$row['clientid']."] ".$row['clientname']." (".(isset($campaigns[$row['clientid']]['banners']) ? count($campaigns[$row['clientid']]['banners']) : 0).")</option>";
			}
			
			echo "</select>";
			echo "&nbsp;<input type='image' src='images/".$GLOBALS['phpAds_TextDirection']."/go_blue.gif' border='0'>";
			echo "</td></form>";
		}
		
		echo "</tr></table>";
		echo "<br><br>";
	}
	
	
	// Header
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
	echo "<tr height='25'>";
	echo "<td height='25' width='40%'><b>&nbsp;&nbsp;$strName</b></td>";
	echo "<td height='25'><b>$strID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$i = 0;
	$checkedall = true;
	$inactivehidden = 0;
	
	if (!$compact && phpAds_dbNumRows($res) == 0)
	{
		echo "<tr bgcolor='#F6F6F6'><td colspan='3' height='25'>&nbsp;&nbsp;".$strNoCampaignsToLink."</td></tr>";
	}
	else
	{
		for (reset($campaigns); $ckey = key($campaigns); next($campaigns))
		{
			$campaign = $campaigns[$ckey];
			
			$linkedrow = (isset($clientids[$campaign['clientid']]) && $clientids[$campaign['clientid']] == true);
			
			if ($compact)
				$showrow = $linkedrow;
			else
				$showrow = ($hideinactive == false || $hideinactive == true && ($campaign['active'] == 't' || $linkedrow));
			
			if (!$compact && !$showrow) $inactivehidden++;
			
			if ($showrow)
			{
				if ($i > 0) echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				
				// Begin row
				echo "<td height='25'>";
				echo "&nbsp;&nbsp;";
				
				if (!$compact)
				{
					// Show checkbox
					if (isset($clientids[$campaign['clientid']]) && $clientids[$campaign['clientid']] == true)
						echo "<input type='checkbox' name='clientid[]' value='".$campaign['clientid']."' checked onclick='reviewall();'>"; 
					else
					{
						echo "<input type='checkbox' name='clientid[]' value='".$campaign['clientid']."' onclick='reviewall();'>"; 
						$checkedall = false;
					}
				}
				else
				{
					echo "<a href='zone-include.php?affiliateid=".$GLOBALS['affiliateid']."&zoneid=".$GLOBALS['zoneid']."&campaignid=".$campaign['clientid']."&zonetype=".phpAds_ZoneCampaign."&action=toggle'>";
					echo "<img src='images/caret-l.gif' border='0' align='absmiddle'></a>";
				}
				
				// Space
				echo "&nbsp;&nbsp;";
				
				
				// Banner icon
				if ($campaign['active'] == 't')
					echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
				else
					echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
				
				
				// Name
				if (phpAds_isUser(phpAds_Admin))
				{
					echo "<a href='campaign-edit.php?clientid=".$campaign['parent']."&campaignid=".$campaign['clientid']."'>";
					echo phpAds_breakString ($campaign['clientname'], '60')."</a>";
				}
				else
					echo phpAds_breakString ($campaign['clientname'], '60');
				
				echo "</td>";
				
				
				// ID
				echo "<td height='25'>".$campaign['clientid']."</td>";
				
				// Edit
				echo "<td height='25'>";
				if ($showbanners)
					echo "&nbsp;";
				else
					echo str_replace ('{count}', isset($campaign['banners']) ? count($campaign['banners']) : 0, $strMatchingBanners);
				echo "</td>";
				
				// End row
				echo "</tr>";
				
				
				if ($showbanners && isset($campaign['banners']))
				{
					reset ($campaign['banners']);
					while (list ($bannerid, $banner) = each ($campaign['banners']))
					{
						$name = $strUntitled;
						if (isset($banner['alt']) && $banner['alt'] != '') $name = $banner['alt'];
						if (isset($banner['description']) && $banner['description'] != '') $name = $banner['description'];
						
						$name = phpAds_breakString ($name, '60');
						
						
						echo "<tr height='1'>";
						echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
						echo "<td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td>";
						echo "</tr>";
						
						echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						if (!$compact) echo "&nbsp;&nbsp;";
						
						// Banner icon
						if ($campaign['active'] == 't' && $banner['active'] == 't')
						{
							if ($banner['storagetype'] == 'html')
								echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'url')
								echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'txt')
								echo "<img src='images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
							else
								echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
						}
						else
						{
							if ($banner['storagetype'] == 'html')
								echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'url')
								echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'txt')
								echo "<img src='images/icon-banner-text-d.gif' align='absmiddle'>&nbsp;";
							else
								echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>&nbsp;";
						}
						
						
						// Name
						if (phpAds_isUser(phpAds_Admin))
						{
							echo "<a href='banner-edit.php?clientid=".$campaign['parent']."&campaignid=".$campaign['clientid']."&bannerid=".$banner['bannerid']."'>";
							echo $name."</a>";
						}
						else
							echo $name;
						
						echo "</td>";
						
						
						// ID
						echo "<td height='25'>".$banner['bannerid']."</td>";
						
						// Show banner
						if ($banner['contenttype'] == 'txt')
						{
							$width	= 300;
							$height = 200;
						}
						else
						{
							$width  = $banner['width'] + 64;
							$height = $banner['bannertext'] ? $banner['height'] + 90 : $banner['height'] + 64;
						}
						
						echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
						echo "<a href='banner-htmlpreview.php?bannerid=$bannerid' target='_new' ";
						echo "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$banner['bannerid']."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
						echo "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strShowBanner."</a>&nbsp;&nbsp;";
						echo "</td>";
					}
				}
				
				
				$i++;
			}
		}
	}
	
	if (!$compact)
	{
		echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
		echo "&nbsp;&nbsp;<input type='checkbox' name='checkall' value=''".($checkedall == true ? ' checked' : '')." onclick='toggleall();'>";
		echo "&nbsp;&nbsp;<b>".$strCheckAllNone."</b>";
		echo "</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
	}
	
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='25' align='".$phpAds_TextAlignLeft."' nowrap>";
	
	if (!$compact)
	{
		if ($hideinactive == true)
		{
			echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
			echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&hideinactive=0'>".$strShowAll."</a>";
			echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$inactivehidden." ".$strInactiveCampaignsHidden;
		}
		else
		{
			echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
			echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&hideinactive=1'>".$strHideInactiveCampaigns."</a>";
		}
	}
	
	echo "</td><td colspan='2' align='".$phpAds_TextAlignRight."' nowrap>";
	
	if ($showbanners == true)
	{
		echo "&nbsp;&nbsp;<img src='images/icon-banner-stored-d.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&showbanners=0'>".$strHideMatchingBanners."</a>";
	}
	else
	{
		echo "&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&showbanners=1'>".$strShowMatchingBanners."</a>";
	}
	
	echo "&nbsp;&nbsp;</td></tr>";
	echo "</table>";
	echo "<br><br>";
	echo "<br><br>";
	
	if (!$compact)
	{
		echo "<input type='submit' name='submit' value='$strSaveChanges'>";
		echo "</form>";
	}
}



function phpAds_showZoneBanners ($width, $height, $what, $zonetype, $delivery)
{
	global $phpAds_config, $showcampaigns, $hideinactive, $affiliateid, $zoneid;
	global $strName, $strID, $strUntitled, $strDescription, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
	global $strEdit, $strCheckAllNone, $strShowBanner;
	global $strNoBannersToLink, $strSaveChanges, $strSelectBannerToLink, $strInactiveBannersHidden;
	global $strShowParentCampaigns, $strHideParentCampaigns, $strHideInactiveBanners, $strShowAll;
	
	if ($zonetype == phpAds_ZoneBanners)
	{
		// Determine selected banners
		$what_array = explode(",",$what);
		for ($k=0; $k < count($what_array); $k++)
		{
			if (substr($what_array[$k],0,9)=="bannerid:")
			{
				$bannerid = substr($what_array[$k],9);
				$bannerids[$bannerid] = true;
			}
		}
	}
	elseif ($zonetype == phpAds_ZoneCampaign)
	{
		// Determine selected campaigns
		$clientids = array();
		$what_array = explode(",",$what);
		for ($k=0; $k < count($what_array); $k++)
		{
			if (substr($what_array[$k],0,9)=="clientid:")
			{
				$clientid = substr($what_array[$k],9);
				$clientids[] = 'clientid = '.$clientid;
			}
		}
		
		// Determine banners owned by selected campaigns
		if (count($clientids))
		{
			$res = phpAds_dbQuery("
				SELECT
					bannerid
				FROM
					".$phpAds_config['tbl_banners']."
				WHERE
					".implode (' OR ', $clientids)."
			");
			
			while ($row = phpAds_dbFetchArray($res))
				$bannerids[$row['bannerid']] = true;
		}
		else
			$bannerids = array();
	}
	else
	{
		$bannerids = array();
	}
	
	// Fetch all campaigns
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent > 0
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$campaigns[$row['clientid']] = $row;
	}
	
	
	// Fetch all banners which can be linked
	$query = "
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		";
	
	if ($delivery != phpAds_ZoneText)
	{
		if ($width != -1 && $height != -1)
			$query .= "WHERE width = $width AND height = $height AND contenttype != 'txt'";
		elseif ($width != -1)
			$query .= "WHERE width = $width AND contenttype != 'txt'";
		elseif ($height != -1)
			$query .= "WHERE height = $height AND contenttype != 'txt'";
		else
			$query .= "WHERE contenttype != 'txt'";
	}
	else
	{
		$query .= "WHERE contenttype = 'txt'";
	}
	
	$query .= "
		ORDER BY
			bannerid";
	
	$res = phpAds_dbQuery($query);
	$compact = (phpAds_dbNumRows($res) > $phpAds_config['gui_link_compact_limit']);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$campaigns[$row['clientid']]['banners'][$row['bannerid']] = $row;
	}
	
	
	
	
	if (!$compact)
	{
		echo "<form name='zonetypeselection' method='post' action='zone-include.php'>";
		echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
		echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
		echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneBanners."'>";
		echo "<input type='hidden' name='action' value='set'>";
	}
	else
	{
		echo "<br>".$strSelectBannerToLink."<br><br>";
		echo "<table cellpadding='0' cellspacing='0' border='0'><tr>";
		
		echo "<form name='zonetypeselection' method='get' action='zone-include.php'>";
		echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
		echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
		echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneBanners."'>";
		
		echo "<td><img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
		echo "<select name='clientid' onChange='this.form.submit();'>";
		
		if (!isset($GLOBALS['clientid']) || $GLOBALS['clientid'] == '')
			echo "<option value='' selected></option>";
		
		// Fetch all campaigns
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = 0
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			if (isset($GLOBALS['clientid']) && $GLOBALS['clientid'] == $row['clientid'])
				echo "<option value='".$row['clientid']."' selected>[id".$row['clientid']."] ".$row['clientname']."</option>";
			else
				echo "<option value='".$row['clientid']."'>[id".$row['clientid']."] ".$row['clientname']."</option>";
		}
		
		echo "</select>";
		echo "</td></form>";
		
		if (isset($GLOBALS['clientid']) && $GLOBALS['clientid'] != '')
		{
			echo "<form name='zonetypeselection' method='get' action='zone-include.php'>";
			echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
			echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
			echo "<input type='hidden' name='clientid' value='".$GLOBALS['clientid']."'>";
			echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneBanners."'>";
			echo "<td>&nbsp;&nbsp;<img src='images/caret-r.gif' align='absmiddle'>&nbsp;&nbsp;";
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
			echo "<select name='campaignid' onChange='this.form.submit();'>";
			
			if (!isset($GLOBALS['campaignid']) || $GLOBALS['campaignid'] == '')
				echo "<option value='' selected></option>";
			
			// Fetch all campaigns
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_clients']."
				WHERE
					parent = ".$GLOBALS['clientid']."
			") or phpAds_sqlDie();
			
			while ($row = phpAds_dbFetchArray($res))
			{
				if (isset($GLOBALS['campaignid']) && $GLOBALS['campaignid'] == $row['clientid'])
					echo "<option value='".$row['clientid']."' selected>[id".$row['clientid']."] ".$row['clientname']."</option>";
				else
					echo "<option value='".$row['clientid']."'>[id".$row['clientid']."] ".$row['clientname']."</option>";
			}
			
			echo "</select>";
			echo "</td></form>";
			
			if (isset($GLOBALS['campaignid']) && $GLOBALS['campaignid'] != '')
			{
				echo "<form name='zonetypeselection' method='get' action='zone-include.php'>";
				echo "<input type='hidden' name='zoneid' value='".$GLOBALS['zoneid']."'>";
				echo "<input type='hidden' name='affiliateid' value='".$GLOBALS['affiliateid']."'>";
				echo "<input type='hidden' name='clientid' value='".$GLOBALS['clientid']."'>";
				echo "<input type='hidden' name='campaignid' value='".$GLOBALS['campaignid']."'>";
				echo "<input type='hidden' name='zonetype' value='".phpAds_ZoneBanners."'>";
				echo "<input type='hidden' name='action' value='toggle'>";
				echo "<td>&nbsp;&nbsp;<img src='images/caret-r.gif' align='absmiddle'>&nbsp;&nbsp;";
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
				echo "<select name='bannerid'>";
				
				// Fetch all banners which can be linked
				$query = "
					SELECT
						bannerid,
						clientid,
						alt,
						description,
						active,
						storagetype
					FROM
						".$phpAds_config['tbl_banners']."
					WHERE
						clientid = ".$GLOBALS['campaignid']."
				";
				
				if ($delivery != phpAds_ZoneText)
				{
					if ($width != -1 && $height != -1)
						$query .= "AND width = $width AND height = $height";
					elseif ($width != -1)
						$query .= "AND width = $width";
					elseif ($height != -1)
						$query .= "AND height = $height";
				}
				else
				{
					$query .= "WHERE contenttype = 'txt'";
				}
				
				$query .= "
					ORDER BY
						bannerid";
				
				$res = phpAds_dbQuery($query);
				
				while ($row = phpAds_dbFetchArray($res))
				{
					if (!isset($bannerids[$row['bannerid']]) || $bannerids[$row['bannerid']] != true)
					{
						$name = $strUntitled;
						if (isset($row['alt']) && $row['alt'] != '') $name = $row['alt'];
						if (isset($row['description']) && $row['description'] != '') $name = $row['description'];
						
						echo "<option value='".$row['bannerid']."'>[id".$row['bannerid']."] ".$name."</option>";
					}
				}
				
				echo "</select>";
				echo "&nbsp;<input type='image' src='images/".$GLOBALS['phpAds_TextDirection']."/go_blue.gif' border='0'>";
				echo "</td></form>";
			}
		}
		
		echo "</tr></table>";
		echo "<br><br>";
	}
	
	// Header
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
	echo "<tr height='25'>";
	echo "<td height='25' width='40%'><b>&nbsp;&nbsp;$strName</b></td>";
	echo "<td height='25'><b>$strID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$i = 0;
	$checkedall = true;
	
	if (!$compact && phpAds_dbNumRows($res) == 0)
	{
		echo "<tr bgcolor='#F6F6F6'><td colspan='3' height='25'>&nbsp;&nbsp;".$strNoBannersToLink."</td></tr>";
	}
	else
	{
		for (reset($campaigns); $ckey = key($campaigns); next($campaigns))
		{
			$campaign = $campaigns[$ckey];
			
			if (isset($campaign['banners']) && is_array($campaign['banners']) && count($campaign['banners']))
			{
				$banners = $campaign['banners'];
				
				$activebanners = 0;
				for (reset($banners); $bkey = key($banners); next($banners))
				{
					$banner = $banners[$bkey];
					
					$linkedrow = (isset($bannerids[$banner['bannerid']]) && $bannerids[$banner['bannerid']] == true);
					
					if ($compact)
						$showrow = $linkedrow;
					else
						$showrow = ($hideinactive == false || $hideinactive == true && ($banner['active'] == 't' && $campaign['active'] == 't' || $linkedrow));
					
					if ($showrow) $activebanners++;
				}
				
				
				if ($showcampaigns && $activebanners)
				{
					if ($i > 0) echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
					echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
					
					// Begin row
					echo "<td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					if (!$compact) echo "&nbsp;&nbsp;";
					
					// Banner icon
					if ($campaign['active'] == 't')
						echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
					else
						echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
					
					
					// Name
					if (phpAds_isUser(phpAds_Admin))
					{
						echo "<a href='campaign-edit.php?clientid=".$campaign['parent']."&campaignid=".$campaign['clientid']."'>";
						echo phpAds_breakString ($campaign['clientname'], '60')."</a>";
					}
					else
						echo phpAds_breakString ($campaign['clientname'], '60');
					
					echo "</td>";
					
					
					// ID
					echo "<td height='25'>".$campaign['clientid']."</td>";
					echo "<td>&nbsp;</td></tr>";
				}
				
				for (reset($banners); $bkey = key($banners); next($banners))
				{
					$banner = $banners[$bkey];
					
					$linkedrow = (isset($bannerids[$banner['bannerid']]) && $bannerids[$banner['bannerid']] == true);
					
					if ($compact)
						$showrow = $linkedrow;
					else
						$showrow = ($hideinactive == false || $hideinactive == true && ($banner['active'] == 't' && $campaign['active'] == 't' || $linkedrow));
					
					if (!$compact && !$showrow) $inactivehidden++;
					
					if ($showrow)
					{
						$name = $strUntitled;
						if (isset($banner['alt']) && $banner['alt'] != '') $name = $banner['alt'];
						if (isset($banner['description']) && $banner['description'] != '') $name = $banner['description'];
						
						$name = phpAds_breakString ($name, '60');
						
						
						if (!$showcampaigns)
						{
							if ($i > 0) echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
						}
						else
						{
							echo "<tr height='1'>";
							echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
							echo "<td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td>";
							echo "</tr>";
						}
						
						
						echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
						
						// Begin row
						echo "<td height='25'>";
						echo "&nbsp;&nbsp;";
						
						// Show checkbox
						if (!$compact)
						{
							if (isset($bannerids[$banner['bannerid']]) && $bannerids[$banner['bannerid']] == true)
								echo "<input type='checkbox' name='bannerid[]' value='".$banner['bannerid']."' checked onclick='reviewall();'>"; 
							else
							{
								echo "<input type='checkbox' name='bannerid[]' value='".$banner['bannerid']."' onclick='reviewall();'>"; 
								$checkedall = false;
							}
						}
						else
						{
							echo "<a href='zone-include.php?affiliateid=".$GLOBALS['affiliateid']."&zoneid=".$GLOBALS['zoneid']."&bannerid=".$banner['bannerid']."&zonetype=".phpAds_ZoneBanners."&action=toggle'>";
							echo "<img src='images/caret-l.gif' border='0' align='absmiddle'></a>";
						}
						
						// Space
						echo "&nbsp;&nbsp;";
						if ($showcampaigns) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						
						// Banner icon
						if ($campaign['active'] == 't' && $banner['active'] == 't')
						{
							if ($banner['storagetype'] == 'html')
								echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'url')
								echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'txt')
								echo "<img src='images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
							else
								echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
						}
						else
						{
							if ($banner['storagetype'] == 'html')
								echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'url')
								echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>&nbsp;";
							elseif ($banner['storagetype'] == 'txt')
								echo "<img src='images/icon-banner-text-d.gif' align='absmiddle'>&nbsp;";
							else
								echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>&nbsp;";
						}
						
						// Name
						if (phpAds_isUser(phpAds_Admin))
						{
							echo "<a href='banner-edit.php?clientid=".$campaign['parent']."&campaignid=".$campaign['clientid']."&bannerid=".$banner['bannerid']."'>";
							echo $name."</a></td>";
						}
						else
							echo $name;
						
						// ID
						echo "<td height='25'>".$banner['bannerid']."</td>";
						
						// Show banner
						if ($banner['contenttype'] == 'txt')
						{
							$width	= 300;
							$height = 200;
						}
						else
						{
							$width  = $banner['width'] + 64;
							$height = $banner['bannertext'] ? $banner['height'] + 90 : $banner['height'] + 64;
						}
						
						echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
						echo "<a href='banner-htmlpreview.php?bannerid=$bannerid' target='_new' ";
						echo "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$banner['bannerid']."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
						echo "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strShowBanner."</a>&nbsp;&nbsp;";
						echo "</td>";
						
						// End row
						echo "</tr>";
						
						
						if (!$showcampaigns) $i++;
					}
				}
				
				if ($showcampaigns && $activebanners) $i++;
			}
		}
	}
	
	if (!$compact)
	{
		echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
		echo "&nbsp;&nbsp;<input type='checkbox' name='checkall' value=''".($checkedall == true ? ' checked' : '')." onclick='toggleall();'>";
		echo "&nbsp;&nbsp;<b>".$strCheckAllNone."</b>";
		echo "</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
	}
	
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='25' align='".$phpAds_TextAlignLeft."' nowrap>";
	
	if (!$compact)
	{
		if ($hideinactive == true)
		{
			echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
			echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&hideinactive=0'>".$strShowAll."</a>";
			echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$inactivehidden." ".$strInactiveBannersHidden;
		}
		else
		{
			echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
			echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&hideinactive=1'>".$strHideInactiveBanners."</a>";
		}
	}
	
	echo "</td><td colspan='2' align='".$phpAds_TextAlignRight."' nowrap>";
	
	if ($showcampaigns == true)
	{
		echo "&nbsp;&nbsp;<img src='images/icon-campaign-d.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&showcampaigns=0'>".$strHideParentCampaigns."</a>";
	}
	else
	{
		echo "&nbsp;&nbsp;<img src='images/icon-campaign.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&showcampaigns=1'>".$strShowParentCampaigns."</a>";
	}
	
	echo "&nbsp;&nbsp;</td></tr>";
	
	
	echo "</table>";
	
	echo "<br><br>";
	echo "<br><br>";
	
	if (!$compact)
	{
		echo "<input type='submit' name='submit' value='$strSaveChanges'>";
		echo "</form>";
	}
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
			if (document.zonetypeselection.elements[i].name == 'bannerid[]' ||
				document.zonetypeselection.elements[i].name == 'clientid[]')
			{
				if (document.zonetypeselection.elements[i].checked == false)
				{
					allchecked = true;
				}
			}
		}
		
		for (var i=0; i<document.zonetypeselection.elements.length; i++)
		{
			if (document.zonetypeselection.elements[i].name == 'bannerid[]' ||
				document.zonetypeselection.elements[i].name == 'clientid[]')
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
			if (document.zonetypeselection.elements[i].name == 'bannerid[]' ||
				document.zonetypeselection.elements[i].name == 'clientid[]')
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



echo "<form name='zonetypes' method='post' action='zone-include.php'>";
echo "<input type='hidden' name='zoneid' value='".$zoneid."'>";
echo "<input type='hidden' name='affiliateid' value='".$affiliateid."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strSelectZoneType."</b></td></tr>";
echo "<tr><td height='25'>";

echo "<select name='zonetype' onChange='this.form.submit();'>";
	echo "<option value='".phpAds_ZoneCampaign."'".(($zonetype == phpAds_ZoneCampaign) ? " selected" : "").">".$strCampaignSelection."</option>";
	echo "<option value='".phpAds_ZoneBanners."'".(($zonetype == phpAds_ZoneBanners) ? " selected" : "").">".$strBannerSelection."</option>";
	echo "<option value='".phpAds_ZoneRaw."'".(($zonetype == phpAds_ZoneRaw) ? " selected" : "").">".$strRawQueryString."</option>";
echo "</select>";
echo "&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'>";

echo "</td></tr>";
echo "</table>";
phpAds_ShowBreak();
echo "</form>";
echo "<br>";



if ($zonetype == phpAds_ZoneCampaign)
{
	phpAds_showZoneCampaign($zone["width"], $zone["height"], $zone["what"], $zone['delivery']);
}

if ($zonetype == phpAds_ZoneBanners)
{
	phpAds_showZoneBanners($zone["width"], $zone["height"], $zone["what"], $zone["zonetype"], $zone['delivery']);
}

if ($zonetype == phpAds_ZoneRaw)
{
	echo "<form name='zonetypeselection' method='post' action='zone-include.php'>";
	echo "<input type='hidden' name='zoneid' value='".$zoneid."'>";
	echo "<input type='hidden' name='affiliateid' value='".$affiliateid."'>";
	echo "<input type='hidden' name='zonetype' value='$zonetype'>";
	echo "<input type='hidden' name='action' value='set'>";
	
	echo "<textarea cols='50' rows='16' name='what' style='width:600px;'>".(isset($zone['what']) ? $zone['what'] : '')."</textarea>";
	
	echo "<br><br>";
	echo "<br><br>";
	
	echo "<input type='submit' name='submit' value='$strSaveChanges'>";
	echo "</form>";
}



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['zone-include.php']['hideinactive'] = $hideinactive;
$Session['prefs']['zone-include.php']['showbanners'] = $showbanners;
$Session['prefs']['zone-include.php']['showcampaigns'] = $showcampaigns;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>