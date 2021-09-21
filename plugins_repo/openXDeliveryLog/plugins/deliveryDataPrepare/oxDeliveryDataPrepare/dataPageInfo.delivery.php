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
 * @package    Plugin
 * @subpackage openxDeliveryLog
 */

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo()
{
    // prevent from running twice
    static $executed;
    if ($executed) {
        return;
    }
    $executed = true;

    if (!empty($_GET['loc'])) {
        $pageInfo = parse_url($_GET['loc']);
    } elseif (!empty($_SERVER['HTTP_REFERER'])) {
        $pageInfo = parse_url($_SERVER['HTTP_REFERER']);
    } elseif (!empty($GLOBALS['loc'])) {
        $pageInfo = parse_url($GLOBALS['loc']);
    }
    if (!empty($pageInfo['scheme'])) {
        $pageInfo['scheme'] = ($pageInfo['scheme'] == 'https') ? 1 : 0;
    }
    $GLOBALS['_MAX']['deliveryData']['pageInfo'] = $pageInfo;
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo_Delivery_logRequest()
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo();
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo_Delivery_logImpression()
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo();
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo_Delivery_logClick()
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataPageInfo();
}
