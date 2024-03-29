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
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if the URL the impression is on contains one of the permitted
 * whiteliest hostnames / does not contain one of the disallowed blacklist
 * hostnames.
 *
 * @param string $limitation The whiteliest/blacklist of hostnames.
 * @param string $op The operator (either '=x' or '!x')
 * @param array $aParams An array of additional parameters to be checked.
 * @return boolean True if the impression permitted according to the whitelist
 *                  or blacklist; false if the impression is not permitted.
 */
function MAX_checkSite_Hostnamelist($limitation, $op, $aParams = [])
{
    if ($limitation == '') {
        return true;
    }
    $url = empty($aParams) ? $GLOBALS['loc'] : $aParams['loc'];
    $hostname = @parse_url($url, PHP_URL_HOST);
    if ($hostname === false) {
        return false;
    }
    $aLookup = unserialize($limitation);
    if ($op == '=~' && isset($aLookup[$hostname])) {
        return true;
    }
    return $op == '!~' && !isset($aLookup[$hostname]);
}
