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

/*
 * NOTE: If this list of event ever changes (IDs or names), the Video Reports must be updated as well
 */
$aVastEventStrToIdMap = [
     'start' => 1,
     'midpoint' => 2,
     'firstquartile' => 3,
     'thirdquartile' => 4,
     'complete' => 5,
     'mute' => 6,
     'replay' => 7,
     'fullscreen' => 8,
     'stop' => 9,
     'unmute' => 10,
     'resume' => 11,
     'pause' => 12,
];

MAX_commonRegisterGlobalsArray(['event', 'video_time_posn']);

// Prevent the logging beacon from being cached by browsers
MAX_commonSetNoCacheHeaders();

// if its a vast tracking event
if (!empty($bannerid) && isset($aVastEventStrToIdMap[$event])) {
    // Remove any special characters from the request variables
    MAX_commonRemoveSpecialChars($_REQUEST);

    $time = MAX_commonGetTimeNow();
    $oi = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];

    $GLOBALS['_MAX']['deliveryData'] = [
        'interval_start' => gmdate('Y-m-d H:i:s', $time - $time % ($oi * 60)),
        'creative_id' => (int)$bannerid,
        'zone_id' => (int)$zoneid,
        'vast_event_id' => $aVastEventStrToIdMap[$event],
    ];

    OX_Delivery_Common_hook('logImpressionVast', [$bannerid, $zoneid, _viewersHostOkayToLog()]);
}

MAX_cookieFlush();

MAX_commonDisplay1x1();
