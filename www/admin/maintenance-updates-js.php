<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

$update_check = false;

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Check for product updates when the admin logs in
if (phpAds_isUser(phpAds_Admin))
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];

    $update_check = false;

    // Check accordingly to user preferences
    if ($pref['updates_enabled']) {
        require_once (MAX_PATH . '/lib/max/OpenadsSync.php');

        $oSync = new MAX_OpenadsSync();

        if ($pref['updates_cache']) {
            $update_check = unserialize($pref['updates_cache']);
        }

        if (!is_array($update_check) || $oSync->getConfigVersion() <= $pref['updates_last_seen']) {
            $update_check = false;
        } else {
            // Make sure that the alert doesn't display everytime
            $doPreference = OA_Dal::factoryDO('preference');
            $doPreference->updates_last_seen = $update_check['config_version'];
            $doPreference->agencyid = 0;
            $doPreference->update();

            // Format like the XML-RPC response
            $update_check = array(0, $update_check);
        }
    }

    phpAds_SessionDataRegister('update_check', $update_check);
    phpAds_SessionDataStore();

    // Add Product Update redirector
    if ($update_check)     {
        header("Content-Type: application/x-javascript");

        if ($update_check[1]['security_fix'])
            echo "alert('".$strUpdateAlertSecurity."');\n";
        else
            echo "if (confirm('".$strUpdateAlert."'))\n\t";

        echo "document.location.replace('maintenance-updates.php');\n";
    }
}

?>