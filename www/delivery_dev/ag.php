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
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

// Get JS
$output = MAX_cacheGetGoogleJavaScript();

// Output JS
MAX_commonSendContentTypeHeader("application/x-javascript");
MAX_header("Expires: ".gmdate('r', time() + 86400));

echo $output;

?>
