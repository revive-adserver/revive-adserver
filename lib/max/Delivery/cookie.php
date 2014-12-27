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
 * @subpackage cookie
 */

$file = '/lib/max/Delivery/cookie.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

$GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'] = array();

// Include the cookie storage library
if (!is_callable('MAX_cookieSet')) {
    if (!empty($conf['cookie']['plugin']) && is_readable(MAX_PATH . "/plugins/cookieStorage/{$conf['cookie']['plugin']}.delivery.php")) {
        include MAX_PATH . "/plugins/cookieStorage/{$conf['cookie']['plugin']}.delivery.php";
    } else {
        function MAX_cookieSet($name, $value, $expire, $path = '/', $domain = null) { return MAX_cookieClientCookieSet($name, $value, $expire, $path, $domain); }
        function MAX_cookieUnset($name) { return MAX_cookieClientCookieUnset($name); }
        function MAX_cookieFlush() { return MAX_cookieClientCookieFlush(); }
        function MAX_cookieLoad() { return true; }
    }
}

/**
 * Adds a cookie into the global cookie cache
 *
 * @param string $name name of cookie to be set
 * @param string $value value to be stored in the cookie
 * @param string $expire timestamp at which the cookie should be set to expire
 *
 */
function MAX_cookieAdd($name, $value, $expire = 0)
{
    if (!isset($GLOBALS['_MAX']['COOKIE']['CACHE'])) {
        $GLOBALS['_MAX']['COOKIE']['CACHE'] = array();
    }
    $GLOBALS['_MAX']['COOKIE']['CACHE'][$name] = array($value, $expire);
}

/**
 * This function sets the viewerid cookie, and does a header redirect to self
 * this lets us tell if a user allows permenant cookies to be set
 *
 * @param string $viewerId The viewerId value to attempt to set
 */
function MAX_cookieSetViewerIdAndRedirect($viewerId) {
    $aConf = $GLOBALS['_MAX']['CONF'];

    MAX_cookieAdd($aConf['var']['viewerId'], $viewerId, _getTimeYearFromNow());
    MAX_cookieFlush();

    // Determine if the access to OpenX was made using HTTPS
    if ($GLOBALS['_MAX']['SSL_REQUEST']) {
        $url = MAX_commonConstructSecureDeliveryUrl(basename($_SERVER['SCRIPT_NAME']));
    } else {
        $url = MAX_commonConstructDeliveryUrl(basename($_SERVER['SCRIPT_NAME']));
    }
    $url .= "?{$aConf['var']['cookieTest']}=1&" . $_SERVER['QUERY_STRING'];
    MAX_header("Location: {$url}");

    ###START_STRIP_DELIVERY
    if(empty($GLOBALS['is_simulation']) && !defined('TEST_ENVIRONMENT_RUNNING')) {
    ###END_STRIP_DELIVERY
        exit;
    ###START_STRIP_DELIVERY
    }
    ###END_STRIP_DELIVERY
}

function _getTimeThirtyDaysFromNow()
{
	return MAX_commonGetTimeNow() + 2592000; // 30*24*60*60;
}

function _getTimeYearFromNow()
{
	return MAX_commonGetTimeNow() + 31536000; // 365*24*60*60;
}

function _getTimeYearAgo()
{
    return MAX_commonGetTimeNow() - 31536000; // 365*24*60*60;
}

/**
 * This function unpacks the serialized array used for capping
 *
 */
function MAX_cookieUnpackCapping()
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $cookieNames = $GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'];

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
                // Delete the temporary capping cookie
                MAX_cookieUnset("_{$cookieName}[{$adId}]");
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
    return in_array($cookieName, array(
        $GLOBALS['_MAX']['CONF']['var']['blockAd'],
        $GLOBALS['_MAX']['CONF']['var']['blockCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['blockZone'],
        $GLOBALS['_MAX']['CONF']['var']['lastView'],
        $GLOBALS['_MAX']['CONF']['var']['lastClick'],
        $GLOBALS['_MAX']['CONF']['var']['blockLoggingClick'],
    ));
}

/**
 * This function gets the unique user ID (creating if necessary)
 * If a new viewerId was created, then a flag is set in $GLOBALS['_MAX']['COOKIE']['newViewerId']
 *
 * @param bool $create Should a viewer ID be created if not present in $_COOKIE ?
 *
 * @return string The viewer ID
 */
function MAX_cookieGetUniqueViewerId($create = true)
{
    static $uniqueViewerId = null;
    if(!is_null($uniqueViewerId)) {
        return $uniqueViewerId;
    }
    $conf = $GLOBALS['_MAX']['CONF'];
    if (isset($_COOKIE[$conf['var']['viewerId']])) {
        $uniqueViewerId = $_COOKIE[$conf['var']['viewerId']];
    } elseif ($create) {
        $uniqueViewerId = md5(uniqid('', true));  // Need to find a way to generate this...
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = true;
    }
    return $uniqueViewerId;
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
    $cookiePrefix = $GLOBALS['_MAX']['MAX_COOKIELESS_PREFIX'];
    return $cookiePrefix . substr(md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']), 0, 32-(strlen($cookiePrefix)));
}

/**
 * A function to check when capping cookies need to be set.
 *
 * @return boolean True if cookies need to be set on request
 */
function MAX_Delivery_cookie_cappingOnRequest()
{
    // view and xmlrpc invocation types must set capping-on-request for technical reasons
    if (isset($GLOBALS['_OA']['invocationType']) &&
        ($GLOBALS['_OA']['invocationType'] == 'xmlrpc' || $GLOBALS['_OA']['invocationType'] == 'view')
    ) {

        return true;
    }

    return !$GLOBALS['_MAX']['CONF']['logging']['adImpressions'];
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
    $setBlock = false;

    if ($cap > 0) {
        // This capping cookie requires a "permanent" expiration time
        $expire = MAX_commonGetTimeNow() + $conf['cookie']['permCookieSeconds'];
        // The unpack capping cookies function adds this value to the counter, so to reset it we add a negative number
        if (!isset($_COOKIE[$conf['var']['cap' . $type]][$id])) {
            $value = 1;
            $setBlock = true;
        } else if ($_COOKIE[$conf['var']['cap' . $type]][$id] >= $cap) {
            $value = -$_COOKIE[$conf['var']['cap' . $type]][$id]+1;
            // Also reset the last-seen when resetting the frequency counter
            $setBlock = true;
        } else {
            $value = 1;
        }
        MAX_cookieAdd("_{$conf['var']['cap' . $type]}[{$id}]", $value, $expire);
    }
    if ($sessionCap > 0) {
        // The unpack capping cookies function deals with imcrementing the counter
        // The expiry is set to 0 to make a session cookie
        // The unpack capping cookies function adds this value to the counter, so to reset it we add a negative number
        if (!isset($_COOKIE[$conf['var']['sessionCap' . $type]][$id])) {
            $value = 1;
            $setBlock = true;
        } else if ($_COOKIE[$conf['var']['sessionCap' . $type]][$id] >= $sessionCap) {
            $value = -$_COOKIE[$conf['var']['sessionCap' . $type]][$id]+1;
            // Also reset the last-seen when resetting the frequency counter
             $setBlock = true;
        } else {
            $value = 1;
        }
        MAX_cookieAdd("_{$conf['var']['sessionCap' . $type]}[{$id}]", $value, 0);
    }
    if ($block > 0 || $setBlock) {
        // This blocking cookie is limited to 30 days
        // Store a cookie using the current time so that the system knows when
        // the last time this viewer saw this ad, an ad in this campaign or an
        // ad in this zone
        MAX_cookieAdd("_{$conf['var']['block' . $type]}[{$id}]", MAX_commonGetTimeNow(), _getTimeThirtyDaysFromNow());
    }
}

/**
 * This function sets a cookie in the client's browser
 *
 * @param string $name  - The name of the cookie to set
 * @param mixed  $value - The value to set for this cookie
 * @param int    $expire- The expiry time (unix timestamp) of this cookie
 * @param string $path  - The (optional) path that this cookie is valid for
 * @param string $domain- The (optional) domain to set this cookie under
 *
 * @return null
 */
function MAX_cookieClientCookieSet($name, $value, $expire, $path = '/', $domain = null)
{
    ###START_STRIP_DELIVERY
    if(empty($GLOBALS['is_simulation']) && !defined('TEST_ENVIRONMENT_RUNNING')) {
    ###END_STRIP_DELIVERY
        if (isset($GLOBALS['_OA']['invocationType']) && $GLOBALS['_OA']['invocationType'] == 'xmlrpc') {
            if (!isset($GLOBALS['_OA']['COOKIE']['XMLRPC_CACHE'])) {
                $GLOBALS['_OA']['COOKIE']['XMLRPC_CACHE'] = array();
            }
            $GLOBALS['_OA']['COOKIE']['XMLRPC_CACHE'][$name] = array($value, $expire);
        } else {
            @setcookie($name, $value, $expire, $path, $domain);
        }
    ###START_STRIP_DELIVERY
    } else {
       $_COOKIE[$name] = $value;
    }
    ###END_STRIP_DELIVERY
}

function MAX_cookieClientCookieUnset($name)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $domain = (!empty($conf['cookie']['domain'])) ? $conf['cookie']['domain'] : null;
    MAX_cookieSet($name, false, _getTimeYearAgo(), '/', $domain);
    // Work around a bug in IE where the cookie name is sometimes URL-encoded
    MAX_cookieSet(str_replace('_', '%5F', urlencode($name)), false, _getTimeYearAgo(), '/', $domain);
}

/**
 * Send all cookies in the global cookie cache to the browser
 */
function MAX_cookieClientCookieFlush()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $domain = !empty($conf['cookie']['domain']) ? $conf['cookie']['domain'] : null;

    MAX_cookieSendP3PHeaders();

    if (!empty($GLOBALS['_MAX']['COOKIE']['CACHE'])) {
        // Set cookies
        reset($GLOBALS['_MAX']['COOKIE']['CACHE']);
        while (list($name,$v) = each ($GLOBALS['_MAX']['COOKIE']['CACHE'])) {
            list($value, $expire) = $v;
            // Treat the viewerId cookie differently, (always set in client)
            if ($name == $conf['var']['viewerId']) {
                MAX_cookieClientCookieSet($name, $value, $expire, '/', !empty($conf['cookie']['viewerIdDomain']) ? $conf['cookie']['viewerIdDomain'] : $domain);
            } else {
                MAX_cookieSet($name, $value, $expire, '/', $domain);
            }
        }
        // Clear cache
        $GLOBALS['_MAX']['COOKIE']['CACHE'] = array();
    }

    // Compact all individual cookies into packed except for any cookies for the current bannerid
    // We only need to set these packed cookies if new capping data has been merged
    $cookieNames = $GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'];

	if (!is_array($cookieNames))
		return;

    $maxCookieSize = !empty($conf['cookie']['maxCookieSize']) ? $conf['cookie']['maxCookieSize'] : 2048;

    // For each type of cookie, repack if necessary
    foreach ($cookieNames as $cookieName) {
        // We only need to write out the compacted cookie if a new item is to be inserted (or updated)
        if (empty($_COOKIE["_{$cookieName}"])) {
            continue;
        }
        switch ($cookieName) {
            case $conf['var']['blockAd']            :
            case $conf['var']['blockCampaign']      :
            case $conf['var']['blockZone']          : $expire = _getTimeThirtyDaysFromNow(); break;
            case $conf['var']['lastClick']          :
            case $conf['var']['lastView']           :
            case $conf['var']['capAd']              :
            case $conf['var']['capCampaign']        :
            case $conf['var']['capZone']            : $expire = _getTimeYearFromNow(); break;
            case $conf['var']['sessionCapCampaign'] :
            case $conf['var']['sessionCapAd']       :
            case $conf['var']['sessionCapZone']     : $expire = 0; break;
        }
        if (!empty($_COOKIE[$cookieName]) && is_array($_COOKIE[$cookieName])) {
            $data = array();
            foreach ($_COOKIE[$cookieName] as $adId => $value) {
                $data[] = "{$adId}.{$value}";
            }
            // RFC says that maximum cookie data length is 4096 bytes
            // So we are assuming that 2048 will be valid in most browsers
            // Discard oldest data until we are under the limit
            while (strlen(implode('_', $data)) > $maxCookieSize) {
                $data = array_slice($data, 1);
            }
            MAX_cookieSet($cookieName, implode('_', $data), $expire, '/', $domain);
        }
    }
}

/**
 * Send the appropriate P3P headers to attempt to permit 3rd party cookies
 *
 */
function MAX_cookieSendP3PHeaders() {
    // Send P3P headers
    if ($GLOBALS['_MAX']['CONF']['p3p']['policies']) {
		MAX_header("P3P: ". _generateP3PHeader());
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
