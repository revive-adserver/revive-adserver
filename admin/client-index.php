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


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("4.1");
phpAds_ShowSections(array("4.1", "4.2", "4.3"));

if (isset($message))
{
	phpAds_ShowMessage($message);
}


/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get clients & campaign and build the tree
if (phpAds_isUser(phpAds_Admin))
{
	$res_clients = db_query("
		SELECT 
			*
		FROM 
			".$phpAds_tbl_clients."
		".phpAds_getListOrder ($listorder, $orderdirection)."
		") or mysql_die();
}
else
{
	$res_clients = db_query("
		SELECT 
			*
		FROM 
			".$phpAds_tbl_clients."
		WHERE
			clientID = ".$Session["clientID"]." OR
			parent = ".$Session["clientID"]."
		".phpAds_getListOrder ($listorder, $orderdirection)."
		") or mysql_die();
}

while ($row_clients = mysql_fetch_array($res_clients))
{
	if ($row_clients['parent'] == 0)
	{
		$clients[$row_clients['clientID']] = $row_clients;
		$clients[$row_clients['clientID']]['expand'] = 0;
		$clients[$row_clients['clientID']]['count'] = 0;
	}
	else
	{
		$campaigns[$row_clients['clientID']] = $row_clients;
		$campaigns[$row_clients['clientID']]['expand'] = 0;
		$campaigns[$row_clients['clientID']]['count'] = 0;
	}
}


// Get the banners for each campaign
$res_banners = db_query("
	SELECT 
		bannerID,
		clientID,
		alt,
		description,
		format,
		active
	FROM 
		".$phpAds_tbl_banners."
		".phpAds_getBannerListOrder ($listorder, $orderdirection)."
	") or mysql_die();

while ($row_banners = mysql_fetch_array($res_banners))
{
	if (isset($campaigns[$row_banners['clientID']]))
	{
		$banners[$row_banners['bannerID']] = $row_banners;
		$campaigns[$row_banners['clientID']]['count']++;
	}
	
	if (isset($clients[$row_banners['clientID']]))
	{
		$clients[$row_banners['clientID']]['count']++;
	}
}



// Expand tree nodes

if (isset($Session["stats_nodes"]) && $Session["stats_nodes"])
	$node_array = explode (",", $Session["stats_nodes"]);
else
	$node_array = array();

// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
	$node_array[] = $expand;

for ($i=0; $i < sizeof($node_array);$i++)
{
	if (isset($collapse) && $collapse == $node_array[$i])
		unset ($node_array[$i]);
	else
	{
		if (isset($clients[$node_array[$i]]))
			$clients[$node_array[$i]]['expand'] = 1;
		if (isset($campaigns[$node_array[$i]]))
			$campaigns[$node_array[$i]]['expand'] = 1;
	}
}

$Session["stats_nodes"] = implode (",", $node_array);
phpAds_SessionDataStore();



// Build Tree
if (isset($banners) && is_array($banners) && count($banners) > 0)
{
	// Add banner to campaigns
	for (reset($banners);$bkey=key($banners);next($banners))
		$campaigns[$banners[$bkey]['clientID']]['banners'][$bkey] = $banners[$bkey];
	
	unset ($banners);
}

if (isset($campaigns) && is_array($campaigns) && count($campaigns) > 0)
{
	for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
		$clients[$campaigns[$ckey]['parent']]['campaigns'][$ckey] = $campaigns[$ckey];
	
	unset ($campaigns);
}








echo "<br><br>";
echo "<br><br>";
echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

if (isset($clients) && is_array($clients) && count($clients) > 0)
{
	echo "<tr height='25'>";
	echo '<td height="25"><b>&nbsp;&nbsp;<a href="'.$PHP_SELF.'?listorder=name">'.$GLOBALS['strName'].'</a>';
	if (($listorder == "name") || ($listorder == ""))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=name&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=name&orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	echo '</b></td>';
	echo '<td height="25"><b><a href="'.$PHP_SELF.'?listorder=id">'.$GLOBALS['strID'].'</a>';
	if ($listorder == "id")
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=id&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=id&orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$i=0;
	for (reset($clients);$key=key($clients);next($clients))
	{
		$client = $clients[$key];
		
		if ($client['parent'] == 0)
		{
			echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			// Icon & name
			echo "<td height='25'>";
			if (isset($client['campaigns']))
			{
				if ($client['expand'] == '1')
					echo "&nbsp;<a href='client-index.php?listorder=".$listorder."&orderdirection=".$orderdirection."&collapse=".$client['clientID']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
				else
					echo "&nbsp;<a href='client-index.php?listorder=".$listorder."&orderdirection=".$orderdirection."&expand=".$client['clientID']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
			}
			else
				echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
				
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
			echo "<a href='client-edit.php?clientID=".$client['clientID']."'>".$client['clientname']."</a>";
			echo "</td>";
			
			// ID
			echo "<td height='25'>".$client['clientID']."</td>";
			
			// Button 2
			echo "<td height='25'>";
			if (($client['count'] == 0 && $client['expand'] == '1') || !isset($client['campaigns']))
				echo "<a href='campaign-edit.php?clientID=".$client['clientID']."'><img src='images/icon-campaign.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			else
				echo "&nbsp;";
			echo "</td>";
			
			// Empty
			echo "<td>&nbsp;</td>";
			
			// Button 1
			echo "<td height='25'>";
			echo "<a href='client-delete.php?clientID=".$client['clientID']."'".phpAds_DelConfirm($strConfirmDeleteClient)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td></tr>";
			
			
			
			if (isset($client['campaigns']) && sizeof ($client['campaigns']) > 0 && $client['expand'] == '1')
			{
				$campaigns = $client['campaigns'];
				
				for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
				{
					// Divider
					echo "<tr height='1'>";
					echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
					echo "<td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
					echo "</tr>";
					
					// Icon & name
					echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if (isset($campaigns[$ckey]['banners']))
					{
						if ($campaigns[$ckey]['expand'] == '1')
							echo "<a href='client-index.php?listorder=".$listorder."&orderdirection=".$orderdirection."&collapse=".$campaigns[$ckey]['clientID']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
						else
							echo "<a href='client-index.php?listorder=".$listorder."&orderdirection=".$orderdirection."&expand=".$campaigns[$ckey]['clientID']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
					}
					else
						echo "<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
					
					
					if ($campaigns[$ckey]['active'] == 'true')
						echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
					else
						echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
					
					echo "<a href='campaign-index.php?campaignID=".$campaigns[$ckey]['clientID']."'>".$campaigns[$ckey]['clientname']."</td>";
					echo "</td>";
					
					// ID
					echo "<td height='25'>".$campaigns[$ckey]['clientID']."</td>";
					
					// Button 1
					echo "<td height='25'>";
					if ($campaigns[$ckey]['expand'] == '1' || !isset($campaigns[$ckey]['banners']))
						echo "<a href='banner-edit.php?campaignID=".$campaigns[$ckey]['clientID']."'><img src='images/icon-banner-stored.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					else
						echo "&nbsp;";
					echo "</td>";
					
					// Button 2
					echo "<td height='25'>";
					echo "<a href='campaign-edit.php?campaignID=".$campaigns[$ckey]['clientID']."'><img src='images/icon-edit.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strEdit</a>&nbsp;&nbsp;";
					echo "</td>";
					
					// Button 3
					echo "<td height='25'>";
					echo "<a href='campaign-delete.php?campaignID=".$campaigns[$ckey]['clientID']."'".phpAds_DelConfirm($strConfirmDeleteCampaign)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "</td></tr>";
					
					
					
					if ($campaigns[$ckey]['expand'] == '1' && isset($campaigns[$ckey]['banners']))
					{
						$banners = $campaigns[$ckey]['banners'];
						for (reset($banners);$bkey=key($banners);next($banners))
						{
							$name = $strUntitled;
							if (isset($banners[$bkey]['alt']) && $banners[$bkey]['alt'] != '') $name = $banners[$bkey]['alt'];
							if (isset($banners[$bkey]['description']) && $banners[$bkey]['description'] != '') $name = $banners[$bkey]['description'];
							
							$name = phpAds_breakString ($name, '30');
							
							// Divider
							echo "<tr height='1'>";
							echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
							echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
							echo "</tr>";
							
							// Icon & name
							echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
							echo "<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							
							if ($banners[$bkey]['active'] == 'true' && $campaigns[$ckey]['active'] == 'true')
							{
								if ($banners[$bkey]['format'] == 'html')
								{
									echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
								}
								elseif ($banners[$bkey]['format'] == 'url')
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
								if ($banners[$bkey]['format'] == 'html')
								{
									echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
								}
								elseif ($banners[$bkey]['format'] == 'url')
								{
									echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
								}
								else
								{
									echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
								}
							}
							
							echo "&nbsp;<a href='banner-edit.php?bannerID=".$banners[$bkey]['bannerID']."&campaignID=".$campaigns[$ckey]['clientID']."'>".$name."</a></td>";
							
							// ID
							echo "<td height='25'>".$banners[$bkey]['bannerID']."</td>";
							
							// Empty
							echo "<td>&nbsp;</td>";
							
							// Button 2
							echo "<td height='25'>";
							if ($phpAds_acl == '1')
								echo "<a href='banner-acl.php?bannerID=".$banners[$bkey]['bannerID']."&campaignID=".$campaigns[$ckey]['clientID']."'><img src='images/icon-acl.gif' border='0' align='absmiddle' alt='$strACL'>&nbsp;$strACL</a>&nbsp;&nbsp;&nbsp;&nbsp;";
							else
								echo "&nbsp;";
							echo "</td>";
							
							// Button 1
							echo "<td height='25'>";
							echo "<a href='banner-delete.php?bannerID=".$banners[$bkey]['bannerID']."&campaignID=".$campaigns[$ckey]['clientID']."'".phpAds_DelConfirm($strConfirmDeleteBanner)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
							echo "</td></tr>";
						}
					}
				}
			}
			
			if ($client['count'] > 0)
			{
				// Divider
				echo "<tr height='1'><td colspan='1'></td><td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
				
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				echo "<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
				echo "$strBannersWithoutCampaign</td>";
				echo "<td height='25'>&nbsp;-&nbsp;</td>";
				echo "<td height='25' colspan='3'>";
				echo "<a href='campaign-edit.php?move=true&clientID=".$client['clientID']."'>";
				echo "<img src='images/icon-update.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strMoveToNewCampaign</a>&nbsp;&nbsp;";
				echo "</td>";
				echo "</tr>";
			}
			
			echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			$i++;
		}
	}
}

echo "<tr height='25'><td colspan='5' height='25'>";
echo "<img src='images/icon-client.gif' border='0' align='absmiddle'>&nbsp;<a href='client-edit.php'>$strAddClient</a>&nbsp;&nbsp;";
echo "</td></tr>";

echo "</table>";



// total number of clients
$res_clients 		  = db_query("SELECT count(*) as count FROM $phpAds_tbl_clients WHERE parent = 0") or mysql_die();
$res_campaigns 		  = db_query("SELECT count(*) as count FROM $phpAds_tbl_clients WHERE parent > 0") or mysql_die();
$res_active_campaigns = db_query("SELECT count(*) as count FROM $phpAds_tbl_clients WHERE parent > 0 AND active='true'");
$res_total_banners 	  = db_query("SELECT count(*) as count FROM $phpAds_tbl_banners");
$res_active_banners   = db_query("SELECT count(*) as count FROM $phpAds_tbl_banners as b, $phpAds_tbl_clients as c WHERE b.clientID=c.clientID AND c.active='true' AND b.active='true'");


echo "<br><br><br><br>";
echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strOverall."</b></td></tr>";
echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr><td height='25'>".$strTotalBanners.": <b>".@mysql_result($res_total_banners, 0, "count")."</b></td>";
echo "<td height='25'>".$strTotalCampaigns.": <b>".@mysql_result($res_campaigns, 0, "count")."</b></td>";
echo "<td height='25'>".$strTotalClients.": <b>".@mysql_result($res_clients, 0, "count")."</b></td></tr>";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";

echo "<tr><td height='25'>".$strActiveBanners.": <b>".@mysql_result($res_active_banners, 0, "count")."</b></td>";
echo "<td height='25'>".$strActiveCampaigns.": <b>".@mysql_result($res_active_campaigns, 0, "count")."</b></td>";
echo "<td height='25'>&nbsp;</td></tr>";

echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
