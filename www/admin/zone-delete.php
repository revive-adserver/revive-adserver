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
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/DB.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($zoneid)) {
    
    MAX_Permission::checkIsAllowed(phpAds_DeleteZone);
    MAX_Permission::checkAccessToObject('zones', $zoneid);
    
//    $doZones = MAX_DB::factoryDO('zones');
//    $doZones->zoneid = $zoneid;
//    
//    if (phpAds_isUser(phpAds_Affiliate)) {
//        if (!$doZones->belongToUser('affiliates', phpAds_getUserID()) || !phpAds_isAllowed(phpAds_DeleteZone)) {
//            phpAds_PageHeader("1");
//            phpAds_Die ($strAccessDenied, $strNotAdmin);
//        } else {
//            $affiliateid = $doZones->affiliateid;
//        }
//    } elseif (phpAds_isUser(phpAds_Agency)) {
//        if ($doZones->belongToUser('agency', phpAds_getUserID())) {
//            phpAds_PageHeader("2");
//            phpAds_Die ($strAccessDenied, $strNotAdmin);
//        }
//    }
    
    $doZones = MAX_DB::factoryDO('zones');
    $doZones->zoneid = $zoneid;
    $doZones->delete();
}

if (!isset($returnurl) && $returnurl == '') {
    $returnurl = 'affiliate-zones.php';
}

Header("Location: ".$returnurl."?affiliateid=$affiliateid");

?>