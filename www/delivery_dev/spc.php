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
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

MAX_commonSetNoCacheHeaders();

/*-------------------------------------------------------*/
/* Register input variables                              */
/*-------------------------------------------------------*/

MAX_commonRegisterGlobalsArray(array('zones' ,'source', 'block', 'blockcampaign', 'exclude', 'mmm_fo', 'q', 'nz'));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Derive the source parameter
$source = MAX_commonDeriveSource($source);

$spc_output = 'var ' . $conf['var']['prefix'] . 'output = new Array(); ' . "\n";

if(!empty($zones)) {
    $zones = explode('|', $zones);
    foreach ($zones as $thisZone) {
        if (empty($thisZone)) continue;
        // nz is set when "named zones" are being used, this allows a zone to be selected more than once
        if (!empty($nz)) {
            list($zonename,$thisZoneid) = explode('=', $thisZone);
            $varname = $zonename;
        } else {
            $thisZoneid = $varname = $thisZone;
        }

        // Clear deiveryData between iterations
        unset($GLOBALS['_MAX']['deliveryData']);

        $what = 'zone:'.$thisZoneid;

        //OX_Delivery_logMessage('$what='.$what, 7);
        //OX_Delivery_logMessage('$context='.print_r($context,true), 7);

        // Get the banner
        $output = MAX_adSelect($what, $clientid, $target, $source, $withtext, $charset, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

        //OX_Delivery_logMessage('$block='.@$block, 7);
        //OX_Delivery_logMessage(print_r($output, true), 7);
        //OX_Delivery_logMessage('output bannerid='.(empty($output['bannerid']) ? ' NO BANNERID' : $output['bannerid']), 7);

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
}
MAX_cookieFlush();

// Setup the banners for this page
MAX_commonSendContentTypeHeader("application/x-javascript", $charset);

echo $spc_output;

?>
