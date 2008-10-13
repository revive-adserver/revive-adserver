<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

MAX_commonSendContentTypeHeader('text/html');

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('timeout'));
$timeout  = !empty($timeout) ? $timeout : 0;

if ($zoneid > 0) {
    // Get the zone from cache
    $aZone = MAX_cacheGetZoneInfo($zoneid);
} else {
    // Direct selection, or problem with admin DB
    $aZone = array();
    $aZone['zoneid'] = $zoneid;
    $aZone['append'] = '';
    $aZone['prepend'] = '';
}

// Get the banner from cache
$aBanner = MAX_cacheGetAd($bannerid);

$prepend = !empty($aZone['prepend']) ? $aZone['prepend'] : '';
$html    = MAX_adRender($aBanner, $zoneid, $source, $target, $ct0, $withtext);
$append  = !empty($aZone['append']) ? $aZone['append'] : '';
$title   = !empty($aBanner['alt']) ? $aBanner['alt'] : 'Advertisement';

echo "
<html>
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

// Include the FlashObject script if required
if ($aBanner['contenttype'] == 'swf') {
    echo MAX_flashGetFlashObjectExternal();
}

echo "
</head>
<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
{$prepend}{$html}{$append}
</body>
</html>";

?>
