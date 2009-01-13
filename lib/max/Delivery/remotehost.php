<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * @author     Andrew Hill <andrew@m3.net>
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
    if (empty($GLOBALS['_OA']['invocationType']) || $run || ($GLOBALS['_OA']['invocationType'] != 'xml-rpc')) {
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
        ###START_STRIP_DELIVERY
        if ($conf['deliveryLog']['enabled']) {
            OA::debug('checking remote host proxy');
        }
        ###END_STRIP_DELIVERY
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
            ###START_STRIP_DELIVERY
            if ($conf['deliveryLog']['enabled']) {
                OA::debug('proxy detected');
            }
            ###END_STRIP_DELIVERY

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
                // only the last item is used in that case
                $ip = explode(',', $ip);
                $ip = trim($ip[count($ip) - 1]);
                // If the found address is not unknown or a private network address
                if (($ip != 'unknown') && (!MAX_remotehostPrivateAddress($ip))) {
                    // Set the "real" remote IP address, and unset
                    // the remote host (as it will be wrong for the
                    // newly found IP address) and HTTP_VIA header
                    // (so that we don't accidently do this twice)
                    $_SERVER['REMOTE_ADDR'] = $ip;
                    $_SERVER['REMOTE_HOST'] = '';
                    $_SERVER['HTTP_VIA']    = '';
                    ###START_STRIP_DELIVERY
                    if ($conf['deliveryLog']['enabled']) {
                        OA::debug('real address set to '.$ip);
                    }
                    ###END_STRIP_DELIVERY
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
    setupIncludePath();
    require_once 'Net/IPv4.php';
    // Define the private address networks, see
    // http://rfc.net/rfc1918.html
    $aPrivateNetworks = array(
        '10.0.0.0/8',
        '172.16.0.0/12',
        '192.168.0.0/16',
        '127.0.0.0/24'
    );
    foreach ($aPrivateNetworks as $privateNetwork) {
        if (Net_IPv4::ipInNetwork($ip, $privateNetwork)) {
            return true;
        }
    }
    return false;
}

?>
