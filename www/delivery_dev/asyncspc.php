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
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

MAX_commonSetNoCacheHeaders();

/*-------------------------------------------------------*/
/* Register input variables                              */
/*-------------------------------------------------------*/

MAX_commonRegisterGlobalsArray(array('zones' ,'source', 'block', 'blockcampaign', 'exclude', 'q', 'prefix'));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Protect from Reflected File Download attacks
if (preg_match('/[^a-zA-Z0-9_-]/', $prefix)) {
    MAX_sendStatusCode(400);
    exit;
}

// Derive the source parameter
$source = MAX_commonDeriveSource($source);

$spc_output = array();

if(!empty($zones)) {
    $zones = explode('|', $zones);
    foreach ($zones as $id => $thisZoneid) {
        $zonename = $prefix.$id;

        // Clear deiveryData between iterations
        unset($GLOBALS['_MAX']['deliveryData']);

        $what = 'zone:'.$thisZoneid;

        // Get the banner
        $output = MAX_adSelect($what, $clientid, $target, $source, $withtext, $charset, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

        $spc_output[$zonename] = array(
            'html' => $output['html'],
            'width' => isset($output['width']) ? $output['width'] : 0,
            'height' => isset($output['height']) ? $output['height'] : 0,
            'iframeFriendly' => isset($output['iframeFriendly']) ? $output['iframeFriendly'] : false,
        );

        // Block this banner for next invocation
        if (!empty($block) && !empty($output['bannerid'])) {
            $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
        }
        // Block this campaign for next invocation
        if (!empty($blockcampaign) && !empty($output['campaignid'])) {
            $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
        }
        // Pass the context array back to the next call, have to iterate over elements to prevent duplication
        if (!empty($output['context'])) {
            foreach ($output['context'] as $id => $contextArray) {
                if (!in_array($contextArray, $context)) {
                    $context[] = $contextArray;
                }
            }
        }
    }
}

MAX_cookieFlush();

if (!empty($_SERVER['HTTP_ORIGIN']) && preg_match('#https?://#', $_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}

header("Content-Type: application/json");

echo json_encode($spc_output);
