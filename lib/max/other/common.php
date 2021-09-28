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

require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';

    // +---------------------------------------+
    // | generic permission checks             |
    // |                                       |
    // | filtering by user type                |
    // +---------------------------------------+


function MAX_checkGenericId($id)
{
    return !empty($id) && preg_match('/^\d+$/D', $id);
}

function MAX_checkAd($advertiserId, $placementId, $adId)
{
    $allowed = false;
    if (MAX_checkGenericId($advertiserId) && MAX_checkGenericId($placementId) && MAX_checkGenericId($adId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {

            //  determine if there are 1 or more ads
            $allowed = (count(
                Admin_DA::getAds(
                    [
                        'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId,
                        'ad_id' => $adId]
                )
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {

            //  determine if there are 1 or more ads
            $allowed = (count(
                Admin_DA::getAds(
                    [
                        'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId,
                        'ad_id' => $adId]
                )
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getAds(
                            [  'advertiser_id' => $advertiserId,
                                    'placement_id' => $placementId,
                                    'ad_id' => $adId]
                        ));
        }
    }
    return $allowed;
}

function MAX_checkAdvertiser($advertiserId, $aParams = [])
{
    $allowed = false;
    if (MAX_checkGenericId($advertiserId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getAdvertisers($aParams + ['advertiser_id' => $advertiserId]));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getAdvertisers(
                $aParams +
                [  'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getAdvertisers($aParams + ['advertiser_id' => $advertiserId]));
        }
    }
    return $allowed;
}

function MAX_checkAgency($agencyId)
{
    $allowed = false;
    if (MAX_checkGenericId($agencyId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getAgencies(['agency_id' => $agencyId]));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = ($agencyId == OA_Permission::getEntityId())
                        && count(Admin_DA::getAgencies(['agency_id' => $agencyId]));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($agencyId == OA_Permission::getAgencyId())
                        && count(Admin_DA::getAgencies(['agency_id' => $agencyId]));
        }
    }
    return $allowed;
}

function MAX_checkPublisher($publisherId)
{
    $allowed = false;
    if (MAX_checkGenericId($publisherId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getPublishers(['publisher_id' => $publisherId]));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getPublishers(
                [  'agency_id' => OA_Permission::getAgencyId(),
                        'publisher_id' => $publisherId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $allowed = ($publisherId == OA_Permission::getEntityId())
                        && count(Admin_DA::getPublishers(['publisher_id' => $publisherId]));
        }
    }
    return $allowed;
}

function MAX_checkPlacement($advertiserId, $placementId, $aParams = [])
{
    $allowed = false;
    if (MAX_checkGenericId($advertiserId) && MAX_checkGenericId($placementId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getPlacements(
                $aParams +
                [  'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getPlacements(
                $aParams +
                [  'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getPlacements(
                            $aParams +
                [  'advertiser_id' => $advertiserId,
                        'placement_id' => $placementId]
                        ));
        }
    }
    return $allowed;
}

function MAX_checkTracker($advertiserId, $trackerId)
{
    $allowed = false;
    if (MAX_checkGenericId($advertiserId) && MAX_checkGenericId($trackerId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getTrackers(
                [  'advertiser_id' => $advertiserId,
                        'tracker_id' => $trackerId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getTrackers(
                [  'agency_id' => OA_Permission::getAgencyId(),
                        'advertiser_id' => $advertiserId,
                        'tracker_id' => $trackerId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $allowed = ($advertiserId == OA_Permission::getEntityId())
                        && count(Admin_DA::getTrackers(
                            [  'advertiser_id' => $advertiserId,
                        'tracker_id' => $trackerId]
                        ));
        }
    }
    return $allowed;
}

function MAX_checkZone($publisherId, $zoneId)
{
    $allowed = false;
    if (MAX_checkGenericId($publisherId) && MAX_checkGenericId($zoneId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getZones(
                [  'publisher_id' => $publisherId,
                        'zone_id' => $zoneId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getZones(
                [  'agency_id' => OA_Permission::getAgencyId(),
                        'publisher_id' => $publisherId,
                        'zone_id' => $zoneId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $allowed = ($publisherId == OA_Permission::getEntityId())
                        && count(Admin_DA::getZones(
                            [  'publisher_id' => $publisherId,
                        'zone_id' => $zoneId]
                        ));
        }
    }
    return $allowed;
}

function MAX_checkAdZoneValid($aZone, $aAd)
{
    $valid = true;
    if ($aZone['width'] != -1 && $aZone['width'] != $aAd['width']) {
        $valid = false;
    } elseif ($aZone['height'] != -1 && $aZone['height'] != $aAd['height']) {
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
    if (MAX_checkGenericId($agencyId) && MAX_checkGenericId($channelId)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $allowed = count(Admin_DA::getChannels(
                [ 'channel_id' => $channelId,
                       'channel_type' => 'admin']
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $allowed = count(Admin_DA::getChannels(
                [  'agency_id' => $agencyId,
                        'channel_id' => $channelId]
            ));
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $allowed = false;
        }
    }
    return $allowed;
}
function MAX_getPlacementName($aPlacement, $length = null)
{
    if (!empty($aPlacement)) {
        if ((OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) && MAX_isAnonymous($aPlacement['anonymous'])) {
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
    if (!empty($alt)) {
        $name = $alt;
    }
    if (!empty($description)) {
        $name = $description;
    }
    if ((OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) && MAX_isAnonymous($anonymous)) {
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
    if (!empty($zoneName)) {
        $name = $zoneName;
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && MAX_isAnonymous($anonymous)) {
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
    if (!empty($publisherName)) {
        $name = $publisherName;
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && MAX_isAnonymous($anonymous)) {
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
    if (!empty($trackerName)) {
        $name = $trackerName;
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) && MAX_isAnonymous($anonymous)) {
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
    if (!empty($advertiserName)) {
        $name = $advertiserName;
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) && MAX_isAnonymous($anonymous)) {
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
    if (!empty($alt)) {
        $name = $alt;
    }
    if (!empty($description)) {
        $name = $description;
    }
    $name = phpAds_breakString($name, '30');

    return $name;
}

/**
 * many methods are expecting $anonymous to be a boolean value
 * although it is held as enum ('t','f') in table
 * use this method to ensure the correct type gets passed
 *
 * @param string | boolean $anonymous
 * @return boolean
 */
function MAX_isAnonymous($anonymous)
{
    return ($anonymous === 'f' ? false : ($anonymous === 't' ? true : $anonymous));
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

        return MAX_commonSlashArray($value);
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


function MAX_getStoredValue($key, $default, $pageName = null, $allowEmpty = false)
{
    global $session, $pgName;
    if (!isset($pageName)) {
        if (isset($pgName)) {
            $pageName = $pgName;
        } else {
            $pageName = basename($_SERVER['SCRIPT_NAME']);
        }
    }

    $value = $default;
    if (isset($_REQUEST[$key]) && (!empty($_REQUEST[$key]) || $allowEmpty)) {
        $value = $_REQUEST[$key];
        MAX_addslashes($value);
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
    $pageName = basename($_SERVER['SCRIPT_NAME']);

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
 * @param array|string Input array.
 * @return array|string Output array with values slashed.
 */
function MAX_commonSlashArray($a)
{
    if (is_array($a)) {
        foreach ($a as $k => $v) {
            $a[$k] = MAX_commonSlashArray($v);
        }
        return $a;
    } else {
        return is_null($a) ? null : addslashes($a);
    }
}


/**
 * Recursively removes slashes from the values in an array.
*
 * @param array|string Input array.
 * @return array|string Output array with values unslashed.
 */
function MAX_commonUnslashArray($a)
{
    if (is_array($a)) {
        foreach ($a as $k => $v) {
            $a[$k] = MAX_commonUnslashArray($v);
        }
        return ($a);
    } else {
        return stripslashes($a);
    }
}


    // +---------------------------------------+
    // | array utilties                        |
    // +---------------------------------------+

function MAX_getStoredArray($key, $default)
{
    global $session;
    $pageName = basename($_SERVER['SCRIPT_NAME']);

    $value = $default;
    if (isset($_REQUEST[$key])) {
        $value = explode(',', $_REQUEST[$key]);
        MAX_addslashes($value);
    } elseif (isset($session['prefs'][$pageName][$key])) {
        $value = explode(',', $session['prefs'][$pageName][$key]);
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
                $aNodes = [];
            } elseif (!in_array($expand, $aNodes)) {
                $aNodes[] = $expand;
            }
        }
    }

    if (!empty($collapse) && in_array($collapse, $aNodes)) {
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
    $aAdZones = Admin_DA::getAdZones(['ad_id' => $adId], true, 'zone_id');
    $aPlacementZones = Admin_DA::getPlacementZones(['placement_id' => $placementId], true, 'zone_id');
    if (!empty($aPlacementZones)) {
        foreach ($aPlacementZones as $zoneId => $aPlacementZone) {
            if (!isset($aAdZones[$zoneId])) {
                Admin_DA::addAdZone(['ad_id' => $adId, 'zone_id' => $zoneId]);
            }
        }
    }
}
// For a given ad id, make sure that zones have correct size/type.  Otherwise, unlink ads from the zone...
function MAX_adjustAdZones($adId)
{
    $aAdZones = Admin_DA::getAdZones(['ad_id' => $adId], true, 'zone_id');
    if (!empty($aAdZones)) {
        $aAd = Admin_DA::getAd($adId);
        $aZones = Admin_DA::getZones(['zone_id' => implode(',', array_keys($aAdZones))], true);
        // get zones linked to this campaign
        $aPlacementZones = Admin_DA::getPlacementZones(['placement_id' => $aAd['placement_id']], true, 'zone_id');
        foreach ($aZones as $zoneId => $aZone) {
            if (!MAX_checkAdZoneValid($aZone, $aAd)) {
                Admin_DA::deleteAdZones(['zone_id' => $zoneId, 'ad_id' => $adId]);
            } else {
                // if ad's campaign is linked to this zone, link ad to zone
                if (isset($aPlacementZones[$zoneId])) {
                    Admin_DA::addAdZone(['zone_id' => $zoneId, 'ad_id' => $adId]);
                }
            }
        }
    }
}

function MAX_adjustZoneAds($zoneId)
{
    $aAdZones = Admin_DA::getAdZones(['zone_id' => $zoneId], true, 'ad_id');
    if (!empty($aAdZones)) {
        $aZone = Admin_DA::getZone($zoneId);
        $aAds = Admin_DA::getAds(['ad_id' => implode(',', array_keys($aAdZones))]);
        foreach ($aAds as $adId => $aAd) {
            if (!MAX_checkAdZoneValid($aZone, $aAd)) {
                Admin_DA::deleteAdZones(['zone_id' => $zoneId, 'ad_id' => $adId]);
            }
        }
    }
}

function MAX_addLinkedAdsToZone($zoneId, $placementId)
{
    $aParams = MAX_getLinkedAdParams($zoneId);
    $aParams['placement_id'] = $placementId;

    $aParams['market_ads_include'] = true;
    $aAds = Admin_DA::getAds($aParams);
    //  FIXME
    $aLinkedAds = Admin_DA::getAdZones(['zone_id' => $zoneId], false, 'ad_id');
    foreach ($aAds as $adId => $aAd) {
        if (!isset($aLinkedAds[$adId])) {
            $ret = Admin_DA::addAdZone(['zone_id' => $zoneId, 'ad_id' => $adId]);
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
    $aParams = [];
    $aZone = Admin_DA::getZone($zoneId);
    if ($aZone['type'] == phpAds_ZoneText) {
        $aParams['ad_type'] = 'txt';
    } else {
        $aParams['ad_type'] = '!txt';
        if ($aZone['type'] == MAX_ZoneEmail) {
            // If the zone is an Email/Newsletter zone, change the existing
            // ad type restriction from !txt to !htmltxt, to also disallow
            // HTML banners as well as text banners
            $aParams['ad_type'] = "!htmltxt";
        }
        if ($aZone['width'] != -1) {
            $aParams['ad_width'] = $aZone['width'];
        }
        if ($aZone['height'] != -1) {
            $aParams['ad_height'] = $aZone['height'];
        }
    }
    // Allow linking *x* banners
    $aParams['ad_nosize'] = true;
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

function MAX_duplicateAdZones($fromAdId, $toAdId)
{
    $aAdZones = Admin_DA::getAdZones(['ad_id' => $fromAdId], true, 'zone_id');
    if (!empty($aAdZones)) {
        foreach ($aAdZones as $zoneId => $adId) {
            Admin_DA::addAdZone(['ad_id' => $toAdId, 'zone_id' => $zoneId]);
        }
    }
}

function MAX_duplicatePlacementZones($fromPlacementId, $toPlacementId)
{
    $pAdZones = Admin_DA::getPlacementZones(['placement_id' => $fromPlacementId], true, 'zone_id');
    if (!empty($pAdZones)) {
        foreach ($pAdZones as $zoneId => $placementId) {
            Admin_DA::addPlacementZone(['placement_id' => $toPlacementId, 'zone_id' => $zoneId], false);
        }
    }
}
