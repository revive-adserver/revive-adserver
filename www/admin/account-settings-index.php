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
require_once MAX_PATH . '/www/admin/config.php';


// Redirect to the appropriate "Settings" page
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    OX_Admin_Redirect::redirect('account-settings-banner-delivery.php');
} else {
    // Only the admin user can change "Settings", so send to
    // the "Preferences" page instead
    OX_Admin_Redirect::redirect('account-preferences-index.php');
}
