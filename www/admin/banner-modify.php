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
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

// Register input variables

//phpAds_registerGlobal ('returnurl', 'duplicate', 'moveto_x', 'moveto', 'applyto_x', 'applyto');
phpAds_registerGlobal('bannerid', 'campaignid', 'clientid', 'returnurl', 'duplicate', 'moveto', 'moveto_x', 'applyto', 'applyto_x');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($bannerid)) {
    OA_Permission::enforceAccessToObject('banners', $bannerid);

    if (!empty($moveto) && isset($moveto_x)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            OA_Permission::enforceAccessToObject('campaigns', $moveto);
        }

        // Move the banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $doBanners->campaignid = $moveto;
        $doBanners->update();

        // Increase the memory for running the maintenance
        OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('maintenance'));

        // Run the Maintenance Priority Engine process
        OA_Maintenance_Priority::scheduleRun();

        // Rebuild cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();

        // Get new clientid
        $clientid = phpAds_getCampaignParentClientID($moveto);

        //confirmation message
        $bannerName = $doBanners->description;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        if ($doCampaigns->get($moveto)) {
           $campaignName = $doCampaigns->campaignname;
        }
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strBannerHasBeenMoved'],
            array(htmlspecialchars($bannerName), htmlspecialchars($campaignName))
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$moveto}&bannerid={$bannerid}");

    }
    elseif (!empty($applyto) && isset($applyto_x)) {
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            OA_Permission::enforceAccessToObject('banners', $applyto);
        }
        if (MAX_AclCopy(basename($_SERVER['PHP_SELF']), $bannerid, $applyto)) {
            // Rebuild cache
            // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
            // phpAds_cacheDelete();

            Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$applyto);
        }
        else {
            phpAds_sqlDie();
        }
    }
    elseif (isset($duplicate) && $duplicate == 'true') {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $oldName = $doBanners->description;
        $new_bannerid = $doBanners->duplicate();

        // Run the Maintenance Priority Engine process
        OA_Maintenance_Priority::scheduleRun();

        // Rebuild cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();

        //confirmation message
        $newName = $doBanners->description;
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strBannerHasBeenDuplicated'],
            array(MAX::constructURL(MAX_URL_ADMIN, "banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid"),
                htmlspecialchars($oldName),
                MAX::constructURL(MAX_URL_ADMIN, "banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$new_bannerid"),
                htmlspecialchars($newName))
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$new_bannerid);
    }
    else {
        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$bannerid);
    }
}

?>
