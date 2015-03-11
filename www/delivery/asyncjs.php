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

// The browser is allowed to cache this
header("Content-Type: text/javascript");
header("ETag: {$etag}");
header("Expire: ".gmdate('D, d M Y H:i:s \G\M\T', MAX_commonGetTimeNow() + 86400));
header("Cache-Control: private, max-age=86400");

if (!empty($_SERVER["HTTP_IF_NONE_MATCH"]) && $_SERVER["HTTP_IF_NONE_MATCH"] == $etag) {
    header("HTTP/1.x 304 Not modified");
    exit;
}

// Try to set the OAID cookie, so that the following request already has it
MAX_cookieGetUniqueViewerId();

require __DIR__.'/async.js';
