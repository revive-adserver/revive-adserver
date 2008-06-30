<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
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
    $result = processBanners(true);
    if (empty($result['errors'])) {
        if (empty($returnurl)) { $returnurl = 'maintenance-banners-check.php'; }
        MAX_Admin_Redirect::redirect($returnurl);
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
        echo "<form action='{$_SERVER['PHP_SELF']}' METHOD='GET'>";
        echo "<input type='submit' name='action' value='{$GLOBALS['strBannerCacheRebuildButton']}' />";
        echo "</form>";
    } else {
        _showPageHeader();
        echo $GLOBALS['strBannerCacheOK'];
    }
}

function _showPageHeader()
{
    phpAds_PageHeader("5.5");
    phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4"));
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

?>
