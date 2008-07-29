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

$file = '/lib/max/Delivery/log.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * @package    MaxDelivery
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 *
 * A file to contain delivery engine functions related to logging of raw
 * data to the database.
 */

require_once MAX_PATH . '/lib/max/Dal/Delivery.php';

/**
 * A function to log an ad request.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $creativeId The creative ID (doesn't exist yet, use null).
 * @param integer $zoneId The zone ID.
 */
function MAX_Delivery_log_logAdRequest($viewerId, $adId, $creativeId, $zoneId)
{
    if (_viewersHostOkayToLog()) {
        OX_Delivery_Common_hook('logRequest', array($viewerId, $adId, $creativeId, $zoneId));
        // @todo - remove following code once buckets will be finished
        $aConf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $geotargeting = array();
        $table = $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request'];
        MAX_Dal_Delivery_Include();
        OA_Dal_Delivery_logAction(
            $table,
            $viewerId,
            $adId,
            $creativeId,
            $zoneId,
            $geotargeting,
            $zoneInfo,
            $userAgentInfo,
            $maxHttps
        );
    }
}

/**
 * A function to log an ad impression.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $creativeId The creative ID (doesn't exist yet, use null).
 * @param integer $zoneId The zone ID.
 */
function MAX_Delivery_log_logAdImpression($viewerId, $adId, $creativeId, $zoneId)
{
    if (_viewersHostOkayToLog()) {
        OX_Delivery_Common_hook('logImpression', array($viewerId, $adId, $creativeId, $zoneId));
        // @todo - remove following code once buckets will be finished
        $aConf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression'];
        MAX_Dal_Delivery_Include();
        OA_Dal_Delivery_logAction(
            $table,
            $viewerId,
            $adId,
            $creativeId,
            $zoneId,
            $geotargeting,
            $zoneInfo,
            $userAgentInfo,
            $maxHttps
        );
    }
}

/**
 * A function to log an ad click.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $creativeId The creative ID (doesn't exist yet, use null).
 * @param integer $zoneId The zone ID.
 */
function MAX_Delivery_log_logAdClick($viewerId, $adId, $creativeId, $zoneId)
{
    if (_viewersHostOkayToLog()) {
        OX_Delivery_Common_hook('logClick', array($viewerId, $adId, $creativeId, $zoneId));
        // @todo - remove following code once buckets will be finished
        $aConf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click'];
        MAX_Dal_Delivery_Include();
        OA_Dal_Delivery_logAction(
            $table,
            $viewerId,
            $adId,
            $creativeId,
            $zoneId,
            $geotargeting,
            $zoneInfo,
            $userAgentInfo,
            $maxHttps
        );
    }
}

/**
 * A function to log a tracker impression.
 *
 * Note that the $aConf['rawDatabase'] variables will only be defined
 * in the event that OpenX is configured for multiple databases. Normally,
 * this will not be the case, so the server_ip field will be 'singleDB'.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $trackerId The tracker ID.
 * @return mixed An array containing the server_raw_tracker_impression_id
 *               and the server_raw_ip values, if the tracker impression
 *               was inserted, false otherwise.
 */
function MAX_Delivery_log_logTrackerImpression($viewerId, $trackerId)
{
    if (_viewersHostOkayToLog()) {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($aConf['rawDatabase']['host'])) {
            if (!empty($aConf['lb']['enabled'])) {
                $aConf['rawDatabase']['host'] = $_SERVER['SERVER_ADDR'];
            } else {
                $aConf['rawDatabase']['host'] = 'singleDB';
            }
        }
        if (isset($aConf['rawDatabase']['serverRawIp'])) {
            $serverRawIp = $aConf['rawDatabase']['serverRawIp'];
        } else {
            $serverRawIp = $aConf['rawDatabase']['host'];
        }
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $aConf['table']['prefix'] . $aConf['table']['data_raw_tracker_impression'];
        MAX_Dal_Delivery_Include();
        $rawTrackerImpressionId = OA_Dal_Delivery_logTracker(
            $table,
            $viewerId,
            $trackerId,
            $serverRawIp,
            $geotargeting,
            $zoneInfo,
            $userAgentInfo,
            $maxHttps
        );
        return array('server_raw_tracker_impression_id' => $rawTrackerImpressionId, 'server_raw_ip' => $serverRawIp);
    }
    return false;
}

function MAX_Delivery_log_logTrackerConnection($viewerId, $trackerId, $aTrackerImpression, $aConnection)
{
    if (_viewersHostOkayToLog()) {
        OX_Delivery_Common_hook('logConversion', array($viewerId, $trackerId, $aTrackerImpression, $aConnection));
        // @todo - remove following code once buckets will be finished
        MAX_Dal_Delivery_Include();
        if (OA_Dal_Delivery_logTrackerConnection(
            $viewerId,
            $trackerId,
            $aTrackerImpression,
            $aConnection
        )) {
            // Log of the connection was sucessful, if this was a "sale" type conversion, then clear the cookie data
            MAX_trackerDeleteActionFromCookie($aConnection);
        }
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
 * @param integer $trackerId The tracker ID.
 * @param integer $serverRawTrackerImpressionId The unique tracker impression
 *                                              id on the raw database server.
 * @param string $serverRawIp The IP address of the raw database server, or null
 *                            if OpenX is not running in multiple database server
 *                            mode.
 */
function MAX_Delivery_log_logVariableValues($variables, $trackerId, $serverRawTrackerImpressionId, $serverRawIp)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    // Get the variable information, including the Variable ID
    foreach ($variables as $variable) {
        if (isset($_GET[$variable['name']])) {
            $value = $_GET[$variable['name']];

            // Do not save variable if empty or if the JS engine set it to "undefined"
            if (!strlen($value) || $value == 'undefined') {
                unset($variables[$variable['variable_id']]);
                continue;
            }
            // Sanitize by datatype
            switch ($variable['type']) {
                case 'int':
                case 'numeric':
                    // Strip useless chars, such as currency
                    $value = preg_replace('/[^0-9.]/', '', $value);
                    $value = floatval($value); break;
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
            unset($variables[$variable['variable_id']]);
            continue;
        }
        $variables[$variable['variable_id']]['value'] = $value;
    }
    if (count($variables)) {
        MAX_Dal_Delivery_Include();
        OA_Dal_Delivery_logVariableValues($variables, $serverRawTrackerImpressionId, $serverRawIp);
    }
}

/**
 * A "private" function to check if the information to be logged should be
 * logged or ignored, on the basis of the viewer's IP address or hostname.
 *
 * @return boolean True if the information should be logged, or false if the
 *                 IP address or host name is in the list of hosts for which
 *                 information should not be logged.
 */
function _viewersHostOkayToLog()
{
    $aConf = $GLOBALS['_MAX']['CONF'];

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

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
        if (!$allowed) return false;
    }

    // Check the user-agent against the list of known bots (if set)
    if (!empty($aConf['logging']['ignoreUserAgents'])) {
        $aKnownBots = explode('|', strtolower($aConf['logging']['ignoreUserAgents']));
        foreach ($aKnownBots as $bot) {
            if (strpos($agent, $bot) !== false) {
                return false;
            }
        }
    }

    // Check if this IP address has been blocked
    if (!empty($aConf['logging']['ignoreHosts'])) {
        $hosts = str_replace(',', '|', $aConf['logging']['ignoreHosts']);
        $hosts = '#('.$hosts.')$#i';

        // Format the hosts to ignore in a PCRE format
        $hosts = str_replace('.', '\.', $hosts);
        $hosts = str_replace('*', '[^.]+', $hosts);
        // Check if the viewer's IP address is in the ignore list
        if (preg_match($hosts, $_SERVER['REMOTE_ADDR'])) {
            return false;
        }
        // Check if the viewer's hostname is in the ignore list
        if (preg_match($hosts, $_SERVER['REMOTE_HOST'])) {
            return false;
        }
    }
    return true;
}

/**
 * A function to get various information that needs to be logged.
 *
 * @todo Update the values set by this function so that safe empty values are set when the information is not available
 *
 * @return array Returns an array with four elements:
 *                  0: An array of the viewer's geotargeting info.
 *                  1: An array of information about the URL the viewer used
 *                     to access the page containing the zone.
 *                  2: An array of information about the viewer's web browser
 *                     and operating system.
 *                  3: An integer to store if the call to OpenX was performed
 *                     using HTTPS (1) or not (0).
 */
function _prepareLogInfo()
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    // Get the Geotargeting information, if required
    $geotargeting = array();
    if (isset($aConf['geotargeting']['saveStats']) && $aConf['geotargeting']['saveStats'] && !empty($GLOBALS['_MAX']['CLIENT_GEO'])) {
        $geotargeting = $GLOBALS['_MAX']['CLIENT_GEO'];
    } else {
        $geotargeting = array(
            'country_code'  => null,
            'region'        => null,
            'city'          => null,
            'postal_code'   => null,
            'latitude'      => null,
            'longitude'     => null,
            'dma_code'      => null,
            'area_code'     => null,
            'organisation'  => null,
            'netspeed'      => null,
            'continent'     => null
        );
    }
    // Get the zone location information, if set up to log this,
    // and if possible
    $zoneInfo = array();
    if ($aConf['logging']['pageInfo']) {
        if (!empty($_GET['loc'])) {
            $zoneInfo = parse_url($_GET['loc']);
        } elseif (!empty($_SERVER['HTTP_REFERER'])) {
            $zoneInfo = parse_url($_SERVER['HTTP_REFERER']);
        } elseif (!empty($GLOBALS['loc'])) {
            $zoneInfo = parse_url($GLOBALS['loc']);
        }
        if (!empty($zoneInfo['scheme'])) {
            $zoneInfo['scheme'] = ($zoneInfo['scheme'] == 'https') ? 1 : 0;
        }
        if (isset($GLOBALS['_MAX']['CHANNELS'])) {
            $zoneInfo['channel_ids'] = $GLOBALS['_MAX']['CHANNELS'];
        }
    }
    // Get the operating system and browser type, if required
    if ($aConf['logging']['sniff'] && isset($GLOBALS['_MAX']['CLIENT'])) {
        $userAgentInfo = array(
            'os' => $GLOBALS['_MAX']['CLIENT']['os'],
            'long_name' => $GLOBALS['_MAX']['CLIENT']['long_name'],
            'browser'   => $GLOBALS['_MAX']['CLIENT']['browser'],
        );
    } else {
        $userAgentInfo = array();
    }
    // Determine if the access to OpenX was made using HTTPS
    $maxHttps = 0;  // https is false
    if ($_SERVER['SERVER_PORT'] == $aConf['openads']['sslPort']) {
        $maxHttps = 1;   // https is true
    }

    // Set required info for logging
    if (!isset($zoneInfo['channel_ids'])) {
        $zoneInfo['channel_ids'] = null;
    }
    if (!isset($zoneInfo['scheme'])) {
        $zoneInfo['scheme'] = null;
    }

    if (!isset($zoneInfo['host'])) {
        $zoneInfo['host'] = null;
    }
    if (!isset($zoneInfo['path'])) {
        $zoneInfo['path'] = null;
    }
    if (!isset($zoneInfo['query'])) {
        $zoneInfo['query'] = null;
    }

    if (!isset($userAgentInfo['os'])) {
        $userAgentInfo['os'] = '';
    }
    if (!isset($userAgentInfo['browser'])) {
        $userAgentInfo['browser'] = '';
    }

    return array($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps);
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
 * This value is used to track conversions for a
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
        MAX_cookieAdd("_{$aConf['var']['last' . ucfirst($action)]}[{$aAdIds[$index]}]", MAX_commonCompressInt(MAX_commonGetTimeNow()) . "-" . $aZoneIds[$index], _getTimeThirtyDaysFromNow());
    }
}

/**
 * A "private" function to set delivery blocking and/or capping cookies.
 *
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
