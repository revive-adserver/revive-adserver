<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
 * @author     Andrew Hill <andrew.hill@openads.org>
 */

/**
 * This function checks the "compiledlimitation" of an ad and returns
 *   true - This limitation passed (so the ad can be shown)
 *   false - One or more of the delivery limitations failed, so this ad cannot be shown
 *
 * @param array $row The row from the delivery engine Dal for this ad
 * @param string $source Optional The value passed in to the ad-call via the "source" parameter
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
        $GLOBALS['_MAX']['CHANNELS'] = '';
        @eval('$result = (' . $row['compiledlimitation'] . ');');
        if (!$result)
        {
            unset($GLOBALS['_MAX']['CHANNELS']);
        }
        else
        {
            $GLOBALS['_MAX']['CHANNELS'] .= MAX_DELIVERY_MULTIPLE_DELIMITER;
        }
        return $result;
    } else {
        return true;
    }
}

/**
 * A function to test if an ad may or may not be delivered, based on that ad's
 * ad blocking, ad capping, campaign blocking and campaign capping rules.
 *
 * Returns true if the ad is blocked or capped (and hence cannot be delivered),
 * false otherwise (in which case the ad can be delivered).
 *
 * Always returns true if the viewer does not allow cookies to be set, so that
 * blocking and capping cannot be circumvented by disabling cookies.
 *
 * @param array $aAd An array with the values of 'block_ad', 'cap_ad',
 *                   'session_cap_ad', 'block_campaign', 'cap_campaign' and
 *                   'session_cap_campaign' defined.
 * @return boolean True if the ad is blocked or capped, false otherwise.
 */
function MAX_limitationsIsAdForbidden($aAd)
{
    $adId = $aAd['ad_id'];
    $campaignId = $aAd['placement_id'];
	return (_limitationsIsAdBlocked($adId, $aAd['block_ad']) ||
	   _limitationsIsAdCapped($adId, $aAd['cap_ad'], $aAd['session_cap_ad']) ||
	   _limitationsIsCampaignBlocked($campaignId, $aAd['block_campaign']) ||
	   _limitationsIsCampaignCapped($campaignId, $aAd['cap_campaign'], $aAd['session_cap_campaign']));
}

/**
 * A function to test if ads in a zone may or may not be delivered, based on that zone's
 * zone blocking and zone capping rules.
 *
 * Returns true if a zone is blocked or capped (and hence an ad from the zone cannot be
 * delivered), false otherwise (in which case the ads from the zone can be delivered).
 *
 * Always returns true if the viewer does not allow cookies to be set, so that
 * blocking and capping cannot be circumvented by disabling cookies.
 *
 * @param integer $zoneId The ID of the zone to check.
 * @param array $aCapping An array with the values of 'block_zone', 'cap_zone' and
 *                        'session_cap_zone' defined.
 * @return boolean True if the zone is blocked or capped, false otherwise.
 */
function MAX_limitationsIsZoneForbidden($zoneId, $aCapping)
{
    return (_limitationsIsZoneBlocked($zoneId, $aCapping['block_zone']) ||
       _limitationsIsZoneCapped($zoneId, $aCapping['cap_zone'], $aCapping['session_cap_zone']));
}

/**
 * A "private" function to test if an ad is blocked as a result of an ad block limitation.
 *
 * @access private
 * @param integer $adId The ID of the ad to check.
 * @param integer $block The number of seconds the ad is to be blocked for after it is shown
 *                       to a viewer.
 * @return boolean True if the ad is blocked, false otherwise.
 */
function _limitationsIsAdBlocked($adId, $block)
{
	return _limitationsIsBlocked('Ad', $adId, $block);
}

/**
 * A "private" function to test if an ad is blocked as a result of a campaign block limitation.
 *
 * @access private
 * @param integer $adId The ID of the campaign to check.
 * @param integer $block The number of seconds the ad is to be blocked for after it is shown
 *                       to a viewer.
 * @return boolean True if the ad is blocked, false otherwise.
 */
function _limitationsIsCampaignBlocked($campaignId, $block)
{
	return _limitationsIsBlocked('Campaign', $campaignId, $block);
}

/**
 * A "private" function to test if a zone is blocked as a result of a zone block limitation.
 *
 * @access private
 * @param integer $zoneId The ID of the zone to check.
 * @param integer $block The number of seconds the zone is to be blocked for after it is shown
 *                       to a viewer.
 * @return boolean True if the zone is blocked, false otherwise.
 */
function _limitationsIsZoneBlocked($zoneId, $block)
{
	return _limitationsIsBlocked('Zone', $zoneId, $block);
}

/**
 * A "private" function to test if an ad is capped as a result of an ad capping or
 * ad session capping limitation.
 *
 * @access private
 * @param integer $adId The ID of the ad to check.
 * @param integer $cap The total number of times the ad is to be shown to a viewer.
 * @param integer $sessionCap Optional total number of times the ad is to be shown
 *                            to a viewer in a session.
 * @return boolean True if the ad is capped, false otherwise.
 */
function _limitationsIsAdCapped($adId, $cap, $sessionCap = 0)
{
	return _limitationsIsCapped('Ad', $adId, $cap, $sessionCap);
}

/**
 * A "private" function to test if an ad is capped as a result of a campaign capping or
 * ad session capping limitation.
 *
 * @access private
 * @param integer $adId The ID of the campaign to check.
 * @param integer $cap The total number of times the ad is to be shown to a viewer.
 * @param integer $sessionCap Optional total number of times the ad is to be shown
 *                            to a viewer in a session.
 * @return boolean True if the ad is capped, false otherwise.
 */
function _limitationsIsCampaignCapped($campaignId, $cap, $sessionCap = 0)
{
	return _limitationsIsCapped('Campaign', $campaignId, $cap, $sessionCap);
}

/**
 * A "private" function to test if a zone is capped as a result of a zone capping or
 * zone session capping limitation.
 *
 * @access private
 * @param integer $zoneId The ID of the zone to check.
 * @param integer $cap The total number of times the zone is to be shown to a viewer.
 * @param integer $sessionCap Optional total number of times the zone is to be shown
 *                            to a viewer in a session.
 * @return boolean True if the zone is capped, false otherwise.
 */
function _limitationsIsZoneCapped($zoneId, $cap, $sessionCap = 0)
{
	return _limitationsIsCapped('Zone', $zoneId, $cap, $sessionCap);
}

/**
 * A "private" function to test to see if a block limitation for an ad or zone item needs
 * to be enforced.
 *
 * @access private
 * @param string $type The block limitation type - one of "Ad", "Campaign" or "Zone".
 * @param integer $id The ID of the ad, campaign or zone to check.
 * @param integer $block The number of seconds the ad or zone is to be blocked for after it is
 *                       shown to a viewer.
 * @return boolean True if the ad or zone is blocked, false otherwise.
 */
function _limitationsIsBlocked($type, $id, $block)
{
    // Always return true (blocked) if cookies have been disabled by the viewer
    if (_areCookiesDisabled($block > 0)) {
        return true;
    }
    // Get the block cookie name from the configuration file
    $conf = $GLOBALS['_MAX']['CONF'];
    $cookieName = $conf['var']['block' . $type];
    // When was the item last seen by the viewer?
    if (isset($_COOKIE[$cookieName][$id])) {
        $timeLastSeen = $_COOKIE[$cookieName][$id];
    }
    // Return if the item is blocked, or not
    return ($block > 0) && isset($timeLastSeen) && (($timeLastSeen + $block) > MAX_commonGetTimeNow());
}

/**
 * A "private" function to test to see if a capping limitation for an ad or zone item needs
 * to be enforced.
 *
 * @access private
 * @param string $type The capping limitation type - one of "Ad", "Campaign" or "Zone".
 * @param integer $id The ID of the ad, campaign or zone to check.
 * @param integer $cap The total number of times an ad or an ad from a zone is to be shown
 *                     to a viewer.
 * @param integer $sessionCap Optional total number of times an ad or an ad from a zone is
 *                            to be shown to a viewer in a session.
 * @return boolean True if the ad or zone is capped, false otherwise.
 */
function _limitationsIsCapped($type, $id, $cap, $sessionCap)
{
    // Always return true (capped) if cookies have been disabled by the viewer
    if (_areCookiesDisabled(($cap > 0) || ($sessionCap > 0))) {
        return true;
    }
    // Get the capping cookie name from the configuration file
    $conf = $GLOBALS['_MAX']['CONF'];
    $cookieName = $conf['var']['cap' . $type];
    // How many times (total) has the item been by the viewer?
    if (isset($_COOKIE[$cookieName][$id])) {
        $totalImpressions = $_COOKIE[$cookieName][$id];
    }
    // Get the session capping cookie name from the configuration file
    $conf = $GLOBALS['_MAX']['CONF'];
    $cookieName = $conf['var']['sessionCap' . $type];
    // How many times (session) has the item been by the viewer?
    if (isset($_COOKIE[$cookieName][$id])) {
        $sessionImpressions = $_COOKIE[$cookieName][$id];
    }
    // Return if the item is capped, or not
    return ((($cap > 0) && isset($totalImpressions) && ($totalImpressions >= $cap)) ||
        (($sessionCap > 0) && isset($sessionImpressions) && ($sessionImpressions >= $sessionCap)));
}

/**
 * A "private" function to test is the viewer has cookies disabled.
 *
 * Works by testing to see if the MAX_cookieGetUniqueViewerID() function
 * has been able to set a cookie, or not.
 *
 * It is a pre-condition of this function that the MAX_cookieGetUniqueViewerID()
 * function have already been called, as this function does not attempt to
 * call the MAX_cookieGetUniqueViewerID() if no cookie exists because the
 * function was not called.
 *
 * @access private
 * @param boolean $filterActive Function always returns true when set to true.
 * @return boolean True if the user has cookies disabled, false otherwise.
 */
function _areCookiesDisabled($filterActive = true)
{
    // Since MAX_cookieGetUniqueViewerID() has to have been called by this point
    return !empty($GLOBALS['_MAX']['COOKIE']['newViewerId']) && $filterActive;
}

?>
