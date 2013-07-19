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
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doBanners = OA_Dal::factoryDO('banners');
$doBanners->storagetype = 'sql';
$doBanners->find();

while ($doBanners->fetch())
{
	// Get the filename
	$filename = $doBanners->filename;

	// Copy the file
	$buffer = phpAds_ImageRetrieve('sql', $filename);
	$doBanners->filename = phpAds_ImageStore('web', $filename, $buffer);

	// TODO: Would be nice if we gave some indication to the user of success or failure!
	if ($doBanners->filename != false)
	{
		phpAds_ImageDelete ('sql', $filename);

	    $doBannersClone = clone($doBanners);

		$doBannersClone->imageurl = '';
		$doBannersClone->storagetype = 'web';

        $doBannersClone->update();
	}
}

Header("Location: maintenance-storage.php");

?>