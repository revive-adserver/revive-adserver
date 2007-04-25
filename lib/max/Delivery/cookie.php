<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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
 * @subpackage cookie
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * Set a cookie in the global cookie cache
 *
 * @param string $name name of cookie to be set
 * @param string $value value to be stored in the cookie
 * @param string $expire timestamp at which the cookie should be set to expire
 *
 */
function MAX_cookieSet($name, $value, $expire = 0)
{
    $cookieCache = &$GLOBALS['_MAX']['COOKIE']['CACHE'];
    if (!isset($cookieCache)) {
        $cookieCache = array();
    }
    $cookieCache[$name] = array($value, $expire);
}

/**
 * This function sets the viewerid cookie, and does a header redirect to self
 * this lets us tell if a user allows permenant cookies to be set
 *
 * @param string $viewerId The viewerId value to attempt to set
 */
function MAX_cookieSetViewerIdAndRedirect($viewerId) {
    $conf = $GLOBALS['_MAX']['CONF'];

    MAX_cookieSet($conf['var']['viewerId'], $viewerId, _getTimeYearFromNow());
    MAX_cookieFlush();

    // Determine if the access to Openads was made using HTTPS
    if ($_SERVER['SERVER_PORT'] == $conf['max']['sslPort']) {
        $url = MAX_commonConstructSecureDeliveryUrl(basename($_SERVER['PHP_SELF']));
    } else {
        $url = MAX_commonConstructDeliveryUrl(basename($_SERVER['PHP_SELF']));
    }
    $url .= "?{$conf['var']['cookieTest']}=1&" . $_SERVER['QUERY_STRING'];
    MAX_header("Location: {$url}");
    exit;
}

/**
 * Send all cookies in the global cookie cache to the browser
 *
 */
function MAX_cookieFlush()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $cookieCache =& $GLOBALS['_MAX']['COOKIE']['CACHE'];

    MAX_cookieSendP3PHeaders();

    if (!empty($cookieCache)) {
        // Set cookies
        while (list($name,$v) = each ($cookieCache)) {
            list($value, $expire) = $v;
            MAX_setcookie($name, $value, $expire, '/', (!empty($conf['cookie']['domain']) ? $conf['cookie']['domain'] : null));
        }
        // Clear cache
        $cookieCache = array();
    }

    // Compact all individual cookies into packed except for any cookies for the current bannerid
    // We only need to set these packed cookies if new capping data has been merged
    $cookieNames = MAX_commonGetArrCappingCookieNames();

	if (!is_array($cookieNames))
		return;

    // For each type of cookie, repack if necessary
    foreach ($cookieNames as $cookieName) {
        // We only need to write out the compacted cookie if a new item is to be inserted (or updated)
        if (empty($_COOKIE["_{$cookieName}"])) {
            continue;
        }
        switch ($cookieName) {
            case $conf['var']['blockAd']            : $expire = _getTimeThirtyDaysFromNow(); break;
            case $conf['var']['capAd']              : $expire = _getTimeYearFromNow(); break;
            case $conf['var']['sessionCapAd']       : $expire = 0; break;
            case $conf['var']['blockCampaign']      : $expire = _getTimeThirtyDaysFromNow(); break;
            case $conf['var']['capCampaign']        : $expire = _getTimeYearFromNow(); break;
            case $conf['var']['sessionCapCampaign'] : $expire = 0; break;
            case $conf['var']['blockZone']          : $expire = _getTimeThirtyDaysFromNow(); break;
            case $conf['var']['capZone']            : $expire = _getTimeYearFromNow(); break;
            case $conf['var']['sessionCapZone']     : $expire = 0; break;
        }
        if (!empty($_COOKIE[$cookieName]) && is_array($_COOKIE[$cookieName])) {
            $data = array();
            foreach ($_COOKIE[$cookieName] as $adId => $value) {
                $data[] = "{$adId}.{$value}";
            }
            MAX_setcookie($cookieName, implode('_', $data), $expire, '/', (!empty($conf['cookie']['domain']) ? $conf['cookie']['domain'] : null));
        }
    }
}

function _getTimeThirtyDaysFromNow()
{
	return MAX_commonGetTimeNow() + 30*24*60*60;
}

function _getTimeYearFromNow() //Chris: See comment above
{
	return MAX_commonGetTimeNow() + 365*24*60*60;
}

$GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'] = array();

/**
 * Stores the values of capping cookie names so that they can be later
 * retrieved by MAX_commonGetArrCappingCookieNames() function.
 *
 * @param array $aCookieNames
 */
function MAX_commonSetArrCappingCookieNames($aCookieNames)
{
    $GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'] = $aCookieNames;
}

/**
 * Returns an array of array capping cookie names. If the names weren't
 * initialized previously by a call to MAX_commonSetArrCappingCookieNames()
 * the empty array is returned.
 *
 * @return array
 */
function MAX_commonGetArrCappingCookieNames()
{
	return $GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'];
}

/**
 * This function unpacks the serialized array used for capping
 *
 */
function MAX_cookieUnpackCapping()
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $cookieNames = MAX_commonGetArrCappingCookieNames();

	if (!is_array($cookieNames))
		return;

    // For each type of cookie, unpack and add any newly set cookies to this array
    foreach ($cookieNames as $cookieName) {
        if (!empty($_COOKIE[$cookieName])) {
            if (!is_array($_COOKIE[$cookieName])) {
                $output = array();
                $data = explode('_', $_COOKIE[$cookieName]);
                foreach ($data as $pair) {
                    list($name, $value) = explode('.', $pair);
                    $output[$name] = $value;
                }
                $_COOKIE[$cookieName] = $output;
            }
        }
        if (!empty($_COOKIE['_' . $cookieName]) && is_array($_COOKIE['_' . $cookieName])) {
            foreach ($_COOKIE['_' . $cookieName] as $adId => $cookie) {
                if (_isBlockCookie($cookieName)) {
                    $_COOKIE[$cookieName][$adId] = $cookie;
                } else {
                    if (isset($_COOKIE[$cookieName][$adId])) {
                        $_COOKIE[$cookieName][$adId] += $cookie;
                    } else {
                        $_COOKIE[$cookieName][$adId] = $cookie;
                    }
                }
                // FIXME-Andrzej: temporary cookies do not get deleted
                // Delete the temporary capping cookie
                MAX_cookieSet("_{$cookieName}[{$adId}]", "0", 1);
                // Work around a bug in IE where the cookie name is sometimes URL-encoded
                MAX_cookieSet("%5F" . urlencode($cookieName.'['.$adId.']'), "0", 1);
            }
        }
    }
}

/**
 * A function to return if a cookie name is a "blocking" cookie name
 * (i.e. the ad blocking, campaign blocking or zone blocking cookie
 * name defined in the configuration file).
 *
 * @param string $cookieName The name of the cookie (e.g. "MAXBLOCK").
 * @return boolean True if $cookieName is one of the blocking cookie
 *                 names, false otherwise.
 */
function _isBlockCookie($cookieName)
{
	$conf = $GLOBALS['_MAX']['CONF'];
	if ($cookieName == $conf['var']['blockAd']) {
	    return true;
	}
	if ($cookieName == $conf['var']['blockCampaign']) {
	    return true;
	}
	if ($cookieName == $conf['var']['blockZone']) {
	    return true;
	}
	return false;
}

/**
 * This function gets the unique user ID (creating if necessary)
 * If a new viewerId was created, then a flag is set in $GLOBALS['_MAX']['COOKIE']['newViewerId']
 *
 * @param bool $create Should a viewer ID be created if not present in $_COOKIE ?
 *
 * @return string The viewer ID
 */
function MAX_cookieGetUniqueViewerID($create = true)
{
    $conf = &$GLOBALS['_MAX']['CONF'];
    if (isset($_COOKIE[$conf['var']['viewerId']])) {
        $userid = $_COOKIE[$conf['var']['viewerId']];
    } else {
        if ($create) {
            $remote_address = $_SERVER['REMOTE_ADDR'];
            $local_address  = $conf['webpath']['delivery']; // How do I get the IP address of this server?
            // Get the exact time
            list($usec, $sec) = explode(" ", microtime());
            $time = (float) $usec + (float) $sec;
            // Get a random number
            $random = mt_rand(0,999999999);
            $userid = substr(md5($local_address.$time.$remote_address.$random),0,32);  // Need to find a way to generate this...
            $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
        } else {
            $userid = null;
        }
    }
    return $userid;
}

/**
 * This function generates a psudo-unique user ID based on IP address and user-agent
 *
 * @return string The cookieless viewer ID
 */
function MAX_cookieGetCookielessViewerID()
{
    if (empty($_SERVER['REMOTE_ADDR']) || empty($_SERVER['HTTP_USER_AGENT'])) {
        return '';
    }
    return MAX_COOKIELESS_PREFIX . substr(md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']), 0, 32-(strlen(MAX_COOKIELESS_PREFIX)));
}

/**
 * Send the appropriate P3P headers to attempt to permit 3rd party cookies
 *
 */
function MAX_cookieSendP3PHeaders() {
    // Send P3P headers
    $conf = $GLOBALS['_MAX']['CONF'];

    if ($conf['p3p']['policies']) {
		MAX_header("P3P: ". _generateP3PHeader());
	}
}

/**
 * A function to set any capping cookies (ie. block, cap or sessionCap) that are required
 * for an ad, a campaign or a zone.
 *
 * @param string $type The type of capping to set, one of "Ad", "Campaign" or "Zone".
 * @param integer $id The ID of the ad, campaign or zone that the capping cookies are for.
 * @param integer $block The number of seconds to block the ad, campaign or zone.
 * @param integer $cap The total number of times a viewer can see an ad, an ad from the
 *                     campaign, or an ad in a zone.
 * @param integer $sessionCap The number of times per session that a viewer can see an
 *                            ad, an ad from the campaign, or an ad in a zone.
 */
function MAX_Delivery_cookie_setCapping($type, $id, $block = 0, $cap = 0, $sessionCap = 0)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($block > 0) {
        // This blocking cookie is limited to 30 days
        $expire = _getTimeThirtyDaysFromNow();
        // Store a cookie using the current time so that the system knows when
        // the last time this viewer saw this ad, an ad in this campaign or an
        // ad in this zone
        $timeLastSeen = MAX_commonGetTimeNow();
        MAX_cookieSet("_{$conf['var']['block' . $type]}[{$id}]", $timeLastSeen, $expire);
    }
    if ($cap > 0) {
        // This capping cookie requires a "permanent" expiration time
        $expire = MAX_commonGetTimeNow() + $conf['cookie']['permCookieSeconds'];
        // The unpack capping cookies function deals with imcrementing the counter
        MAX_cookieSet("_{$conf['var']['cap' . $type]}[{$id}]", 1, $expire);
    }
    if ($sessionCap > 0) {
        // The unpack capping cookies function deals with imcrementing the counter
        // The expiry is set to 0 to make a session cookie
        MAX_cookieSet("_{$conf['var']['sessionCap' . $type]}[{$id}]", 1, 0);
    }
}

/**
 * Function to generate the P3P header string
 *
 * @access private
 *
 * @return string P3P header content
 */
function _generateP3PHeader()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $p3p_header = '';
    if ($conf['p3p']['policies']) {
		if ($conf['p3p']['policyLocation'] != '') {
			$p3p_header .= " policyref=\"".$conf['p3p']['policyLocation']."\"";
		}
        if ($conf['p3p']['policyLocation'] != '' && $conf['p3p']['compactPolicy'] != '') {
            $p3p_header .= ", ";
        }
		if ($conf['p3p']['compactPolicy'] != '') {
			$p3p_header .= " CP=\"".$conf['p3p']['compactPolicy']."\"";
		}
    }
    return $p3p_header;
}

?>