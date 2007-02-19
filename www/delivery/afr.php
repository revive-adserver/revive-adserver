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

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobals('refresh', 'resize', 'rewrite');

// Initialise any afr.php specific variables
if (!isset($rewrite))   $rewrite = 1;
if (!isset($refresh))   $refresh = 0;
if (!isset($resize))    $resize = 0;

// Get the banner
$banner = MAX_adSelect($what, $target, $source, $withtext, $context, true, $ct0, $loc, $referer);
MAX_cookieFlush();

// Rewrite targets in HTML code to make sure they are
// local to the parent and not local to the iframe
if (isset($rewrite) && $rewrite == 1) {
	$banner['html'] = preg_replace('#target\s*=\s*([\'"])_parent\1#i', "target='_top'", $banner['html']);
	$banner['html'] = preg_replace('#target\s*=\s*([\'"])_self\1#i', "target='_parent'", $banner['html']);
}

// Build HTML
echo "<html>\n";
echo "<head>\n";
echo "<title>".(!empty($banner['alt']) ? $banner['alt'] : 'Advertisement')."</title>\n";

// Include the FlashObject script if required
if (isset($banner['contenttype']) && $banner['contenttype'] == 'swf') {
    echo MAX_flashGetFlashObjectExternal();
}

// Add refresh meta tag if $refresh is set and numeric
if (isset($refresh) && is_numeric($refresh) && $refresh > 0) {
    $dest = MAX_commonGetDeliveryUrl() . substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], basename($_SERVER['SCRIPT_FILENAME'])));
    parse_str($_SERVER['QUERY_STRING'], $qs);
    $dest .= (!array_key_exists('loc', $qs)) ? "&loc=" . urlencode($loc) : '';
	echo "<meta http-equiv='refresh' content='".$refresh.";url=$dest'>\n";
}

if (isset($resize) && $resize == 1) {
	echo "<script language='JavaScript'>\n";
	echo "<!--\n";
	echo "\tfunction MAX_adjustframe(frame) {\n";
	echo "\t\tif (document.all) {\n";
    echo "\t\t\tparent.document.all[frame.name].width = ".$banner['width'].";\n";
    echo "\t\t\tparent.document.all[frame.name].height = ".$banner['height'].";\n";
  	echo "\t\t}\n";
  	echo "\t\telse if (document.getElementById) {\n";
    echo "\t\t\tparent.document.getElementById(frame.name).width = ".$banner['width'].";\n";
    echo "\t\t\tparent.document.getElementById(frame.name).height = ".$banner['height'].";\n";
  	echo "\t\t}\n";
	echo "\t}\n";
	echo "// -->\n";
	echo "</script>\n";
}

echo "</head>\n";

if (isset($resize) && $resize == 1) {
	echo "<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='background-color:transparent; width: 100%; text-align: center;' onload=\"MAX_adjustframe(window);\">\n";
} else {
	echo "<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='background-color:transparent; width: 100%; text-align: center;'>\n";
}

echo $banner['html'];
echo "\n</body>\n";

echo "</html>\n";

// stop benchmarking
MAX_benchmarkStop();

?>
