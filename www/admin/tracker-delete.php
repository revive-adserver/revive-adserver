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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/DB.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency))
{
	$doTracker = MAX_DB::factoryDO('trackers');
	$doTracker->trackerid = $trackerid;
	
	if (!$doTracker->belongToUser('agency', phpAds_getUserID()))
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doTracker = MAX_DB::factoryDO('trackers');

if (!empty($trackerid))
{
    $doTracker->trackerid = $trackerid;
    $doTracker->delete();
}
elseif (!empty($clientid))
{
    $doTracker->clientid = $clientid;
    $doTracker->delete();
}


if (empty($returnurl))
	$returnurl = 'advertiser-trackers.php';

header ("Location: ".$returnurl."?clientid=".$clientid);

?>