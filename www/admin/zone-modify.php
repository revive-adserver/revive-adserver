<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal('newaffiliateid', 'returnurl', 'duplicate');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);

if (!MAX_checkZone($affiliateid, $zoneid)) {
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($zoneid) && $zoneid != '') {

    MAX_Permission::checkAccessToObject('zones', $zoneid);

    if (isset($newaffiliateid) && $newaffiliateid != '') {
        // A publisher cannot move a zone to another publisher!
        if (phpAds_isUser(phpAds_Affiliate)) {
            phpAds_Die($strAccessDenied, $strNotAdmin);
        }
        // Needs to ensure that the publisher the zone is being moved
        // to is owned by the agency, if an agency is logged in
        if (phpAds_isUser(phpAds_Agency + phpAds_Affiliate)) {
            if (!MAX_checkPublisher($newaffiliateid)) {
                phpAds_Die($strAccessDenied, $strNotAdmin);
            }
        }
        // Move the zone to the new Publisher/Affiliate
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneid);
        $doZones->affiliateid = $newaffiliateid;
        $doZones->update();
        Header("Location: ".$returnurl."?affiliateid=".$newaffiliateid."&zoneid=".$zoneid);
        exit;

    } elseif (isset($duplicate) && $duplicate == 'true') {
        // Can the user add new zones?
        MAX_Permission::checkIsAllowed(phpAds_AddZone);
        // Duplicate the zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneid);
        $new_zoneid = $doZones->duplicate();
        Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$new_zoneid);
        exit;

    }

}

Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$zoneid);

?>