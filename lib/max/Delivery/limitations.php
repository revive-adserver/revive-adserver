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
$Id$
*/

/**
 * @package    MaxDelivery
 * @subpackage limitations
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * This function checks the "compiledlimitation" of an ad and returns
 *   true - This limitation passed (so the ad can be shown)
 *   false - One or more of the delivery limitations failed, so this ad cannot be shown
 *
 * @param array $row The row from the delivery engine Dal for this ad
 * @param string $source Optional The value passed in to the ad-call via the "source" parameter
 * 
 * @return boolean True if the ACL passes, false otherwise
 */
function MAX_limitationsCheckAcl($row, $source = '')
{
    if (!empty($row['compiledlimitation'])) {
        // Set to true in case of error in eval
        $result = true;

        // Include required delivery files...
        if(strlen($row['acl_plugins'])) {
            $acl_plugins = explode(',', $row['acl_plugins']);
            foreach ($acl_plugins as $acl_plugin) {
                list($package, $name) = explode(':', $acl_plugin);
                require_once(MAX_PATH . "/plugins/deliveryLimitations/{$package}/{$name}.delivery.php");
            }
        }
        @eval('$result = (' . $row['compiledlimitation'] . ');');
        return $result;
    } else {
        return true;
    }
}


/**
 * This function checks if the user has cookies enabled in his/her browser.
 * This function works only if MAX_cookieGetUniqueViewerID() has been
 * already called. The function always returns false if this is first
 * visit of the user to the system.
 *
 * @param boolean $filterActive Can only return true if this
 *                parameter is set to true.
 * @return boolean True if the user has cookies disabled, false otherwise.
 */
function _areCookiesDisabled($filterActive = true)
{
    // Since MAX_cookieGetUniqueViewerID() has to have been called by this point
    return !empty($GLOBALS['_MAX']['COOKIE']['newViewerId']) && $filterActive;
}


/**
 * The basic function for checking if a given element (ad or zone) is blocked.
 * @param string $capType Either 'Ad' or 'Zone'.
 * @param int $id The ID of the banner being checked.
 * @param int $block The number of seconds that must pass before this ad can be seen again.
 * 
 * @return boolean True if the ad IS blocked (and so can't be shown) false if the ad is not blocked
 *                 and so can be shown.
 * @see MAX_limitationsIsAdBlocked
 * @see MAX_limitationsIsZoneBlocked
 */
function MAX_limitationsIsBlocked($capType, $id, $block)
{
    if (_areCookiesDisabled($block > 0)) {
        return true;
    }
    
    $conf = $GLOBALS['_MAX']['CONF'];
    $timeLastSeen = $_COOKIE[$conf['var']['block' . $capType]][$id];
    return $block > 0 && isset($timeLastSeen) && (($timeLastSeen + $block) > MAX_commonGetTimeNow());
}


/**
 * Checks whether cap conditions for the element have been fulfilled.
 *
 * @param string $id Id of the element to check.
 * @param string $capModel Either 'cap' or 'sessionCap' followed by either 'Ad' or 'Zone'.
 * @param int $maxViews Maximum number of views allowed
 * @return boolean True if and only if the banner must not be displayed.
 */
function MAX_limitationsIsExceeded($id, $capModel, $maxViews)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	$cViews = $_COOKIE[$conf['var'][$capModel]][$id];
    return ($maxViews > 0) && (isset($cViews) && ($cViews >= $maxViews));
}


/**
 * The basic function to check capping of various elements (eg. 'Ad's or 'Zone's).
 * 
 * @param int $id Id of the element to check.
 * @param int $capping Maximum number of displays for a single user.
 * @param int $session_capping Maximum number of displays in a single session.
 * 
 * @return boolean True - This ad has already been seen the maximum number of times
 *                 False - This ad can be seen
 */
function MAX_limitationsIsCapped($capType, $id, $capping, $session_capping)
{
    if (_areCookiesDisabled(($capping > 0) || ($session_capping > 0))) {
        return true;
    }
    
    return MAX_limitationsIsExceeded($id, 'cap' . $capType, $capping) ||
    	MAX_limitationsIsExceeded($id, 'sessionCap' . $capType, $session_capping);
}


/**
 * This function first checks to see if a viewerId is present
 *   This is so that we don't show blocked ads to a user who won't let us set cookies
 * Then it checks if there is a "last seen" timestamp for this ad present, if so it compares
 * that against the current time, and only 
 *
 * @param int $bannerid The ID of the banner being checked
 * @param int $block The number of seconds that must pass before this ad can be seen again
 * 
 * @return boolean True if the ad IS blocked (and so can't be shown) false if the ad is not blocked
 *                 and so can be shown.
 */
function MAX_limitationsIsAdBlocked($bannerid, $block)
{
	return MAX_limitationsIsBlocked('Ad', $bannerid, $block);
}

/**
 * This function first checks to see if a viewerId is present
 *   This is so that we don't show capped ads to a user who won't let us set cookies
 * Then it checks if there is a "number of times seen" count for this ad present, 
 *   if so it compares that against the maximum times to show this ad
 *
 * @param int $bannerid
 * @param int $capping
 * @param int $session_capping
 * 
 * @return boolean True - This ad has already been seen the maximum number of times
 *                 False - This ad can be seen
 */
function MAX_limitationsIsAdCapped($bannerid, $capping, $session_capping = 0)
{
	return MAX_limitationsIsCapped('Ad', $bannerid, $capping, $session_capping);
}


/**
 * Returns true if zone is blocked to view, false otherwise.
 * Always returns true if a user does not allow cookies.
 * Otherwise checks if the zone have not been displayed for the
 * amount of time passed in the parameter.
 * 
 * @param int $zoneId The ID of the zone to check
 * @param int $block The number of seconds that must pass before this zone can be seen again
 * @return boolean True if the zone IS blocked (and so can't be shown) false if the ad is not blocked
 *                 and so can be shown.
 */
function MAX_limitationsIsZoneBlocked($zoneId, $block)
{
	return MAX_limitationsIsBlocked('Zone', $zoneId, $block);
}


/**
 * Returns true if zone is blocked to view, false otherwise.
 * Always returns true if a user does not allow cookies.
 * Otherwise it checks if there is a "number of times seen" count for this zone present.
 * If so, it compares that against the maximum times to show this zone.
 * 
 * @param int $zoneId
 * @param int $capping
 * @param int $session_capping
 * 
 * @return boolean True - This ad has already been seen the maximum number of times
 *                 False - This ad can be seen
 */
function MAX_limitationsIsZoneCapped($zoneId, $capping, $session_capping = 0)
{
	return MAX_limitationsIsCapped('Zone', $zoneId, $capping, $session_capping);
}


/**
 * Returns true if a zone is blocked or capped, false otherwise.
 * Always returns true if the user does not allow cookies.
 *
 * @param int $zoneId Id of the zone to check.
 * @param array $zoneCapping Array with the values of 'blockZone', 'capZone' and 'sessionCapZone' defined.
 * @return boolean True if the zone is forbidden, false if it can be shown to the user.
 */
function MAX_limitationsIsZoneForbidden($zoneId, $zoneCapping)
{
	return MAX_limitationsIsZoneBlocked($zoneId, $zoneCapping['blockZone'])
		|| MAX_limitationsIsZoneCapped($zoneId, $zoneCapping['capZone'], $zoneCapping['sessionCapZone']);
}


/**
 * Returns true if a banner is blocked or capped, false otherwise.
 * Always returns true if the user does not allow cookies.
 *
 * @param int $bannerid Id of the banner to check.
 * @param array $arrCapping Array with the values of 'block', 'capping' and 'session_capping' defined.
 * @return boolean True if the banner is forbidden, false if it can be shown to the user.
 */
function MAX_limitationsIsAdForbidden($bannerId, $arrCapping)
{
	return MAX_limitationsIsAdBlocked($bannerId, $arrCapping['block'])
		|| MAX_limitationsIsAdCapped($bannerId, $arrCapping['capping'], $arrCapping['session_capping']);
}

?>
