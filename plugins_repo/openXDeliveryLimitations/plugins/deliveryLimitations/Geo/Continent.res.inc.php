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

require_once dirname(__FILE__) . '/data/res-continent.inc.php';

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
if (!isset($GLOBALS['_MAX']['_GEOCACHE']['continent'])) {
    global $OA_Geo_continent, $OA_Geo_cont_name;
    $res = array();

    foreach ($OA_Geo_cont_name as $k => $v) {
        $res[$k] = array($v);
    }

    foreach ($OA_Geo_continent as $k => $v) {
        $res[$v][] = $k;
    }

    $GLOBALS['_MAX']['_GEOCACHE']['continent'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['continent'];
}

?>
