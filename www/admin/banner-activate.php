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
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

// Register input variables
phpAds_registerGlobal ('value');

if ($value == OA_ENTITY_STATUS_RUNNING) {
    $value = OA_ENTITY_STATUS_PAUSED;
} else {
    $value = OA_ENTITY_STATUS_RUNNING;
}

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);
OA_Permission::enforceAccessToObject('banners',   $bannerid, true);

if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    if ($value == OA_ENTITY_STATUS_RUNNING) {
        OA_Permission::enforceAllowed(OA_PERM_BANNER_ACTIVATE);
    } else {
        OA_Permission::enforceAllowed(OA_PERM_BANNER_DEACTIVATE);
    }
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/


if (!empty($bannerid))
{
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->get($bannerid);
    $bannerName = $doBanners->description;
    
    $translation = new OX_Translation();
    $message = ($value == OA_ENTITY_STATUS_PAUSED) ? $GLOBALS ['strBannerHasBeenDeactivated'] : $GLOBALS ['strBannerHasBeenActivated'];
    $translated_message = $translation->translate($message, array (
        MAX::constructURL(MAX_URL_ADMIN, "banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid"), 
        htmlspecialchars($bannerName)
    ));
    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
    
    $doBanners->status = $value;
    $doBanners->update();
}
elseif (!empty($campaignid))
{
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->status = $value;
    $doBanners->whereAdd('campaignid = ' . $campaignid);

    // Update all the banners
    $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
}

// Run the Maintenance Priority Engine process
OA_Maintenance_Priority::scheduleRun();

// Rebuild cache
// require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
// phpAds_cacheDelete();
header("Location: campaign-banners.php?clientid=".$clientid."&campaignid=".$campaignid);

?>
