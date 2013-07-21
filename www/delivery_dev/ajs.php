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
MAX_commonRegisterGlobalsArray(array('block', 'blockcampaign', 'exclude', 'mmm_fo', 'q'));

if (isset($context) && !is_array($context)) {
    $context = MAX_commonUnpackContext($context);
}
if (!is_array($context)) {
    $context = array();
}

if (isset($exclude) && $exclude != '' && $exclude != ',') {
    $exclude = explode(',', trim($exclude, ','));
    for ($i = 0; $i < count($exclude); $i++) {
        // Avoid adding empty entries and duplicates
        if ($exclude[$i] != '' && array_search(array ("!=" => $exclude[$i]), $context) === false) {
            $context[] = array ("!=" => $exclude[$i]);
        }
    }
}

// Get the banner
$output = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

// Block this banner for next invocation
if (!empty($block) && !empty($output['bannerid'])) {
    $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
// Block this banner for next invocation
if (!empty($block) && !empty($output['bannerid'])) {
    $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
}

// Block this campaign for next invocation
if (!empty($blockcampaign) && !empty($output['campaignid'])) {
    $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
}
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

// Append context, if any
$output['html'] .= (!empty($context)) ? "<script type='text/javascript'>document.context='".MAX_commonPackContext($context)."'; </script>" : '';

MAX_cookieFlush();

// Show the banner
MAX_commonSendContentTypeHeader("text/javascript", $charset);

if (isset($output['contenttype']) && $output['contenttype'] == 'swf' && !isset($mmm_fo)) {
    echo MAX_flashGetFlashObjectInline();
}

echo MAX_javascriptToHTML($output['html'], 'OX_'.substr(md5(uniqid('', 1)), 0, 8));

// Backwards compatible block-banner JS variable (>2.4 tags do all this via document.context)
if (!empty($block) && !empty($output['bannerid'])) {
    $varprefix = $GLOBALS['_MAX']['CONF']['var']['prefix'];
    echo "\nif (document.{$varprefix}used) document.{$varprefix}_used += 'bannerid:".$output['bannerid'].",';\n";
    // Provide backwards compatibility for the time-being
    echo "\nif (document.MAX_used) document.MAX_used += 'bannerid:".$output['bannerid'].",';\n";
    echo "\nif (document.phpAds_used) document.phpAds_used += 'bannerid:".$output['bannerid'].",';\n";
}

// Backwards compatible block-campaign JS variable (>2.4 tags do all this via document.context)
if (!empty($blockcampaign) && !empty($output['campaignid'])) {
    $varprefix = $GLOBALS['_MAX']['CONF']['var']['prefix'];
    echo "\nif (document.{$varprefix}used) document.{$varprefix}used += 'campaignid:".$output['campaignid'].",';\n";
    // Provide backwards compatibility for the time-being
    echo "\nif (document.MAX_used) document.MAX_used += 'campaignid:".$output['campaignid'].",';\n";
    echo "\nif (document.phpAds_used) document.phpAds_used += 'campaignid:".$output['campaignid'].",';\n";
}
?>
