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
/* HTML framework                                        */
/*********************************************************/

if (!isset($order))   $order = '';
if (!isset($compact)) $compact = '';
if (!isset($view))	  $view = '';


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
			parent = ".$Session["clientid"]."
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($campaignid == $row['clientid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href=stats-campaign.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("1.1.1", $extra);
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
			phpAds_ShowSections(array("1.1.1", "1.1.2", "1.1.3"));
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
		
		$extra .= "<a href=stats-campaign.php?campaignid=".$row['clientid'].">".phpAds_buildClientName ($row['clientid'], $row['clientname'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strModifyCampaign</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBanners</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.2", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.2", "2.1.3", "2.1.4"));
}



/*********************************************************/
/* Define sections                                       */
/*********************************************************/

// Define defaults
$i = 0;



/*********************************************************/
/* Get statistics                                        */
/*********************************************************/

$tmp_views = array();
$tmp_clicks = array();
$tmp_alt = array();
$tmp_crt = array();

if ($phpAds_config['compact_stats'])
{
	$res_query = "
		SELECT
			".$phpAds_config['tbl_banners'].".bannerid as bannerid,
			IF (".$phpAds_config['tbl_banners'].".description='', ".$phpAds_config['tbl_banners'].".description, ".$phpAds_config['tbl_banners'].".alt) as alt,
			sum(".$phpAds_config['tbl_adstats'].".views) as adviews,
			sum(".$phpAds_config['tbl_adstats'].".clicks) as adclicks
		FROM
			".$phpAds_config['tbl_banners']."
			LEFT JOIN ".$phpAds_config['tbl_adstats']." USING (bannerid)
		WHERE
			".$phpAds_config['tbl_banners'].".clientid = $campaignid
		GROUP BY
			".$phpAds_config['tbl_banners'].".bannerid
		";
	
	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
	
	while ($row_banners = phpAds_dbFetchArray($res_banners))
	{
		$tmp_views[$row_banners['bannerid']] = $row_banners['adviews'];
		$tmp_clicks[$row_banners['bannerid']] = $row_banners['adclicks'];
		$tmp_alt[$row_banners['bannerid']] = strtolower($row_banners['alt']);
		$tmp_ctr[$row_banners['bannerid']] = 0;
	}
}
else
{
	$res_query = "
		SELECT
			".$phpAds_config['tbl_banners'].".bannerid as bannerid,
			IF (".$phpAds_config['tbl_banners'].".description='', ".$phpAds_config['tbl_banners'].".description, ".$phpAds_config['tbl_banners'].".alt) as alt,
			count(".$phpAds_config['tbl_adviews'].".bannerid) as adviews
		FROM
			".$phpAds_config['tbl_banners']."
			LEFT JOIN ".$phpAds_config['tbl_adviews']." USING (bannerid)
		WHERE
			".$phpAds_config['tbl_banners'].".clientid = $campaignid
		GROUP BY
			".$phpAds_config['tbl_banners'].".bannerid
		";
	
	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
	
	while ($row_banners = phpAds_dbFetchArray($res_banners))
	{
		$tmp_views[$row_banners['bannerid']] = $row_banners['adviews'];
		$tmp_clicks[$row_banners['bannerid']] = 0;
		$tmp_alt[$row_banners['bannerid']] = strtolower($row_banners['alt']);
		$tmp_ctr[$row_banners['bannerid']] = 0;
	}
	
	$res_query = "
		SELECT
			".$phpAds_config['tbl_banners'].".bannerid as bannerid,
			count(".$phpAds_config['tbl_adclicks'].".bannerid) as adclicks
		FROM
			".$phpAds_config['tbl_banners']."
			LEFT JOIN ".$phpAds_config['tbl_adclicks']." USING (bannerid)
		WHERE
			".$phpAds_config['tbl_banners'].".clientid = $campaignid
		GROUP BY
			".$phpAds_config['tbl_banners'].".bannerid
		";
	
	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
	
	while ($row_banners = phpAds_dbFetchArray($res_banners))
	{
		$tmp_clicks[$row_banners['bannerid']] = $row_banners['adclicks'];
	}
}

if (count($tmp_clicks) > 0)
{
	reset ($tmp_clicks);
	while (list ($key,) = each ($tmp_clicks)) 
	{
		if ($tmp_clicks[$key] != 0 && $tmp_views[$key] != 0)
			$tmp_ctr[$key] = 100 * $tmp_clicks[$key] / $tmp_views[$key];
		else
			$tmp_ctr[$key] = 0;
	}
}


if ($order == "adviews")
{
	if (count($tmp_views) > 0) arsort ($tmp_views, SORT_NUMERIC);
	$tmp_order = $tmp_views;
}
elseif ($order == "adclicks")
{
	if (count($tmp_clicks) > 0) arsort ($tmp_clicks, SORT_NUMERIC);
	$tmp_order = $tmp_clicks;
}
elseif ($order == "ctr")
{
	if (count($tmp_ctr) > 0) arsort ($tmp_ctr, SORT_NUMERIC);
	$tmp_order = $tmp_ctr;
}
elseif ($order == "alt")
{
	if (count($tmp_alt) > 0) asort ($tmp_alt, SORT_STRING);
	$tmp_order = $tmp_alt;
}
else
{
	$tmp_order = $tmp_views;
	$order = "id";
}

if (!isset($order))
	$order = '';



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br><br>";
?>




<script language="JavaScript">
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
			if (caretobj) caretobj.src = 'images/triangle-l.gif'
		}	
	}
}
//-->
</script>


<?php

$totaladviews = 0;
$totaladclicks = 0;

if (count($tmp_order) > 0)
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	if (isset($compact) && $compact == "t")
	{
		// Legend
		echo "<tr bgcolor='#FFFFFF' height='25'>";
		echo "<td>&nbsp;</td>";
		
		if ($order == "alt")
			echo "<td align='left' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=alt&compact=$compact'><u>$strDescription</u></a></b></td>";
		else
			echo "<td align='left' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=alt&compact=$compact'>$strDescription</a></b></td>";
		
		if ($order == "id")
			echo "<td align='left' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=id&compact=$compact'><u>$strID</u></a></b></td>";
		else
			echo "<td align='left' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=id&compact=$compact'>$strID</a></b></td>";
		
		if ($order == "adviews")
			echo "<td align='right' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=adviews&compact=$compact'><u>$strViews</u></a></b></td>";
		else
			echo "<td align='right' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=adviews&compact=$compact'>$strViews</a></b></td>";
		
		if ($order == "adclicks")
			echo "<td align='right' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=adclicks&compact=$compact'><u>$strClicks</u></a></b></td>";
		else
			echo "<td align='right' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=adclicks&compact=$compact'>$strClicks</a></b></td>";
		
		if ($order == "ctr")
			echo "<td align='right' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=ctr&compact=$compact'><u>$strCTRShort</u></a></b>&nbsp;&nbsp;</td>";
		else
			echo "<td align='right' nowrap height='25'><b><a href='$PHP_SELF?campaignid=$campaignid&view=$view&order=ctr&compact=$compact'>$strCTRShort</a></b>&nbsp;&nbsp;</td>";
		
		echo "</tr>";
	}
	
	$where = "";
	
	
	reset ($tmp_order);
	while (list ($bannerid,) = each ($tmp_order)) 
	{
	    $adviews  = $tmp_views[$bannerid];
	    $adclicks = $tmp_clicks[$bannerid];
		
		if ($adclicks != 0 && $view == 'adclicks') continue;	// Don't show banners without adclicks
		if ($adviews != 0 && $view == 'adviews') continue;	// Don't show banners without adclicks
		
		
		$totaladviews += $adviews;
		$totaladclicks += $adclicks;
			
		$res_query = "
			SELECT
				banner,
				bannerid,
				width,
				height,
				format,
				active,
				alt,
				description,
				bannertext
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
			echo "<td height='25' colspan='4'>";
			
			if ($row_banners['active'] == 't')
			{
				if ($row_banners['format'] == 'html')
				{
					echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
				}
				elseif ($row_banners['format'] == 'url')
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
				if ($row_banners['format'] == 'html')
				{
					echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
				}
				elseif ($row_banners['format'] == 'url')
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
			echo "<td height='25' align='left' nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		   	echo "<td colspan='3' align='left'>";
			echo phpAds_buildBannerCode ($row_banners['bannerid'], $row_banners['banner'], $row_banners['active'], $row_banners['format'], $row_banners['width'], $row_banners['height'], $row_banners['bannertext']);
			echo "</td></tr>";
			echo "<tr><td height='10' colspan='4' bgcolor='$bgcolor'>&nbsp;</td></tr>";
		  	
			
		    if ($adclicks > 0 || $adviews > 0)
		    {
				// Stats
				echo "<tr bgcolor='$bgcolor'>";
				echo "<td height='25' align='left' nowrap>&nbsp;</td>";
				echo "<td height='25' align='left' nowrap>$strViews: <b>$adviews</b></td>";
				echo "<td height='25' align='left' nowrap>$strClicks: <b>$adclicks</b></td>";
				echo "<td height='25' align='left' nowrap>$strRatio: <b>".phpAds_buildCTR($adviews, $adclicks)."<b></td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr bgcolor='$bgcolor'>";
				echo "<td height='25' align='left' nowrap>&nbsp;</td>";
				echo "<td height='25' bgcolor='$bgcolor' colspan='3'>$strBannerNoStats</td>";
				echo "</tr>";
			}
			
			
			// Divider
			echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			
			
			// Buttons
			echo "<tr><td colspan='4' height='25' align='right'>";
			
			if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_DisableBanner) && $row_banners['active'] == 't') // only for the client if allowed
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-deactivate.gif' align='absmiddle'>&nbsp;";
				echo "<a href='banner-activate.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."&value=true'>$strDeActivate</a>";
			}
			if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ActivateBanner) && $row_banners['active'] != 't') // only for the client if allowed
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-activate.gif' align='absmiddle'>&nbsp;";
				echo "<a href='banner-activate.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."&value=false'>$strActivate</a>";
			}
			if ($adclicks > 0 || $adviews > 0)
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-zoom.gif' align='absmiddle'>&nbsp;";
				echo "<a href='stats-details.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>$strDetailStats</a>";
				
				if (phpAds_isUser(phpAds_Admin)) // only for the admin
				{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<img src='images/icon-undo.gif' align='absmiddle'>&nbsp;";
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
			
			echo "<td height='25' width='30' align='left'>&nbsp;";
			if (ereg ("Mozilla/6", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
				echo "<img name='caret".$row_banners['bannerid']."' src='images/triangle-l.gif' align='absmiddle' onClick=\"showHideLayers('".$row_banners['bannerid']."');\">";
			echo "</td>";
			
			
			echo "<td height='25' align='left' nowrap>";
			
			
			if ($row_banners['active'] == 't')
			{
				if ($row_banners['format'] == 'html')
				{
					echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
				}
				elseif ($row_banners['format'] == 'url')
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
				if ($row_banners['format'] == 'html')
				{
					echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
				}
				elseif ($row_banners['format'] == 'url')
				{
					echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
				}
				else
				{
					echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
				}
			}
			
			echo "&nbsp;";
			echo "<a height='25' href='stats-details.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>";
			
			if ($row_banners['description'] != '')	$name = $row_banners['description'];
			elseif ($row_banners['alt'] != '')		$name = $row_banners['alt'];
			else									$name = $strUntitled;
			
			echo phpAds_breakString ($name, '30');
			
			echo "</a>";
			echo "</td>";
			
			echo "<td height='25' align='left' nowrap>".$row_banners['bannerid']."</td>";
			
		    if ($adclicks > 0 || $adviews > 0)
		    {
				// Stats
				echo "<td height='25' align='right' nowrap>".$adviews."</td>";
				echo "<td height='25' align='right' nowrap>".$adclicks."</td>";
				echo "<td height='25' align='right' nowrap>".phpAds_buildCTR($adviews, $adclicks)."&nbsp;&nbsp;</td>";
			}
			else
			{
				echo "<td height='25' align='right' nowrap>-</td>";
				echo "<td height='25' align='right' nowrap>-</td>";
				echo "<td height='25' align='right' nowrap>-&nbsp;&nbsp;</td>";
			}
			
			echo "</tr>";
			
			echo "<tr bgcolor='$bgcolor'>";
			echo "<td height='1' width='30'><img src='images/spacer.gif' width='1' height='1'></td>";
			echo "<td colspan='5'>";
			
			if (ereg ("Mozilla/6", $HTTP_USER_AGENT) || ereg ("IE", $HTTP_USER_AGENT))
			{
				echo "<div id='banner".$row_banners['bannerid']."' style='display: none;'>";
				
				echo "<table width='100%' cellpadding=0 cellspacing=0 border=0><tr><td align='left'>";
				echo "<tr><td height='1'><img src='images/break-l.gif' height='1' width='100%' vspace='0'></tr><td>";
				echo "<tr><td height='10'>&nbsp;</tr><td>";
				echo "<tr><td>";
					echo phpAds_buildBannerCode ($row_banners['bannerid'], $row_banners['banner'], $row_banners['active'], $row_banners['format'], $row_banners['width'], $row_banners['height'], $row_banners['bannertext']);
				echo "</tr><td>";
				echo "<tr><td height='10'>&nbsp;</tr><td>";
				echo "<tr><td height='1'><img src='images/break-l.gif' height='1' width='100%' vspace='0'></tr><td>";
				echo "<tr><td height='25'>";
				
			    if ($adclicks > 0 || $adviews > 0)
				{
					echo "<a href='stats-details.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'>";
					echo "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;$strDetailStats</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if (phpAds_isUser(phpAds_Admin)) // only for the admin
					{
						echo "<a href='stats-reset.php?campaignid=$campaignid&bannerid=".$row_banners['bannerid']."'".phpAds_DelConfirm($strConfirmResetBannerStats).">";
						echo "<img src='images/icon-undo.gif' align='absmiddle' border='0'>&nbsp;$strResetStats</a>";
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
	echo "<form action='stats-campaign.php'>";
	echo "<td colspan='6' height='35' align='right'>";
	echo "<input type='hidden' name='campaignid' value='$campaignid'>";
	echo "<input type='hidden' name='order' value='$order'>";
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
	echo "<input type='image' border='0' name='submit' src='images/go_blue.gif'>";
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
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>