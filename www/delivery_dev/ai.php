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