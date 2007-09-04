<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
+---------------------------------------------------------------------------+
$Id: spc.delivery.php 525 2006-10-18 11:21:20Z chris@m3.net $
*/

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

/*-------------------------------------------------------*/
/* Register input variables                              */
/*-------------------------------------------------------*/

MAX_commonRegisterGlobalsArray(array('zones' ,'source', 'block', 'blockcampaign', 'exclude', 'mmm_fo', 'q', 'nz'));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Derive the source parameter
$source = MAX_commonDeriveSource($source);

$zones = explode('|', $zones);
$spc_output = '';
foreach ($zones as $thisZone) {
    if (empty($thisZone)) continue;
    // nz is set when "named zones" are being used, this allows a zone to be selected more than once
    if ($nz) {
        list($zonename,$thisZoneid) = explode('=', $thisZone);
        $varname = $zonename;
    } else {
        $thisZoneid = $varname = $thisZone;
    }

    $what = 'zone:'.$thisZoneid;
    // Get the banner
    $output = MAX_adSelect($what, $clientid, $target, $source, $withtext, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

    // Store the html2js'd output for this ad
    $spc_output .= MAX_javascriptToHTML($output['html'], $conf['var']['prefix'] . "output['{$varname}']", false, false) . "\n";

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

MAX_cookieFlush();

// Show the banner
header("Content-type: application/x-javascript");
echo $spc_output;

?>
