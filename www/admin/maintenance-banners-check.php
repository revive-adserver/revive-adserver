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
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner-cache.inc.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

phpAds_registerGlobal('action', 'returnurl');

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($action) && ($action == 'Rebuild')) {
    OA_Permission::checkSessionToken();

    $result = processBanners(true);
    if (empty($result['errors'])) {
        if (empty($returnurl)) { $returnurl = 'maintenance-banners-check.php'; }
        OX_Admin_Redirect::redirect($returnurl);
    } else {
        _showPageHeader();
        echo $GLOBALS['strBannerCacheErrorsFound'];
        echo "<ul>";
       foreach ($result['errors'] as $error) {
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            if (empty($campaigns[$error['campaignid']])) {
                if ($doCampaigns->get($error['campaignid'])) {
                    $campaigns[$error['campaignid']] = $doCampaigns->toArray();
                }
            }
            echo "<li><a href='banner-edit.php?clientid={$campaigns[$error['campaignid']]['clientid']}&campaignid={$error['campaignid']}&bannerid={$error['bannerid']}'>{$error['description']}</a></li>";
        }
        echo "</ul>";
    }
} else {
    $result = processBanners(false);
    if (!empty($result['errors']) || !empty($result['different'])) {
        _showPageHeader();
        echo $GLOBALS['strBannerCacheDifferencesFound'];
        echo "<form action='' METHOD='GET'>";
        echo "<input type='hidden' name='token' value='".htmlspecialchars(phpAds_SessionGetToken(), ENT_QUOTES)."' />";
        echo "<input type='submit' name='action' value='{$GLOBALS['strBannerCacheRebuildButton']}' />";
        echo "</form>";
    } else {
        _showPageHeader();
        echo $GLOBALS['strBannerCacheOK'];
    }
}

function _showPageHeader()
{
    phpAds_PageHeader("maintenance-index");
    phpAds_MaintenanceSelection("banners");
}


//function processBanners($commit = false) {
//    $doBanners = OA_Dal::factoryDO('banners');
//
//    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
//    {
//        $doBanners->addReferenceFilter('agency', $agencyId = OA_Permission::getEntityId());
//    }
//    $doBanners->find();
//
//    $different = 0;
//    $same      = 0;
//    $errors    = array();
//
//    while ($doBanners->fetch())
//    {
//    	// Rebuild filename
//    	if ($doBanners->storagetype == 'sql' || $doBanners->storagetype == 'web') {
//    		$doBanners->imageurl = '';
//    	}
//    	$GLOBALS['_MAX']['bannerrebuild']['errors'] = false;
//    	if ($commit) {
//            $doBannersClone = clone($doBanners);
//            $doBannersClone->update();
//            $newCache = $doBannersClone->htmlcache;
//    	} else {
//    	    $newCache = phpAds_getBannerCache($doBanners->toArray());
//    	}
//        if (empty($GLOBALS['_MAX']['bannerrebuild']['errors'])) {
//            if ($doBanners->htmlcache != $newCache && ($doBanners->storagetype == 'html')) {
//                $different++;
//            } else {
//                $same++;
//            }
//    	} else {
//    	    $errors[] = $doBanners->toArray();
//    	}
//    }
//    return array('errors' => $errors, 'different' => $different, 'same' => $same);
//}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
