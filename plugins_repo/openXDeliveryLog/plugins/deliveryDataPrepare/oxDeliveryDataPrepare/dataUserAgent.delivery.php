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

// if ($aConf['logging']['sniff'] && isset($GLOBALS['_MAX']['CLIENT']))
// @todo should the call to browser sniffer library be moved in here?

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent()
{
    // prevent from running twice
    static $executed;
    if ($executed) return;
    $executed = true;

    $userAgentInfo = array(
        'os'        => $GLOBALS['_MAX']['CLIENT']['os'],
        'long_name' => $GLOBALS['_MAX']['CLIENT']['long_name'],
        'browser'   => $GLOBALS['_MAX']['CLIENT']['browser'],
    );
    $GLOBALS['_MAX']['deliveryData']['userAgentInfo'] = $userAgentInfo;
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent_Delivery_logRequest()
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent();
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent_Delivery_logImpression()
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent();
}

function Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent_Delivery_logClick()
{
    Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataUserAgent();
}

?>