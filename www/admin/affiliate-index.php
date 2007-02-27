<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

error_reporting('E_ALL');

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.2");
phpAds_ShowSections(array("4.1", "4.2", "4.3"));

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder))
{
	if (isset($session['prefs']['affiliate-index.php']['listorder']))
		$listorder = $session['prefs']['affiliate-index.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['affiliate-index.php']['orderdirection']))
		$orderdirection = $session['prefs']['affiliate-index.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($session['prefs']['affiliate-index.php']['nodes']))
	$node_array = explode (",", $session['prefs']['affiliate-index.php']['nodes']);
else
	$node_array = array();



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$loosezones = false;

$doAffiliates = MAX_DB::factoryDO('affiliates');
$doAffiliates->addListOrderBy($listorder, $orderdirection);

// Get affiliates and build the tree
if (phpAds_isUser(phpAds_Agency))
{
	$doAffiliates->agencyid = $session['userid'];
}
elseif (phpAds_isUser(phpAds_Affiliate))
{
	$doAffiliates->affiliateid = $session['userid'];
}

$doAffiliates->find();
while ($doAffiliates->fetch() && $row_affiliates = $doAffiliates->toArray())
{
	$affiliates[$row_affiliates['affiliateid']] = $row_affiliates;
	$affiliates[$row_affiliates['affiliateid']]['expand'] = 0;
	$affiliates[$row_affiliates['affiliateid']]['count'] = 0;
}

$doZones = MAX_DB::factoryDO('zones');
$doZones->addListOrderBy($listorder, $orderdirection);

$doAdZoneAssoc = MAX_DB::factoryDO('ad_zone_assoc');
$doAdZoneAssoc->selectAdd('zone_id');
$doAdZoneAssoc->selectAdd('COUNT(*) AS num_ads');
$doAdZoneAssoc->groupBy('zone_id');

// Get the zones for each affiliate
if (phpAds_isUser(phpAds_Admin))
{
    $doAdZoneAssoc->whereAdd('zone_id > 0');
}
elseif (phpAds_isUser(phpAds_Agency))
{
    $agencyId = phpAds_getAgencyID();
    
    $doAffiliates = MAX_DB::factoryDO('affiliates');
    $doAffiliates->agencyid = $agencyId;
    $doZones->joinAdd($doAffiliates);

    $doAdZoneAssoc->joinAdd($doZones);
}

$doZones->find();

while ($doZones->fetch() && $row_zones = $doZones->toArray())
{
	if (isset($affiliates[$row_zones['affiliateid']]))
	{
		$zones[$row_zones['zoneid']] = $row_zones;
		$affiliates[$row_zones['affiliateid']]['count']++;
	}
	else
		$loosezones = true;
}

$doAdZoneAssoc->find();
while ($doAdZoneAssoc->fetch() && $row_ad_zones = $doAdZoneAssoc->toArray()) {
    // set warning flag if zone has no low-priority ads linked
    $aZoneAds = MAX_cacheGetZoneLinkedAds($row_ad_zones['zone_id'], false);
    $lpc_flag = false;
    if ($aZoneAds['count_active'] > 0) {
        if (count($aZoneAds['lAds']) == 0) {
            $lpc_flag = true;
        }
    }
    $zones[$row_ad_zones['zone_id']]['lpc_flag'] = $lpc_flag;
    
    $zones[$row_ad_zones['zone_id']]['num_ads'] = $row_ad_zones['num_ads'];
}


// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{
	switch ($expand)
	{
		case 'all' :	$node_array   = array();
						if (isset($affiliates)) foreach (array_keys($affiliates) as $key)	$node_array[] = $key;
						break;
						
		case 'none':	$node_array   = array();
						break;
						
		default:		$node_array[] = $expand;
						break;
	}
}

$node_array_size = sizeof($node_array);
for ($i=0; $i < $node_array_size;$i++)
{
	if (isset($collapse) && $collapse == $node_array[$i])
		unset ($node_array[$i]);
	else
	{
		if (isset($affiliates[$node_array[$i]]))
			$affiliates[$node_array[$i]]['expand'] = 1;
	}
}



// Build Tree
if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	// Add banner to campaigns
	foreach (array_keys($zones) as $zkey)
	{
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	}
	
	unset ($zones);
}



echo "<img src='images/icon-affiliate-new.gif' border='0' align='absmiddle'>&nbsp;";
echo "<a href='affiliate-edit.php' accesskey=".$keyAddNew.">".$strAddNewAffiliate_Key."</a>&nbsp;&nbsp;";
phpAds_ShowBreak();



echo "<br /><br />";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo '<td height="25" width="40%"><b>&nbsp;&nbsp;<a href="affiliate-index.php?listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-index.php?orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-index.php?orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="affiliate-index.php?listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-index.php?orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-index.php?orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


if (!isset($affiliates) || !is_array($affiliates) || count($affiliates) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='6'>";
	echo "&nbsp;&nbsp;".$strNoAffiliates;
	echo "</td></tr>";
	
	echo "<td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}
else
{
	$i=0;
	foreach (array_keys($affiliates) as $key)
	{
		$affiliate = $affiliates[$key];
		$channels = Admin_DA::getChannels(array('publisher_id' => $affiliate['affiliateid']));
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		if (isset($affiliate['zones']))
		{
			if ($affiliate['expand'] == '1')
				echo "&nbsp;<a href='affiliate-index.php?collapse=".$affiliate['affiliateid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='affiliate-index.php?expand=".$affiliate['affiliateid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
			
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";

        // set low priority campaign warning if any of this affiliate's zones
        // are without low-priority ads
        $zone_overview_icon = 'icon-zone.gif';
        $zone_overview_warning_start = '';
        $zone_overview_warning_end = '';
        foreach($affiliates[$affiliate['affiliateid']]['zones'] as $aff_zone) {
            if ($aff_zone['lpc_flag']) {
                $zone_overview_icon = 'icon-zone-w.gif';
                $zone_overview_warning_start = "<acronym title='Warning - Publisher has zones with no low-priority ads linked'>";
                $zone_overview_warning_end = "</acronym>";
            }
        }
		
		echo "<a href='affiliate-edit.php?affiliateid=".$affiliate['affiliateid']."'>".$affiliate['name']."</a>";
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$affiliate['affiliateid']."</td>";
		
		// Button - Create
		echo "<td height='25'>";
		if ($affiliate['expand'] == '1' || !isset($affiliate['zones']))
			echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."'><img src='images/icon-zone-new.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			echo "&nbsp;";
		echo "</td>";
		
		// Button - Zone overview
		echo "<td height='25'>";
		echo "<a href='affiliate-zones.php?affiliateid=".$affiliate['affiliateid']."'>".$zone_overview_warning_start."<img src='images/".$zone_overview_icon."' border='0' align='absmiddle' alt='{$GLOBALS['strZones']}'>".$zone_overview_warning_end."&nbsp;{$GLOBALS['strZones']}</a>&nbsp;&nbsp;";
		echo "</td>";
		
		// Button - Channel overview
		echo "<td height='25'>";
		echo "<a href='affiliate-channels.php?affiliateid={$affiliate['affiliateid']}'>";
		if (empty($channels)) {
		    echo "<img src='images/icon-channel-d.gif' border='0' align='absmiddle' alt='{$GLOBALS['strChannels']}'>";
		} else {
		    echo "<img src='images/icon-channel.gif' border='0' align='absmiddle' alt='{$GLOBALS['strChannels']}'>";
	    }
	    echo "&nbsp;{$GLOBALS['strChannels']}</a>&nbsp;&nbsp;";
		
		echo "</td>";
		
		// Button - Delete
		echo "<td height='25'>";
		echo "<a href='affiliate-delete.php?affiliateid=".$affiliate['affiliateid']."&returnurl=affiliate-index.php'".phpAds_DelConfirm($strConfirmDeleteAffiliate)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td></tr>";
		
		if (isset($affiliate['zones']) && sizeof ($affiliate['zones']) > 0 && $affiliate['expand'] == '1')
		{
			$zones = $affiliate['zones'];
			
			foreach (array_keys($zones) as $zkey)
			{
				// Divider
				echo "<tr height='1'>";
				echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
				echo "<td colspan='6' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
				echo "</tr>";
				
				// Icon & name
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
				
                if (!empty($zones[$zkey]['num_ads']))
				{
					if ($zones[$zkey]['delivery'] == phpAds_ZoneBanner) {
                        // set low priority campaign warning if zone has no low-priority ads
                        $zone_overview_icon = 'icon-zone.gif';
                        $zone_overview_warning_start = '';
                        $zone_overview_warning_end = '';
                        if ($zones[$zkey]['lpc_flag']) {
                            $zone_overview_icon = 'icon-zone-w.gif';
                            $zone_overview_warning_start = "<acronym title='Warning - There are no low-priority ads linked to this zone'>";
                            $zone_overview_warning_end = "</acronym>";
                        }
						echo $zone_overview_warning_start."<img src='images/".$zone_overview_icon."' align='absmiddle'>".$zone_overview_warning_end."&nbsp;";
					} elseif ($zones[$zkey]['delivery'] == phpAds_ZoneInterstitial) {
						echo "<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
					} elseif ($zones[$zkey]['delivery'] == phpAds_ZonePopup) {
						echo "<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;";
					} elseif ($zones[$zkey]['delivery'] == phpAds_ZoneText) {
						echo "<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;";
					}
				}
				else
				{
					if ($zones[$zkey]['delivery'] == phpAds_ZoneBanner)
						echo "<img src='images/icon-zone-d.gif' align='absmiddle'>&nbsp;";
					elseif ($zones[$zkey]['delivery'] == phpAds_ZoneInterstitial)
						echo "<img src='images/icon-interstitial-d.gif' align='absmiddle'>&nbsp;";
					elseif ($zones[$zkey]['delivery'] == phpAds_ZonePopup)
						echo "<img src='images/icon-popup-d.gif' align='absmiddle'>&nbsp;";
					elseif ($zones[$zkey]['delivery'] == phpAds_ZoneText)
						echo "<img src='images/icon-textzone-d.gif' align='absmiddle'>&nbsp;";
				}

				echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'>".$zones[$zkey]['zonename']."</td>";
				echo "</td>";
				
				// ID
				echo "<td height='25'>".$zones[$zkey]['zoneid']."</td>";
				
				// Button 1
				echo "<td height='25'>";
				echo "&nbsp;";
				echo "</td>";
				
				// Button 3
				echo "<td height='25'>";
				echo "&nbsp;";
				echo "</td>";
				
				// Button 2
				echo "<td height='25'>";
				echo "<a href='zone-include.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;";
				echo "</td>";
				
				// Button 4
				echo "<td height='25'>";
				echo "<a href='zone-delete.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."&returnurl=affiliate-index.php'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td></tr>";
			}
		}
		
		echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
}

if ($loosezones)
{
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	echo "<td height='25'>&nbsp;&nbsp;";
	echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
	echo $strZonesWithoutAffiliate."</td>";
	echo "<td height='25'>&nbsp;-&nbsp;</td>";
	echo "<td height='25' colspan='3'>";
	echo "<a href='affiliate-edit.php?move=t'>";
	echo "<img src='images/".$phpAds_TextDirection."/icon-update.gif' border='0' align='absmiddle' alt='$strMoveToNewAffiliate'>&nbsp;$strMoveToNewAffiliate</a>&nbsp;&nbsp;";
	echo "</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr><td height='25' colspan='6' align='".$phpAds_TextAlignRight."'>";
echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
echo "&nbsp;<a href='affiliate-index.php?expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
echo "&nbsp;<a href='affiliate-index.php?expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>";
echo "</td></tr>";

echo "</table>";


// Total number of clients
$doAffiliates = MAX_DB::factoryDO('affiliates');
$doZones = MAX_DB::factoryDO('zones');

if (phpAds_isUser(phpAds_Agency)) {
    $doAffiliates->agencyid = phpAds_getAgencyID();
    $doZones->joinAdd($doAffiliates);
}

$countZone = $doZones->count();
$countAffiliate = $doAffiliates->count();

echo "\t\t\t\t<br /><br /><br /><br />\n";
echo "\t\t\t\t<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>\n";
echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25' colspan='3'>&nbsp;&nbsp;<b>".$strOverall."</b></td>\n";
echo "\t\t\t\t</tr>\n";
echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;&nbsp;".$strTotalZones.": <b>".$countZone."</b></td>\n";
echo "\t\t\t\t\t<td height='25'>".$strTotalAffiliates.": <b>".$countAffiliate."</b></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t</table>\n";
echo "\t\t\t\t<br /><br />\n";

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['affiliate-index.php']['listorder'] = $listorder;
$session['prefs']['affiliate-index.php']['orderdirection'] = $orderdirection;
$session['prefs']['affiliate-index.php']['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
