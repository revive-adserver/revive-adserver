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
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_MANAGER, OA_PERM_MANAGER_DELETE);

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($affiliateid)) {
    $ids = explode(',', $affiliateid);
    foreach ($ids as $affiliateid) {
        // Security check
        OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->affiliateid = $affiliateid;
        if ($doAffiliates->get($affiliateid)) {
            $aAffiliate = $doAffiliates->toArray();
        }
        $doAffiliates->delete();
    }

    // Queue confirmation message
    $translation = new OX_Translation();

    if (count($ids) == 1) {
        $translated_message = $translation->translate($GLOBALS['strWebsiteHasBeenDeleted'], [
            htmlspecialchars($aAffiliate['name'])
        ]);
    } else {
        $translated_message = $translation->translate($GLOBALS['strWebsitesHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}

if (empty($returnurl)) {
    $returnurl = 'website-index.php';
}

Header("Location: " . $returnurl);
