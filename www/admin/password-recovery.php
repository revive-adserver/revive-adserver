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

// Define a constant to avoid displaying the login screen
define ('OA_SKIP_LOGIN', 1);

// Require the initialisation file
require_once '../../init.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Admin/PasswordRecovery.php';

$recovery_page = new OA_Admin_PasswordRecovery();

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    $recovery_page->handlePost($_POST);
} else {
    $recovery_page->handleGet($_GET);
}

?>
