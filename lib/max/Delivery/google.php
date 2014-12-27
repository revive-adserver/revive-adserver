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
 * @subpackage google
 */

$file = '/lib/max/Delivery/google.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * This function outputs the javascript code to track Google Adsense banners
 *
 */
function MAX_googleGetJavaScript()
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $ag = file_get_contents(MAX_PATH.'/lib/max/Delivery/templates/ag.js');

    $from  = array();
    $to    = array();
    foreach (array('click', 'frame') as $k) {
        $v = $conf['file'][$k];
        $k = strtoupper($k);
        $from[] = "@@F_{$k}@@";
        $to[]   = $v;
        $from[] = "@@F_{$k}_PREG@@";
        $to[]   = preg_quote($v, '/');
    }
    foreach ($conf['var'] as $k => $v) {
        $k = strtoupper($k);
        $from[] = "@@V_{$k}@@";
        $to[]   = $v;
        $from[] = "@@V_{$k}_PREG@@";
        $to[]   = preg_quote($v, '/');
    }

    // ctDelimiter
    $from[] = "@@OA_DELIM@@";
    $to[]   = $conf['delivery']['ctDelimiter'];

    // Supported networks
    $from[] = "@@OA_DOMAINS_PREG@@";
    $to[]   = "googlesyndication\.com|ypn-js\.overture\.com|googleads\.g\.doubleclick\.net";

    $ag = str_replace($from, $to, $ag);

    return $ag;
}

?>
