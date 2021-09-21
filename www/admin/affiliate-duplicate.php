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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal('returnurl');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid, true);
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doAffiliates = OA_Dal::factoryDO('affiliates');
$doAffiliates->get($affiliateid);
$oldName = $doAffiliates->name;
$new_affiliateId = $doAffiliates->duplicate();
$newName = $doAffiliates->name;

// Queue confirmation message
$translation = new OX_Translation();
$translated_message = $translation->translate(
    $GLOBALS['strWebsiteHasBeenDuplicated'],
    [MAX::constructURL(MAX_URL_ADMIN, "affiliate-edit.php?affiliateid=$affiliateid"),
        htmlspecialchars($oldName),
        MAX::constructURL(MAX_URL_ADMIN, "affiliate-edit.php?affiliateid=$new_affiliateId"),
        htmlspecialchars($newName)]
);
OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

Header("Location: affiliate-edit.php?affiliateid=$new_affiliateId");
exit;
