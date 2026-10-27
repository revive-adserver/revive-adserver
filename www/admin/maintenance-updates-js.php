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
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

$update_check = [];

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Check for product updates when the admin logs in
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    $aConf = $GLOBALS['_MAX']['CONF'];
    $aVars = OA_Dal_ApplicationVariables::getAll();

    $update_check = [];

    // Check accordingly to user preferences
    if (!empty($aConf['sync']['checkForUpdates'])) {
        if ($aVars['sync_cache']) {
            $update_check = \RV\Sync::normalizeUpdates(unserialize($aVars['sync_cache'], ['allowed_classes' => false]));
        }

        // If cache timestamp is not set or older than 24hrs, re-sync
        if (empty($aVars['sync_timestamp']) || $aVars['sync_timestamp'] + 86400 < time()) {
            $oSync = RV_getContainer()->get(\RV\Sync::class);
            $res = $oSync->checkForUpdates();

            if ($res[0] == 0) {
                $update_check = $res[1];
            } elseif ($res[0] == 800) {
                $update_check = [];
            }
        }

        $latestVersion = $update_check ? max(array_column($update_check, 'config_version')) : 0;
        if ($latestVersion <= ($aVars['sync_last_seen'] ?? 0)) {
            $update_check = [];
        } else {
            // Remember the newest suggested release so the alert only appears once.
            OA_Dal_ApplicationVariables::set('sync_last_seen', $latestVersion);
        }
    }

    phpAds_SessionDataRegister('maint_update_js', true);
    phpAds_SessionDataStore();

    // Add Product Update redirector
    if ($update_check) {
        header("Content-Type: application/x-javascript");

        if (in_array(1, array_column($update_check, 'security_fix'))) {
            echo "alert('" . $strUpdateAlertSecurity . "');\n";
        } else {
            echo "if (confirm('" . $strUpdateAlert . "'))\n\t";
        }

        echo "document.location.replace('updates-product.php');\n";
    }
}
