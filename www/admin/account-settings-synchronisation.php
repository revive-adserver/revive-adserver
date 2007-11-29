<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$  $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobalUnslashed('updates_enabled');

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();

    $oPreferences->setPrefChange('updates_enabled', isset($updates_enabled));

    if (!count($aErrormessage)) {
        if (!$oPreferences->writePrefChange()) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        } else {
            MAX_Admin_Redirect::redirect('account-settings-synchronisation.php');
        }
    }

}

if (isset($message)) {
    phpAds_ShowMessage($message);
}
phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("synchronisation");

$aSettings = array (
    array (
        'text'    => $GLOBALS['strSyncSettings'],
        'items'   => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'updates_enabled',
                'text'    => $strAdminCheckUpdates,
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>
