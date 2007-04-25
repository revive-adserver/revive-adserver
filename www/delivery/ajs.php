<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
MAX_commonRegisterGlobals('block', 'blockcampaign', 'exclude', 'mmm_fo', 'q');

if (!is_array($context) && isset($context)) {
    $context = unserialize(base64_decode($context));
}
if (!is_array($context)) {
    $context = array();
}

if (isset($exclude) && $exclude != '' && $exclude != ',') {
    $exclude = explode (',', $exclude);
    if (count($exclude) > 0) {
        for ($i = 0; $i < count($exclude); $i++) {
            if ($exclude[$i] != '') {
                $context[] = array ("!=" => $exclude[$i]);
            }
        }
    }
}

// Get the banner
$output = MAX_adSelect($what, $target, $source, $withtext, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

// Save the context array into a javascript variable
if (isset($output['context']) && is_array($output['context'])) {
    $JScontext = "<script type='text/javascript'>document.context='".base64_encode(serialize($output['context']))."'; </script>";
} else { $JScontext = ''; }

MAX_cookieFlush();

// Show the banner
header("Content-type: application/x-javascript");
if (isset($output['contenttype']) && $output['contenttype'] == 'swf' && !$mmm_fo) {
    echo MAX_flashGetFlashObjectInline();
}

$uniqid = substr(md5(uniqid('', 1)), 0, 8);
echo MAX_javascriptToHTML($output['html'] . $JScontext, "MAX_{$uniqid}");

// Block this banner for next invocation
if (!empty($block) && !empty($output['bannerid'])) {
    echo "\nif (document.MAX_used) document.MAX_used += 'bannerid:".$output['bannerid'].",';\n";
    // Provide backwards compatibility for the time-being
    echo "\nif (document.phpAds_used) document.phpAds_used += 'bannerid:".$output['bannerid'].",';\n";
}

// Block this campaign for next invocation
if (!empty($blockcampaign) && !empty($output['campaignid'])) {
    echo "\nif (document.MAX_used) document.MAX_used += 'campaignid:".$output['campaignid'].",';\n";
    // Provide backwards compatibility for the time-being
    echo "\nif (document.phpAds_used) document.phpAds_used += 'campaignid:".$output['campaignid'].",';\n";
}

// stop benchmarking
MAX_benchmarkStop();

?>