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

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('zones', 'block', 'blockcampaign', 'nz'));

if (isset($context) && !is_array($context)) {
    $context = MAX_commonUnpackContext($context);
}
if (!is_array($context)) {
    $context = array();
}

$useMultipleZones = false;

if(empty($zones)) {
    $zones = $zoneid;
}
else {
    $useMultipleZones = true;
}

$aBanners = array();
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

    $what = "zone:".$thisZoneid;

    // Get the banner
    $banner = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, true, $ct0, $loc, $referer);
    if (!empty($block) && !empty($banner['bannerid'])) {
        $banner['context'][] = array('!=' => 'bannerid:' . $banner['bannerid']);
    }
    // Block this campaign for next invocation
    if (!empty($blockcampaign) && !empty($banner['campaignid'])) {
        $banner['context'][] = array('!=' => 'campaignid:' . $banner['campaignid']);
    }
    // Pass the context array back to the next call, have to iterate over elements to prevent duplication
    if (!empty($banner['context'])) {
        foreach ($banner['context'] as $id => $contextArray) {
            if (!in_array($contextArray, $context)) {
                $context[] = $contextArray;
            }
        }
    }
    $aResponse = array(
        'html'    => $banner['html'],
        'context' => MAX_commonPackContext($banner['context']),
    );
    foreach ($banner['aRow']['aSearch'] as $index => $value) {
        $key = substr($value, 1, strlen($value) -2);
        $aResponse[$key] = $banner['aRow']['aReplace'][$index];
    }
    // Remove duplicated fields from the aRow
    unset($banner['aRow']['aSearch'], $banner['aRow']['aReplace'], $banner['aRow']['bannerContent']);

    // Add fields from aRow to the response (assuming they don't exist already)
    foreach ($banner['aRow'] as $key => $value) {
        if (!in_array($key, array_keys($aResponse))) {
            $aResponse[$key] = $value;
        }
    }
    $aResponse['creativeUrl'] = _adRenderBuildFileUrl($banner['aRow']);
    $aBanners[] = $aResponse;
}

$i = 1;
$outputJson = "{";
if ($useMultipleZones) {
    foreach ($aBanners as $aBanner) {
        $outputJson .= "ad" . $i++ . ":{";
        $outputJson .= "'html':" . json_encode($aBanner['html']);
        $outputJson .= ",'imp':" . json_encode($aBanner['logUrl']);
        $outputJson .= ",'click':" . json_encode($aBanner['clickUrl']);
        $outputJson .= ",'zoneid':" . json_encode($aBanner['zoneid']);
        $outputJson .= "}";
        if (count($aBanners) !== $i-1) $outputJson .= ",\n";
    }
}
elseif (count($aBanners) > 0) {
    $outputJson .= "ad" . $i++ . ":{";
        $outputJson .= "'html': " . json_encode($aBanners[0]['html']);
        $outputJson .= ",'imp': " . json_encode($aBanners[0]['logUrl']);
        $outputJson .= ",'click': " . json_encode($aBanners[0]['clickUrl']);
        $outputJson .= ",'zoneid': " . json_encode($aBanners[0]['zoneid']);
        $outputJson .= "}";
}
$outputJson .= "}";

// Do something special with cookies? 

MAX_cookieFlush();

MAX_commonSendContentTypeHeader('application/json', $charset);

echo $outputJson;
?>