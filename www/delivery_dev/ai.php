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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/Delivery/image.php';

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('filename', 'contenttype'));

if (!empty($filename)) {
    $aCreative = MAX_cacheGetCreative($filename);

	if (empty($aCreative) || !isset($aCreative['contents'])) {
		// Filename not found, show the admin user's default banner
		// (as the agency cannot be determined from a filename)
		if ($conf['defaultBanner']['imageUrl'] != "") {
		    MAX_redirect($conf['defaultBanner']['imageUrl']);
		} else {
		    MAX_commonDisplay1x1();
		}
	} else {
		// Filename found, dump contents to browser
		MAX_imageServe($aCreative, $filename, $contenttype);
	}
} else {
	// Filename not specified, show the admin user's default banner
	// (as the agency cannot be determined from a filename)
	if ($conf['defaultBanner']['imageUrl'] != "") {
	    MAX_redirect($conf['defaultBanner']['imageUrl']);
	} else {
        MAX_commonDisplay1x1();
    }
}

?>