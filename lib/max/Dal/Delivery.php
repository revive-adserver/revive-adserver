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

$file = '/lib/max/Dal/Delivery.php';
###START_STRIP_DELIVERY
if (isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;


require_once MAX_PATH . '/lib/OA/Dal/Delivery.php';


function MAX_Dal_Delivery_Include()
{
    static $included;
    if (isset($included)) {
        return;
    }
    $included = true;
    $conf = $GLOBALS['_MAX']['CONF'];

    require(MAX_PATH . '/lib/OA/Dal/Delivery/' . strtolower($conf['database']['type']) . '.php');
}
