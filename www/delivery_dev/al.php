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
require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('layerstyle'));
if (!isset($layerstyle) || empty($layerstyle)) $layerstyle = 'geocities';

// Include layerstyle
if (file_exists(MAX_PATH . '/plugins/invocationTags/adlayer/layerstyles/'.$layerstyle.'/layerstyle.inc.php')) {
    include MAX_PATH . '/plugins/invocationTags/adlayer/layerstyles/'.$layerstyle.'/layerstyle.inc.php';
}

$limitations = MAX_layerGetLimitations();

MAX_commonSendContentTypeHeader("application/x-javascript", $charset);
if ($limitations['compatible']) {
	$output = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, $limitations['richmedia'], $GLOBALS['ct0'], $GLOBALS['loc'], $GLOBALS['referer']);

	MAX_cookieFlush();
	// Exit if no matching banner was found
	if (empty($output['html'])) {
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

?>
