<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal('newaffiliateid', 'returnurl', 'duplicate');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($zoneid) && $zoneid != '') {

    if (isset($newaffiliateid) && $newaffiliateid != '') {
        // A publisher cannot move a zone to another publisher!
        OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
        // Needs to ensure that the publisher the zone is being moved
        // to is owned by the agency, if an agency is logged in
        OA_Permission::enforceAccessToObject('affiliates', $newaffiliateid);
        // Move the zone to the new Publisher/Affiliate
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneid);
        $doZones->affiliateid = $newaffiliateid;
        $doZones->update();
        
        // Queue confirmation message
        $zoneName = $doZones->zonename;
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($newaffiliateid)) {
            $websiteName = $doAffiliates->name;
        }    
        $translation = new OX_Translation();
        $translated_message = $translation->translate($GLOBALS['strZoneHasBeenMoved'],
            array(htmlspecialchars($zoneName), htmlspecialchars($websiteName))
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        
        
        Header("Location: ".$returnurl."?affiliateid=".$newaffiliateid."&zoneid=".$zoneid);
        exit;

    } 
    elseif (isset($duplicate) && $duplicate == 'true') {
        // Can the user add new zones?
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            OA_Permission::enforceAllowed(OA_PERM_ZONE_ADD);
        }
        // Duplicate the zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneid);
        $oldName = $doZones->zonename;
        $new_zoneid = $doZones->duplicate();
        if ($doZones->get($new_zoneid)) {
            $newName = $doZones->zonename;;
        }
        // Queue confirmation message
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strZoneHasBeenDuplicated'],
            array(MAX::constructURL(MAX_URL_ADMIN, "zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid"), 
                htmlspecialchars($oldName),
                MAX::constructURL(MAX_URL_ADMIN, "zone-edit.php?affiliateid=$affiliateid&zoneid=$new_zoneid"), 
                htmlspecialchars($newName))
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        
        Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$new_zoneid);
        exit;

    }

}

Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$zoneid);

?>