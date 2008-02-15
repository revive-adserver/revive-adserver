<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Sync.php';
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
            $oSync = new OA_Sync();
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
