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

// Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick
function Plugin_deliveryLimitations_Client_initClientData_Delivery_postInit()
{
    if (!empty($GLOBALS['_MAX']['CONF']['Client']['sniff']) && isset($_SERVER['HTTP_USER_AGENT'])) { 
        if (!class_exists('phpSniff')) { 
            include dirname(__FILE__) . '/lib/phpSniff/phpSniff.class.php'; 
        } 
        $client = new phpSniff($_SERVER['HTTP_USER_AGENT']); 
        $GLOBALS['_MAX']['CLIENT'] = $client->_browser_info; 
    } 
}

?>
