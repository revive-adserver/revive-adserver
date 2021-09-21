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
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

// Register input variables
phpAds_registerGlobal('userid', 'returnurl');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);
$doAccounts = OA_Dal::factoryDO('accounts');
$accountId = $doAccounts->getAdminAccountId();

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($accountId) && !empty($userid)) {
    if (OA_Admin_UI_UserAccess::countNumberOfUserLinkedToAccount($accountId) > 1) {
        OA_Admin_UI_UserAccess::unlinkUserFromAccount($userid, $accountId);
    } else {
        OA_Session::setMessage($GLOBALS['strCantDeleteOneAdminUser']);
    }
}

if (empty($returnurl)) {
    $returnurl = 'admin-access.php';
}

Header("Location: " . $returnurl);
