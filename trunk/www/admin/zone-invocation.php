<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid);

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OA_Permission::enforceAllowed(OA_PERM_ZONE_INVOCATION);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabIndex = 1;
$agencyId = OA_Permission::getAgencyId();
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
        $thirdpartytrack = $GLOBALS['_MAX']['CONF']['delivery']['clicktracking'];
    }
    $maxInvocation = new MAX_Admin_Invocation();
    echo $maxInvocation->placeInvocationForm($extra, true);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
