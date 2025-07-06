<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);
OA_Permission::enforceAccessToObject('banners', $bannerid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();


// Get input parameters
$advertiserId = MAX_getValue('clientid');
$campaignId = MAX_getValue('campaignid');
$bannerId = MAX_getValue('bannerid');
$aCurrentZones = MAX_getValue('includezone');
$listorder = MAX_getStoredValue('listorder', 'name');
$orderdirection = MAX_getStoredValue('orderdirection', 'up');
$submit = MAX_getValue('submit');

// Get zone filter parameters
$zoneFilterWebsite = MAX_commonGetValue('filterWebsite');
$zoneFilterZone = MAX_commonGetValue('filterZone');
$zoneFilterZoneType = MAX_commonGetValue('filterZoneType[]');
$zoneFilterZoneDimensionsToggle = MAX_commonGetValue('filterZoneDimensionsToggle');
$zoneFilterZoneDimensionsWidth = MAX_commonGetValue('filterZoneDimensionsWidth');
$zoneFilterZoneDimensionsHeight = MAX_commonGetValue('filterZoneDimensionsHeight');

// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = ['clientid' => $advertiserId, 'campaignid' => $campaignId, 'bannerid' => $bannerId];

// Process submitted form
if (isset($submit)) {
    OA_Permission::checkSessionToken();

    $dalZones = OA_Dal::factoryDAL('zones');
    $prioritise = false;
    $error = false;
    $aPreviousZones = Admin_DA::getAdZones(['ad_id' => $bannerId]);
    $aDeleteZones = [];

    // First, remove any zones that should be deleted.
    if (!empty($aPreviousZones)) {
        $unlinked = 0;
        foreach ($aPreviousZones as $aAdZone) {
            $zoneId = $aAdZone['zone_id'];
            if ((empty($aCurrentZones[$zoneId])) && ($zoneId > 0)) {
                // Schedule for deletion
                $aDeleteZones[] = $zoneId;
            } else {
                // Remove this key, because it is already there and does not need to be added again.
                unset($aCurrentZones[$zoneId]);
            }
        }
    }

    // Unlink zones
    if (!empty($aDeleteZones)) {
        $unlinked = $dalZones->unlinkZonesFromBanner($aDeleteZones, $bannerId);
        if ($unlinked > 0) {
            $prioritise = true;
        } elseif ($unlinked == -1) {
            $error = true;
        }
    }

    // Link zones
    if (!empty($aCurrentZones)) {
        $linked = $dalZones->linkZonesToBanner(array_keys($aCurrentZones), $bannerId);
        if (PEAR::isError($linked)
            || $linked == -1) {
            $error = $linked;
        } elseif ($linked > 0) {
            $prioritise = true;
        }
    }

    if ($prioritise) {
        // Run the Maintenance Priority Engine process
        OA_Maintenance_Priority::scheduleRun();
    }

    // Move on to the next page
    if (!$error) {
        // Queue confirmation message
        $translation = new OX_Translation();
        if ($linked > 0) {
            $linked_message = $translation->translate($GLOBALS['strXZonesLinked'], [$linked]);
        }
        if ($unlinked > 0) {
            $unlinked_message = $translation->translate($GLOBALS['strXZonesUnlinked'], [$unlinked]);
        }
        if ($linked > 0 || $unlinked > 0) {
            $translated_message = $linked_message . ($linked_message != '' && $unlinked_message != '' ? ', ' : ' ') . $unlinked_message;
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        }

        Header("Location: banner-zone.php?clientid={$clientid}&campaignid={$campaignid}&bannerid={$bannerid}");
        exit;
    }
}

// Display navigation
$aOtherCampaigns = Admin_DA::getPlacements(['agency_id' => $agencyId]);
$aOtherBanners = Admin_DA::getAds(['placement_id' => $campaignId], false);
MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities);

// Main code
$aAd = Admin_DA::getAd($bannerId);
$aParams = ['agency_id' => $agencyId];
$aExtraParams = [];
if ($aAd['type'] == 'txt') {
    // If the banner is a text banner, only select zones (and their parent
    // publishers) where the zone type is a text zone
    $aParams['zone_type'] = phpAds_ZoneText;
} else {
    // Only select zones (and their parent publishers) where the zone
    // dimensions are a match for the banner
    $aParams['zone_width'] = $aAd['width'] . ',-1';
    $aParams['zone_height'] = $aAd['height'] . ',-1';
    if ($aAd['type'] == 'html') {
        // In addition, if the banner is an HTML banner, only select zones
        // (and their parent publishers) where the zone type is NOT an
        // email/newsletter zone
        $aTypes = [
            phpAds_ZoneBanner,
            phpAds_ZoneInterstitial,
            phpAds_ZonePopup,
            MAX_ZoneClick,
            OX_ZoneVideoInstream,
            OX_ZoneVideoOverlay,
        ];
        $aExtraParams['zone_type'] = implode(',', $aTypes);
    }
}
$aPublishers = Admin_DA::getPublishers($aParams, true);
$aLinkedZones = Admin_DA::getAdZones(['ad_id' => $bannerId], false, 'zone_id');

?>

<section id="zone-filter">
    <p class="inlineIcon iconFilter"><b><?php echo $GLOBALS["str"] ?></b></p>

<!--    --><?php
//
//    $zoneFilterForm = new OA_Admin_UI_Component_Form("zoneFilter", "GET", ".");
//
//    // Remove unnecessary hidden form inputs
//    $zoneFilterForm->removeElement("_qf__zoneFilter");
//    $zoneFilterForm->removeElement("token");
//
//    // Add hidden form inputs corresponding to required IDs
//    $zoneFilterForm->addElement('hidden', 'clientid', $advertiserId);
//    $zoneFilterForm->addElement('hidden', 'campaignid', $campaignId);
//    $zoneFilterForm->addElement('hidden', 'bannerid', $bannerId);
//
//    // Add 'search by name' filters
//    $zoneFilterForm->addElement("text", "zoneFilterWebsite", $GLOBALS["strWebsite"]);
//    $zoneFilterForm->addElement("text", "zoneFilterZone", $GLOBALS["strZone"]);
//
//    $zoneFilterForm->display();
//
//    ?>

    <?php

    $iabSizes = [];

    foreach(array_keys($phpAds_IAB) as $iabKey)
    {
        $iabSizes[$phpAds_IAB[$iabKey]["width"] . "x" . $phpAds_IAB[$iabKey]["height"]] = $GLOBALS["strIab"][$iabKey];
    }

    $iabSizes["-"] = $GLOBALS["strCustom"];

    ?>

    <form action="<?= $pageName; ?>" method="get" style="display: grid; grid-template-columns: repeat(2, max-content); grid-template-rows: repeat(4, max-content); justify-content: left">
        <input type='hidden' name='clientid' value='<?=$advertiserId ?>'>
        <input type='hidden' name='campaignid' value='<?= $campaignId ?>'>
        <input type='hidden' name='bannerid' value='<?= $bannerId ?>'>

        <div style="margin: 15px auto">
            <label for="filter-website" class="inlineIcon iconWebsite"><?= $GLOBALS["strWebsite"] ?></label>
            <input type="text" name="filterWebsite" id="filter-website" placeholder="website.com" value="<?= $zoneFilterWebsite ?>">
        </div>

       <div style="margin: 15px auto">
           <label for="filter-zone" class="inlineIcon iconZone"><?= $GLOBALS["strZone"] ?></label>
           <input type="text" name="filterZone" id="filter-zone" placeholder="Homepage" value="<?= $zoneFilterZone ?>">
       </div>

        <div style="margin: 15px auto">
            <?= $GLOBALS["strZoneType"] ?><br>
            <input type="checkbox" id="filter-zone-type-banner" name="filterZoneType[]" value="<?= phpAds_ZoneBanner ?>">
            <label for="filter-zone-type-banner" class="inlineIcon iconZone"><?= $GLOBALS["strBannerButtonRectangle"] ?></label><br>
            <input type="checkbox" id="filter-zone-type-text-ad" name="filterZoneType[]" value="<?= phpAds_ZoneText ?>">
            <label for="filter-zone-type-text-ad" class="inlineIcon iconZoneText"><?= $GLOBALS["strTextAdZone"] ?></label><br>
            <input type="checkbox" id="filter-zone-type-email" name="filterZoneType[]" value="<?= MAX_ZoneEmail ?>">
            <label for="filter-zone-type-email" class="inlineIcon iconZoneEmail"><?= $GLOBALS["strEmailAdZone"] ?></label><br>
            <input type="checkbox" id="filter-zone-type-inline-video-ad" name="filterZoneType[]" value="<?= OX_ZoneVideoInstream ?>">
            <label for="filter-zone-type-inline-video-ad" class="inlineIcon iconZoneVideoInstream"><?= $GLOBALS["strZoneVideoInstream"] ?></label><br>
            <input type="checkbox" id="filter-zone-type-overlay-video-ad" name="filterZoneType[]" value="<?= OX_ZoneVideoOverlay ?>">
            <label for="filter-zone-type-overlay-video-ad" class="inlineIcon iconZoneVideoOverlay"><?= $GLOBALS["strZoneVideoOverlay"] ?></label><br>
        </div>

        <div style="margin: 15px auto">
            <input type="checkbox" id="filter-zone-dimensions-toggle" name="filterZoneDimensionsToggle" value="1" onchange="onFilterZoneDimensionsToggleChange(event)">
            <label for="filter-zone-dimensions-toggle"><?= $GLOBALS["strSize"] ?></label><br>
            <select id="filter-zone-dimensions-dropdown" onchange="onFilterZoneDimensionsDropdownChange(event)">
                <?php

                foreach ($iabSizes as $size => $option)
                {
                    echo
                    "
                        <option value='$size'>$option</option>
                    ";
                }

                ?>
            </select>
            <br>
            <input onchange="onFilterZoneDimensionsSizeChange(event)" type="text" name="filterZoneDimensionsWidth" id="filter-zone-dimensions-width" placeholder="Width (in px)">
            x
            <input onchange="onFilterZoneDimensionsSizeChange(event)" type="text" name="filterZoneDimensionsHeight" id="filter-zone-dimensions-height" placeholder="Height (in px)">
        </div>

        <div style="margin: 15px auto">
            <input type="reset" value="<?= $GLOBALS["strClear"] ?>">
            <input type="submit" value="<?= $GLOBALS["strZonesSearch"] ?>">
        </div>
    </form>

    <script>
        const onFilterZoneDimensionsToggleChange = (event) =>
        {
            const toggle = event.target.checked;

            $("#filter-zone-dimensions-dropdown")[0].disabled = !toggle;
            $("#filter-zone-dimensions-width")[0].disabled = !toggle;
            $("#filter-zone-dimensions-height")[0].disabled = !toggle;
        }

        const onFilterZoneDimensionsDropdownChange = (event) =>
        {
            const valueSelected = event.target.value;

            const filterZoneDimensionsWidth = $("#filter-zone-dimensions-width");
            const filterZoneDimensionsHeight = $("#filter-zone-dimensions-height");

            if (valueSelected === "-")
            {
                filterZoneDimensionsWidth.val("*");
                filterZoneDimensionsHeight.val("*");
            }
            else
            {
                const [width, height] = valueSelected.split('x');
                filterZoneDimensionsWidth.val(width);
                filterZoneDimensionsHeight.val(height);
            }
        }

        const onFilterZoneDimensionsSizeChange = (event) =>
        {
            const filterZoneDimesionsDropdown = $("#filter-zone-dimensions-dropdown")[0];
            const size = `${$("#filter-zone-dimensions-width").val()}x${$("#filter-zone-dimensions-height").val()}`;
            for (const option of filterZoneDimesionsDropdown.options)
            {
                if (option.value === size)
                {
                    option.selected = true;
                    return;
                }
            }
            filterZoneDimesionsDropdown.options[filterZoneDimesionsDropdown.options.length - 1].selected = true;
        }
    </script>
</section>

<?php

echo "
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<form name='zones' action='$pageName' method='post'>
<input type='hidden' name='clientid' value='$advertiserId'>
<input type='hidden' name='campaignid' value='$campaignId'>
<input type='hidden' name='bannerid' value='$bannerId'>
<input type='hidden' name='token' value='" . htmlspecialchars(phpAds_SessionGetToken(), ENT_QUOTES) . "'>";

MAX_displayZoneHeader($pageName, $listorder, $orderdirection, $aEntities);

if ($error) {
    $errorMoreInformation = '';
    if (PEAR::isError($error)) {
        $errorMoreInformation = $error->getMessage();
    }
    // Message
    echo "<br>";
    echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'>";
    echo "<span class='tab-r'> {$GLOBALS['strUnableToLinkBanner']}</span><br /><br />";
    echo "{$GLOBALS['strErrorLinkingBanner']} <br />" . $errorMoreInformation . "</div><br />";
} else {
    echo "<br /><br />";
}

// Filter out websites by name
$aPublishers = array_filter(
        $aPublishers,
        function ($aPublisher) use ($zoneFilterWebsite)
        {
            if(!empty($zoneFilterWebsite))
            {
                return strstr($aPublisher['name'], $zoneFilterWebsite);
            }

            return true;
        }
);

$zoneToSelect = false;
if (!empty($aPublishers)) {
    MAX_sortArray($aPublishers, ($listorder == 'id' ? 'publisher_id' : $listorder), $orderdirection == 'up');
    $i = 0;

    //select all checkboxes
    $publisherIdList = '';
    foreach ($aPublishers as $publisherId => $aPublisher) {
        $publisherIdList .= $publisherId . '|';
    }

    echo "<input type='checkbox' id='selectAllField' onClick='toggleAllZones(\"" . $publisherIdList . "\");'><label for='selectAllField'>" . $strSelectUnselectAll . "</label>";

    foreach ($aPublishers as $publisherId => $aPublisher) {
        $publisherName = $aPublisher['name'];
        $aZones = Admin_DA::getZones($aParams + $aExtraParams + ['publisher_id' => $publisherId], true);

        // Filter out zones by name
        $aZones = array_filter(
                $aZones,
                function ($aZone) use ($zoneFilterZone)
                {
                    if(!empty($zoneFilterZone))
                    {
                        return strstr($aZone['name'], $zoneFilterZone);
                    }

                    return true;
                }
        );

        if (!empty($aZones)) {
            $zoneToSelect = true;
            $bgcolor = ($i % 2 == 0) ? " bgcolor='#F6F6F6'" : '';
            $bgcolorSave = $bgcolor;

            $allchecked = true;
            foreach ($aZones as $zoneId => $aZone) {
                if (!isset($aLinkedZones[$zoneId])) {
                    $allchecked = false;
                    break;
                }
            }
            $checked = $allchecked ? ' checked' : '';
            if ($i > 0) {
                echo "
<tr height='1'>
    <td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
</tr>";
            }
            echo "
<tr height='25'$bgcolor>
    <td>
        <table>
            <tr>
                <td>&nbsp;</td>
                <td valign='top'><input id='affiliate$publisherId' name='affiliate[$publisherId]' type='checkbox' value='t'$checked onClick='toggleZones($publisherId);' tabindex='$tabindex'>&nbsp;&nbsp;</td>
                <td valign='top'><img src='" . OX::assetPath() . "/images/icon-affiliate.gif' align='absmiddle'>&nbsp;</td>
                <td><a href='affiliate-edit.php?affiliateid=$publisherId'>" . htmlspecialchars($publisherName) . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table>
    </td>
    <td>$publisherId</td>
    <td height='25'>&nbsp;</td>
</tr>";

            $tabindex++;
            if (!empty($aZones)) {
                MAX_sortArray($aZones, ($listorder == 'id' ? 'zone_id' : $listorder), $orderdirection == 'up');
                foreach ($aZones as $zoneId => $aZone) {
                    $zoneName = $aZone['name'];
                    $zoneDescription = $aZone['description'];
                    $zoneIsActive = isset($aZone['active']) && $aZone['active'] == 't';
                    $zoneIcon = MAX_getEntityIcon('zone', $zoneIsActive, $aZone['type']);
                    $checked = isset($aLinkedZones[$zoneId]) ? ' checked' : '';
                    $bgcolor = ($checked == ' checked') ? " bgcolor='#d8d8ff'" : $bgcolorSave;

                    echo "
<tr height='25'$bgcolor>
    <td>
        <table>
            <tr>
                <td width='28'>&nbsp;</td>
                <td valign='top'><input name='includezone[$zoneId]' id='a$publisherId' type='checkbox' value='t'$checked onClick='toggleAffiliate($publisherId);' tabindex='$tabindex'>&nbsp;&nbsp;</td>
                <td valign='top'><img src='$zoneIcon' align='absmiddle'>&nbsp;</td>
                <td><a href='zone-edit.php?affiliateid=$publisherId&zoneid=$zoneId'>" . htmlspecialchars($zoneName) . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table>
    </td>
    <td>$zoneId</td>
    <td>" . htmlspecialchars($zoneDescription) . "</td>
</tr>";
                }
            }
            $i++;
        }
    }
    echo "
<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
}
if (!$zoneToSelect) {
    echo "
<tr height='25' bgcolor='#F6F6F6'>
    <td colspan='4'>&nbsp;&nbsp;{$GLOBALS['strNoZonesToLinkToCampaign']}</td>
</tr>
<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
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
                if (document.zones.elements[i].name == 'affiliate[' + affiliateid + ']')
                    checked = document.zones.elements[i].checked;

                if (document.zones.elements[i].id == 'a' + affiliateid + '')
                    document.zones.elements[i].checked = checked;
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
