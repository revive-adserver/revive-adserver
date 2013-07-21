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
 */

if (!isset($GLOBALS['_MAX']['_GEOCACHE']['city'])) {
    $pathPlugins = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'].'/deliveryLimitations/Geo/';
    require $pathPlugins.'data/res-iso3166.inc.php';
    require $pathPlugins.'Country.res.inc.php';

    foreach ($OA_Geo_ISO3166_MaxMind as $k => $v) {
        unset($res[$k]);
    }

    $res = array('' => MAX_Plugin_Translation::translate('---Any---', $this->extension, $this->group)) +
        $res;

    $GLOBALS['_MAX']['_GEOCACHE']['city'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['city'];
}

?>