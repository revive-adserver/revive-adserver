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
 * Check to see if this impression contains the valid language.
 *
 * @param string $limitation The language limitation
 * @param string $op The operator
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's language passes this limitation's test.
 */
function MAX_checkClient_Language($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    } else {
        $language = $aParams['language'];
    }
    if ($limitation == '' || empty($language)) {
        return true;
    }
    // Strip off q=X if present
    $language = preg_replace('/;q=[0-9\.]+$/', '', $language);

    $aLimitation = MAX_limitationsGetAFromS($limitation);
    $aLanguages = MAX_limitationsGetAFromS($language);

    $aMatchedValues = array_intersect($aLimitation, $aLanguages);
    if ('=~' == $op) {
        return !empty($aMatchedValues);
    } else {
        return empty($aMatchedValues);
    }
}

?>
