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

$file = '/lib/max/Delivery/remotehost.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * @package    MaxDelivery
 * @subpackage remotehost
 *
 * A file to contain delivery engine functions related to obtaining data
 * about the remote viewer.
 */

/**
 * Wrapper function to set all remotehost information, by default this will execute if the invocationType is
 * not set to "xml-rpc" (xml-rpc calls this after re-populating the $_SERVER array)
 *
 * @param boolean $run Ignore invocationType checking?
 */
function MAX_remotehostSetInfo($run = false)
{
    if (empty($GLOBALS['_OA']['invocationType']) || $run || ($GLOBALS['_OA']['invocationType'] != 'xmlrpc')) {
        MAX_remotehostProxyLookup();
        MAX_remotehostReverseLookup();
        //MAX_remotehostSetClientInfo();  // now moved into plugin
        MAX_remotehostSetGeoInfo();
    }
}

/**
 * A function to convert the $_SERVER['REMOTE_ADDR'] global variable
 * from the current value to the real remote viewer's value, should
 * that viewer be coming via an HTTP proxy.
 *
 * Only performs this conversion if the option to do so is set in the
 * configuration file.
 */
function MAX_remotehostProxyLookup()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    // Should proxy lookup conversion be performed?
    if ($conf['logging']['proxyLookup']) {
        OX_Delivery_logMessage('checking remote host proxy', 7);
        // Determine if the viewer has come via an HTTP proxy
        $proxy = false;
        if (!empty($_SERVER['HTTP_VIA']) || !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $proxy = true;
        } elseif (!empty($_SERVER['REMOTE_HOST'])) {
            $aProxyHosts = array(
                'proxy',
                'cache',
                'inktomi'
            );
            foreach ($aProxyHosts as $proxyName) {
                if (strpos($_SERVER['REMOTE_HOST'], $proxyName) !== false) {
                    $proxy = true;
                    break;
                }
            }
        }
        // Has the viewer come via an HTTP proxy?
        if ($proxy) {
            OX_Delivery_logMessage('proxy detected', 7);

            // Try to find the "real" IP address the viewer has come from
            $aHeaders = array(
                'HTTP_FORWARDED',
                'HTTP_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_CLIENT_IP'
            );
            foreach ($aHeaders as $header) {
                if (!empty($_SERVER[$header])) {
                    $ip = $_SERVER[$header];
                    break;
                }
            }
            if (!empty($ip)) {
                // The "remote IP" may be a list, ensure that
                // only the FIRST non-private value is used in that case
                // See http://en.wikipedia.org/wiki/X-Forwarded-For#Format
                foreach (explode(',', $ip) as $ip) {
                    $ip = trim($ip);
                    // If the found address is not unknown or a private network address
                    if (($ip != 'unknown') && (!MAX_remotehostPrivateAddress($ip))) {
                        // Set the "real" remote IP address, and unset
                        // the remote host (as it will be wrong for the
                        // newly found IP address) and HTTP_VIA header
                        // (so that we don't accidently do this twice)
                        $_SERVER['REMOTE_ADDR'] = $ip;
                        $_SERVER['REMOTE_HOST'] = '';
                        $_SERVER['HTTP_VIA']    = '';
                        OX_Delivery_logMessage('real address set to '.$ip, 7);
                        break;
                    }
                }
            }
        }
    }
}

/**
 * A function to perform a reverse lookup of the hostname from the IP address,
 * and store the result in the $_SERVER['REMOTE_HOST'] global variable.
 *
 * Only performs the reverse lookup if the option is set in the configuration,
 * and if the host name is not already present. If the the host name is not
 * present and the option to perform the lookup is not set, then the host name
 * is set to the remote IP address instead.
 */
function MAX_remotehostReverseLookup()
{
    // Is the remote host name already set?
    if (empty($_SERVER['REMOTE_HOST'])) {
        // Should reverse lookups be performed?
        if ($GLOBALS['_MAX']['CONF']['logging']['reverseLookup']) {
            $_SERVER['REMOTE_HOST'] = @gethostbyaddr($_SERVER['REMOTE_ADDR']);
        } else {
            $_SERVER['REMOTE_HOST'] = $_SERVER['REMOTE_ADDR'];
        }
    }
}
/**
 * A function to set the viewer's geotargeting information in the
 * $GLOBALS['_MAX']['CLIENT_GEO'] global variable, if a plugin for
 * geotargeting information is configured.
 *
 * @todo This is a workaround to avoid having to include the entire plugin architecure
 *       just to be able to load the config information. The plugin system should be
 *       refactored to allow the Delivery Engine to load the information independently
 */
function MAX_remotehostSetGeoInfo()
{
    if (!function_exists('parseDeliveryIniFile')) {
        require_once MAX_PATH . '/init-delivery-parse.php';
    }
    $aConf = $GLOBALS['_MAX']['CONF'];
    $type = (!empty($aConf['geotargeting']['type'])) ? $aConf['geotargeting']['type'] : null;
    if (!is_null($type) && $type != 'none') {
        $aComponent = explode(':', $aConf['geotargeting']['type']);
        if (!empty($aComponent[1]) && (!empty($aConf['pluginGroupComponents'][$aComponent[1]]))) {
            $GLOBALS['_MAX']['CLIENT_GEO'] = OX_Delivery_Common_hook('getGeoInfo', array(), $type);
        }
    }
}

/**
 * A function to determine if a given IP address is in a private network or
 * not.
 *
 * @param string $ip The IP address to check.
 * @return boolean Returns true if the IP address is in a private network,
 *                 false otherwise.
 */
function MAX_remotehostPrivateAddress($ip)
{
	$ip = ip2long($ip);

	if (!$ip) return false;

	return (MAX_remotehostMatchSubnet($ip, '10.0.0.0', 8) ||
		MAX_remotehostMatchSubnet($ip, '172.16.0.0', 12) ||
		MAX_remotehostMatchSubnet($ip, '192.168.0.0', 16) ||
		MAX_remotehostMatchSubnet($ip, '127.0.0.0', 8)
    );
}

function MAX_remotehostMatchSubnet($ip, $net, $mask)
{
	$net = ip2long($net);

	if (!is_integer($ip)) {
        $ip = ip2long($ip);
    }

	if (!$ip || !$net) {
		return false;
    }

	if (is_integer($mask)) {
		// Netmask notation x.x.x.x/y used

		if ($mask > 32 || $mask <= 0)
			return false;
		elseif ($mask == 32)
			$mask = ~0;
		else
			$mask = ~((1 << (32 - $mask)) - 1);
	} elseif (!($mask = ip2long($mask))) {
		return false;
    }

	return ($ip & $mask) == ($net & $mask) ? true : false;
}
