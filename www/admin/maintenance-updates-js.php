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
require_once MAX_PATH . '/lib/RV/Sync.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

$update_check = false;

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Check for product updates when the admin logs in
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN))
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    $aVars = OA_Dal_ApplicationVariables::getAll();

    $update_check = false;

    // Check accordingly to user preferences
    if (!empty($aConf['sync']['checkForUpdates'])) {
        if ($aVars['sync_cache']) {
            $update_check = unserialize($aVars['sync_cache']);
        }

        // If cache timestamp not set or older than 24hrs, re-sync
        if (isset($aVars['sync_timestamp']) && $aVars['sync_timestamp'] + 86400 < time()) {
            $oSync = new RV_Sync();
            $res = $oSync->checkForUpdates();

            if ($res[0] == 0) {
                $update_check = $res[1];
            }
        }

        if (!is_array($update_check) || $update_check['config_version'] <= $aVars['sync_last_seen']) {
            $update_check = false;
        } else {
            // Make sure that the alert doesn't display everytime
            OA_Dal_ApplicationVariables::set('sync_last_seen', $update_check['config_version']);

            // Format like the XML-RPC response
            $update_check = array(0, $update_check);
        }
    }

    phpAds_SessionDataRegister('maint_update_js', true);
    phpAds_SessionDataStore();

    // Add Product Update redirector
    if (isset($update_check[0]) && $update_check[0] == 0) {
        header("Content-Type: application/x-javascript");

        if ($update_check[1]['security_fix'])
            echo "alert('".$strUpdateAlertSecurity."');\n";
        else
            echo "if (confirm('".$strUpdateAlert."'))\n\t";

        echo "document.location.replace('updates-product.php');\n";
    }
}

?>
