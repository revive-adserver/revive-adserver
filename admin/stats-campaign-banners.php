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
require ("lib-expiration.inc.php");
require ("lib-gd.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($compact))
{
	if (isset($Session['prefs']['stats-campaign-banners.php']['compact']))
		$compact = $Session['prefs']['stats-campaign-banners.php']['compact'];
	else
		$compact = 't';
}

if (!isset($view))
{
	if (isset($Session['prefs']['stats-campaign-banners.php']['view']))
		$view = $Session['prefs']['stats-campaign-banners.php']['view'];
	else
		$view = 'all';
}

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-campaign-banners.php']['listorder']))
		$listorder = $Session['prefs']['stats-campaign-banners.php']['listorder'];
	else
		$listorder = 'name';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-campaign-banners.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-campaign-banners.php']['orderdirection'];
	else
		$orderdirection = '';
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_getUserID() == phpAds_getParentID ($campaignid))
	{
		$extra = '';
		
		$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = ".phpAds_getUserID()."
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($campaignid == $row['clientid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=stats-campaign-banners.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("1.1.1", $extra);
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
			phpAds_ShowSections(array("1.1.1", "1.1.2"));
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);	
	}
}

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
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
		if ($campaignid == $row['clientid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=stats-campaign-banners.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBannerOverview</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.2", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.2", "2.1.3"));
}



/*********************************************************/
/* Define sections                                       */
/*********************************************************/

// Define defaults
$i = 0;



/*********************************************************/
/* Get statistics                                        */
/*********************************************************/

$banners = array();
$order_array = array();

if ($phpAds_config['compact_stats'])
{
	$query = "
		SELECT
			".$phpAds_config['tbl_banners'].".bannerid,
			".$phpAds_config['tbl_banners'].".description,
			".$phpAds_config['tbl_banners'].".alt,
			SUM(".$phpAds_config['tbl_adstats'].".views) AS adviews,
			SUM(".$phpAds_config['tbl_adstats'].".clicks) AS adclicks
		FROM
			".$phpAds_config['tbl_banners']." LEFT JOIN 
			".$phpAds_config['tbl_adstats']." USING (bannerid)
		WHERE
			".$phpAds_config['tbl_banners'].".clientid = $campaignid
		GROUP BY
			".$phpAds_config['tbl_banners'].".bannerid
		";
	
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$banners[$row['bannerid']]['id'] = $row['bannerid'];
		$banners[$row['bannerid']]['name'] = phpAds_buildBannerName ('', $row['description'], $row['alt']);
		$banners[$row['bannerid']]['adviews'] = $row['adviews'];
		$banners[$row['bannerid']]['adclicks'] = $row['adclicks'];
	}
}
else
{
	$query = "
		SELECT
			".$phpAds_config['tbl_banners'].".bannerid,
			".$phpAds_config['tbl_banners'].".description,
			".$phpAds_config['tbl_banners'].".alt,
			COUNT(".$phpAds_config['tbl_adviews'].".bannerid) AS adviews
		FROM
			".$phpAds_config['tbl_banners']." LEFT JOIN
			".$phpAds_config['tbl_adviews']." USING (bannerid)
		WHERE
			".$phpAds_config['tbl_banners'].".clientid = $campaignid
		GROUP BY
			".$phpAds_config['tbl_banners'].".bannerid
		";
	
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$banners[$row['bannerid']]['id'] = $row['bannerid'];
		$banners[$row['bannerid']]['name'] = phpAds_buildBannerName ('', $row['description'], $row['alt']);
		$banners[$row['bannerid']]['adviews'] = $row['adviews'];
	}
	
	$query = "
		SELECT
			".$phpAds_config['tbl_banners'].".bannerid,
			COUNT(".$phpAds_config['tbl_adclicks'].".bannerid) AS adclicks
		FROM
			".$phpAds_config['tbl_banners']." LEFT JOIN 
			".$phpAds_config['tbl_adclicks']." USING (bannerid)
		WHERE
			".$phpAds_config['tbl_banners'].".clientid = $campaignid
		GROUP BY
			".$phpAds_config['tbl_banners'].".bannerid
		";
	
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if (isset($banners[$row['bannerid']]))
			$banners[$row['bannerid']]['adclicks'] = $row['adclicks'];
	}
}

if (count($banners))
{
	// Calculate CTR
	for (reset($banners); $key = key($banners); next($banners))
		$banners[$key]['ctr'] = phpAds_buildCTR ($banners[$key]['adviews'], $banners[$key]['adclicks']);
	
	// Build order array
	for (reset($banners); $key = key($banners); next($banners))
	{
		$order_array[$key] = $banners[$key][$listorder];
	}
	
	// Sort order array
	if ($listorder == 'name')
	{
		if ($orderdirection == 'down')
			asort ($order_array, SORT_STRING);
		else
			arsort ($order_array, SORT_STRING);
	}
	else
	{
		if ($orderdirection == 'down')
			asort ($order_array, SORT_NUMERIC);
		else
			arsort ($order_array, SORT_NUMERIC);
	}
}



/*********************************************************/
/* Custom JavaScript code                                */
/*********************************************************/

?><script language="JavaScript">
<!--
function findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function showHideLayers(obj) { 
	bannerobj = findObj('banner'+obj);
	caretobj = findObj('caret'+obj);

	if (bannerobj.style)
	{
		if (bannerobj.style.display=='none')
		{
			bannerobj.style.display='';
			if (caretobj) caretobj.src = 'images/triangle-d.gif'
		}
		else
		{
			bannerobj.style.display='none';
			if (caretobj) caretobj.src = 'images/<?php echo $phpAds_TextDirection; ?>/triangle-l.gif'
		}	
	}
}
//-->
</script><?php



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";

$totaladviews = 0;
$totaladclicks = 0;

if (count($order_array) > 0)
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	if (isset($compact) && $compact == "t")
	{
		// Legend
		echo "<tr bgcolor='#FFFFFF' height='25'>";
		echo "<td>&nbsp;</td>";
		
		echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b><a href='stats-campaign-banners.php?campaignid=".$campaignid."&listorder=name'>".$strName."</a>";
		
		if (($listorder == "name") || ($listorder == ""))
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=up">';
				echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
			}
			else
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=down">';
				echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		
		echo "</b></td>";
		echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b><a href='stats-campaign-banners.php?campaignid=".$campaignid."&listorder=id'>".$strID."</a>";
		
		if ($listorder == "id")
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=up">';
				echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
			}
			else
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=down">';
				echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		
		echo "</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b><a href='stats-campaign-banners.php?campaignid=".$campaignid."&listorder=adviews'>".$strViews."</a>";
		
		if ($listorder == "adviews")
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=up">';
				echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
			}
			else
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=down">';
				echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		
		echo "</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b><a href='stats-campaign-banners.php?campaignid=".$campaignid."&listorder=adclicks'>".$strClicks."</a>";
		
		if ($listorder == "adclicks")
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=up">';
				echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
			}
			else
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=down">';
				echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		
		echo "</b></td>";
		echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b><a href='stats-campaign-banners.php?campaignid=".$campaignid."&listorder=ctr'>".$strCTRShort."</a>";
		
		if ($listorder == "ctr")
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=up">';
				echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
			}
			else
			{
				echo ' <a href="stats-campaign-banners.php?campaignid='.$campaignid.'&orderdirection=down">';
				echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		
		echo "</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
	}
	
	$where = "";
	
	
	reset ($order_array);
	while (list ($bannerid,) = each ($order_array)) 
	{
	    $adviews  = $banners[$bannerid]['adviews'];
	    $adclicks = $banners[$bannerid]['adclicks'];
		
		if ($adclicks != 0 && $view == 'adclicks') continue;	// Don't show banners without adclicks
		if ($adviews != 0 && $view == 'adviews') continue;	// Don't show banners without adclicks
		
		
		$totaladviews += $adviews;
		$totaladclicks += $adclicks;
			
		$res_query = "
			SELECT
				bannerid,
				width,
				height,
				active,
				alt,
				description,
				bannertext,
				storagetype
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = $bannerid
			";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		$row_banners = phpAds_dbFetchArray($res_banners);
		
		$where .= " bannerid = ".$row_banners['bannerid']." OR";
		
		if (isset($compact) && $compact != "t")
		{
			// Background color
			$i % 2 ? $bgcolor="#F6F6F6": $bgcolor= "#F6F6F6";
			$i++;
			
			// Divider
			echo "<tr>";
			echo "<td height='25' colspan='4' align='".$phpAds_TextAlignLeft."'>";
			
			if ($row_banners['active'] == 't')
			{
				if ($row_banners['storagetype'] == 'html')
				{
					echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
				}
				elseif ($row_banners['storagetype'] == 'url')
				{
					echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
				}
				else
				{
					echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
				}
			}
			else
			{
				if ($row_banners['storagetype'] == 'html')
				{
					echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
				}
				elseif ($row_banners['storagetype'] == 'url')
				{
					echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
				}
				else
				{
					echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
				}
			}
			
			echo "&nbsp;<b>".phpAds_buildBannerName ($row_banners['bannerid'], $row_banners['description'], $row_banners['alt'])."</b>";
			
			echo "</td></tr>";
			
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			
			// Banner
			echo "<tr><td height='10' colspan='4' bgcolor='$bgcolor'>&nbsp;</td></tr>";
			echo "<tr bgcolor='$bgcolor'>";
			echo "<td height='25' align='".$phpAds_TextAlignLeft."' nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		   	echo "<td colspan='3' align='".$phpAds_TextAlignLeft."'>";
			echo phpAds_buildBannerCode ($row_banners['bannerid']);
			echo "</td></tr>";
			echo "<tr><td height='10' colspan='4' bgcolor='$bgcolor'>&nbsp;</td></tr>";
		  	
			
		    if ($adclicks > 0 || $adviews > 0)
		    {
				// Stats
				echo "<tr bgcolor='$bgcolor'>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>&nbsp;</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>$strViews: <b>$adviews</b></td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>$strClicks: <b>$adclicks</b></td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>$strCTR: <b>".phpAds_buildCTR($adviews, $adclicks)."<b></td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr bgcolor='$bgcolor'>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>&nbsp;</td>";
				echo "<td height='25' bgcolor='$bgcolor' colspan='3'>$strBannerNoStats</td>";
				echo "</tr>";
			}
			
			
			// Divider
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			
			// Buttons
			echo "<tr><td colspan='4' height='25' align='".$phpAds_TextAlignRight."'>";
			
			if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_DisableBanner) && $row_banners['active'] == 't') // only for the client if allowed
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-deactivate.gif' align='absmiddle'>&nbsp;";
				echo "<a href='banner-activate.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."&value=t'>$strDeActivate</a>";
			}
			if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ActivateBanner) && $row_banners['active'] != 't') // only for the client if allowed
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-activate.gif' align='absmiddle'>&nbsp;";
				echo "<a href='banner-activate.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."&value=f'>$strActivate</a>";
			}
			if ($adclicks > 0 || $adviews > 0)
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-zoom.gif' align='absmiddle'>&nbsp;";
				echo "<a href='stats-banner-history.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>$strBannerHistory</a>";
				
				if (phpAds_isUser(phpAds_Admin)) // only for the admin
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle'>&nbsp;";
					echo "<a href='stats-reset.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'".phpAds_DelConfirm($strConfirmResetBannerStats).">$strResetStats</a>";
				}
			}
			if (phpAds_isUser(phpAds_Admin) || (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyBanner))) // only for the admin
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;";
				echo "<a href='banner-edit.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>$strModifyBanner</a>";
			}
			echo "</td></tr>";
			
			echo "<tr><td height='35' colspan='4' bgcolor='#FFFFFF'>&nbsp;</td></tr>";
		}
		else
		{
			// Background color
			$i % 2 ? $bgcolor="#FFFFFF": $bgcolor= "#F6F6F6";
			$i++;
			
			
			echo "<tr><td height='1' colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			echo "<tr bgcolor='$bgcolor'>";
			
			echo "<td height='25' width='30' align='".$phpAds_TextAlignLeft."'>&nbsp;";
			if (ereg ("Mozilla/6", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
				echo "<img name='caret".$row_banners['bannerid']."' src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' onClick=\"showHideLayers('".$row_banners['bannerid']."');\">";
			echo "</td>";
			
			
			echo "<td height='25' align='".$phpAds_TextAlignLeft."' nowrap>";
			
			
			if ($row_banners['active'] == 't')
			{
				if ($row_banners['storagetype'] == 'html')
				{
					echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
				}
				elseif ($row_banners['storagetype'] == 'url')
				{
					echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
				}
				else
				{
					echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
				}
			}
			else
			{
				if ($row_banners['storagetype'] == 'html')
				{
					echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
				}
				elseif ($row_banners['storagetype'] == 'url')
				{
					echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
				}
				else
				{
					echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
				}
			}
			
			echo "&nbsp;";
			echo "<a height='25' href='stats-banner-history.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>";
			
			if ($row_banners['description'] != '')	$name = $row_banners['description'];
			elseif ($row_banners['alt'] != '')		$name = $row_banners['alt'];
			else									$name = $strUntitled;
			
			echo phpAds_breakString ($name, '30');
			
			echo "</a>";
			echo "</td>";
			
			echo "<td height='25' align='".$phpAds_TextAlignLeft."' nowrap>".$row_banners['bannerid']."</td>";
			
		    if ($adclicks > 0 || $adviews > 0)
		    {
				// Stats
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>".$adviews."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>".$adclicks."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>".phpAds_buildCTR($adviews, $adclicks)."&nbsp;&nbsp;</td>";
			}
			else
			{
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>-</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>-</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."' nowrap>-&nbsp;&nbsp;</td>";
			}
			
			echo "</tr>";
			
			echo "<tr bgcolor='$bgcolor'>";
			echo "<td height='1' width='30'><img src='images/spacer.gif' width='1' height='1'></td>";
			echo "<td colspan='5'>";
			
			if (ereg ("Mozilla/6", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
			{
				echo "<div id='banner".$row_banners['bannerid']."' style='display: none;'>";
				
				echo "<table width='100%' cellpadding=0 cellspacing=0 border=0><tr><td align='".$phpAds_TextAlignLeft."'>";
				echo "<tr><td height='1'><img src='images/break-l.gif' height='1' width='100%' vspace='0'></tr><td>";
				echo "<tr><td height='10'>&nbsp;</tr><td>";
				echo "<tr><td>";
					echo phpAds_buildBannerCode ($row_banners['bannerid']);
				echo "</tr><td>";
				echo "<tr><td height='10'>&nbsp;</tr><td>";
				echo "<tr><td height='1'><img src='images/break-l.gif' height='1' width='100%' vspace='0'></tr><td>";
				echo "<tr><td height='25'>";
				
			    if ($adclicks > 0 || $adviews > 0)
				{
					echo "<a href='stats-banner-history.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>";
					echo "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;$strBannerHistory</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if (phpAds_isUser(phpAds_Admin)) // only for the admin
					{
						echo "<a href='stats-reset.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'".phpAds_DelConfirm($strConfirmResetBannerStats).">";
						echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle' border='0'>&nbsp;$strResetStats</a>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				}
				
				if (phpAds_isUser(phpAds_Admin) || (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyBanner))) // only for the admin
				{
					echo "<a href='banner-edit.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>";
					echo "<img src='images/icon-edit.gif' align='absmiddle' border='0'>&nbsp;$strModifyBanner</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				echo "</tr><td>";
				echo "</table>";
				
				echo "</div>";
			}
			
			echo "</td></tr>";
		}
	}
	
	
	echo "<tr><td height='1' colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	echo "<tr>";
	echo "<form action='stats-campaign-banners.php'>";
	echo "<td colspan='6' height='35' align='right'>";
	echo "<input type='hidden' name='campaignid' value='$campaignid'>";
	echo "<select name='view' onChange='this.form.submit();'>";
		echo "<option value='all'".($view=='all' ? " selected" : "").">$strShowAllBanners</option>";
		echo "<option value='adclicks'".($view=='adclicks' ? " selected" : "").">$strShowBannersNoAdClicks</option>";
		echo "<option value='adviews'".($view=='adviews' ? " selected" : "").">$strShowBannersNoAdViews</option>";
	echo "</select>";
	echo "&nbsp;";
	echo "<select name='compact' onChange='this.form.submit();'>";
		echo "<option value='f'".($compact!='t' ? " selected" : "").">$strVerbose</option>";
		echo "<option value='t'".($compact=='t' ? " selected" : "").">$strCompact</option>";
	echo "</select>";
	echo "&nbsp;";
	echo "<input type='image' border='0' name='submit' src='images/".$phpAds_TextDirection."/go_blue.gif'>";
	echo "</td>";
	echo "</form>";
	echo "</tr>";
	
	
	echo "</table>";
	echo "<br><br>";
	echo "<br><br>";
}




?>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='2'><b><?php echo $strCreditStats;?></b></td></tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

<?php
if (phpAds_GDImageFormat() != "none" && $totaladviews > 0 && !$phpAds_config['compact_stats'])
{
?>
	<tr><td height='20' colspan='2'>&nbsp;</td></tr>	
	<tr>
		<td bgcolor="#FFFFFF" colspan=2><img src="graph-hourly.php?where=<?php $where = ereg_replace("OR$", "", $where); echo urlencode("$where");?>" border="0" width="385" height="150"></td>
	</tr>
	<tr><td height='10' colspan='2'>&nbsp;</td></tr>	
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
<?php
}
?>

<?php
list($desc,$enddate,$daysleft)=days_left($campaignid);
$adclicksleft = adclicks_left($campaignid);
$adviewsleft  = adviews_left($campaignid);
?>
	<tr>
		<td height='25'><?php echo $strTotalViews;?>: <b><?php echo $totaladviews;?></b></td>
		<td height='25'><?php echo $strViewCredits;?>: <b><?php echo $adviewsleft;?></b></td>
	</tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='25'><?php echo $strTotalClicks;?>: <b><?php echo $totaladclicks;?></b></td>
		<td height='25'><?php echo $strClickCredits;?>: <b><?php echo $adclicksleft;?></b></td>
	</tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='25' colspan='2'><?php echo $desc; ?></td>
	</tr>
	<?php
		if ($adviewsleft != $strUnlimited || $adclicksleft != $strUnlimited) {
	?>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr>
		<td height='60' align='left'>
		<?php
		if ($adviewsleft == $strUnlimited)
			print "&nbsp;";
		else
			print "<img src='graph-daily.php?width=200&data=Views^$totaladviews^^Credits^$adviewsleft^^'></td>\n";
		print "<td height='60'>";
		if ($adclicksleft == $strUnlimited)
			print "&nbsp;";
		else
			print "<img src='graph-daily.php?width=200&data=Clicks^$totaladclicks^^Credits^$adclicksleft^^'></td>\n";
		?>
	</tr>
	<?php
		}
	?>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
<?php



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['stats-campaign-banners.php']['compact'] = $compact;
$Session['prefs']['stats-campaign-banners.php']['view'] = $view;
$Session['prefs']['stats-campaign-banners.php']['listorder'] = $listorder;
$Session['prefs']['stats-campaign-banners.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>