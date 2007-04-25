<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

MAX_Permission::checkAccessToObject('zones', $zoneid);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (isset($session['prefs']['affiliate-zones.php']['listorder'])) {
    $navorder = $session['prefs']['affiliate-zones.php']['listorder'];
} else {
    $navorder = '';
}
if (isset($session['prefs']['affiliate-zones.php']['orderdirection'])) {
    $navdirection = $session['prefs']['affiliate-zones.php']['orderdirection'];
} else {
    $navdirection = '';
}

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabIndex = 1;
$agencyId = phpAds_getAgencyID();
$aEntities = array('affiliateid' => $affiliateid, 'zoneid' => $zoneid);

$aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
$aOtherZones = Admin_DA::getZones(array('publisher_id' => $affiliateid));
MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$dalZones = OA_Dal::factoryDAL('zones');
if ($zone = $dalZones->getZoneForInvocationForm($zoneid)) {
    $extra = array('affiliateid' => $affiliateid,
                   'zoneid' => $zoneid,
                   'width' => $zone['width'],
                   'height' => $zone['height'],
                   'delivery' => $zone['delivery'],
                   'website' => $zone['website']
    );
    $tabindex = 1;
    // Ensure 3rd Party Click Tracking defaults to the preference for this agency
    if (!isset($thirdpartytrack)) {
        $thirdpartytrack = $GLOBALS['_MAX']['PREF']['gui_invocation_3rdparty_default'];
    }
    $maxInvocation = new MAX_Admin_Invocation();
    echo $maxInvocation->placeInvocationForm($extra, true);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
