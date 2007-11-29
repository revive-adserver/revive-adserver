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
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin);

// If the form has been submitted, write out the new settings configuration file
$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal(
        'logging_adRequests',
        'logging_adImpressions',
        'logging_adClicks',
        'logging_trackerImpressions',
        'logging_reverseLookup',
        'logging_proxyLookup',
        'logging_sniff',
        'logging_ignoreHosts'
    );
    // Set up the settings configuration file
    $oSettings = new OA_Admin_Settings();
    $oSettings->setConfigChange('logging', 'adRequests',         isset($logging_adRequests));
    $oSettings->setConfigChange('logging', 'adImpressions',      isset($logging_adImpressions));
    $oSettings->setConfigChange('logging', 'adClicks',           isset($logging_adClicks));
    $oSettings->setConfigChange('logging', 'trackerImpressions', isset($logging_trackerImpressions));
    $oSettings->setConfigChange('logging', 'reverseLookup',      isset($logging_reverseLookup));
    $oSettings->setConfigChange('logging', 'proxyLookup',        isset($logging_proxyLookup));
    $oSettings->setConfigChange('logging', 'sniff',              isset($logging_sniff));
    if (isset($logging_ignoreHosts)) {
        // Split the list of hosts to ignore on a space, comma, or semicolon
        $aIgnoreHosts = preg_split('/ |,|;/', $logging_ignoreHosts);
        // Remove any empty string hosts
        $aEmptyKeys = array_keys($aIgnoreHosts, '');
        $counter = -1;
        foreach ($aEmptyKeys as $key) {
            $counter++;
            array_splice($aIgnoreHosts, $key - $counter, 1);
        }
        $oSettings->setBulkConfigChange('ignoreHosts', $aIgnoreHosts);
    }

    if (!$oSettings->writeConfigChange()) {
        // Unable to write the settings configuration file
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }

    if (!count($aErrormessage))
            MAX_Admin_Redirect::redirect('account-settings-banner-storage.php');

}

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("banner-logging");

// Change ignore_hosts into a string, so the function handles it good
$conf['ignoreHosts'] = join("\n", $conf['ignoreHosts']);

$aSettings = array (
    array (
        'text'  => $strBannerLogging,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_adRequests',
                'text'    => $strLogAdRequests
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_adImpressions',
                'text'    => $strLogAdImpressions
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_adClicks',
                'text'    => $strLogAdClicks
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_trackerImpressions',
                'text'    => $strLogTrackerImpressions
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_reverseLookup',
                'text'    => $strReverseLookup
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_proxyLookup',
                'text'    => $strProxyLookup
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_sniff',
                'text'    => $strSniff
            )
        )
    ),
    array (
        'text'  => $strPreventLogging,
        'items' => array (
            array (
                'type'    => 'textarea',
                'name'    => 'ignoreHosts',
                'text'    => $strIgnoreHosts
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>