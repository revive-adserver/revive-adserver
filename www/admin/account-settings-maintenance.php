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

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

    // Register input variables
    phpAds_registerGlobal(
        'maintenance_blockAdImpressions', 'maintenance_blockAdClicks',
        'maintenance_operationInterval', 'maintenance_compactStats',
        'maintenance_compactStatsGrace', 'priority_instantUpdate',
        'logging_defaultImpressionConnectionWindow',
        'logging_defaultClickConnectionWindow', 'maintenance_autoMaintenance'
    );

    // Set up the configuration .ini file
    $oConfig = new OA_Admin_Settings();
    if (isset($maintenance_blockAdImpressions)) {
        if ((!is_numeric($maintenance_blockAdImpressions)) || ($maintenance_blockAdImpressions < 0)) {
            $aErrormessage[1][] = $strBlockAdViewsError;
        } else {
            $oConfig->setConfigChange('maintenance', 'blockAdImpressions', $maintenance_blockAdImpressions);
        }
    }
    if (isset($maintenance_blockAdClicks)) {
        if ((!is_numeric($maintenance_blockAdClicks)) || ($maintenance_blockAdClicks < 0)) {
            $aErrormessage[1][] = $strBlockAdClicksError;
        } else {
            $oConfig->setConfigChange('maintenance', 'blockAdClicks', $maintenance_blockAdClicks);
        }
    }
    if (isset($maintenance_operationInterval)) {
        if ((!is_numeric($maintenance_operationInterval)) ||
                (!OA_OperationInterval::checkOperationIntervalValue($maintenance_operationInterval))) {

            $aErrormessage[2][] = $strMaintenanceOIError;
        } else {
            $oConfig->setConfigChange('maintenance', 'operationInterval', $maintenance_operationInterval);
        }
    }
    $oConfig->setConfigChange('maintenance', 'compactStats', isset($maintenance_compactStats));
    $oConfig->setConfigChange('maintenance', 'autoMaintenance', isset($maintenance_autoMaintenance));
    if (isset($maintenance_compactStatsGrace)) {
        if ((!is_numeric($maintenance_compactStatsGrace)) || ($maintenance_compactStatsGrace <= 0)) {
            $aErrormessage[2][] = $strWarnCompactStatsGrace;
        } else {
            $oConfig->setConfigChange('maintenance', 'compactStatsGrace', $maintenance_compactStatsGrace);
        }

    }
    if (isset($logging_defaultImpressionConnectionWindow)) {
        if (($logging_defaultImpressionConnectionWindow != '') &&
            ((!is_numeric($logging_defaultImpressionConnectionWindow)) ||
             ($logging_defaultImpressionConnectionWindow <= 0))) {
            $aErrormessage[2][] = $strDefaultImpConWindowError;
        } else {
            $oConfig->setConfigChange('logging', 'defaultImpressionConnectionWindow',
                                     $logging_defaultImpressionConnectionWindow);
        }
    }
    if (isset($logging_defaultClickConnectionWindow)) {
        if (($logging_defaultClickConnectionWindow != '') &&
            ((!is_numeric($logging_defaultClickConnectionWindow)) ||
             ($logging_defaultClickConnectionWindow <= 0))) {
            $aErrormessage[2][] = $strDefaultCliConWindowError;
        } else {
            $oConfig->setConfigChange('logging', 'defaultClickConnectionWindow',
                                     $logging_defaultClickConnectionWindow);
        }

    }
    $oConfig->setConfigChange('priority', 'instantUpdate', isset($priority_instantUpdate));

    if (!count($aErrormessage)) {
        if (!$oConfig->writeConfigChange()) {
            // Unable to write the config file out
            $aErrormessage[0][] = $strUnableToWriteConfig;
        } else {
            MAX_Admin_Redirect::redirect('account-settings-synchronisation.php');
        }
    }
}

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("maintenance");

// Change ignore_hosts into a string, so the function handles it good
$conf['ignoreHosts'] = join("\n", $conf['ignoreHosts']);

$aSettings = array (
    array (
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
    ),
    array (
        'text'            => $strMaintenanceSettings,
        'items'           => array (
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
            ),
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
            )
        )
    ),
    array (
        'text'       => $strPrioritySettings,
        'items'      => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'priority_instantUpdate',
                'text'    => $strPriorityInstantUpdate
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>
