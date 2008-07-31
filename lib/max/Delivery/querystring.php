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

/**
 * @package    MaxDelivery
 * @subpackage querystring
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * Populate variables from a specially encoded string.  This is used because
 * in a click URL, a parameter could possibly be another URL.
 *
 * The resulting values are set into the $_GET, and $_REQUEST globals
 */
function MAX_querystringConvertParams()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $qs = $_SERVER['QUERY_STRING'];
    // 1.  Strip off the destination
    $dest = false;
    $destStr = $conf['var']['dest'] . '=';
    $pos = strpos($qs, $destStr);
    if ($pos === false) {
        $destStr = 'dest=';
        $pos = strpos($qs, $destStr);
    }
    if ($pos !== false) {
        $dest = urldecode(substr($qs, $pos + strlen($destStr)));
        $qs = substr($qs, 0, $pos);
    }
    // 2.  Parse the remaining string
    $aGet = array();
    $paramStr = $conf['var']['params'] . '=';
    $paramPos = strpos($qs, $paramStr);
    if (is_numeric($paramPos)) {
        $qs = urldecode(substr($qs, $paramPos + strlen($paramStr)));
        $delim = $qs{0};
        if (is_numeric($delim)) {
            $delim = substr($qs, 1, $delim);
        }
        $qs = substr($qs, strlen($delim) + 1);
        MAX_querystringParseStr($qs, $aGet, $delim);

        // Fix the destination URL since if appended by a form, it will have no '?'
        $qPos = isset($aGet[$conf['var']['dest']]) ? strpos($aGet[$conf['var']['dest']], '?') : false;
        $aPos = isset($aGet[$conf['var']['dest']]) ? strpos($aGet[$conf['var']['dest']], '&') : false;
        if ($aPos && !$qPos) {
            $desturl = substr($aGet[$conf['var']['dest']], 0, $aPos);
            $destparams = substr($aGet[$conf['var']['dest']], $aPos+1);
            $aGet[$conf['var']['dest']] = $desturl . '?' . $destparams;
        }
    } else {
        parse_str($qs, $aGet);
    }
    if ($dest !== false) {
        $aGet[$conf['var']['dest']] = $dest;
    }
    // 3.  Add any cookie values to the GET string...
    $n = isset($_GET[$conf['var']['n']]) ? $_GET[$conf['var']['n']] : '';
    if (empty($n)) {
        // Try from querystring
        $n = isset($aGet[$conf['var']['n']]) ? $aGet[$conf['var']['n']] : '';
    }
    if (!empty($n) && !empty($_COOKIE[$conf['var']['vars']][$n])) {
        $aVars = unserialize(stripslashes($_COOKIE[$conf['var']['vars']][$n]));
        foreach ($aVars as $name => $value) {
            if (!isset($_GET[$name])) {
                $aGet[$name] = $value;
            }
        }
    }
    $_GET = $aGet;
    $_REQUEST = $_GET + $_POST + $_COOKIE;
}

/**
 * @todo Currently only methods 1 and 2 are being used
 *
 * Get the URL that this click will redirect to, using a the following methods (in order):
 *
 *  1) Was a dest=URL was passed in.
 *  2) Does a URL exist in the banner properties (cached or database lookup)
 *  3) Is there a default Agency/Admin URL
 *  4) Use the refering page
 *  5) Give up use "about:blank"
 *
 * to see if the URL is passed in.  If not, it checks the banner from the cache
 * or database.  As a last resort, it either uses the default banner URL or the referer.
 *
 * @param integer $adId The ID of the ad that was clicked or null for no DB lookup
 *
 * @return string The destination URL
 */
function MAX_querystringGetDestinationUrl($adId = null)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $dest = isset($_REQUEST[$conf['var']['dest']]) ? $_REQUEST[$conf['var']['dest']] : '';
    if (empty($dest) && !empty($adId)) {
        // Get the destination from the banner
        $aAd = MAX_cacheGetAd($adId);
        if (!empty($aAd)) {
            $dest = $aAd['url'];
        }
    }

    // If no destination URL has been found by now, then we don't need to redirect
    if (empty($dest)) {
        return;
    }
    /**
     * @TODO Remove code below, as the default banner target needs to go into the
     * cached entity retrieval above!
     */
    //if (empty($dest)) {
    //    $dest = ($adId == 'DEFAULT') ? $pref['default_banner_destination'] : $_SERVER['HTTP_REFERER'];
    //}
    $aVariables = array();
    /**
     * @todo Perhaps the list below should simply be $conf['var']...
     */
    $aValidVariables = array(
        $conf['var']['adId'],
        $conf['var']['cacheBuster'],
        $conf['var']['channel'],
        $conf['var']['dest'],
        $conf['var']['logClick'],
        $conf['var']['n'],
        $conf['var']['zoneId'],
        $conf['var']['params'],
        $conf['var']['cookieTest'],
        /**
         * @todo This variable below needs to be config-file driven, all occurences need to be changed to $conf['var']['channel_ids']
         */
        'channel_ids'
    );

    // We also need to ensure that any variables already present in the dest are not duplicated...
    $destParams = parse_url($dest);
    if (!empty($destParams['query'])) {
        $destQuery = explode('&', $destParams['query']);
        if (!empty($destQuery)) {
            foreach ($destQuery as $destPair) {
                list($destName, $destValue) = explode('=', $destPair);
                $aValidVariables[] = $destName;
            }
        }
    }

    foreach ($_GET as $name => $value) {
        if (!in_array($name, $aValidVariables)) {
            $aVariables[] = $name . '=' . $value;
        }
    }
    foreach ($_POST as $name => $value) {
        if (!in_array($name, $aValidVariables)) {
            $aVariables[] = $name . '=' . $value;
        }
    }
    if (!empty($aVariables)) {
        $dest .= ((strpos($dest, '?') > 0) ? '&' : '?') . implode('&', $aVariables);
    }
    return $dest;
}

/**
 * Mimic PHP's parse_str functionality (including decoding values), only allow passing in a delimiter.
 * These values are set back into $aArr via a reference
 *
 * @param string $qs The string in which to parse
 * @param string $aArr The array in which to store the values
 * @param string $delim The delimiter on which to parse the value
 */
function MAX_querystringParseStr($qs, &$aArr, $delim = '&')
{
    $aArr = $_GET;
    // Parse the rest of the array and add to the request array.
    $aElements = explode($delim, $qs);
    foreach($aElements as $element) {
        $len = strpos($element, '=');
        if ($len !== false) {
            $name = substr($element, 0, $len);
            $value = substr($element, $len+1);
            $aArr[$name] = urldecode($value);
        }
    }
}

?>
