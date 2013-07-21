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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once(MAX_PATH . '/lib/max/Delivery/cache.php');
require_once(MAX_PATH . '/lib/max/Delivery/javascript.php');
require_once MAX_PATH . '/lib/max/Delivery/tracker.php';

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('trackerid'));
if (empty($trackerid)) $trackerid = 0;

// Log the tracker impression
if ($conf['logging']['trackerImpressions']) {
    $aConversion = MAX_trackerCheckForValidAction($trackerid);
    if (!empty($aConversion)) {
        $aConversionInfo = MAX_Delivery_log_logConversion($trackerid, $aConversion);
        $serverConvId = $serverRawIp = null;
        // I still dislike having checks here looking for specific return values... but that's what the logConversionVariable call expects :(
        if (isset($aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_conv_id'])) {
            $serverConvId = $aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_conv_id'];
        }
        if (isset($aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_raw_ip'])) {
            $serverRawIp = $aConversionInfo['deliveryLog:oxLogConversion:logConversion']['server_raw_ip'];
        }
        
        // Log tracker impression variable values
        MAX_Delivery_log_logVariableValues(MAX_cacheGetTrackerVariables($trackerid), $trackerid, $serverConvId, $serverRawIp);
    }
}
MAX_cookieFlush();
// Send a 1 x 1 gif
MAX_commonDisplay1x1();

?>