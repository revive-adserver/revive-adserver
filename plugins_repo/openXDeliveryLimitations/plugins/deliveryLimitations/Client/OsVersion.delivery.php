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
function MAX_checkClient_OsVersion($limitation, $op, $aParams = [])
{
    static $res;

    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT'];

        if (!isset($aParams['osName'])) {
            $aParams['osName'] = $aParams['wrapper']->getOsName();
        }

        if (!isset($aParams['osVersion'])) {
            $aParams['osVersion'] = $aParams['wrapper']->getOsVersion();
        }
    }

    $aLimitation = explode('|', $limitation);

    if (!MAX_limitationsMatchString('osName', $aLimitation[0], '==', $aParams)) {
        return false;
    }

    if ($op == 'nn') {
        return true;
    }

    if ($aLimitation[0] == \Sinergi\BrowserDetector\Os::WINDOWS) {
        if (null === $res) {
            require(__DIR__ . '/OsVersion.res.inc.php');
        }

        if (isset($res[$aLimitation[1]])) {
            $aLimitation[1] = $res[$aLimitation[1]];
        }

        $aParams['osVersion'] = strtolower($aParams['osVersion']);

        if (isset($res[$aParams['osVersion']])) {
            $aParams['osVersion'] = $res[$aParams['osVersion']];
        }
    }

    return MAX_limitationMatchNumeric('osVersion', (float)$aLimitation[1], $op, $aParams);
}
