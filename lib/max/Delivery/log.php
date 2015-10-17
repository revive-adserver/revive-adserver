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

$file = '/lib/max/Delivery/log.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * @package    MaxDelivery
 *
 * A file to contain delivery engine functions related to logging of raw
 * data to the database.
 */

require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/tracker.php';

/**
 * A function to log an ad request.
 *
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $zoneId The zone ID.
 * @param array   $aAd The ad-array (see page DocBlock); contains ad_id, zone_id, and all other available fields
 */
function MAX_Delivery_log_logAdRequest($adId, $zoneId, $aAd = array())
{
    // Only log requests if request logging is enabled
    if (empty($GLOBALS['_MAX']['CONF']['logging']['adRequests'])) { return true; }

    // Call all registered plugins that use the "logRequest" hook
    OX_Delivery_Common_hook('logRequest', array($adId, $zoneId, $aAd, _viewersHostOkayToLog($adId, $zoneId)));
}

/**
 * A function to log an ad impression.
 *
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $zoneId The zone ID.
 */
function MAX_Delivery_log_logAdImpression($adId, $zoneId)
{
    // Only log impressions if impression logging is enabled
    if (empty($GLOBALS['_MAX']['CONF']['logging']['adImpressions'])) { return true; }

    // Call all registered plugins that use the "logImpression" hook
    OX_Delivery_Common_hook('logImpression', array($adId, $zoneId, _viewersHostOkayToLog($adId, $zoneId)));
}

/**
 * A function to log an ad click.
 *
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $zoneId The zone ID.
 */
function MAX_Delivery_log_logAdClick($adId, $zoneId)
{
    // Only log clicks if click logging is enabled
    if (empty($GLOBALS['_MAX']['CONF']['logging']['adClicks'])) { return true; }

    // Call all registered plugins that use the "logClick" hook
    OX_Delivery_Common_hook('logClick', array($adId, $zoneId, _viewersHostOkayToLog($adId, $zoneId)));
}

/**
 * A function to log a conversion.
 *
 * @param integer $trackerId The tracker ID the conversion is for,
 * @param array $aConversion An array of the conversion details, as returned from the
 *                           MAX_trackerCheckForValidAction() function.
 * @return mixed An array containing the server_conv_id and the server_raw_ip values,
 *               if the conversion was logged successfully, false otherwise.
 */
function MAX_Delivery_log_logConversion($trackerId, $aConversion)
{
    // Only log conversions if logging of tracker impressions logging is enabled
    if (empty($GLOBALS['_MAX']['CONF']['logging']['trackerImpressions'])) { return true; }

    // Prepare the raw database IP address, depending on if OpenX is running
    // with multiple delivery servers, or just a single server
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (!empty($aConf['lb']['enabled'])) {
        $aConf['rawDatabase']['host'] = $_SERVER['SERVER_ADDR'];
    } else {
        $aConf['rawDatabase']['host'] = 'singleDB';
    }
    if (isset($aConf['rawDatabase']['serverRawIp'])) {
        $serverRawIp = $aConf['rawDatabase']['serverRawIp'];
    } else {
        $serverRawIp = $aConf['rawDatabase']['host'];
    }
    // Call all registered plugins that use the "logConversion" hook
    $aConversionInfo = OX_Delivery_Common_hook('logConversion', array($trackerId, $serverRawIp, $aConversion, _viewersHostOkayToLog(null, null, $trackerId)));
    // Check that the conversion was logged correctly
    if (is_array($aConversionInfo)) {
        // Return the result
        return $aConversionInfo;
    }
    return false;
}

/**
 * A function to log tracker impression variable values.
 *
 * Note that the $aConf['rawDatabase'] variables will only be defined
 * in the event that OpenX is configured for multiple databases. Normally,
 * this will not be the case, so the server_ip field will be 'singleDB'.
 *
 * @param array $aVariables An array of variables as returned by
 *                          MAX_cacheGetTrackerVariables().
 * @param integer $trackerId The tracker ID.
 * @param integer $serverConvId The unique conversion ID value of the
 *                              conversion as logged on the raw database
 *                              server.
 * @param string $serverRawIp The IP address of the raw database server,
 *                            or the single server setup identifier.
 * @param string $pluginId    The plugin identifier.
 */
function MAX_Delivery_log_logVariableValues($aVariables, $trackerId, $serverConvId, $serverRawIp, $pluginId = null)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    // Get the variable information, including the Variable ID
    foreach ($aVariables as $aVariable) {
        if (isset($_GET[$aVariable['name']])) {
            $value = $_GET[$aVariable['name']];

            // Do not save variable if empty or if the JS engine set it to "undefined"
            if (!strlen($value) || $value == 'undefined') {
                unset($aVariables[$aVariable['variable_id']]);
                continue;
            }
            // Sanitize by datatype
            switch ($aVariable['type']) {
                case 'int':
                case 'numeric':
                    // Strip useless chars, such as currency
                    $value = preg_replace('/[^0-9.]/', '', $value);
                    $value = floatval($value);
                    break;
                case 'date':
                    if (!empty($value)) {
                        $value = date('Y-m-d H:i:s', strtotime($value));
                    } else {
                        $value = '';
                    }
                    break;
            }
        } else {
            // Do not save anything if the variable isn't set
            unset($aVariables[$aVariable['variable_id']]);
            continue;
        }
        $aVariables[$aVariable['variable_id']]['value'] = $value;
    }
    if (count($aVariables)) {
        OX_Delivery_Common_hook(
            'logConversionVariable',
            array($aVariables, $trackerId, $serverConvId, $serverRawIp, _viewersHostOkayToLog(null, null, $trackerId)),
            empty($pluginId) ? null : $pluginId.'Variable'
        );
    }
}

/**
 * A "private" function to check if the information to be logged should be
 * logged or ignored, on the basis of the viewer's IP address or hostname.
 *
 * @access private
 * @param integer $adId      The id of the ad being logged
 * @param integer $zoneId    The id of the zone being logged
 * @param integer $trackerId The id of the tracker being logged
 * @return boolean True if the information should be logged, or false if the
 *                 IP address or host name is in the list of hosts for which
 *                 information should not be logged.
 */

function _viewersHostOkayToLog($adId=0, $zoneId=0, $trackerId=0)
{
    $aConf = $GLOBALS['_MAX']['CONF'];

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    $okToLog = true;
    // Check the user-agent against the list of known browsers (if set)
    if (!empty($aConf['logging']['enforceUserAgents'])) {
        $aKnownBrowsers = explode('|', strtolower($aConf['logging']['enforceUserAgents']));
        $allowed = false;
        foreach ($aKnownBrowsers as $browser) {
            if (strpos($agent, $browser) !== false) {
                $allowed = true;
                break;
            }
        }
        OX_Delivery_logMessage('user-agent browser : '.$agent.' is '.($allowed ? '' : 'not ').'allowed', 7);
        if (!$allowed) {
            $GLOBALS['_MAX']['EVENT_FILTER_FLAGS'][] = 'enforceUserAgents';
            $okToLog = false;
        }
    }

    // Check the user-agent against the list of known bots (if set)
    if (!empty($aConf['logging']['ignoreUserAgents'])) {
        $aKnownBots = explode('|', strtolower($aConf['logging']['ignoreUserAgents']));
        foreach ($aKnownBots as $bot) {
            if (strpos($agent, $bot) !== false) {
                OX_Delivery_logMessage('user-agent '.$agent.' is a known bot '.$bot, 7);
                $GLOBALS['_MAX']['EVENT_FILTER_FLAGS'][] = 'ignoreUserAgents';
                $okToLog = false;
            }
        }
    }

    // Check if this IP address has been blocked
    if (!empty($aConf['logging']['ignoreHosts'])) {
        $hosts = str_replace(',', '|', $aConf['logging']['ignoreHosts']);
        $hosts = '#^('.$hosts.')$#i';

        // Format the hosts to ignore in a PCRE format
        $hosts = str_replace('.', '\.', $hosts);
        $hosts = str_replace('*', '[^.]+', $hosts);
        // Check if the viewer's IP address is in the ignore list
        if (preg_match($hosts, $_SERVER['REMOTE_ADDR'])) {
            OX_Delivery_logMessage('viewer\'s ip is in the ignore list '.$_SERVER['REMOTE_ADDR'], 7);
            $GLOBALS['_MAX']['EVENT_FILTER_FLAGS'][] = 'ignoreHosts_ip';
            $okToLog = false;
        }
        // Check if the viewer's hostname is in the ignore list
        if (preg_match($hosts, $_SERVER['REMOTE_HOST'])) {
            OX_Delivery_logMessage('viewer\'s host is in the ignore list '.$_SERVER['REMOTE_HOST'], 7);
            $GLOBALS['_MAX']['EVENT_FILTER_FLAGS'][] = 'ignoreHosts_host';
            $okToLog = false;
        }
    }
    if ($okToLog) OX_Delivery_logMessage('viewer\'s host is OK to log', 7);

    $result = OX_Delivery_Common_Hook('filterEvent', array($adId, $zoneId, $trackerId));
    if (!empty($result) && is_array($result)) {
        foreach ($result as $pci => $value) {
            if ($value == true) {
                $GLOBALS['_MAX']['EVENT_FILTER_FLAGS'][] = $pci;
                $okToLog = false;
            }
        }
    }
    return $okToLog;
}

/**
 * A function to return GET variables, where the GET variable name is
 * extracted from the configuration file settings, and the GET variable
 * value is exploded into an array of items on the constant
 * $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'].
 *
 * Returns an empty array if there is no GET variable by the specified
 * name.
 *
 * @param string The name of the variable as defined in the configuration
 *               file's [var] section.
 * @return array The GET variable exploded to an array, or an empty
 *               array if the GET variable requested is not defined.
 */
function MAX_Delivery_log_getArrGetVariable($name)
{
    $varName = $GLOBALS['_MAX']['CONF']['var'][$name];
    return isset($_GET[$varName]) ? explode($GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'], $_GET[$varName]) : array();
}

/**
 * A function to ensure that a given index in an array is set, and is an
 * integer value.
 *
 * @param array $aArray A reference to the array to ensure the integer
 *                      value is set in.
 * @param integer $index The array index value to test & set, if required.
 */
function MAX_Delivery_log_ensureIntegerSet(&$aArray, $index)
{
    if (!is_array($aArray)) {
        $aArray = array();
    }
    if (empty($aArray[$index])) {
        $aArray[$index] = 0;
    } else {
        if (!is_integer($aArray[$index])) {
           $aArray[$index] = intval($aArray[$index]);
        }
    }
}

/**
 * A function to set any ad capping cookies required for an ad.
 *
 * @param integer $index The index to the ad and ad limitation arrays
 *                       that corresponds with the ad to set capping
 *                       cookies for.
 * @param array $aAds An array of ad IDs, indexed by $index.
 * @param array $aCaps An array of arrays, indexed by the strings
 *                     "block", "capping" and "session_capping", then
 *                     indexed by $index, containing the cap values.
 */
function MAX_Delivery_log_setAdLimitations($index, $aAds, $aCaps)
{
    _setLimitations('Ad', $index, $aAds, $aCaps);
}

/**
 * A function to set any campaign capping cookies required for an ad.
 *
 * @param integer $index The index to the campaign and campaign limitation
 *                       arrays that corresponds with the ad to set capping
 *                       cookies for.
 * @param array $aCampaigns An array of campaign IDs, indexed by $index.
 * @param array $aCaps An array of arrays, indexed by the strings
 *                     "block", "capping" and "session_capping", then
 *                     indexed by $index, containing the cap values.
 */
function MAX_Delivery_log_setCampaignLimitations($index, $aCampaigns, $aCaps)
{
    _setLimitations('Campaign', $index, $aCampaigns, $aCaps);
}

/**
 * A function to set any zone capping cookies required for a zone.
 *
 * @param integer $index The index to the zone and zone limitation
 *                       arrays that corresponds with the zone to set capping
 *                       cookies for.
 * @param array $aZones An array of zone IDs, indexed by $index.
 * @param array $aCaps An array of arrays, indexed by the strings
 *                     "block", "capping" and "session_capping", then
 *                     indexed by $index, containing the cap values.
 */
function MAX_Delivery_log_setZoneLimitations($index, $aZones, $aCaps)
{
    _setLimitations('Zone', $index, $aZones, $aCaps);
}

/**
 * This function sets or updates the last action (cookie) record
 * This value is used to track conversions for a campaign
 *
 * @param integer $index
 * @param array $aAdIds
 * @param array $aZoneIds
 * @param array $aSetLastSeen
 * @param integer $action
 */
function MAX_Delivery_log_setLastAction($index, $aAdIds, $aZoneIds, $aSetLastSeen, $action = 'view')
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (!empty($aSetLastSeen[$index])) {
        $cookieData = MAX_commonCompressInt(MAX_commonGetTimeNow()) . "-" . $aZoneIds[$index];

        // See if any plugin-components have added items to the conversion cookie...
        $conversionParams =  OX_Delivery_Common_hook('addConversionParams', array(&$index, &$aAdIds, &$aZoneIds, &$aSetLastSeen, &$action, &$cookieData));
        if (!empty($conversionParams) && is_array($conversionParams)) {
            foreach ($conversionParams as $params) {
                if (!empty($params) && is_array($params)) {
                    foreach ($params as $key => $value) {
                        // Note: We have to use space as a delimiter, if your plugin
                        // requires spaces in the data, you may need to encode them.
                        $cookieData .= " {$value}";
                    }
                }
            }
        }
        MAX_cookieAdd("_{$aConf['var']['last' . ucfirst($action)]}[{$aAdIds[$index]}]", $cookieData, _getTimeThirtyDaysFromNow());
    }
}

/**
 * This fuction set or updates the click blocked (cookie) record
 * This value is used to block clicks
 *
 * @param integer $index The index to the addId array that correspond
 *                       with the add that has been clicked
 * @param array $aAdIds  An array of add's id, indexed by integers that
 *                       coincides with the add's id
 *
 */
function MAX_Delivery_log_setClickBlocked($index, $aAdIds)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    MAX_cookieAdd("_{$aConf['var']['blockLoggingClick']}[{$aAdIds[$index]}]", MAX_commonCompressInt(MAX_commonGetTimeNow()), _getTimeThirtyDaysFromNow());
}

/**
 * This function check if the click logging for an add is blocked
 * when the block logging is active
 *
 * @param integer $adId              The add's id of the add that the function checks
 *                                   if is blocked for click logging
 * @param array $aBlockLoggingClick  And array with the timestamps of the last click logged
 *                                   for every add that has been clicked
 * @return boolean                   Returns true when the click block logging window for
 *                                   and add hasn't expired yet
 */
function MAX_Delivery_log_isClickBlocked($adId, $aBlockLoggingClick)
{
    if (isset($GLOBALS['conf']['logging']['blockAdClicksWindow']) && $GLOBALS['conf']['logging']['blockAdClicksWindow'] != 0) {
        if (isset($aBlockLoggingClick[$adId])) {
            $endBlock = MAX_commonUnCompressInt($aBlockLoggingClick[$adId]) + $GLOBALS['conf']['logging']['blockAdClicksWindow'];
            if ($endBlock >= MAX_commonGetTimeNow()) {
                OX_Delivery_logMessage('adID '.$adId.' click is still blocked by block logging window ', 7);
                return true;
            }
        }
    }
    return false;
}

/**
 * A "private" function to set delivery blocking and/or capping cookies.
 *
 * @access private
 * @param string $type The type of blocking/capping cookies to set. One of
 *                     'Ad', 'Campaign' or 'Zone'.
 * @param integer $index The index to the item and item limitation
 *                       arrays that corresponds with the item to set capping
 *                       cookies for.
 * @param array $aItems An array of item IDs, indexed by $index.
 * @param array $aCaps An array of arrays, indexed by the strings
 *                     "block", "capping" and "session_capping", then
 *                     indexed by $index, containing the cap values.
 */
function _setLimitations($type, $index, $aItems, $aCaps)
{
    // Ensure that the capping values for this item are set
    MAX_Delivery_log_ensureIntegerSet($aCaps['block'], $index);
    MAX_Delivery_log_ensureIntegerSet($aCaps['capping'], $index);
    MAX_Delivery_log_ensureIntegerSet($aCaps['session_capping'], $index);
    // Set the capping cookies
    MAX_Delivery_cookie_setCapping(
        $type,
        $aItems[$index],
        $aCaps['block'][$index],
        $aCaps['capping'][$index],
        $aCaps['session_capping'][$index]
    );
}

?>
