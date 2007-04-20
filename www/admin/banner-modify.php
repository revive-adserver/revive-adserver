<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
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
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';

// Register input variables

//phpAds_registerGlobal ('returnurl', 'duplicate', 'moveto_x', 'moveto', 'applyto_x', 'applyto');
phpAds_registerGlobal('bannerid', 'campaignid', 'clientid', 'returnurl', 'duplicate', 'moveto', 'moveto_x', 'applyto', 'applyto_x');


// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($bannerid)) {
    MAX_Permission::checkAccessToObject('banners', $bannerid);

    if (!empty($moveto) && isset($moveto_x)) {
        if (phpAds_isUser(phpAds_Agency)) {
            MAX_Permission::checkAccessToObject('campaigns', $moveto);
        }

        // Move the banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $doBanners->campaignid = $moveto;
        $doBanners->update();

        // Run the Maintenance Priority Engine process
        MAX_Maintenance_Priority::run();

        // Rebuild cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();

        // Get new clientid
        $clientid = phpAds_getCampaignParentClientID($moveto);
        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$moveto}&bannerid={$bannerid}");

    } elseif (!empty($applyto) && isset($applyto_x)) {
        if (phpAds_isUser(phpAds_Agency)) {
            MAX_Permission::checkAccessToObject('banners', $applyto);
        }
        if (MAX_AclCopy(basename($_SERVER['PHP_SELF']), $bannerid, $applyto)) {
            // Rebuild cache
            // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
            // phpAds_cacheDelete();

            Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$applyto);
        } else {
            phpAds_sqlDie();
        }
    } elseif (isset($duplicate) && $duplicate == 'true') {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $new_bannerid = $doBanners->duplicate();

        // Run the Maintenance Priority Engine process
        MAX_Maintenance_Priority::run();

        // Rebuild cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();

        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$new_bannerid);
    } else {
        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$bannerid);
    }
}

?>
