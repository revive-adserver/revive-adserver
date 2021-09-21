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
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal('returnurl');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_MANAGER, OA_PERM_MANAGER_DELETE);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

OA_Permission::enforceAccountPermission(OA_ACCOUNT_TRAFFICKER, OA_PERM_ZONE_DELETE);

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($zoneid)) {
    $ids = explode(',', $zoneid);
    foreach ($ids as $zoneid) {
        // Security check
        OA_Permission::enforceAccessToObject('zones', $zoneid);
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zoneid = $zoneid;
        if ($doZones->get($zoneid)) {
            $aZone = $doZones->toArray();
        }
        $doZones->delete();
    }

    // Queue confirmation message
    $translation = new OX_Translation();

    if (count($ids) == 1) {
        $translated_message = $translation->translate($GLOBALS['strZoneHasBeenDeleted'], [
            htmlspecialchars($aZone['zonename'])
        ]);
    } else {
        $translated_message = $translation->translate($GLOBALS['strZonesHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}

if (!isset($returnurl) && $returnurl == '') {
    $returnurl = 'affiliate-zones.php';
}

Header("Location: " . $returnurl . "?affiliateid=$affiliateid");
