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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Preference.php';

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER, OA_ACCOUNT_ADVERTISER);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

}


























/**
 * @todo add warn_limit and warn_limit_days for agency and advertiser,
 *       now is only in the interface
 */

require_once MAX_PATH . '/lib/OA/OperationInterval.php';

if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

    // Register input variables
    phpAds_registerGlobal('warn_admin', 'warn_client', 'warn_agency', 'warn_limit',
                          'warn_limit_days');

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    $oPreferences->setPrefChange('warn_admin',  isset($warn_admin));
    $oPreferences->setPrefChange('warn_client', isset($warn_client));
    $oPreferences->setPrefChange('warn_agency', isset($warn_agency));
    if (isset($warn_limit)) {
        if ((!is_numeric($warn_limit)) || ($warn_limit <= 0)) {
            $aErrormessage[4][] = $strWarnLimitErr;
        } else {
            $oPreferences->setPrefChange('warn_limit', $warn_limit);
        }
    }
    if (isset($warn_limit_days)) {
        if ((!is_numeric($warn_limit_days)) || ($warn_limit_days <= 0)) {
            $aErrormessage[4][] = $strWarnLimitDaysErr;
        } else {
            $oPreferences->setPrefChange('warn_limit_days', $warn_limit_days);
        }
    }

    if (!count($aErrormessage)) {
        if (!$oPreferences->writePrefChange()) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        } else {
            MAX_Admin_Redirect::redirect('account-preferences-language-timezone.php');
        }
    }
}

// Display the settings page's header and sections
phpAds_PageHeader("5.1");
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "My Account" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show the "Preferences", "User Log" and "Channel Management" sections of the "My Account" sections
    phpAds_ShowSections(array("5.1", "5.3", "5.7"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
}

$oOptions->selection("campaign-email-reports");

// Change ignore_hosts into a string, so the function handles it good
$conf['ignoreHosts'] = join("\n", $conf['ignoreHosts']);

$aSettings = array (
    array (
        'text'  => $strAdminEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_admin',
                'text'    => $strWarnAdmin
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_limit',
                'text'    => $strWarnLimit,
                'size'    => 12,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true',
                'req'     => true,
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_limit_days',
                'text'    => $strWarnLimitDays,
                'size'    => 12,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true',
                'req'     => true,
                'check'   => 'number+'
            ),
        )
     ),
     array (
        'text'  => $strAgencyEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_agency',
                'text'    => $strWarnAgency
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_limit',
                'text'    => $strWarnLimit,
                'size'    => 12,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true',
                'req'     => true,
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_limit_days',
                'text'    => $strWarnLimitDays,
                'size'    => 12,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true',
                'req'     => true,
                'check'   => 'number+'
            ),
        )
     ),
     array (
        'text'  => $strAdveEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_client',
                'text'    => $strWarnClient
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_limit',
                'text'    => $strWarnLimit,
                'size'    => 12,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true',
                'req'     => true,
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_limit_days',
                'text'    => $strWarnLimitDays,
                'size'    => 12,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true',
                'req'     => true,
                'check'   => 'number+'
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>