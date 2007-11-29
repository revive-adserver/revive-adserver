<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id: settings-stats.php 12637 2007-11-20 19:02:36Z miguel.correa@openads.org $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin);

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

     // Register input variables
    phpAds_registerGlobal('qmail_patch', 'admin_email_headers', 'userlog_email');

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    $oPreferences->setPrefChange('qmail_patch', isset($qmail_patch));
    $oPreferences->setPrefChange('userlog_email', isset($userlog_email));

    if (isset($admin_email_headers)) {
        $admin_email_headers = trim(ereg_replace("\r?\n", '\\r\\n', $admin_email_headers));
        $oPreferences->setPrefChange('admin_email_headers', $admin_email_headers);
    }

    if (!count($aErrormessage)) {
        if (!$oPreferences->writePrefChange()) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        } else {
            MAX_Admin_Redirect::redirect('account-settings-geotargeting.php');
        }
    }
}

phpAds_PageHeader("5.2");
if (phpAds_isUser(phpAds_Admin)) {
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
} elseif (phpAds_isUser(phpAds_Agency)) {
//    phpAds_ShowSections(array("5.2", "5.4", "5.3"));
    phpAds_ShowSections(array("5.2", "5.3"));
}

$oOptions->selection("email");

// Change ignore_hosts into a string, so the function handles it good
$conf['ignoreHosts'] = join("\n", $conf['ignoreHosts']);

$aSettings = array (
    array (
       'text'  => $strEmailLog,
       'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'userlog_email',
                'text'    => $strUserlogEmail
            )
        )
    ),
    array (
       'text'  => $strEmailHeader,
       'items' => array (
            array (
               'type'    => 'textarea',
               'name'    => 'admin_email_headers',
               'text'    => $strAdminEmailHeaders,
               'depends' => 'warn_client==true || warn_admin==true || warn_agency==true'
            )
        )
    ),
        array (
        'text'  => $strQmailPatch,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'qmail_patch',
                'text'    => $strEnableQmailPatch,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true'
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>