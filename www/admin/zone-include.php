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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/common.php';;
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid);

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OA_Permission::enforceAllowed(OA_PERM_ZONE_LINK);
}

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();

    // Get input parameters
    $pref =& $GLOBALS['_MAX']['PREF'];
    $publisherId    = MAX_getValue('affiliateid');
    $zoneId         = MAX_getValue('zoneid');
    $advertiserId   = MAX_getValue('clientid');
    $placementId    = MAX_getValue('campaignid');
    $adId           = MAX_getValue('bannerid');
    $action         = MAX_getValue('action');
    $aCurrent       = MAX_getValue('includebanner');
    $hideInactive   = MAX_getStoredValue('hideinactive', ($pref['ui_hide_inactive'] == true), null, true);
    $listorder      = MAX_getStoredValue('listorder', 'name');
    $orderdirection = MAX_getStoredValue('orderdirection', 'up');
    $selection      = MAX_getValue('selection');
    $showMatchingAds = MAX_getStoredValue('showbanners', ($pref['ui_show_matching_banners'] == true), null, true);
    $showParentPlacements = MAX_getStoredValue('showcampaigns', ($pref['ui_show_matching_banners_parents'] == true), null, true);
    $submit         = MAX_getValue('submit');
    $view           = MAX_getStoredValue('view', 'placement');

    $aZone = Admin_DA::getZone($zoneId);

    if ($aZone['type'] == MAX_ZoneEmail) {
        $view = 'ad';
    }

    // Initialise some parameters
    $pageName = basename($_SERVER['SCRIPT_NAME']);
    $tabIndex = 1;
    $agencyId = OA_Permission::getAgencyId();
    $aEntities = array('affiliateid' => $publisherId, 'zoneid' => $zoneId);

    if (isset($action)) {
        $result = true;
        if ($action == 'set' && $view == 'placement' && !empty($placementId)) {
            $aLinkedPlacements = Admin_DA::getPlacementZones(array('zone_id' => $zoneId), false, 'placement_id');
            if (!isset($aLinkedPlacements[$placementId])) {
                Admin_DA::addPlacementZone(array('zone_id' => $zoneId, 'placement_id' => $placementId));
            }

            MAX_addLinkedAdsToZone($zoneId, $placementId);

            // Queue confirmation message
            $translation = new OX_Translation ();
            $translated_message = $translation->translate ( $GLOBALS['strZoneLinkedCampaign'], array(
                MAX::constructURL(MAX_URL_ADMIN, 'zone-edit.php?affiliateid=' .  $publisherId . '&zoneid=' . $zoneId),
                htmlspecialchars($aZone['name'])
            ));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        } elseif ($action == 'set' && $view == 'ad' && !empty($adId)) {
            $aLinkedAds = Admin_DA::getAdZones(array('zone_id' => $zoneId), false, 'ad_id');
            if (!isset($aLinkedAds[$adId])) {
                $result = Admin_DA::addAdZone(array('zone_id' => $zoneId, 'ad_id' => $adId));
            }
            if (!PEAR::isError($result)) {
                // Queue confirmation message
                $translation = new OX_Translation();
                $translated_message = $translation->translate ( $GLOBALS['strZoneLinkedBanner'], array(
                    MAX::constructURL(MAX_URL_ADMIN, 'zone-edit.php?affiliateid=' .  $publisherId . '&zoneid=' . $zoneId),
                    htmlspecialchars($aZone['name'])
                ));
                OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
            }
        } elseif ($action == 'remove' && !empty($placementId) && empty($adId)) {
            Admin_DA::deletePlacementZones(array('zone_id' => $zoneId, 'placement_id' => $placementId));

            // Queue confirmation message
            $translation = new OX_Translation();
            $translated_message = $translation->translate ( $GLOBALS['strZoneRemovedCampaign'], array(
                MAX::constructURL(MAX_URL_ADMIN, 'zone-edit.php?affiliateid=' .  $publisherId . '&zoneid=' . $zoneId),
                htmlspecialchars($aZone['name'])
            ));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        } elseif ($action == 'remove' && !empty($adId) && empty($placementId)) {
            Admin_DA::deleteAdZones(array('zone_id' => $zoneId, 'ad_id' => $adId));

            // Queue confirmation message
            $translation = new OX_Translation ();
            $translated_message = $translation->translate ( $GLOBALS['strZoneRemovedBanner'], array(
                MAX::constructURL(MAX_URL_ADMIN, 'zone-edit.php?affiliateid=' .  $publisherId . '&zoneid=' . $zoneId),
                htmlspecialchars($aZone['name'])
            ));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        }
        if (!PEAR::isError($result)) {
            // Run the Maintenance Priority Engine process
            OA_Maintenance_Priority::scheduleRun();

            Header("Location: zone-include.php?affiliateid=$publisherId&zoneid=$zoneId");
            exit;
        }
    }

    if (isset($submit)) {
        switch ($view) {
            case 'placement' :
                $aPrevious = Admin_DA::getPlacementZones(array('zone_id' => $zoneId));
                $key = 'placement_id';
                break;
            case 'ad' :
                $aPrevious = Admin_DA::getAdZones(array('zone_id' => $zoneId));
                $key = 'ad_id';
                break;
        }

        // First, remove any placements/adverts that should be deleted.
        if (!empty($aPrevious)) {
            foreach ($aPrevious as $aZoneAssoc) {
                $id = $aZoneAssoc[$key];
                if (empty($aCurrent[$id])) {
                    // The user has removed this zone link
                    $aParameters = array('zone_id' => $zoneId, $key => $id);
                    if ($view == 'placement') {
                        Admin_DA::deletePlacementZones($aParameters);
                    } else {
                        Admin_DA::deleteAdZones($aParameters);
                    }
                } else {
                    // Remove this key, because it is already there and does not need to be added again.
                    unset($aCurrent[$id]);
                }
            }
        }

        $addResult = true;
        if (!empty($aCurrent)) {
            foreach ($aCurrent as $id => $value) {
                $aVariables = array('zone_id' => $zoneId, $key => $id);
                if ($view == 'placement') {
                    $addResult = Admin_DA::addPlacementZone($aVariables);
                } else {
                    $addResult = Admin_DA::addAdZone($aVariables);
                }
            }
        }

        if (!$addResult) {
            Header("Location: zone-include.php?affiliateid=$publisherId&zoneid=$zoneId");
            exit;
        }
        // Move on to the next page
        Header("Location: zone-probability.php?affiliateid=$publisherId&zoneid=$zoneId");
        exit;
    }
    // Display initial parameters...
    $tabIndex = 1;

    $aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
    $aOtherZones = Admin_DA::getZones(array('publisher_id' => $publisherId));
    MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);

    if (!empty($action) && PEAR::isError($result)) {
        // Message
        echo "<br>";
        echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'>";
        echo "<span class='tab-r'> {$GLOBALS['strUnableToLinkBanner']}</span><br /><br />";
        echo "{$GLOBALS['strErrorLinkingBanner']} <br />" . $result->message . "</div><br />";
    }

    MAX_displayPlacementAdSelectionViewForm($publisherId, $zoneId, $view, $pageName, $tabIndex, $aOtherZones);

    $aParams = MAX_getLinkedAdParams($zoneId);

    if ($view == 'placement') {
        $aDirectLinkedAds = Admin_DA::getAdZones(array('zone_id' => $zoneId), true, 'ad_id');
        $aOtherAdvertisers = Admin_DA::getAdvertisers($aParams + array('agency_id' => $agencyId), false);
        $aOtherPlacements = !empty($advertiserId) ? Admin_DA::getPlacements($aParams + array('advertiser_id' => $advertiserId), false) : null;
        $aZonesPlacements = Admin_DA::getPlacementZones(array('zone_id' => $zoneId), true, 'placement_id');
        MAX_displayZoneEntitySelection('placement', $aOtherAdvertisers, $aOtherPlacements, null, $advertiserId, $placementId, $adId, $publisherId, $zoneId, $GLOBALS['strSelectCampaignToLink'], $pageName, $tabIndex);
        if (!empty($aZonesPlacements)) {
	        $aParams = array('placement_id' => implode(',', array_keys($aZonesPlacements)));
	        $aParams += MAX_getLinkedAdParams($zoneId);
        } else {
            $aParams = null;
        }
        MAX_displayLinkedPlacementsAds($aParams, $publisherId, $zoneId, $hideInactive, $showMatchingAds, $pageName, $tabIndex, $aDirectLinkedAds);
    } elseif ($view == 'ad') {
        $aOtherAdvertisers = Admin_DA::getAdvertisers($aParams + array('agency_id' => $agencyId), false);
        $aOtherPlacements = !empty($advertiserId) ? Admin_DA::getPlacements($aParams + array('advertiser_id' => $advertiserId), false) : null;
        $aOtherAds = !empty($placementId) ? Admin_DA::getAds($aParams + array('placement_id' => $placementId), false) : null;
        $aAdsZones = Admin_DA::getAdZones(array('zone_id' => $zoneId), true, 'ad_id');
        MAX_displayZoneEntitySelection('ad', $aOtherAdvertisers, $aOtherPlacements, $aOtherAds, $advertiserId, $placementId, $adId, $publisherId, $zoneId, $GLOBALS['strSelectBannerToLink'], $pageName, $tabIndex);
        $aParams = !empty($aAdsZones) ? array('ad_id' => implode(',', array_keys($aAdsZones))) : null;
        MAX_displayLinkedAdsPlacements($aParams, $publisherId, $zoneId, $hideInactive, $showParentPlacements, $pageName, $tabIndex);
    }
?>

    <script language='Javascript'>
    <!--
        function toggleall()
        {
            allchecked = false;

            for (var i=0; i<document.zonetypeselection.elements.length; i++)
            {
                if (document.zonetypeselection.elements[i].name == 'bannerid[]' ||
                    document.zonetypeselection.elements[i].name == 'campaignid[]')
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
                    document.zonetypeselection.elements[i].name == 'campaignid[]')
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
                    document.zonetypeselection.elements[i].name == 'campaignid[]')
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

    $session['prefs'][$pageName]['hideinactive'] = $hideInactive;
    $session['prefs'][$pageName]['showbanners'] = $showMatchingAds;
    $session['prefs'][$pageName]['showcampaigns'] = $showParentPlacements;
    $session['prefs'][$pageName]['listorder'] = $listorder;
    $session['prefs'][$pageName]['orderdirection'] = $orderdirection;
    if ($aOtherZones[$zoneId]['type'] != MAX_ZoneEmail) {
        $session['prefs'][$pageName]['view'] = $view;
    }

    phpAds_SessionDataStore();

    phpAds_PageFooter();

?>
