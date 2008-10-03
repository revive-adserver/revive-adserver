<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OA_Permission::enforceAllowed(OA_PERM_ZONE_DELETE);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($zoneid)) {
    $ids = explode(',', $zoneid);
    while (list(,$zoneid) = each($ids)) {

        // Security check
        OA_Permission::enforceAccessToObject('zones', $zoneid);
    
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zoneid = $zoneid;
        if ($doZones->get($zoneid)) {
            $aZone = $doZones->toArray();
        }

        // Ad  Networks
        $oAdNetworks = new OA_Central_AdNetworks();
        $oAdNetworks->deleteZone($doZones->as_zone_id);

        $doZones->delete();
    }
    
    // Queue confirmation message
    $translation = new OX_Translation ();
    
    if (count($ids) == 1) {
        $translated_message = $translation->translate ($GLOBALS['strZoneHasBeenDeleted'], array(
            htmlspecialchars($aZone['zonename'])
        ));
    } else {
        $translated_message = $translation->translate ($GLOBALS['strZonesHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}

if (!isset($returnurl) && $returnurl == '') {
    $returnurl = 'affiliate-zones.php';
}

Header("Location: ".$returnurl."?affiliateid=$affiliateid");

?>