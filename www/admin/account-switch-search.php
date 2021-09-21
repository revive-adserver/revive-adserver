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

/**
 * A script to provide search results for the account switcher component.
 *
 * Currently, the script takes two GET parameters:
 *   - "q"     -- The string user typed in the seach box
 *   - "limit" -- The number of search results to be returned.
 */

if (empty($_GET["q"])) {
    $q = '';
} else {
    $q = strtolower($_GET["q"]);
}

// Require the initialisation file
require_once '../../init.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/AccountSwitch.php';

// Send header with charset info
header("Content-Type: text/html" . (isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=" . $phpAds_CharSet : ""));

$oTpl = new OA_Admin_Template('account-switch-search.html');
OA_Admin_UI_AccountSwitch::assignModel($oTpl, $q);
$oTpl->display();
