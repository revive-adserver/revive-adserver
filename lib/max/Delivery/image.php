<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

$file = '/lib/OA/Delivery/image.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * @package    MaxDelivery
 * @subpackage image
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 * This library defines functions that need to be available to
 * the ai delivery script
 *
 */

function MAX_imageServe($aCreative, $filename, $contenttype)
{
	// Check if the browser sent a If-Modified-Since header and if the image was
	// modified since that date
	if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ||
		$aCreative['t_stamp'] > strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
		MAX_header("Last-Modified: ".gmdate('D, d M Y H:i:s', $aCreative['t_stamp']).' GMT');
		if (isset($contenttype) && $contenttype != '') {
			switch ($contenttype) {
				case 'swf': MAX_header('Content-type: application/x-shockwave-flash; name='.$filename); break;
				case 'dcr': MAX_header('Content-type: application/x-director; name='.$filename); break;
				case 'rpm': MAX_header('Content-type: audio/x-pn-realaudio-plugin; name='.$filename); break;
				case 'mov': MAX_header('Content-type: video/quicktime; name='.$filename); break;
				default:	MAX_header('Content-type: image/'.$contenttype.'; name='.$filename); break;
			}
		}
		echo $aCreative['contents'];
	} else {
		// Send "Not Modified" status header
		MAX_sendStatusCode(304);
	}
}

?>