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

if (!isset($GLOBALS['_MAX']['_GEOCACHE']['dma'])) {
    $pathPlugins = dirname(__FILE__) . '/data/';
    require $pathPlugins.'res-dmacodes.inc.php';

    $res = $OA_Geo_DmaCodes;

    asort($res);

    $GLOBALS['_MAX']['_GEOCACHE']['dma'] = $res;
} else {
    $res = $GLOBALS['_MAX']['_GEOCACHE']['dma'];
}

?>
