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
    OA_Permission::checkSessionToken();

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

    } elseif (!empty($applyto) && isset($applyto_x)) {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        $bannerName = $doBanners->description;

        if ($applyto == -1) {
            if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                OA_Permission::enforceAccessToObject('campaigns', $campaignid);
            }
            $appliedTo = 0;
            $doBanners = OA_Dal::factoryDO('banners');
            $doBanners->campaignid = $campaignid;
            $doBanners->find();
            while ($doBanners->fetch()) {
                if (($doBanners->bannerid != $bannerid) && (MAX_AclCopy(basename($_SERVER['SCRIPT_NAME']), $bannerid, $doBanners->bannerid))) {
                    $appliedTo++;
                }
            }
            $applyto = $bannerid;
        } else {
            if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                OA_Permission::enforceAccessToObject('banners', $applyto);
            }
            if (MAX_AclCopy(basename($_SERVER['SCRIPT_NAME']), $bannerid, $applyto)) {
                $appliedTo++;
            }
        }
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strBannerAclHasBeenAppliedTo'],
            array(MAX::constructURL(MAX_URL_ADMIN, "banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid"),
                htmlspecialchars($bannerName),
                $appliedTo
            )
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        Header ("Location: {$returnurl}?clientid={$clientid}&campaignid={$campaignid}&bannerid=".$applyto);
    } elseif (isset($duplicate) && $duplicate == 'true') {
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
