<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver - Native Stealth JS Generator                             |
| This script overrides the product configuration to generate               |
| AdBlock-safe JS code natively, without regex replacement.                 |
+---------------------------------------------------------------------------+
*/

require_once '../../init-delivery.php';

// Override configuration by changing 'product' to 'content'
// Revive will generate: 
// - window.contentAsync instead of window.reviveAsync
// - data-content-id instead of data-revive-id
$GLOBALS['_MAX']['CONF']['var']['product'] = 'content';

// Override next step URL
$GLOBALS['_MAX']['CONF']['file']['asyncspc'] = '../assets/data/packet';

$conf = $GLOBALS['_MAX']['CONF'];

$product = 'content';

// Standard ETag Caching Logic (asyncjs.php)
$etag = md5("{$conf['webpath']['delivery']}*{$conf['webpath']['deliverySSL']}");

OX_Delivery_Common_sendPreconnectHeaders();

header("Content-Type: text/javascript");
header("ETag: {$etag}");
header("Cross-Origin-Resource-Policy: cross-origin");

if (!empty($conf['delivery']['assetClientCacheExpire'])) {
    $expire = (int) $conf['delivery']['assetClientCacheExpire'];
    header("Expire: " . gmdate('D, d M Y H:i:s \G\M\T', MAX_commonGetTimeNow() + $expire));
    header("Cache-Control: private, max-age={$expire}");
}

MAX_cookieGetUniqueViewerId();
MAX_cookieFlush();

// Construct stealth URLs 
$baseUrl = $conf['webpath']['delivery'];
$baseUrl = str_replace('/delivery', '', $baseUrl);
$stealthDataUrl = 'http://' . $baseUrl . '/assets/data/packet';
$stealthDataUrlSSL = 'https://' . str_replace('/delivery', '', $conf['webpath']['deliverySSL']) . '/assets/data/packet';

ob_start();
require __DIR__ . '/' . $GLOBALS['_MAX']['CONF']['file']['asyncjsjs'];
$jsContent = ob_get_clean();

// Replace ALL instances of reviveAsync with contentAsync
$jsContent = str_replace('c.reviveAsync', 'c.contentAsync', $jsContent);
$jsContent = str_replace('reviveAsync', 'contentAsync', $jsContent);
// Make sure we didn't miss any
$jsContent = preg_replace('/reviveAsync/', 'contentAsync', $jsContent);

// Fix empty name field - replace name:"" with name:"content"
$jsContent = str_replace('name:""', 'name:"content"', $jsContent);
$jsContent = preg_replace('/name:"\s*"/', 'name:"content"', $jsContent);
$jsContent = preg_replace('/name:\s*""/', 'name:"content"', $jsContent);

// Replace the asyncspc URL with our stealth URL
$jsContent = preg_replace(
    '#"http://[^"]*delivery/\.\./assets/data/packet"#',
    '"' . $stealthDataUrl . '"',
    $jsContent
);
$jsContent = preg_replace(
    '#"https://[^"]*delivery/\.\./assets/data/packet"#',
    '"' . $stealthDataUrlSSL . '"',
    $jsContent
);
$jsContent = preg_replace(
    '#"http://[^"]*delivery[^"]*asyncspc\.php"#',
    '"' . $stealthDataUrl . '"',
    $jsContent
);
$jsContent = preg_replace(
    '#"https://[^"]*delivery[^"]*asyncspc\.php"#',
    '"' . $stealthDataUrlSSL . '"',
    $jsContent
);

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");

echo $jsContent;
?>