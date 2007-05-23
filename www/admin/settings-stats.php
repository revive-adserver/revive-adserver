<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
require_once MAX_PATH . '/lib/max/Admin/Config.php';
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

    // Register input variables
    phpAds_registerGlobal('logging_csvImport','logging_adRequests', 'logging_adImpressions',
                          'logging_adClicks','logging_trackerImpressions',
                          'logging_reverseLookup', 'logging_proxyLookup', 'logging_sniff',
                          'ignoreHosts',
                          'logging_blockAdImpressions', 'logging_blockAdClicks',
                          'logging_blockTrackerImpressions',
                          'modules_AdServer', 'modules_Tracker',
                          'maintenance_operationInterval',
                          'maintenance_compactStats', 'maintenance_compactStatsGrace',
                          'priority_instantUpdate',
                          'logging_defaultImpressionConnectionWindow',
                          'logging_defaultClickConnectionWindow',
                          'warn_admin', 'warn_client', 'warn_agency', 'warn_limit',
                          'admin_email_headers', 'qmail_patch', 'warn_limit_days'
                          );
    // Set up the configuration .ini file
    $config = new MAX_Admin_Config();
    $config->setConfigChange('logging', 'csvImport',          isset($logging_csvImport));
    $config->setConfigChange('logging', 'adRequests',         isset($logging_adRequests));
    $config->setConfigChange('logging', 'adImpressions',      isset($logging_adImpressions));
    $config->setConfigChange('logging', 'adClicks',           isset($logging_adClicks));
    $config->setConfigChange('logging', 'trackerImpressions', isset($logging_trackerImpressions));
    $config->setConfigChange('logging', 'reverseLookup',      isset($logging_reverseLookup));
    $config->setConfigChange('logging', 'proxyLookup',        isset($logging_proxyLookup));
    $config->setConfigChange('logging', 'sniff',              isset($logging_sniff));
    if (isset($logging_blockAdImpressions)) {
        if ((!is_numeric($logging_blockAdImpressions)) || ($logging_blockAdImpressions < 0)) {
            $errormessage[1][] = $strBlockAdViewsError;
        } else {
            $config->setConfigChange('logging', 'blockAdImpressions', $logging_blockAdImpressions);
        }
    }
    if (isset($logging_blockAdClicks)) {
        if ((!is_numeric($logging_blockAdClicks)) || ($logging_blockAdClicks < 0)) {
            $errormessage[1][] = $strBlockAdClicksError;
        } else {
            $config->setConfigChange('logging', 'blockAdClicks', $logging_blockAdClicks);
        }
    }
    if (isset($logging_blockTrackerImpressions)) {
        if ((!is_numeric($logging_blockTrackerImpressions)) || ($logging_blockTrackerImpressions < 0)) {
            $errormessage[1][] = $strBlockAdConversionsError;
        } else {
            $config->setConfigChange('logging', 'blockTrackerImpressions', $logging_blockTrackerImpressions);
        }
    }
    if (isset($ignoreHosts)) {
        // Split the list of hosts to ignore on a space, comma, or semicolon
        $ignoreHostsArray = preg_split('/ |,|;/', $ignoreHosts);
        // Remove any empty string hosts
        $emptyKeys = array_keys($ignoreHostsArray, '');
        $counter = -1;
        foreach ($emptyKeys as $key) {
            $counter++;
            array_splice($ignoreHostsArray, $key - $counter, 1);
        }
        $config->setBulkConfigChange('ignoreHosts', $ignoreHostsArray);
    }
    $config->setConfigChange('modules', 'AdServer',        isset($modules_AdServer));
    $config->setConfigChange('modules', 'Tracker',         isset($modules_Tracker));
    if (isset($maintenance_operationInterval)) {
        if ((!is_numeric($maintenance_operationInterval)) ||
                (!MAX_OperationInterval::checkOperationIntervalValue($maintenance_operationInterval))) {

            $errormessage[2][] = $strMaintenanceOIError;
        } else {
            $config->setConfigChange('maintenance', 'operationInterval', $maintenance_operationInterval);
        }
    }
    $config->setConfigChange('maintenance', 'compactStats', isset($maintenance_compactStats));
    if (isset($maintenance_compactStatsGrace)) {
        if ((!is_numeric($maintenance_compactStatsGrace)) || ($maintenance_compactStatsGrace <= 0)) {
            $errormessage[2][] = $strWarnCompactStatsGrace;
        } else {
            $config->setConfigChange('maintenance', 'compactStatsGrace', $maintenance_compactStatsGrace);
        }

    }
    if (isset($logging_defaultImpressionConnectionWindow)) {
        if (($logging_defaultImpressionConnectionWindow != '') &&
            ((!is_numeric($logging_defaultImpressionConnectionWindow)) ||
             ($logging_defaultImpressionConnectionWindow <= 0))) {
            $errormessage[2][] = $strDefaultImpConWindowError;
        } else {
            $config->setConfigChange('logging', 'defaultImpressionConnectionWindow',
                                     $logging_defaultImpressionConnectionWindow);
        }
    }
    if (isset($logging_defaultClickConnectionWindow)) {
        if (($logging_defaultClickConnectionWindow != '') &&
            ((!is_numeric($logging_defaultClickConnectionWindow)) ||
             ($logging_defaultClickConnectionWindow <= 0))) {
            $errormessage[2][] = $strDefaultCliConWindowError;
        } else {
            $config->setConfigChange('logging', 'defaultClickConnectionWindow',
                                     $logging_defaultClickConnectionWindow);
        }

    }
    $config->setConfigChange('priority', 'instantUpdate', isset($priority_instantUpdate));
    // Set up the preferences object
    $preferences = new MAX_Admin_Preferences();
    $preferences->setPrefChange('warn_admin',  isset($warn_admin));
    $preferences->setPrefChange('warn_client', isset($warn_client));
    $preferences->setPrefChange('warn_agency', isset($warn_agency));
    if (isset($warn_limit)) {
        if ((!is_numeric($warn_limit)) || ($warn_limit <= 0)) {
            $errormessage[4][] = $strWarnLimitErr;
        } else {
            $preferences->setPrefChange('warn_limit', $warn_limit);
        }
    }
    if (isset($warn_limit_days)) {
        if ((!is_numeric($warn_limit_days)) || ($warn_limit_days <= 0)) {
            $errormessage[4][] = $strWarnLimitDaysErr;
        } else {
            $preferences->setPrefChange('warn_limit_days', $warn_limit_days);
        }
    }
    if (isset($admin_email_headers)) {
        $admin_email_headers = trim(ereg_replace('\r?\n', '\\r\\n', $admin_email_headers));
        $preferences->setPrefChange('admin_email_headers', $admin_email_headers);
    }
    $preferences->setPrefChange('qmail_patch', isset($qmail_patch));

    if (!count($errormessage)) {
        if (!$config->writeConfigChange()) {
            // Unable to write the config file out
            $errormessage[0][] = $strUnableToWriteConfig;
        } else {
            if (!$preferences->writePrefChange()) {
                // Unable to update the preferences
                $errormessage[0][] = $strUnableToWritePrefs;
            } else {
                MAX_Admin_Redirect::redirect('settings-interface.php');
            }
        }
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_SettingsSelection("stats");

// Change ignore_hosts into a string, so the function handles it good
$conf['ignoreHosts'] = join("\n", $conf['ignoreHosts']);

$settings = array (
    array (
        'text'  => $strStatisticsLogging,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_csvImport',
                'text'    => $strCsvImport
            ),
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
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_blockAdImpressions',
                'text'    => $strBlockAdViews,
                'size'    => 12,
                //'depends' => 'logging_adImpressions==true',
                'enabled' => 'false',
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_blockAdClicks',
                'text'    => $strBlockAdClicks,
                'size'    => 12,
                //'depends' => 'logging_adClicks==true',
                'enabled' => 'false',
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_blockTrackerImpressions',
                'text'    => $strBlockAdConversions,
                'size'    => 12,
                //'depends' => 'logging_trackerImpressions==true',
                'enabled' => 'false',
                'check'   => 'number+'
            )
        )
    ),
    array (
        'text'       => $strMaintenaceSettings,
        'items'      => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'modules_AdServer',
                'text'    => $strMaintenanceAdServerInstalled,
                'depends' => 'logging_adRequests==true || logging_adImpressions==true || logging_adClicks==true'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'modules_Tracker',
                'text'    => $strMaintenanceTrackerInstalled,
                'depends' => 'logging_trackerImpressions==true'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'maintenance_operationInterval',
                'text'    => $strMaintenanceOI,
                'size'    => 12,
                'depends' => 'modules_AdServer==true || modules_Tracker==true',
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'maintenance_compactStats',
                'text'    => $strMaintenanceCompactStats,
                'depends' => 'modules_AdServer==true || modules_Tracker==true'
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
                'depends' => 'logging_adImpressions==true && logging_trackerImpressions==true && modules_AdServer==true && modules_Tracker==true',
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
                'depends' => 'logging_adClicks==true && logging_trackerImpressions==true && modules_AdServer==true && modules_Tracker==true',
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
    ),
    array (
        'text'  => $strEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_admin',
                'text'    => $strWarnAdmin
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_agency',
                'text'    => $strWarnAgency
            ),
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
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'textarea',
                'name'    => 'admin_email_headers',
                'text'    => $strAdminEmailHeaders,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'qmail_patch',
                'text'    => $strQmailPatch,
                'depends' => 'warn_client==true || warn_admin==true || warn_agency==true'
            )
        )
    )
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
