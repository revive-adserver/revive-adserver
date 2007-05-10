<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/lib/max/Delivery/cookie.php';
require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';
require_once MAX_PATH . '/lib/max/Delivery/log.php';

/**
 * @package    MaxDelivery
 * @subpackage common
 * @author     Chris Nutting <chris@m3.net>
 *
 * This library defines functions that need to be available to
 * all delivery engine scripts
 *
 */

/**
 * A function that can be used to get the delivery URL,
 * or the delivery URL prefix (sans-file) if no filname
 * is passed in.
 *
 * @param string $file Optional delivery file name.
 * @return string The delivery URL.
 */
function MAX_commonGetDeliveryUrl($file = null)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == $conf['max']['sslPort']) {
        $url = MAX_commonConstructSecureDeliveryUrl($file);
    } else {
        $url = MAX_commonConstructDeliveryUrl($file);
    }
    return $url;
}

/**
 * A function to generate the URL for delivery scripts.
 *
 * @param string $file The file name of the delivery script.
 * @return string The URL to the delivery script.
 */
function MAX_commonConstructDeliveryUrl($file)
{
        $conf = $GLOBALS['_MAX']['CONF'];
        return 'http://' . $conf['webpath']['delivery'] . '/' . $file;
}

/**
 * A function to generate the secure URL for delivery scripts.
 *
 * @param string $file The file name of the delivery script.
 * @return string The URL to the delivery script.
 */
function MAX_commonConstructSecureDeliveryUrl($file)
{
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($conf['max']['sslPort'] != 443) {
            // Fix the delivery host
            $path = preg_replace('#/#', ':' . $conf['max']['sslPort'] . '/', $conf['webpath']['deliverySSL']);
        } else {
            $path = $conf['webpath']['deliverySSL'];
        }
        return 'https://' . $path . '/' . $file;
}

/**
 * A function to generate the URL for delivery scripts without a protocol.
 *
 * @param string $file The file name of the delivery script.
 * @param boolean $ssl Use the SSL delivery path (true) or not. Default is false.
 * @return string The parital URL to the delivery script (i.e. without
 *                an 'http:' or 'https:' prefix).
 */
function MAX_commonConstructPartialDeliveryUrl($file, $ssl = false)
{
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($ssl) {
            return '//' . $conf['webpath']['deliverySSL'] . '/' . $file;
        } else {
            return '//' . $conf['webpath']['delivery'] . '/' . $file;
        }
}

/**
 * Remove an assortment of special characters from a variable or array:
 * 1.  Strip slashes if magic quotes are turned on.
 * 2.  Strip out any HTML
 * 3.  Strip out any CRLF
 * 4.  Remove any white space
 *
 * @access  public
 * @param   string $var  The variable to process.
 * @return  string       $var, minus any special quotes.
 */
function MAX_commonRemoveSpecialChars(&$var)
{
    static $magicQuotes;
    if (!isset($magicQuotes)) {
        $magicQuotes = get_magic_quotes_gpc();
    }
    if (isset($var)) {
        if (!is_array($var)) {
            if ($magicQuotes) {
                $var = stripslashes($var);
            }
            $var = strip_tags($var);
            $var = str_replace(array("\n", "\r"), array('', ''), $var);
            $var = trim($var);
        } else {
            array_walk($var, 'MAX_commonRemoveSpecialChars');
        }
    }
}

/**
 * This function sends the anti-caching headers when called
 *
 */
function MAX_commonSetNoCacheHeaders()
{
    MAX_header('Pragma: no-cache');
    MAX_header('Cache-Control: private, max-age=0, no-cache');
    MAX_header('Date: '.gmdate('D, d M Y H:i:s', MAX_commonGetTimeNow()).' GMT');
}

/**
 * This function takes an array of variable names
 * and makes them available in the global scope
 *
 * $_POST values take precedence over $_GET values
 *
 */
function MAX_commonRegisterGlobalsArray($args = array())
{
    static $magic_quotes_gpc;
    if (!isset($magic_quotes_gpc)) {
        $magic_quotes_gpc = ini_get('magic_quotes_gpc');
    }

    $found = false;
    foreach($args as $key) {
        if (isset($_GET[$key])) {
            $value = $_GET[$key];
            $found = true;
        }
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            $found = true;
        }
        if ($found) {
            if (!$magic_quotes_gpc) {
                if (!is_array($value)) {
                    $value = addslashes($value);
                } else {
                    $value = MAX_commonSlashArray($value);
                }
            }
            $GLOBALS[$key] = $value;
            $found = false;
        }
    }
}

/**
 * This function takes the "source" value and normalises it
 * and encrypts it if necessary
 *
 * @param string The value from the source parameter
 * @return string Encrypted source
 */
function MAX_commonDeriveSource($source)
{
    return MAX_commonEncrypt(trim(urldecode($source)));
}

/**
 * This function takes a normalised source value, and encrypts it
 * if the $conf['delivery']['obfuscate'] variable is set
 *
 * @param string $string
 * @return string Encrypted source
 */
function MAX_commonEncrypt($string)
{
    $convert = '';
    if (isset($string) && substr($string,1,4) != 'obfs' && $GLOBALS['_MAX']['CONF']['delivery']['obfuscate']) {
        $strLen = strlen($string);
        for ($i=0; $i < $strLen; $i++) {
            $dec = ord(substr($string,$i,1));
            if (strlen($dec) == 2) {
                $dec = 0 . $dec;
            }
            $dec = 324 - $dec;
            $convert .= $dec;
        }
        $convert = '{obfs:' . $convert . '}';
        return ($convert);
    } else {
        return $string;
    }
}

/**
 * This method decrypts the source value if it has been previously
 * encrypted, otherwise returns the string unchanged
 *
 * @param string $string
 * @return string Decrypted source value
 */
function MAX_commonDecrypt($string)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $convert = '';
    if (isset($string) && substr($string,1,4) == 'obfs' && $conf['delivery']['obfuscate']) {
        $strLen = strlen($string);
        for ($i=6; $i < $strLen-1; $i = $i+3) {
            $dec = substr($string,$i,3);
            $dec = 324 - $dec;
            $dec = chr($dec);
            $convert .= $dec;
        }
        return ($convert);
    } else {
        return($string);
    }
}

/**
 * This function takes the parameters passed into the delivery script
 * Normalises them, and sets them into the global scope
 * Parameters specific to individual scripts are dealt with individually
 */
function MAX_commonInitVariables()
{
    MAX_commonRegisterGlobalsArray(array('context', 'source', 'target', 'withText', 'withtext', 'ct0', 'what', 'loc', 'referer', 'zoneid', 'campaignid', 'bannerid', 'clientid'));
    global $context, $source, $target, $withText, $withtext, $ct0, $what, $loc, $referer, $zoneid, $campaignid, $bannerid, $clientid;

    if (!isset($context)) 	$context = array();
    if (!isset($source))	$source = '';
    if (!isset($target)) 	$target = '_blank';
    if (isset($withText) && !isset($withtext))  $withtext = $withText;
    if (!isset($withtext)) 	$withtext = '';
    if (!isset($ct0)) 	$ct0 = '';
    if (!isset($what)) {
        if (!empty($bannerid)) {
            $what = 'bannerid:'.$bannerid;
        } elseif (!empty($campaignid)) {
            $what = 'campaignid:'.$campaignid;
        } elseif (!empty($zoneid)) {
            $what = 'zone:'.$zoneid;
        } else {
            $what = '';
        }
    } elseif (preg_match('/^.+:.+$/', $what)) {
        list($whatName, $whatValue) = explode(':', $what);
        if ($whatName == 'zone') {
            $whatName = 'zoneid';
        }
        global $$whatName;
        $$whatName = $whatValue;
    }

    // 2.0 backwards compatibility - clientid parameter was used to fetch a campaign
    if (!isset($clientid))  $clientid = '';

    $source = MAX_commonDeriveSource($source);

    if (!empty($loc)) {
        $loc = stripslashes($loc);
    } elseif (!empty($_SERVER['HTTP_REFERER'])) {
        $loc = $_SERVER['HTTP_REFERER'];
    } else {
        $loc = '';
    }

    // Set real referer - Only valid if passed in
    if (!empty($referer)) {
        $_SERVER['HTTP_REFERER'] = stripslashes($referer);
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) unset($_SERVER['HTTP_REFERER']);
    }

    $GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'] = array(
        $GLOBALS['_MAX']['CONF']['var']['blockAd'],
        $GLOBALS['_MAX']['CONF']['var']['capAd'],
        $GLOBALS['_MAX']['CONF']['var']['sessionCapAd'],
        $GLOBALS['_MAX']['CONF']['var']['blockCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['capCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['sessionCapCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['blockZone'],
        $GLOBALS['_MAX']['CONF']['var']['capZone'],
        $GLOBALS['_MAX']['CONF']['var']['sessionCapZone']);
}

/**
 * Display a 1x1 pixel gif.  Include the appropriate image headers
 */
function MAX_commonDisplay1x1()
{
    MAX_header('Content-Type: image/gif');
    MAX_header('Content-Length: 43');
    // 1 x 1 gif
    echo base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==');
}

function MAX_commonGetTimeNow()
{
    static $now;
    if (!isset($now)) {
        $now = $GLOBALS['_MAX']['NOW'] = time();
    }
    return $now;
}


/**
 * set a cookie (for real)
 */
function MAX_setcookie($name, $value, $expire, $path, $domain)
{
    if(!empty($GLOBALS['is_simulation'])) {
       $_COOKIE[$name] = $value;
    } else {
        setcookie($name, $value, $expire, $path, $domain);
    }
}

/**
 * send a header (for real)
 */
function MAX_header($value)
{
    if(empty($GLOBALS['is_simulation'])) {
        header($value);
    }
}

?>
