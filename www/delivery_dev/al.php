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

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('layerstyle'));
if (!isset($layerstyle) || empty($layerstyle)) {
    $layerstyle = 'geocities';
}

$plugin = MAX_PATH.$conf['pluginPaths']['plugins'].'invocationTags/oxInvocationTags/layerstyles/'.$layerstyle.'/layerstyle.inc.php';

if (!preg_match('/^[a-z0-9-]{1,64}$/Di', $layerstyle) || !@include($plugin)) {
    // Don't generate output when plugin layerstyleisn't available,just send javascript comment on fail
    MAX_sendStatusCode(404);
    echo '// Cannot load required layerstyle file. Check if openXInvocationTags plugin is installed';
    exit;
}

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('block', 'blockcampaign', 'exclude', 'mmm_fo', 'q'));

if (isset($context) && !is_array($context)) {
    $context = MAX_commonUnpackContext($context);
}
if (!is_array($context)) {
    $context = array();
}

$limitations = MAX_layerGetLimitations();

MAX_commonSendContentTypeHeader("application/x-javascript", $charset);
if ($limitations['compatible']) {
    $output = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, $limitations['richmedia'], $GLOBALS['ct0'], $GLOBALS['loc'], $GLOBALS['referer']);

    MAX_cookieFlush();

    $uniqid = substr(md5(uniqid('', 1)), 0, 8);

    // Just output the beacon if no matching banner was found
    if (empty($output['bannerid'])) {
        echo MAX_javascriptToHTML($output['html'], "MAX_{$uniqid}");
        exit;
    }

    // Block this banner for next invocation
    if (!empty($block) && !empty($output['bannerid'])) {
        $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
    }

    // Block this campaign for next invocation
    if (!empty($blockcampaign) && !empty($output['campaignid'])) {
        $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
    }

    // Block this campaign for next invocation
    if (!empty($blockcampaign) && !empty($output['campaignid'])) {
        $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
    }
    // Append any data to the context array
    if (!empty($output['context'])) {
        foreach ($output['context'] as $id => $contextArray) {
            if (!in_array($contextArray, $context)) {
                $context[] = $contextArray;
            }
        }
    }

    // Include the FlashObject script if required
    if ($output['contenttype'] == 'swf') {
        echo MAX_flashGetFlashObjectInline();
    }

    // Set document.context, if required
    $output['html'] .= (!empty($context)) ? "<script type='text/javascript'>document.context='" . MAX_commonPackContext($context) . "'; </script>" : '';

    echo MAX_javascriptToHTML(MAX_layerGetHtml($output, $uniqid), "MAX_{$uniqid}");
    MAX_layerPutJs($output, $uniqid);
    ob_flush();
}
?>
