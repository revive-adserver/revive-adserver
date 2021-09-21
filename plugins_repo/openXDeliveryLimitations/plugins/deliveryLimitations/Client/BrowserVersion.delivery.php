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
 * Check to see if this impression contains the valid browser.
 *
 * @param string $limitation The browser (or comma list of browsers) limitation
 * @param string $op The operator ('==', '!=', '=~', '!~')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's browser passes this limitation's test.
 */
function MAX_checkClient_BrowserVersion($limitation, $op, $aParams = [])
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT'];

        if (!isset($aParams['browserName'])) {
            $aParams['browserName'] = $aParams['wrapper']->getBrowserName();
        }

        if (!isset($aParams['browserVersion'])) {
            $aParams['browserVersion'] = $aParams['wrapper']->getBrowserVersion();
        }
    }

    $aLimitation = explode('|', $limitation);

    if (!MAX_limitationsMatchString('browserName', $aLimitation[0], '==', $aParams)) {
        return false;
    }

    if ($op == 'nn') {
        return true;
    }

    if (!isset($aLimitation[1])) {
        $aLimitation[1] = 0;
    }

    return MAX_limitationMatchNumeric('browserVersion', (float)$aLimitation[1], $op, $aParams);
}
