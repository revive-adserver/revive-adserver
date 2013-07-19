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

phpAds_registerGlobalUnslashed('return_url', 'account_id');

if (!empty($account_id)) {
    OA_Permission::enforceAccess($account_id);
    OA_Permission::switchAccount($account_id);
}

if (empty($return_url) && !empty($_SERVER['HTTP_REFERER'])) {
    $return_url = $_SERVER['HTTP_REFERER'];
}

if (empty($return_url) || preg_match('/[\r\n]/', $_SERVER['HTTP_REFERER'])) {
    $return_url = MAX::constructURL(MAX_URL_ADMIN, 'index.php');
} else {
    $session['accountSwitch'] = 1;
    phpAds_SessionDataStore();
}

// Ensure that we never return to this account-switch.php page, in the
// event that the session timed out, and then the user changed account
// manually...
$aUrlComponents = parse_url($return_url);
$aPathInformation = pathinfo($aUrlComponents['path']);
if ($aPathInformation['filename'] == 'account-switch') {
    $sectionID = $aPathInformation['filename'];
    OX_Admin_Redirect::redirect();
}

OA_Admin_UI_AccountSwitch::addToRecentlyUsedAccounts($account_id);

// Re-direct...
header('Location: ' . $return_url);
exit;

?>