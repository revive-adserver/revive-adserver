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
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

MAX_commonSendContentTypeHeader('text/html');

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(['timeout']);
$timeout = empty($timeout) ? 0 : $timeout;

if ($zoneid > 0) {
    // Get the zone from cache
    $aZone = MAX_cacheGetZoneInfo($zoneid);
} else {
    // Direct selection, or problem with admin DB
    $aZone = [];
    $aZone['zoneid'] = $zoneid;
    $aZone['append'] = '';
    $aZone['prepend'] = '';
}

// Get the banner from cache
$aBanner = MAX_cacheGetAd($bannerid);

$prepend = empty($aZone['prepend']) ? '' : $aZone['prepend'];
$html = MAX_adRender($aBanner, $zoneid, $source, $target, $ct0, $withtext);
$append = empty($aZone['append']) ? '' : $aZone['append'];
$title = empty($aBanner['alt']) ? 'Advertisement' : htmlspecialchars($aBanner['alt']);

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
<title>$title</title>";

if ($timeout > 0) {
    $timeoutMs = $timeout * 1000;
    echo "
<script type='text/javascript'>
<!--// <![CDATA[
  window.setTimeout(\"window.close()\",$timeoutMs);
// ]]> -->
</script>";
}

echo "
<style type='text/css'>
body {margin:0; height:100%; width:100%}
</style>
</head>
<body>
{$prepend}{$html}{$append}
</body>
</html>";
