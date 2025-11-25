<?php

/**
 * Revive Adserver - GitHub "Bouncer" Script
 * Redirects static image requests to dynamic delivery URLs
 */

require_once '../../init.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';

$zoneid = isset($_GET['zoneid']) ? (int)$_GET['zoneid'] : 0;
if ($zoneid === 0) {
    error_log("GH.PHP Error: No Zone ID provided");
    exit(); 
}

$conf = $GLOBALS['_MAX']['CONF'];
$random = md5(uniqid(rand(), true));

$targetUrl = MAX_commonConstructDeliveryUrl($conf['file']['view']);
$targetUrl .= "?zoneid=" . $zoneid;
$targetUrl .= "&n=" . $random;

// send aggressive no-cache headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// redirect
header("Location: " . $targetUrl, true, 307);
exit();
?>