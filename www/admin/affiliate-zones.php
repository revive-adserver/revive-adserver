<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('listorder', 'orderdirection');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
if (!empty($affiliateid)) { //check if client explicitly given
    OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
}

/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/
//get websites and set the current one
$aWebsites = getWebsiteMap();
if (empty($affiliateid)) {
    $ids = array_keys($aWebsites);
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid']) {
        $affiliateid = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'];
    }
    
    if (!$affiliateid || !isset($aWebsites[$affiliateid])) { //check if 'current' from session was not removed 
        $affiliateid = !empty($ids) ? $ids[0] : -1; //if no websites set non-existent id 
    }   
}

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder)) {
    if (isset($session['prefs']['affiliate-zones.php']['listorder'])) {
        $listorder = $session['prefs']['affiliate-zones.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['affiliate-zones.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['affiliate-zones.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
addPageTools($affiliateid);
$oHeaderModel = buildHeaderModel($affiliateid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    phpAds_PageHeader(null, $oHeaderModel);
} 
else {
    $sections = array("2.1");
    phpAds_PageHeader(null, $oHeaderModel);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get clients & campaign and build the tree
$doZones = OA_Dal::factoryDO('zones');
$doZones->affiliateid = $affiliateid;
$doZones->addListorderBy($listorder, $orderdirection);
$doZones->find();

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";


echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
    if  (($orderdirection == "") || ($orderdirection == "down"))
    {
        echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
        echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
    }
    else
    {
        echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
        echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
    }
    echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
    if  (($orderdirection == "") || ($orderdirection == "down"))
    {
        echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
        echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
    }
    else
    {
        echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
        echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
    }
    echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;</td>';
echo '<td height="25"><b><a href="affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=size">'.$GLOBALS['strSize'].'</a>';

if ($listorder == "size")
{
    if  (($orderdirection == "") || ($orderdirection == "down"))
    {
        echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
        echo '<img src="' . OX::assetPath() . '/images/caret-ds.gif" border="0" alt="" title="">';
    }
    else
    {
        echo ' <a href="affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
        echo '<img src="' . OX::assetPath() . '/images/caret-u.gif" border="0" alt="" title="">';
    }
    echo '</a>';
}

echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";


if ($doZones->getRowCount() == 0)
{
    echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='4'>";
    if (empty($affiliateid) || $affiliateid < 0) {
        echo "&nbsp;&nbsp;$strNoZonesAddWebsite";
    }
    else {
        echo "&nbsp;&nbsp;$strNoZones";
    }
    echo "</td></tr>";

    echo "<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>";
}

$i=0;
while ($doZones->fetch() && $row_zones = $doZones->toArray())
{
    if ($i > 0) echo "<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>";
    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

    echo "<td height='25'>&nbsp;&nbsp;";

    $aZoneAds = MAX_cacheGetZoneLinkedAds($row_zones['zoneid'], false);
    if ($aZoneAds['count_active'] > 0) {
        if ($row_zones['delivery'] == phpAds_ZoneBanner) {
            if (count($aZoneAds['lAds']) == 0) {
                // There are linked ads, but no low-priority ads (this will result in serving blanks)
                echo "<acronym title='Warning - There are no low-priority ads linked to this zone'><img src='" . OX::assetPath() . "/images/icon-zone-w.gif' align='absmiddle' />&nbsp;</acronym>";
            } else {
                echo "<img src='" . OX::assetPath() . "/images/icon-zone.gif' align='absmiddle'>&nbsp;";
            }
        } elseif ($row_zones['delivery'] == phpAds_ZoneInterstitial) {
            echo "<img src='" . OX::assetPath() . "/images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == phpAds_ZonePopup) {
            echo "<img src='" . OX::assetPath() . "/images/icon-popup.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == phpAds_ZoneText) {
            echo "<img src='" . OX::assetPath() . "/images/icon-textzone.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == MAX_ZoneEmail) {
            echo "<img src='" . OX::assetPath() . "/images/icon-zone-email.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == MAX_ZoneClick) {
            echo "<img src='" . OX::assetPath() . "/images/icon-zone-click.gif' align='absmiddle'>&nbsp;";
        }
    } else {
        if ($row_zones['delivery'] == phpAds_ZoneBanner) {
            echo "<img src='" . OX::assetPath() . "/images/icon-zone-d.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == phpAds_ZoneInterstitial) {
            echo "<img src='" . OX::assetPath() . "/images/icon-interstitial-d.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == phpAds_ZonePopup) {
            echo "<img src='" . OX::assetPath() . "/images/icon-popup-d.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == phpAds_ZoneText) {
            echo "<img src='" . OX::assetPath() . "/images/icon-textzone-d.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == MAX_ZoneEmail) {
            echo "<img src='" . OX::assetPath() . "/images/icon-zone-email-d.gif' align='absmiddle'>&nbsp;";
        } elseif ($row_zones['delivery'] == MAX_ZoneClick) {
            echo "<img src='" . OX::assetPath() . "/images/icon-zone-click-d.gif' align='absmiddle'>&nbsp;";
        }
    }

    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_EDIT))
        echo "<a href='zone-edit.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'>".$row_zones['zonename']."</a>";
    else
        echo $row_zones['zonename'];

    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "</td>";

    // ID
    echo "<td height='25'>".$row_zones['zoneid']."</td>";

    // Size
    if ($row_zones['delivery'] == phpAds_ZoneText)
    {
        echo "<td height='25'>".$strCustom." (".$strTextAdZone.")</td>";
    }
    else
    {
        if ($row_zones['width'] == -1) $row_zones['width'] = '*';
        if ($row_zones['height'] == -1) $row_zones['height'] = '*';

        echo "<td height='25'>".phpAds_getBannerSize($row_zones['width'], $row_zones['height'])."</td>";
    }

    echo "<td>&nbsp;</td>";
    echo "</tr>";

    // Description
    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
    echo "<td>&nbsp;</td>";
    echo "<td height='25' colspan='3'>".stripslashes($row_zones['description'])."</td>";
    echo "</tr>";

    echo "<tr height='1'>";
    echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='1'></td>";
    echo "<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>";
    echo "</tr>";
    echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

    // Empty
    echo "<td>&nbsp;</td>";

    // Button 1, 2 & 3
    echo "<td height='25' colspan='3'>";
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_LINK)) echo "<img src='" . OX::assetPath() . "/images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;<a href='zone-include.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'>$strIncludedBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<img src='" . OX::assetPath() . "/images/icon-zone-probability.gif' border='0' align='absmiddle' alt='$strProbability'>&nbsp;<a href='zone-probability.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'>$strProbability</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION)) echo "<img src='" . OX::assetPath() . "/images/icon-generatecode.gif' border='0' align='absmiddle' alt='$strInvocationcode'>&nbsp;<a href='zone-invocation.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."'>$strInvocationcode</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_DELETE)) echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;<a href='zone-delete.php?affiliateid=".$affiliateid."&zoneid=".$row_zones['zoneid']."&returnurl=affiliate-zones.php'".MAX_zoneDelConfirm($row_zones['zoneid']).">$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "</td></tr>";

    $i++;
}

if ($doZones->getRowCount() > 0)
{
    echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
echo "<br /><br />";



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['affiliate-zones.php']['listorder'] = $listorder;
$session['prefs']['affiliate-zones.php']['orderdirection'] = $orderdirection;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;

phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function buildHeaderModel($websiteId)
{
    if ($websiteId) {    
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($websiteId)) {
            $aWebsite = $doAffiliates->toArray();
        }
        
        $websiteName = $aWebsite['name'];
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
            $websiteEditUrl = "affiliate-edit.php?affiliateid=$websiteId";
        }
    }
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array(
        array ('name' => $websiteName, 'url' => $websiteEditUrl, 
               'id' => $websiteId, 'entities' => getWebsiteMap(),
               'htmlName' => 'affiliateid'
              ),
        array('name' => '')               
    ), 'zones', 'list');    
    
    return $oHeaderModel;
}


function getWebsiteMap()
{
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) { //should this constraint be added always instead of only for managers?
        $doAffiliates->agencyid = OA_Permission::getAgencyId();
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
        $doAffiliates->agencyid = OA_Permission::getEntityId();
    }
    $doAffiliates->find();
    
    $aWebsiteMap = array();    
    while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
        $aWebsiteMap[$row['affiliateid']] = array('name' => $row['name'],
            'url' => "affiliate-edit.php?affiliateid=".$row['affiliateid']);        
    }
    
    return $aWebsiteMap;
}


function addPageTools($websiteId)
{
    if ($websiteId > 0 && (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_ADD)))
    {
        addPageLinkTool($GLOBALS["strAddNewZone_Key"], "zone-edit.php?affiliateid=$websiteId", 'iconZoneAdd', $GLOBALS["strAddNew"] );
    }    
}

?>
