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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/other/stats.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);

// Get input parameters
$advertiserId   = MAX_getValue('clientid');
$campaignId     = MAX_getValue('campaignid');
$aCurrentZones  = MAX_getValue('includezone');
$listorder      = MAX_getStoredValue('listorder', 'name');
$orderdirection = MAX_getStoredValue('orderdirection', 'up');
$submit         = MAX_getValue('submit');

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('clientid' => $advertiserId, 'campaignid' => $campaignId);

// Process submitted form
if (isset($submit))
{
    $aPreviousZones = Admin_DA::getPlacementZones(array('placement_id' => $campaignId));

    // First, remove any zones that should be deleted.
    if (!empty($aPreviousZones)) {
        foreach ($aPreviousZones as $aPlacementZone) {
            $zoneId = $aPlacementZone['zone_id'];
            if (empty($aCurrentZones[$zoneId])) {
                // The user has removed this zone link
                $aParams = array('zone_id' => $zoneId, 'placement_id' => $campaignId);
                Admin_DA::deletePlacementZones($aParams);
            } else {
                // Remove this key, because it is already there and does not need to be added again.
                unset($aCurrentZones[$zoneId]);
            }
        }
    }

    if (!empty($aCurrentZones)) {
        foreach ($aCurrentZones as $zoneId => $value) {
            $aVariables = array('zone_id' => $zoneId, 'placement_id' => $campaignId);
            Admin_DA::addPlacementZone($aVariables);
        }
    }

    // Move on to the next page
    Header("Location: campaign-banners.php?clientid=$advertiserId&campaignid=$campaignId");
    exit;
}

// Display navigation
$aOtherAdvertisers = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
$aOtherCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $advertiserId));
MAX_displayNavigationCampaign($pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);

echo "
<br /><br />
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<form name='zones' action='$pageName' method='post'>
<input type='hidden' name='clientid' value='$advertiserId'>
<input type='hidden' name='campaignid' value='$campaignId'>";

    MAX_displayZoneHeader($pageName, $listorder, $orderdirection, $aEntities);

    $aParams = array('placement_id' => $campaignId);
    $aLinkedZones = Admin_DA::getPlacementZones($aParams, false, 'zone_id');
    $pAdIds = implode(',', array_keys(Admin_DA::getAds(array('placement_id' => $campaignId))));
    if (!empty($pAdIds)) {
        $aLinkedAdZones = Admin_DA::getAdZones(array('ad_id' => $pAdIds), false, 'zone_id');
    } else {
        $aLinkedAdZones = array();
    }

    $aParams = array();
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    	$aParams['agency_id'] = OA_Permission::getAgencyId();
    }
    $zoneToSelect = false;
    $aPublishers = Admin_DA::getPublishers($aParams);
    if (!empty($aPublishers)) {
        MAX_sortArray($aPublishers, ($listorder == 'id' ? 'publisher_id' : $listorder), $orderdirection == 'up');
        $i=0;

        //select all checkboxes
        $publisherIdList = '';
        foreach ($aPublishers as $publisherId => $aPublisher) {
            $publisherIdList .= $publisherId . '|';
        }

        echo"<input type='checkbox' id='selectAllField' onClick='toggleAllZones(\"".$publisherIdList."\");'><label for='selectAllField'>".$strSelectUnselectAll."</label>";

        foreach ($aPublishers as $publisherId => $aPublisher) {
            $publisherName = $aPublisher['name'];
            $aParams = array('publisher_id' => $aPublisher['publisher_id']);
            $aZones = Admin_DA::getZones($aParams, true);

            if (!empty($aZones)) {
                $zoneToSelect = true;
                $bgcolor = ($i % 2 == 0) ? " bgcolor='#F6F6F6'" : '';
                $bgcolorSave = $bgcolor;
                $allchecked = true;
                foreach ($aZones as $zoneId => $zone) {
                    if ($zone['type'] == MAX_ZoneEmail) {
                        $allchecked = false;
                        continue;
                    }
                    if (!isset($aLinkedZones[$zoneId])) {
                        $allchecked = false;
                        break;
                    }
                }
                $checked = $allchecked ? ' checked' : '';
                if ($i > 0) echo "
<tr height='1'>
    <td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
</tr>";

                echo "
<tr height='25'$bgcolor>
    <td>
        <table>
            <tr>
                <td>&nbsp;</td>
                <td valign='top'><input name='affiliate[$publisherId]' type='checkbox' value='t'$checked onClick='toggleZones($publisherId);' tabindex='$tabindex'>&nbsp;&nbsp;</td>
                <td valign='top'><img src='" . MAX::assetPath() . "/images/icon-affiliate.gif' align='absmiddle'>&nbsp;</td>
                <td><a href='affiliate-edit.php?affiliateid=$publisherId'>$publisherName</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table>
    </td>
    <td>$publisherId</td>
    <td height='25'>&nbsp;</td>
</tr>";

                $tabindex++;
                if (!empty($aZones)) {
                    MAX_sortArray($aZones, ($listorder == 'id' ? 'zone_id' : $listorder), $orderdirection == 'up');
                    foreach($aZones as $zoneId => $aZone) {
                        $zoneName = $aZone['name'];
                        $zoneDescription = $aZone['description'];
                        $zoneIcon = MAX_getEntityIcon('zone', true, $aZone['type']);
                        $checked = isset($aLinkedZones[$zoneId]) ? ' checked' : '';
                        // If any ads from this campaign are linked, then use partial highlight colour...
                        $bgcolor = (isset($aLinkedAdZones[$zoneId])) ? " bgcolor='#d8d8ff'" : $bgcolorSave;
                        // Override the above highlight if this banner is linked at the campaign level...
                        $bgcolor = ($checked == ' checked') ? " bgcolor='#ffd8d8'" : $bgcolor;
                        if ($aZone['type'] == MAX_ZoneEmail) {
                            // Skip email zones from the campaign-zone list because they are not valid to link campaigns to
                            continue;
                        }
                        if ($aZone['width'] == -1 && $aZone['height'] == -1) {
                            $warning = "<acronym title='Warning: Zone is *x*'><img src='" . MAX::assetPath() . "/images/warning.gif' alt='Zone is *x*' /></acronym> ";
                        } else {
                            $warning = '';
                        }

                        echo "
<tr height='25'$bgcolor>
    <td>
        <table>
            <tr>
                <td width='28'>&nbsp;</td>
                <td valign='top'><input name='includezone[$zoneId]' id='a$publisherId' type='checkbox' value='t'$checked onClick='toggleAffiliate($publisherId);' tabindex='$tabindex' $disabled>&nbsp;&nbsp;</td>
                <td valign='top'><img src='$zoneIcon' align='absmiddle'>&nbsp;</td>
                <td><a href='zone-edit.php?affiliateid=$publisherId&zoneid=$zoneId'>$zoneName</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table>
    </td>
    <td>$zoneId</td>
    <td>{$warning}{$zoneDescription}</td>
</tr>";
                    }
                }
                $i++;
            }
        }
        echo "
<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    }
    if (!$zoneToSelect) {
        echo "
<tr height='25' bgcolor='#F6F6F6'>
    <td colspan='4'>&nbsp;&nbsp;{$GLOBALS['strNoZonesToLinkToCampaign']}</td>
</tr>
<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    }

    echo "
</table>";


    echo "
<br /><br />
<input type='submit' name='submit' value='{$GLOBALS['strSaveChanges']}' tabindex='$tabindex'>";
    $tabindex++;

    echo "
</form>";



    /*-------------------------------------------------------*/
    /* Form requirements                                     */
    /*-------------------------------------------------------*/

    ?>

    <script language='Javascript'>
    <!--
        affiliates = new Array();
    <?php
        if (!empty($aPublishersZones)) {
            foreach ($aPublishersZones as $publisherId => $aPublishersZone) {
                if (!empty($aPublishersZone['children'])) {
                    $num = count($aPublishersZone['children']);
                    echo "
affiliates[$publisherId] = $num;";
                }
            }
        }
    ?>

        function showMessage(message)
        {
            var result = confirm(message);

            if (result)
            {
	             return true ;
            }
            else
            {
	             return false ;
            }
        }


        function toggleAffiliate(affiliateid)
        {
            var count = 0;
            var affiliate;

            for (var i=0; i<document.zones.elements.length; i++)
            {
                if (document.zones.elements[i].name == 'affiliate[' + affiliateid + ']')
                    affiliate = i;

                if (document.zones.elements[i].id == 'a' + affiliateid + '' &&
                    document.zones.elements[i].checked)
                    count++;
            }

            document.zones.elements[affiliate].checked = (count == affiliates[affiliateid]);
        }

        function toggleZones(affiliateid)
        {
            var checked

            for (var i=0; i<document.zones.elements.length; i++)
            {
                if (document.zones.elements[i].name == 'affiliate[' + affiliateid + ']') {
                    if (!document.zones.elements[i].disabled) {
                        checked = document.zones.elements[i].checked;
                    }
                }

                if (document.zones.elements[i].id == 'a' + affiliateid + '') {
                    if (!document.zones.elements[i].disabled) {
                        document.zones.elements[i].checked = checked;
                    }
                }
            }
        }

        function toggleAllZones(zonesList)
        {
            var zonesArray, checked, selectAllField;

            selectAllField = document.getElementById('selectAllField');

            zonesArray = zonesList.split('|');

            for (var i=0; i<document.zones.elements.length; i++) {

                if (selectAllField.checked == true) {
                    document.zones.elements[i].checked = true;
                } else {
                    document.zones.elements[i].checked = false;
                }
            }
        }

    //-->
    </script>

<?php

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs'][$pageName]['listorder'] = $listorder;
$session['prefs'][$pageName]['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
