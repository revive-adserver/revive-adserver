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
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once LIB_PATH . '/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/AccountSwitch.php';

phpAds_registerGlobalUnslashed('account_id');

if (!empty($account_id)) {
    OA_Permission::enforceAccess($account_id);
    OA_Permission::switchAccount($account_id);
}

$return_url = $_SERVER['HTTP_REFERER'] ?? null;

if (empty($return_url)) {
    OX_Admin_Redirect::redirect();
}

$admin_url = MAX::constructURL(MAX_URL_ADMIN);

// Check if the return URL starts with the admin URL
if (0 !== strncmp($admin_url, $return_url, strlen($admin_url))) {
    OX_Admin_Redirect::redirect();
}

$session['accountSwitch'] = 1;
phpAds_SessionDataStore();

// Ensure that we never return to this account-switch.php page, in the
// event that the session timed out, and then the user changed account
// manually...
$aUrlComponents = parse_url($return_url);
$aPathInformation = pathinfo($aUrlComponents['path']);
if ($aPathInformation['filename'] == 'account-switch') {
    OX_Admin_Redirect::redirect();
}

OA_Admin_UI_AccountSwitch::addToRecentlyUsedAccounts($account_id);

// Re-direct...
header('Location: ' . $return_url);
exit;
