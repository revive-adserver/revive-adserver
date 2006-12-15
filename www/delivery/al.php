<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
MAX_commonRegisterGlobals('layerstyle');
if (!isset($layerstyle) || empty($layerstyle)) $layerstyle = 'geocities';

// Include layerstyle
if (file_exists(MAX_PATH . '/plugins/invocationTags/adlayer/layerstyles/'.$layerstyle.'/layerstyle.inc.php')) {
    include_once MAX_PATH . '/plugins/invocationTags/adlayer/layerstyles/'.$layerstyle.'/layerstyle.inc.php';
}

$limitations = MAX_layerGetLimitations();

header("Content-type: application/x-javascript");
if ($limitations['compatible']) {
	$output = MAX_adSelect($what, $target, $source, $withtext, $context, $limitations['richmedia'], $GLOBALS['loc'], $GLOBALS['referer']);

	MAX_cookieFlush();
	// Exit if no matching banner was found
	if (!$output) {
        if ($conf['debug']['benchmark']) {
            $timer->stop();
            MAX_logBenchmark(basename($_SERVER['PHP_SELF']), $_SERVER['QUERY_STRING'], $timer->timeElapsed(), 'No ad displayed');
        }
	    exit;
	}
	$uniqid = substr(md5(uniqid('', 1)), 0, 8);

	// Include the FlashObject script if required
    if ($output['contenttype'] == 'swf') {
        echo MAX_flashGetFlashObjectInline();
    }

	echo MAX_javascriptToHTML(MAX_layerGetHtml($output, $uniqid), "MAX_{$uniqid}");
	MAX_layerPutJs($output, $uniqid);
}

// stop benchmarking
MAX_benchmarkStop();

?>
