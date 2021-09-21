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
 * @subpackage limitations
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
        if (!isset($GLOBALS['_MAX']['FILES']['aIncludedPlugins'])) {
            $GLOBALS['_MAX']['FILES']['aIncludedPlugins'] = [];
        }
        // Set to true in case of error in eval
        $result = true;
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Include required delivery files...
        if (strlen($row['acl_plugins'])) {
            $acl_plugins = explode(',', $row['acl_plugins']);
            foreach ($acl_plugins as $acl_plugin) {
                list($extension, $package, $name) = explode(':', $acl_plugin);
                $pluginName = MAX_PATH . $aConf['pluginPaths']['plugins'] . "{$extension}/{$package}/{$name}.delivery.php";
                if (!isset($GLOBALS['_MAX']['FILES']['aIncludedPlugins'][$pluginName])) {
                    // If any of the delivery files doesn't exists don't check the delivery limitations
                    if (include($pluginName)) {
                        $GLOBALS['_MAX']['FILES']['aIncludedPlugins'][$pluginName] = true;
                    } else {
                        return true;
                    }
                }
            }
        }
        @eval('$result = (' . $row['compiledlimitation'] . ');');
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
    $showCappedNoCookie = !empty($aAd['show_capped_no_cookie']);
    return (_limitationsIsAdCapped($adId, $aAd['cap_ad'] ?? 0, $aAd['session_cap_ad'] ?? 0, $aAd['block_ad'] ?? 0, $showCappedNoCookie) ||
       _limitationsIsCampaignCapped($campaignId, $aAd['cap_campaign'] ?? 0, $aAd['session_cap_campaign'] ?? 0, $aAd['block_campaign'] ?? 0, $showCappedNoCookie));
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
    $capZone = isset($aCapping['cap_zone']) ? $aCapping['cap_zone'] : null;
    $sessionCapZone = isset($aCapping['session_cap_zone']) ? $aCapping['session_cap_zone'] : null;
    $blockZone = isset($aCapping['block_zone']) ? $aCapping['block_zone'] : null;
    $showCappedNoCookie = !empty($aCapping['show_capped_no_cookie_zone']);
    return (_limitationsIsZoneCapped($zoneId, $capZone, $sessionCapZone, $blockZone, $showCappedNoCookie));
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
function _limitationsIsAdCapped($adId, $cap, $sessionCap, $block, $showCappedNoCookie)
{
    return _limitationsIsCapped('Ad', $adId, $cap, $sessionCap, $block, $showCappedNoCookie);
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
function _limitationsIsCampaignCapped($campaignId, $cap, $sessionCap, $block, $showCappedNoCookie)
{
    return _limitationsIsCapped('Campaign', $campaignId, $cap, $sessionCap, $block, $showCappedNoCookie);
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
function _limitationsIsZoneCapped($zoneId, $cap, $sessionCap, $block, $showCappedNoCookie)
{
    // We set $showCappedNoCookie to false to keep zone capping behaviour the same as
    // in previous versions of OpenX, ie, if a zone is capped, don't show the ad to a
    // viewer without cookies.
    return _limitationsIsCapped('Zone', $zoneId, $cap, $sessionCap, $block, $showCappedNoCookie);
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
 * @param integer $block The time period to use for capping tests (seconds)
 * @param boolean $showCappedNoCookie true if we should show the ad even if there is no cookie.
 * @return boolean True if the ad or zone is capped, false otherwise.
 */
function _limitationsIsCapped($type, $id, $cap, $sessionCap, $block, $showCappedNoCookie)
{
    // Always return true (capped) if cookies have been disabled by the viewer
    // Return true if ( (capping has be set) && (do not show capped ads to users without cookies) )
    if (_areCookiesDisabled((($cap > 0) || ($sessionCap > 0) || ($block > 0)) && !$showCappedNoCookie)) {
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
    $cookieName = $conf['var']['sessionCap' . $type];
    // How many times (session) has the item been by the viewer?
    if (isset($_COOKIE[$cookieName][$id])) {
        $sessionImpressions = $_COOKIE[$cookieName][$id];
    }
    // When was the ad last seen
    $cookieName = $conf['var']['block' . $type];
    if (isset($_COOKIE[$cookieName][$id])) {
        $lastSeen = $_COOKIE[$cookieName][$id];
    }

    // If the ad has been seen the requisite number of times...
    if ((($cap > 0) && isset($totalImpressions) && ($totalImpressions >= $cap)) ||
        (($sessionCap > 0) && isset($sessionImpressions) && ($sessionImpressions >= $sessionCap))) {
        if ($block > 0 && MAX_commonGetTimeNow() > $lastSeen + $block) {
            // This ad was last seen outside the block window, so it can now be seen again
            // The log mechanism will deal with resetting the frequency counter
            return false;
        } else {
            return true;
        }
    } elseif ($block > 0 && ($cap == 0 && $sessionCap == 0) && MAX_commonGetTimeNow() <= $lastSeen + $block) {
        return true;
    } else {
        return false;
    }
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
