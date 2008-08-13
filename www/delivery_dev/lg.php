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

/**
 * @package    MaxDelivery
 * @author     Scott Switzer <scott@switzer.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
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

//$aOverrideAdIds = MAX_marketplaceLogGetIds();

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

if (isset($_REQUEST['channel_ids'])) {
    $GLOBALS['_MAX']['CHANNELS'] = str_replace(
        $GLOBALS['_MAX']['CONF']['delivery']['chDelimiter'],
        $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'],
        $_REQUEST['channel_ids']
    );
}

// Loop over the ads to be logged (there may be more than one due to internal re-directs)
// and log each ad, and then set any capping cookies required
$countAdIds = count($aAdIds);
for ($index = 0; $index < $countAdIds; $index++) {
    // Ensure that each ad to be logged has campaign, creative and zone
    // values set, and that all values are integers
    MAX_Delivery_log_ensureIntegerSet($aAdIds, $index);
    MAX_Delivery_log_ensureIntegerSet($aCampaignIds, $index);
    MAX_Delivery_log_ensureIntegerSet($aCreativeIds, $index);
    MAX_Delivery_log_ensureIntegerSet($aZoneIds, $index);
    if ($aAdIds[$index] > 0) {
        // Override with marketplace ads, if any
        $adId = isset($aOverrideAdIds[$index]) ? $aOverrideAdIds[$index] : $aAdIds[$index];
        // Log the ad impression, if required
        if ($GLOBALS['_MAX']['CONF']['logging']['adImpressions']) {
            MAX_Delivery_log_logAdImpression($viewerId, $adId, $aCreativeIds[$index], $aZoneIds[$index]);
        }
        if ($aAdIds[$index] == $adId) {
            // Set the capping cookies, if required
            MAX_Delivery_log_setAdLimitations($index, $aAdIds, $aCapAd);
            MAX_Delivery_log_setCampaignLimitations($index, $aCampaignIds, $aCapCampaign);
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
