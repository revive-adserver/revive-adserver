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

if (!isset($GLOBALS['_MAX']['_GEOCACHE']['region'])) {
    $pathPlugins = dirname(__FILE__) . '/data/';
    require $pathPlugins.'res-iso3166.inc.php';
    require $pathPlugins.'res-iso3166-2.inc.php';
    require $pathPlugins.'res-fips.inc.php';

    foreach ($OA_Geo_FIPS as $k => $v) {
        if ($k == 'US' || $k == 'CA') {
            $v = $OA_Geo_ISO3166_2[$k];
        }
        $res[$k] = array($OA_Geo_ISO3166[$k]) + $v;
    }

    uasort($res, create_function('$a,$b', 'return strcmp($a[0], $b[0]);'));

    $GLOBALS['_MAX']['_GEOCACHE']['region'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['region'];
}

?>
