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
 * @subpackage openxDeliveryLimitation
 */

MAX_Dal_Delivery_Include();

require_once MAX_PATH . '/lib/RV/Extension/DeliveryLimitations/ClientDataWrapperInterface.php';
require_once MAX_PATH . '/lib/RV/Extension/DeliveryLimitations/ClientDataWrapper/SinergiWrapper.php';

// Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick
function Plugin_deliveryLimitations_Client_initClientData_Delivery_postInit()
{
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $GLOBALS['_MAX']['CLIENT'] = [
            'wrapper' => new \RV\Extension\DeliveryLimitations\ClientDataWrapper\SinergiWrapper($_SERVER['HTTP_USER_AGENT']),
            'ua' => $_SERVER['HTTP_USER_AGENT'],
        ];
    }
}
