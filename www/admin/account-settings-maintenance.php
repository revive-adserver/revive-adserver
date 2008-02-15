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
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    /*
    // Block Banner Logging Settings
    $aElements += array(
        'maintenance_blockAdImpressions' => array('maintenance' => 'blockAdImpressions'),
        'maintenance_blockAdClicks'      => array('maintenance' => 'blockAdClicks')
    );
    */
    // Maintenance Settings
    $aElements += array(
        'maintenance_autoMaintenance' => array(
            'maintenance' => 'autoMaintenance',
            'bool'        => true
        ),
        'maintenance_operationInterval' => array('maintenance' => 'operationInterval'),
        'maintenance_compactStats' => array(
            'maintenance' => 'compactStats',
            'bool'        => true
        ),
        'maintenance_compactStatsGrace'             => array('maintenance' => 'compactStatsGrace'),
        /*
        'logging_defaultImpressionConnectionWindow' => array('logging' => 'defaultImpressionConnectionWindow'),
        'logging_defaultClickConnectionWindow'      => array('logging' => 'defaultClickConnectionWindow'),
        */
    );
    // Priority Settings
    $aElements += array(
        'priority_instantUpdate' => array(
            'priority' => 'instantUpdate',
            'bool'     => true
        )
    );
    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
        // The settings configuration file was written correctly,
        // go to the "next" settings page from here
        MAX_Admin_Redirect::redirect('account-settings-synchronisation.php');
    }
    // Could not write the settings configuration file, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWriteConfig;
}

// Display the settings page's header and sections
phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3"));

// Set the correct section of the settings pages and display the drop-down menu
$oOptions->selection("maintenance");

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
  /*array (
        'text'  => $strPreventLogging,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'maintenance_blockAdImpressions',
                'text'    => $strBlockAdViews,
                'size'    => 12,
                'depends' => 'logging_adImpressions==true',
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'maintenance_blockAdClicks',
                'text'    => $strBlockAdClicks,
                'size'    => 12,
                'depends' => 'logging_adClicks==true',
                'check'   => 'number+'
            )
        )
    ),*/
    array (
        'text'  => $strMaintenanceSettings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'maintenance_autoMaintenance',
                'text'	  => $strEnableAutoMaintenance
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'select',
                'name'    => 'maintenance_operationInterval',
                'text'    => $strMaintenanceOI,
                'size'    => 12,
                'items'   =>  array(
                    60 => 60,
                    30 => 30,
                    20 => 20,
                    15 => 15,
                    10 => 10,
                    5 => 5
                )
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'maintenance_compactStats',
                'text'    => $strMaintenanceCompactStats
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'maintenance_compactStatsGrace',
                'text'    => $strMaintenanceCompactStatsGrace,
                'size'    => 12,
                'depends' => 'maintenance_compactStats==true',
                'check'   => 'number+'
            )/*,
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_defaultImpressionConnectionWindow',
                'text'    => $strDefaultImpConWindow,
                'size'    => 12,
                'depends' => 'logging_adImpressions==true && logging_trackerImpressions==true',
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_defaultClickConnectionWindow',
                'text'    => $strDefaultCliConWindow,
                'size'    => 12,
                'depends' => 'logging_adClicks==true && logging_trackerImpressions==true',
                'check'   => 'number+'
            )*/
        )
    ),
    array (
        'text'  => $strPrioritySettings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'priority_instantUpdate',
                'text'    => $strPriorityInstantUpdate
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>