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

$etag = md5("{$conf['webpath']['delivery']}*{$conf['webpath']['deliverySSL']}");
$product = $GLOBALS['_MAX']['CONF']['var']['product'];

OX_Delivery_Common_sendPreconnectHeaders();

if (!empty($_SERVER["HTTP_IF_NONE_MATCH"]) && $_SERVER["HTTP_IF_NONE_MATCH"] == $etag) {
    MAX_header("HTTP/1.x 304 Not modified");

    // Some temporary cookies might have been deleted, if so send permanent ones
    MAX_cookieFlush();

    exit;
}

header("Content-Type: text/javascript");
header("ETag: {$etag}");
header("Cross-Origin-Resource-Policy: cross-origin");

// The browser is allowed to cache this
if (!empty($conf['delivery']['assetClientCacheExpire'])) {
    $expire = (int) $conf['delivery']['assetClientCacheExpire'];

    header("Expire: " . gmdate('D, d M Y H:i:s \G\M\T', MAX_commonGetTimeNow() + $expire));
    header("Cache-Control: private, max-age={$expire}");
}

// Try to set the OAID cookie, so that the following request already has it
MAX_cookieGetUniqueViewerId();
MAX_cookieFlush();

require __DIR__ . '/' . $GLOBALS['_MAX']['CONF']['file']['asyncjsjs'];
