<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: log.php 6300 2006-12-14 11:15:05Z monique.szpak@m3.net $
*/

/**
 * @package    MaxDelivery
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 *
 * A file to contain delivery engine functions related to logging of raw
 * data to the database.
 */

require_once MAX_PATH . '/lib/max/Delivery/cookie.php';
require_once MAX_PATH . '/lib/max/Dal/Delivery.php';

/**
 * A function to log an ad request.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $adId The advertisement ID (was bannerid).
 * @param integer $creativeId The creative ID (doesn't exist yet, use null).
 * @param integer $zoneId The zone ID.
 */
function MAX_logAdRequest($viewerId, $adId, $creativeId, $zoneId)
{
    if (_viewersHostOkayToLog()) {
        $conf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_request'];
        MAX_Dal_Delivery_Include();
        MAX_Dal_Delivery_logAction(
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
function MAX_logAdImpression($viewerId, $adId, $creativeId, $zoneId)
{
    if (_viewersHostOkayToLog()) {
        $conf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        MAX_Dal_Delivery_Include();
        MAX_Dal_Delivery_logAction(
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
function MAX_logAdClick($viewerId, $adId, $creativeId, $zoneId)
{
    if (_viewersHostOkayToLog()) {
        $conf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_click'];
        MAX_Dal_Delivery_Include();
        MAX_Dal_Delivery_logAction(
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
 * Note that the $conf['rawDatabase'] variables will only be defined
 * in the event that Max is configured for multiple databases. Normally,
 * this will not be the case, so the server_ip field will be 'singleDB'.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $trackerId The tracker ID.
 * @return mixed An array containing the server_raw_tracker_impression_id
 *               and the server_raw_ip values, if the tracker impression
 *               was inserted, false otherwise.
 */
function MAX_logTrackerImpression($viewerId, $trackerId)
{
    if (_viewersHostOkayToLog()) {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (empty($conf['rawDatabase']['host'])) {
            $conf['rawDatabase']['host'] = 'singleDB';
        }
        if (isset($conf['rawDatabase']['serverRawIp'])) {
            $serverRawIp = $conf['rawDatabase']['serverRawIp'];
        } else {
            $serverRawIp = $conf['rawDatabase']['host'];
        }
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_tracker_impression'];
        MAX_Dal_Delivery_Include();
        $rawTrackerImpressionId = MAX_Dal_Delivery_logTracker(
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

/**
 * A function to log tracker impression variable values.
 *
 * Note that the $conf['rawDatabase'] variables will only be defined
 * in the event that Max is configured for multiple databases. Normally,
 * this will not be the case, so the server_ip field will be 'singleDB'.
 *
 * @param integer $trackerId The tracker ID.
 * @param integer $serverRawTrackerImpressionId The unique tracker impression
 *                                              id on the raw database server.
 * @param string $serverRawIp The IP address of the raw database server, or null
 *                            if Max is not running in multiple database server
 *                            mode.
 */
function MAX_logVariableValues($variables, $trackerId, $serverRawTrackerImpressionId, $serverRawIp)
{
    $conf = $GLOBALS['_MAX']['CONF'];
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
        MAX_Dal_Delivery_logVariableValues($variables, $serverRawTrackerImpressionId, $serverRawIp);
    }
}

/**
 * A function to log a tracker click.
 *
 * @deprecated v0.3.27  I believe this function is not used and has never been used.
 *
 * @param integer $viewerId The viewer ID (was userid).
 * @param integer $trackerId The tracker ID.
 */
function MAX_logTrackerClick($viewerId, $trackerId)
{
    if (_viewersHostOkayToLog()) {
        $conf = $GLOBALS['_MAX']['CONF'];
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_tracker_click'];
        MAX_Dal_Delivery_Include();
        MAX_Dal_Delivery_logAction(
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
 * A function to log benchmarking data to the debug file.
 *
 * A file called "debug.log" is created in the /var directory, if it
 * does not exist already, to store the benchmarking information.
 *
 * @param string $page The name of the script being benchmarked.
 * @param string $queryString The query string parameters passed to the page.
 * @param double $benchmark The elapsed time of the benchmark.
 * @param string $extra Any extra information to be logged.
 */
function MAX_logBenchmark($page, $queryString, $benchmark, $extra = '') {
    if (_viewersHostOkayToLog()) {
        $memoryUsage = MAX_benchmarkGetMemoryUsage();
        $message = date("d/m/Y|H:i:s") . '|' . $memoryUsage . '|' . $page . '|' .
            $benchmark . '|' . $extra . '|' . $queryString . "\n";
        $logFile = fopen(MAX_PATH . '/var/debug.log', 'a');
        fwrite($logFile, $message);
        fclose($logFile);
    }
}

/**
 * A function to check if the information to be logged should be logged
 * or ignored, on the basis of the viewer's IP address or hostname.
 *
 * @return boolean True if the information should be logged, or false if the
 *                 IP address or host name is in the list of hosts for which
 *                 information should not be logged.
 */
function _viewersHostOkayToLog()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if (count($conf['ignoreHosts']) > 0) {
        $hosts = '#('.implode('|',$conf['ignoreHosts']).')$#i';
        if ($hosts != '') {
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
 *                  3: An integer to store if the call to Max was performed
 *                     using HTTPS (1) or not (0).
 */
function _prepareLogInfo()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    // Get the Geotargeting information, if required
    $geotargeting = array();
    if ($conf['geotargeting']['saveStats'] && !empty($GLOBALS['_MAX']['CLIENT_GEO'])) {
        $geotargeting = $GLOBALS['_MAX']['CLIENT_GEO'];
    }
    // Get the zone location information, if possible
    if (!empty($_GET['loc'])) {
        $zoneInfo = parse_url($_GET['loc']);
    } elseif (!empty($_SERVER['HTTP_REFERER'])) {
        $zoneInfo = parse_url($_SERVER['HTTP_REFERER']);
    } else {
        $zoneInfo = array();
    }
    if (!empty($zoneInfo['scheme'])) {
        $zoneInfo['scheme'] = ($zoneInfo['scheme'] == 'https') ? 1 : 0;
    }
    // Get the operating system and browser type, if required
    if ($conf['logging']['sniff'] && isset($GLOBALS['_MAX']['CLIENT'])) {
        $userAgentInfo = array(
            'os' => $GLOBALS['_MAX']['CLIENT']['os'],
            'long_name' => $GLOBALS['_MAX']['CLIENT']['long_name'],
            'browser'   => $GLOBALS['_MAX']['CLIENT']['browser'],
        );
    } else {
        $userAgentInfo = array();
    }
    // Determine if the access to Max was made using HTTPS
    $maxHttps = 0;  // https is false
    if ($_SERVER['SERVER_PORT'] == $conf['max']['sslPort']) {
        $maxHttps = 1;   // https is true
    }
    return array($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps);
}

/**
 * Returns a request variable exploded to an array or empty array
 * if there is no request variable with the specified name.
 * @param string Name of the variable.
 * @return array Request variable exploded to an array
 */
function _getArrRequestVariable($name)
{
	return isset($_REQUEST[$name]) ? explode(MAX_DELIVERY_MULTIPLE_DELIMITER, $_REQUEST[$name]) : array();
}


/**
 * Checks the request string for variables indicating named after a cookie.
 * If the value for the cookie is given in the request string then it returns
 * the value as an array. Otherwise, returns an empty array.
 * @param string Name of the variable in the configuration file.
 * @return array Value of the cookie in the form of array.
 */
function _getArrRequestConfVariable($name)
{
	return _getArrRequestVariable($GLOBALS['_MAX']['CONF']['var'][$name]);
}

/**
 * Returns an integer value from an array or 0 if
 * the array is empty.
 * @param array $arr
 * @param object $idx
 * @return int
 */
function _getIValueFromArr($arr, $idx)
{
	return empty($arr) ? 0 : intval($arr[$idx]);
}


/**
 * Returns an integer value from double-dimensional array or 0 if
 * the value is empty.
 * @param array $arr
 * @param object $idxFirst
 * @param object $idxSecond
 * @return int
 */
function _getIValueFromArrArr($arr, $idxFirst, $idxSecond)
{
	return _getIValueFromArr($arr[$idxFirst], $idxSecond);
}


/**
 * Reads limitation values from the array and set a proper cookies
 * according to values found.
 *
 * @param string $capType Either 'Ad' or 'Zone'.
 * @param int $id Id of the element to set limitations for.
 * @param array $arrArrCapValues 2D array to get values from.
 * @param int $idx Second index of the array to look for values.
 * @see MAX_cookieSetCapping
 */
function _setLimitations($capType, $id, $arrArrCapValues, $idx)
{
    $block = _getIValueFromArrArr($arrArrCapValues, 'block', $idx);
    $capping = _getIValueFromArrArr($arrArrCapValues, 'capping', $idx);
    $sessionCapping = _getIValueFromArrArr($arrArrCapValues, 'session_capping', $idx);

    MAX_cookieSetCapping($id, $capType, $block, $capping, $sessionCapping);
}


/**
 * Reads limitation values from the array and set a proper cookies
 * according to values found.
 *
 * @param int $adId
 * @param array $arrArrCapValues
 * @param int $idx
 * @see _setLimitations
 */
function _setAdLimitations($adId, $arrArrCapValues, $idx)
{
    _setLimitations('Ad', $adId, $arrArrCapValues, $idx);
}


/**
 * Reads limitation values from the array and set a proper cookies
 * according to values found.
 *
 * @param int $zoneId
 * @param array $arrArrCapValues
 * @param int $idx
 * @see _setLimitations
 */
function _setZoneLimitations($zoneId, $arrArrCapValues, $idx)
{
    _setLimitations('Zone', $zoneId, $arrArrCapValues, $idx);
}
?>
