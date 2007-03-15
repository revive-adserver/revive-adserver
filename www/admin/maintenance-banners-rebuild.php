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
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doBanners = MAX_DB::factoryDO('banners');

if (phpAds_isUser(phpAds_Agency))
{
    $doBanners->addReferenceFilter('agency', $agencyId = phpAds_getUserId());
}
$doBanners->find();

while ($doBanners->fetch())
{
	// Rebuild filename
	if ($doBanners->storagetype == 'sql' || $doBanners->storagetype == 'web') {
		$doBanners->imageurl = '';
	}
	$doBannersClone = clone($doBanners);
	$doBannersClone->update();
}

MAX_Admin_Redirect::redirect('maintenance-banners.php');

?>
