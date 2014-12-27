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

/**
 * @package    MaxDelivery
 */

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/querystring.php';

// Prevent the logging beacon from being cached by browsers
MAX_commonSetNoCacheHeaders();

// Remove any special characters from the request variables
MAX_commonRemoveSpecialChars($_REQUEST);

// Get the viewer ID, and the ad, campaign, creative and zone variables to be logged
// from the request variables
$viewerId     = MAX_cookieGetUniqueViewerId();
MAX_cookieAdd($conf['var']['viewerId'], $viewerId, _getTimeYearFromNow());

$aAdIds       = MAX_Delivery_log_getArrGetVariable('adId');
$aCampaignIds = MAX_Delivery_log_getArrGetVariable('campaignId');
$aCreativeIds = MAX_Delivery_log_getArrGetVariable('creativeId');
$aZoneIds     = MAX_Delivery_log_getArrGetVariable('zoneId');

// Get any ad, campaign and zone capping information from the request variables
$aCapAd['block']                 = MAX_Delivery_log_getArrGetVariable('blockAd');
$aCapAd['capping']               = MAX_Delivery_log_getArrGetVariable('capAd');
$aCapAd['session_capping']       = MAX_Delivery_log_getArrGetVariable('sessionCapAd');
$aCapCampaign['block']           = MAX_Delivery_log_getArrGetVariable('blockCampaign');
$aCapCampaign['capping']         = MAX_Delivery_log_getArrGetVariable('capCampaign');
$aCapCampaign['session_capping'] = MAX_Delivery_log_getArrGetVariable('sessionCapCampaign');
$aCapZone['block']               = MAX_Delivery_log_getArrGetVariable('blockZone');
$aCapZone['capping']             = MAX_Delivery_log_getArrGetVariable('capZone');
$aCapZone['session_capping']     = MAX_Delivery_log_getArrGetVariable('sessionCapZone');
$aSetLastSeen                    = MAX_Delivery_log_getArrGetVariable('lastView');

// Loop over the ads to be logged (there may be more than one due to internal re-directs)
// and log each ad, and th  en set any capping cookies required
$countAdIds = count($aAdIds);
for ($index = 0; $index < $countAdIds; $index++) {
    // Ensure that each ad to be logged has campaign, creative and zone
    // values set, and that all values are integers
    MAX_Delivery_log_ensureIntegerSet($aAdIds, $index);
    MAX_Delivery_log_ensureIntegerSet($aCampaignIds, $index);
    MAX_Delivery_log_ensureIntegerSet($aCreativeIds, $index);
    MAX_Delivery_log_ensureIntegerSet($aZoneIds, $index);
    if ($aAdIds[$index] >= -1) {
        $adId = $aAdIds[$index];
        // Log the ad impression, if required
        if ($GLOBALS['_MAX']['CONF']['logging']['adImpressions']) {
            MAX_Delivery_log_logAdImpression($adId, $aZoneIds[$index]);
        }
        if ($aAdIds[$index] == $adId) {
            // Set the capping cookies, if required
            MAX_Delivery_log_setAdLimitations($index, $aAdIds, $aCapAd);
            MAX_Delivery_log_setCampaignLimitations($index, $aCampaignIds, $aCapCampaign);
            MAX_Delivery_log_setLastAction($index, $aAdIds, $aZoneIds, $aSetLastSeen);
            if ($aZoneIds[$index] != 0) {
                MAX_Delivery_log_setZoneLimitations($index, $aZoneIds, $aCapZone);
            }
        }
    }
}

MAX_cookieFlush();
MAX_querystringConvertParams();

if (!empty($_REQUEST[$GLOBALS['_MAX']['CONF']['var']['dest']])) {
    MAX_redirect($_REQUEST[$GLOBALS['_MAX']['CONF']['var']['dest']]);
} else {
    // Display a 1x1 pixel gif
    MAX_commonDisplay1x1();
}

// Run automaintenance, if needed
if (!empty($GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenance']) && empty($GLOBALS['_MAX']['CONF']['lb']['enabled'])) {
    if (MAX_cacheCheckIfMaintenanceShouldRun()) {
        include MAX_PATH . '/lib/OA/Maintenance/Auto.php';
        OA_Maintenance_Auto::run();
    }
}

?>
