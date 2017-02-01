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
 * @subpackage querystring
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
        $aVars = json_decode($_COOKIE[$conf['var']['vars']][$n], true);
        if (is_array($aVars)) {
            foreach ($aVars as $name => $value) {
                if (!isset($_GET[$name])) {
                    $aGet[$name] = $value;
                }
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
    $aVariables = array();
    $aValidVariables = array_values($conf['var']);

    // See if any plugin-components have added items to the click url...
    $componentParams =  OX_Delivery_Common_hook('addUrlParams', array(array('bannerid' => $adId)));
    if (!empty($componentParams) && is_array($componentParams)) {
        foreach ($componentParams as $params) {
            if (!empty($params) && is_array($params)) {
                foreach ($params as $key => $value) {
                    $aValidVariables[] = $key;
                }
            }
        }
    }

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
