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
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 * @todo       The $this->translate calls below won't pull into the .pot files correctly...
 *             we need to look into how best to do these kinds of bulk translates
 */

if (!isset($GLOBALS['_MAX']['_GEOCACHE']['country'])) {
    $pathPlugins = dirname(__FILE__) . '/data/';
    require $pathPlugins.'res-iso3166.inc.php';

    $res = array();

    foreach ($OA_Geo_ISO3166 as $k => $v) {
        if (!in_array($k, $OA_Geo_ISO3166_Deprecated) && !in_array($k, $OA_Geo_ISO3166_MaxMind)) {
            $res[$k] = $this->translate($v);
        }
    }

    asort($res);

    foreach ($OA_Geo_ISO3166_MaxMind as $k => $v) {
        $res[$k] = $this->translate($v);
    }

    $GLOBALS['_MAX']['_GEOCACHE']['country'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['country'];
}

?>
