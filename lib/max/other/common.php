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


require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';

    // +---------------------------------------+
    // | generic permission checks             |
    // |                                       |
    // | filtering by user type                |
    // +---------------------------------------+


function MAX_checkAd($advertiserId, $placementId, $adId)
{
    $allowed = false;
    if (is_numeric($advertiserId) && is_numeric($placementId) && is_numeric($adId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {

            //  determine if there are 1 or more ads
            $allowed = (count(
                Admin_DA::getAds(
                    array(
                        'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId,
                        'ad_id' => $adId))));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {

            //  determine if there are 1 or more ads
            $allowed = (count(
                Admin_DA::getAds(
                    array(
                        'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId,
                        'ad_id' => $adId))));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getAds(
                            array(  'advertiser_id' => $advertiserId,
                                    'placement_id' => $placementId,
                                    'ad_id' => $adId)));
        }
    }
    return $allowed;
}

function MAX_checkAdvertiser($advertiserId)
{
    $allowed = false;
    if (is_numeric($advertiserId) && $advertiserId > 0) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getAdvertisers(array('advertiser_id' => $advertiserId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getAdvertisers(
                array(  'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getAdvertisers(array('advertiser_id' => $advertiserId)));
        }
    }
    return $allowed;
}

function MAX_checkAgency($agencyId)
{
    $allowed = false;
    if (is_numeric($agencyId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getAgencies(array('agency_id' => $agencyId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = ($agencyId == OA_Permission::getEntityId())
                        && count(Admin_DA::getAgencies(array('agency_id' => $agencyId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($agencyId == OA_Permission::getAgencyId())
                        && count(Admin_DA::getAgencies(array('agency_id' => $agencyId)));
        }
    }
    return $allowed;
}

function MAX_checkPublisher($publisherId)
{
    $allowed = false;
    if (is_numeric($publisherId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getPublishers(array('publisher_id' => $publisherId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getPublishers(
                array(  'agency_id' => OA_Permission::getAgencyId(),
                        'publisher_id' => $publisherId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $allowed = ($publisherId == OA_Permission::getEntityId())
                        && count(Admin_DA::getPublishers(array('publisher_id' => $publisherId)));
        }
    }
    return $allowed;
}

function MAX_checkPlacement($advertiserId, $placementId)
{
    $allowed = false;
    if (is_numeric($advertiserId) && is_numeric($placementId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getPlacements(
                array(  'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getPlacements(
                array(  'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getPlacements(
                array(  'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId)));
        }
    }
    return $allowed;
}

function MAX_checkTracker($advertiserId, $trackerId)
{
    $allowed = false;
    if (is_numeric($advertiserId) && is_numeric($trackerId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getTrackers(
                array(  'advertiser_id' => $advertiserId,
                        'tracker_id' => $trackerId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getTrackers(
                array(  'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId,
                        'tracker_id' => $trackerId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getTrackers(
                array(  'advertiser_id' => $advertiserId,
                        'tracker_id' => $trackerId)));
        }
    }
    return $allowed;
}

function MAX_checkZone($publisherId, $zoneId)
{
    $allowed = false;
    if (is_numeric($publisherId) && is_numeric($zoneId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getZones(
                array(  'publisher_id' => $publisherId,
                        'zone_id' => $zoneId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getZones(
                array(  'agency_id' => OA_Permission::getAgencyId(),
                        'publisher_id' => $publisherId,
                        'zone_id' => $zoneId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $allowed = ($publisherId == OA_Permission::getEntityId())
                        && count(Admin_DA::getZones(
                array(  'publisher_id' => $publisherId,
                        'zone_id' => $zoneId)));
        }
    }
    return $allowed;
}

function MAX_checkAdZoneValid($aZone, $aAd)
{
    $valid = true;
    if ($aZone['width'] > -1 && $aZone['width'] != $aAd['width']) {
        $valid = false;
    } elseif ($aZone['height'] > -1 && $aZone['height'] != $aAd['height']) {
        $valid = false;
    } elseif ($aAd['type'] == 'txt' && $aZone['type'] != phpAds_ZoneText) {
        $valid = false;
    } elseif ($aZone['type'] == phpAds_ZoneText && $aAd['type'] != 'txt') {
        $valid = false;
    }
    return $valid;
}

function MAX_checkChannel($agencyId, $channelId)
{
    $allowed = false;
    if (is_numeric($agencyId) && is_numeric($channelId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getChannels(
                array( 'channel_id' => $channelId,
                       'channel_type' => 'admin')));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getChannels(
                array(  'agency_id' => $agencyId,
                        'channel_id' => $channelId)));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $allowed = false;
        }
    }
    return $allowed;
}
function MAX_getPlacementName($aPlacement, $length = null)
{
    if (!empty($aPlacement)) {
        if ((OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) && $aPlacement['anonymous'] == 't') {
            $name = $GLOBALS['strHiddenCampaign'] . ' ' . $aPlacement['placement_id'];
        } else {
            $name = empty($aPlacement['name']) ? $GLOBALS['strUntitled'] : $aPlacement['name'];
        }
    } else {
        $name = '';
    }

    if (is_numeric($length) && sizeof($name) > $length) {
        $name = substr($name, 0, $length);
    }

    return $name;
}
function MAX_getAdName($description, $alt = null, $length = null, $anonymous = false, $id = null)
{
    $name = $GLOBALS['strUntitled'];
    if (!empty($alt)) $name = $alt;
    if (!empty($description)) $name = $description;
    if ((OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) && $anonymous) {
        $name = $GLOBALS['strHiddenAd'];
        if (!empty($id)) {
            $name = $name . ' ' . $id;
        }
    }

    if (is_numeric($length) && sizeof($name) > $length) {
        $name = substr($name, 0, $length);
    }

    return $name;
}
function MAX_getZoneName($zoneName, $length = null, $anonymous = false, $id = null)
{
    $name = $GLOBALS['strUntitled'];
    if (!empty($zoneName)) $name = $zoneName;
    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && $anonymous) {
        $name = $GLOBALS['strHiddenZone'];
        if (!empty($id)) {
            $name = $name . ' ' . $id;
        }
    }

    if (is_numeric($length) && sizeof($name) > $length) {
        $name = substr($name, 0, $length);
    }

    return $name;
}
function MAX_getPublisherName($publisherName, $length = null, $anonymous = false, $id = null)
{
    $name = $GLOBALS['strUntitled'];
    if (!empty($publisherName)) $name = $publisherName;
    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && $anonymous) {
        $name = $GLOBALS['strHiddenWebsite'];
        if (!empty($id)) {
            $name = $name . ' ' . $id;
        }
    }

    if (is_numeric($length) && sizeof($name) > $length) {
        $name = substr($name, 0, $length);
    }

    return $name;
}
function MAX_getTrackerName($trackerName, $length = null, $anonymous = false, $id = null)
{
    $name = $GLOBALS['strUntitled'];
    if (!empty($trackerName)) $name = $trackerName;
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) && $anonymous) {
        $name = $GLOBALS['strHiddenTracker'];
        if (!empty($id)) {
            $name = $name . ' ' . $id;
        }
    }

    if (is_numeric($length) && sizeof($name) > $length) {
        $name = substr($name, 0, $length);
    }

    return $name;
}
function MAX_getAdvertiserName($advertiserName, $length = null, $anonymous = false, $id = null)
{
    $name = $GLOBALS['strUntitled'];
    if (!empty($advertiserName)) $name = $advertiserName;
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) && $anonymous) {
        $name = $GLOBALS['strHiddenAdvertiser'];
        if (!empty($id)) {
            $name = $name . ' ' . $id;
        }
    }

    if (is_numeric($length) && sizeof($name) > $length) {
        $name = substr($name, 0, $length);
    }

    return $name;
}
function MAX_getBannerName($description, $alt)
{
    global $strUntitled;

    $name = $strUntitled;
    if (!empty($alt)) $name = $alt;
    if (!empty($description)) $name = $description;
    $name = phpAds_breakString ($name, '30');

    return $name;
}


/**
 * Retained for backward-compatibility.
 *
 * @param string $key
 * @param object $default
 * @deprecated Use MAX_commonGetValue() instead.
 * @see MAX_commonGetValue()
 */
function MAX_getValue($key, $default = null)
{
    return MAX_commonGetValue($key, $default);
}


/**
 * This function returns value from the $_REQUEST array stored under
 * $key key. If magic_quotes_gpc is not enabled it adds the slashes to the
 * value before returning it. If the value is not defined in the $_REQUEST
 * then the value passed as $default is returned.
 *
 * @param string $key
 * @param object $default
 */
function MAX_commonGetValue($key, $default = null)
{
    $value = $default;
    if (isset($_REQUEST[$key])) {
        $value = $_REQUEST[$key];
        if (!get_magic_quotes_gpc()) {
            return MAX_commonSlashArray($value);
        }
    }

    return $value;
}


/**
 * This function returns value from the $_REQUEST array stored under
 * $key key. If magic_quotes_gpc is enabled it removes the slashes to the
 * value before returning it. If the value is not defined in the $_REQUEST
 * then the value passed as $default is returned.
 *
 * @param string $key
 * @param object $default
 */
function MAX_commonGetValueUnslashed($key, $default = null)
{
    return _commonGetValueUnslashed($_REQUEST, $key, $default);
}


/**
 * Returns value stored under the $key in the $aValues array. If
 * magic_quotes_gpc is enabled it removes the slashes to the
 * value before returning it. If the value is not defined in the $aValues
 * then the value passed as $default is returned.
 *
 * @param array $aValues
 * @param string $sKey
 * @param object $oDefault
 * @return object
 */
function _commonGetValueUnslashed($aValues, $sKey, $oDefault = null)
{
    $value = $oDefault;
    if (isset($aValues[$sKey])) {
        $value = $aValues[$sKey];
        if (get_magic_quotes_gpc()) {
            return MAX_commonUnslashArray($value);
        }
    }
    return $value;
}


/**
 * Returns the value stored under the $key in the $_POST. If
 * magic_quotes_gpc is enabled it removes the slashes from the
 * value before returning it. If the value is not defined in the $_POST
 * then the $_GET array is checked. If the value is still not found then
 * $sDefault is returned. Whichever value is returned, it is trimmed first.
 *
 * @param string $sKey
 * @param string $sDefault
 * @return string
 */
function MAX_commonGetPostValueUnslashed($sKey, $sDefault = null)
{
    $value = _commonGetValueUnslashed($_POST, $sKey);
    if (is_null($value)) {
        $value = _commonGetValueUnslashed($_GET, $sKey);
    }
    if (is_null($value)) {
        $value = $sDefault;
    }
    if (is_null($value)) {
        return null;
    }
    return trim($value);
}


function MAX_getStoredValue($key, $default, $pageName=null)
{
    global $session, $pgName;
    if(isset($pgName)) {
        $pageName = $pgName;
    } else {
        $pageName = basename($_SERVER['PHP_SELF']);
    }

    $value = $default;
    if (isset($_REQUEST[$key])) {
        $value = $_REQUEST[$key];
        if (!get_magic_quotes_gpc()) MAX_addslashes($value);
    } elseif (isset($session['prefs']['GLOBALS'][$key])) {
        $value = $session['prefs']['GLOBALS'][$key];
    } elseif (isset($session['prefs'][$pageName][$key])) {
        $value = $session['prefs'][$pageName][$key];
    }

    return $value;
}


function MAX_changeStoredValue($key, $value)
{
    global $session;
    $pageName = basename($_SERVER['PHP_SELF']);

    if (isset($_REQUEST[$key])) {
        $_REQUEST[$key] = $value;
    }
    if (isset($_GET[$key])) {
        $_GET[$key] = $value;
    }
    if (isset($_POST[$key])) {
        $_POST[$key] = $value;
    }
    if (isset($session['prefs']['GLOBALS'][$key])) {
        $session['prefs']['GLOBALS'][$key] = $value;
    }
    if (isset($session['prefs'][$pageName][$key])) {
        $session['prefs'][$pageName][$key] = $value;
    }

    return true;
}



function MAX_addslashes(&$item)
{
    $item = MAX_commonSlashArray($item);
}


/**
 * Recursively add slashes to the values in an array.
*
 * @param array Input array.
 * @return array Output array with values slashed.
 */
function MAX_commonSlashArray($a)
{
    if (is_array($a)) {
        reset($a);
        while (list($k,$v) = each($a)) {
            $a[$k] = MAX_commonSlashArray($v);
        }
        reset ($a);
        return ($a);
    } else {
        return is_null($a) ? null : addslashes($a);
    }
}


/**
 * Recursively removes slashes from the values in an array.
*
 * @param array Input array.
 * @return array Output array with values unslashed.
 */
function MAX_commonUnslashArray($a)
{
    if (is_array($a)) {
        reset($a);
        while (list($k,$v) = each($a)) {
            $a[$k] = MAX_commonUnslashArray($v);
        }
        reset ($a);
        return ($a);
    } else {
        return stripslashes($a);
    }
}


    // +---------------------------------------+
    // | array utilties                        |
    // +---------------------------------------+

// this is never called
function MAX_arrayMergeRecursive(&$a, &$b)
{
    $keys = array_keys($a);
    foreach ($keys as $key) {
        if (isset($b[$key])) {
            if (is_array($a[$key]) && is_array($b[$key])) {
                //????????? the 'merge' fn not only is not a PHP fn, it's not defined anywhere, go figure ...
                merge($a[$key], $b[$key]);
            } else {
                $a[$key] = $b[$key];
            }
        }
    }
    $keys = array_keys($b);
    foreach ($keys as $key) {
        if (!isset($a[$key])) {
            $a[$key] = $b[$key];
        }
    }
}

function MAX_getStoredArray($key, $default)
{
    global $session;
    $pageName = basename($_SERVER['PHP_SELF']);

    $value = $default;
    if (isset($_REQUEST[$key])) {
        $value = explode(',',$_REQUEST[$key]);
        if (!get_magic_quotes_gpc()) {
            MAX_addslashes($value);
        }
    } elseif (isset($session['prefs'][$pageName][$key])) {
        $value = explode(',',$session['prefs'][$pageName][$key]);
    }
    return $value;
}

    // +---------------------------------------+
    // | tree node state handling              |
    // +---------------------------------------+
function MAX_adjustNodes(&$aNodes, $expand, $collapse)
{
    if (!empty($expand)) {
        if ($expand != 'all') {
            if ($expand == 'none') {
                $aNodes = array();
            }
            elseif (!in_array($expand, $aNodes)) {
                $aNodes[] = $expand;
            }
        }
    }

    if (!empty($collapse) && in_array($collapse, $aNodes) ) {
        unset($aNodes[array_search($collapse, $aNodes)]);
    }
}

/**
 * Determine if a node is expanded or not.
 *
 * @param integer $id
 * @param string $expand
 * @param array $aNodes
 * @param string $prefix
 * @return boolean
 */
function MAX_isExpanded($id, $expand, &$aNodes, $prefix)
{
    $isExpanded = false;
    if ($expand == 'all') {
        $isExpanded = true;
        if (!in_array($prefix . $id, $aNodes)) {
            $aNodes[] = $prefix . $id;
        }
    } elseif ($expand != 'none' && in_array($prefix . $id, $aNodes)) {
        $isExpanded = true;
    }

    return $isExpanded;
}

    // +---------------------------------------+
    // | adjustments                           |
    // +---------------------------------------+
function MAX_addDefaultPlacementZones($adId, $placementId)
{
    $aAdZones = Admin_DA::getAdZones(array('ad_id' => $adId), true, 'zone_id');
    $aPlacementZones = Admin_DA::getPlacementZones(array('placement_id' => $placementId), true, 'zone_id');
    if (!empty($aPlacementZones)) {
        foreach ($aPlacementZones as $zoneId => $aPlacementZone) {
            if (!isset($aAdZones[$zoneId])) {
                Admin_DA::addAdZone(array('ad_id' => $adId, 'zone_id' => $zoneId));
            }
        }
    }
}
// For a given ad id, make sure that zones have correct size/type.  Otherwise, unlink ads from the zone...
function MAX_adjustAdZones($adId)
{
    $aAdZones = Admin_DA::getAdZones(array('ad_id' => $adId), true, 'zone_id');
    if (!empty($aAdZones)) {
        $aAd = Admin_DA::getAd($adId);
        $aZones = Admin_DA::getZones(array('zone_id' => implode(',', array_keys($aAdZones))), true);
        // get zones linked to this campaign
        $aPlacementZones = Admin_DA::getPlacementZones(array('placement_id' => $aAd['placement_id']), true, 'zone_id');
        foreach ($aZones as $zoneId => $aZone) {
            if (!MAX_checkAdZoneValid($aZone, $aAd)) {
                Admin_DA::deleteAdZones(array('zone_id' => $zoneId, 'ad_id' => $adId));
            } else {
                // if ad's campaign is linked to this zone, link ad to zone
                if (isset($aPlacementZones[$zoneId])) {
                    Admin_DA::addAdZone(array('zone_id' => $zoneId, 'ad_id' => $adId));
                }
            }
        }
    }
}

function MAX_adjustZoneAds($zoneId)
{
    $aAdZones = Admin_DA::getAdZones(array('zone_id' => $zoneId), true, 'ad_id');
    if (!empty($aAdZones)) {
        $aZone = Admin_DA::getZone($zoneId);
        $aAds = Admin_DA::getAds(array('ad_id' => implode(',', array_keys($aAdZones))));
        foreach ($aAds as $adId => $aAd) {
            if (!MAX_checkAdZoneValid($aZone, $aAd)) {
                Admin_DA::deleteAdZones(array('zone_id' => $zoneId, 'ad_id' => $adId));
            }
        }
    }
}

function MAX_addLinkedAdsToZone($zoneId, $placementId)
{
    $aParams = MAX_getLinkedAdParams($zoneId);
    $aParams['placement_id'] = $placementId;

    $aAds = Admin_DA::getAds($aParams);
    //  FIXME
    $aLinkedAds = Admin_DA::getAdZones(array('zone_id' => $zoneId), false, 'ad_id');
    foreach ($aAds as $adId => $aAd) {
        if (!isset($aLinkedAds[$adId])) {
            $ret = Admin_DA::addAdZone(array('zone_id' => $zoneId, 'ad_id' => $adId));
            if (PEAR::isError($ret)) {
                return false;
            }
        }
    }
    return true;
}

// Get ad limitation parameters
function MAX_getLinkedAdParams($zoneId)
{
    $aParams = array();
    $aZone = Admin_DA::getZone($zoneId);
    if ($aZone['type'] == phpAds_ZoneText) {
        $aParams['ad_type'] = 'txt';
    } else {
        if ($aZone['width'] > -1) {
            $aParams['ad_width'] = $aZone['width'];
        }
        if ($aZone['height'] > -1) {
            $aParams['ad_height'] = $aZone['height'];
        }
    }
    return $aParams;
}

    // +---------------------------------------+
    // | file handling                         |
    // +---------------------------------------+
/* REDUNDANT
function MAX_removeFile($adId)
{
    $aAd =  Admin_DA::getAd($adId);
    _removeFile($aAd);
}

function MAX_removeFiles($aParams)
{
    $aAds =  Admin_DA::getAds($aParams);
    foreach ($aAds as $aAd) {
        _removeFile($aAd);
    }
}

function _removeFile($aAd)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    if (!empty($aAd['filename'])) {
        if ($aAd['type'] == 'web') {
            if ($phpAds_config['type_web_mode'] == 0) {
                $fileName = "{$phpAds_config['type_web_dir']}/{$aAd['filename']}";
                if (@file_exists($fileName)) {
                    @unlink ($fileName);
                }
            } else {
                // FTP mode
                $server = parse_url($phpAds_config['type_web_ftp']);
                if ($server['path'] != '' && substr($server['path'], 0, 1) == '/') {
                    $server['path'] = substr ($server['path'], 1);
                }
                if ($server['scheme'] == 'ftp') {
                    $conn_id = @ftp_connect($server['host']);
                    if ($server['pass'] && $server['user'])
                    $login = @ftp_login ($conn_id, $server['user'], $server['pass']);
                    else
                    $login = @ftp_login ($conn_id, 'anonymous', $pref['admin_email']);
                    if (($conn_id) || ($login)) {
                        if ($server['path'] != '')
                        @ftp_chdir ($conn_id, $server['path']);
                        if (@ftp_size ($conn_id, $aAd['filename']) > 0) {
                            @ftp_delete ($conn_id, $aAd['filename']);
                        }
                        @ftp_quit($conn_id);
                    }
                }
            }
        } elseif ($aAd['type'] == 'sql') {
            Admin_DA::deleteImage($aAd['filename']);
        }
    }
}
*/
// +---------------------------------------+
// | Duplication functions                 |
// +---------------------------------------+

function MAX_duplicatePlacement($placementId, $advertiserId) {
    $oDbh =& OA_DB::singleton();
    $conf = $GLOBALS['_MAX']['CONF'];
    // Copy campaign details
    $table = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['campaigns'],true);
    $query = "
        INSERT INTO
            {$table}
            (
                campaignname,
                clientid,
                views,
                clicks,
                conversions,
                expire,
                activate,
                status,
                priority,
                weight,
                target_impression,
                target_click,
                target_conversion,
                anonymous,
                companion,
                comments,
                revenue,
                revenue_type,
                updated
            )
        SELECT
            CONCAT('Copy of ', campaignname),
            " . $oDbh->quote($advertiserId, 'integer') . ",
            views,
            clicks,
            conversions,
            expire,
            activate,
            status,
            priority,
            weight,
            target_impression,
            target_click,
            target_conversion,
            anonymous,
            companion,
            comments,
            revenue,
            revenue_type,
            '". OA::getNow() ."'
        FROM
            {$table}
        WHERE
            campaignid = ". $oDbh->quote($placementId, 'integer');
    $res = $oDbh->exec($query);
    if (PEAR::isError($res)) {
        return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
    }

    $newPlacementId = $oDbh->lastInsertID($conf['table']['prefix'].$conf['table']['campaigns'],'campaignid');

    // Duplicate placement-zone-associations (Do this before duplicating banners to ensure an exact copy of ad-zone-assocs
    MAX_duplicatePlacementZones($placementId, $newPlacementId);

    // Duplicate placement-tracker-associations
    $table = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['campaigns_trackers'],true);
    $query = "
        INSERT INTO
            {$table}
            (
                campaignid,
                trackerid,
                status,
                viewwindow,
                clickwindow
            )
            SELECT
                " . $oDbh->quote($newPlacementId, 'integer') . ",
                trackerid,
                status,
                viewwindow,
                clickwindow
            FROM
                {$table}
            WHERE
                campaignid = ". $oDbh->quote($placementId, 'integer');
    $res = $oDbh->exec($query);
    if (PEAR::isError($res)) {
        return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
    }

    // Duplicate banners
    $table = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['banners'],true);
    $query = "
        SELECT
            bannerid
        FROM
            {$table}
        WHERE
            campaignid = ". $oDbh->quote($placementId, 'integer');
    $res = $oDbh->QUERY($query);
    if (PEAR::isError($res)) {
        return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
    }
    while ($row = $res->fetchRow()) {
        $newBannerId = MAX_duplicateAd($row['bannerid'], $newPlacementId);
    }

    return $newPlacementId;
}

function MAX_duplicateAd($adId, $placementId) {
    $oDbh =& OA_DB::singleton();
    $conf = $GLOBALS['_MAX']['CONF'];

    // Duplicate the banner
    $table = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['banners'],true);
    $query = "
        SELECT
            *
        FROM
            {$table}
        WHERE
            bannerid = ". $oDbh->quote($adId, 'integer');
    $res = $oDbh->query($query);
    if (PEAR::isError($res)) {
        return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
    }

    if ($row = $res->fetchRow()) {
        // Remove bannerid
        unset($row['bannerid']);
        if ($row['campaignid'] == $placementId) {
            $row['description'] = 'Copy of ' . $row['description'];
        }

        // Duplicate stored banner
        if ($row['storagetype'] == 'web' || $row['storagetype'] == 'sql') {
            $row['filename'] = phpAds_ImageDuplicate($row['storagetype'], $row['filename']);
        } elseif ($row['type'] == 'web' || $row['type'] == 'sql') {
            $row['filename'] = phpAds_ImageDuplicate($row['type'], $row['filename']);
        }

        // Clone banner
        $values_fields = '';
        $values = '';

        $row['updated'] = OA::getNow();
        $row['campaignid'] = $placementId;

        foreach ($row AS $name => $value) {
            $values_fields .= "$name, ";
            $values .= $oDbh->quote($value) .", ";
        }

        $values_fields = ereg_replace(", $", "", $values_fields);
        $values = ereg_replace(", $", "", $values);

        $query = "
            INSERT INTO
                {$table}
                ($values_fields)
            VALUES
                ($values)
       ";
        $res = $oDbh->exec($query);
        if (PEAR::isError($res)) {
            return MAX::raiseError($res, MAX_ERROR_DBFAILURE);
        }

        $new_adId = $oDbh->lastInsertID($conf['table']['prefix'].$conf['table']['banners'],'bannerid');

        // Copy ACLs and capping
        MAX_AclCopy(basename($_SERVER['PHP_SELF']), $adId, $new_adId);

        // Duplicate and ad-zone associations
        MAX_duplicateAdZones($adId, $new_adId);
    }
    return $new_adId;
}

function MAX_duplicateAdZones($fromAdId, $toAdId) {
    $aAdZones = Admin_DA::getAdZones(array('ad_id' => $fromAdId), true, 'zone_id');
    if (!empty($aAdZones)) {
        foreach ($aAdZones as $zoneId => $adId) {
            Admin_DA::addAdZone(array('ad_id' => $toAdId, 'zone_id' => $zoneId));
        }
    }
}

function MAX_duplicatePlacementZones($fromPlacementId, $toPlacementId) {
    $pAdZones = Admin_DA::getPlacementZones(array('placement_id' => $fromPlacementId), true, 'zone_id');
    if (!empty($pAdZones)) {
        foreach ($pAdZones as $zoneId => $placementId) {
            Admin_DA::addPlacementZone(array('placement_id' => $toPlacementId, 'zone_id' => $zoneId));
        }
    }
}

?>
