<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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

// Overwrite $conf, as a reference to $GLOBALS['_MAX']['CONF'],
// so that configuration options can be more easily set during
// the installation process
$conf =& $GLOBALS['_MAX']['CONF'];

// Required files
require_once MAX_PATH . '/lib/max/Admin/DB.php';
require_once MAX_PATH . '/lib/max/Admin/Config.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Upgrade.php';
require_once MAX_PATH . '/lib/max/language/Default.php';
require_once MAX_PATH . '/lib/max/language/Settings.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';

// Register input variables
phpAds_registerGlobal('installvars', 'phase', 'max_language', 'database_type',
                      'database_host', 'database_port', 'database_username',
                      'database_password', 'database_name', 'table_prefix',
                      'table_type', 'admin', 'admin_pw', 'admin_pw2',
                      'webpath_admin', 'webpath_delivery', 'webpath_deliverySSL',
                      'webpath_images', 'webpath_imagesSSL');

// Overwrite language if selected during install
if (!isset($installvars['language']) && isset($language)) {
    $conf['max']['language'] = $language;
}

// Load the required language files
Language_Default::load();
Language_Settings::load();


// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

/*-------------------------------------------------------*/
/* Begin of code                                         */
/*-------------------------------------------------------*/

// Check if already installed
if ($conf['max']['installed']) {
    phpAds_PageHeader('');
    phpAds_Die($strFatalError, $strAlreadyInstalled);
}

// First thing to do is clear the $session variable to
// prevent users from pretending to be logged in.
unset($session);

// Authorize the user
phpAds_Start();
// Setup navigation
$phpAds_nav = array (
    "admin" => array (
    "1"     =>  array("install.php" => $strInstall)
    )
);

// Store fatal errors
$fatal = array();

// Security check, only admin can perform this action
phpAds_checkAccess(phpAds_Admin);
if (phpAds_isUser(phpAds_Admin)) {

    //  which phase of the install/upgrade process are we?
    if (!isset($phase)) {
        $phase = 0;
    }
    $errormessage = array();
    // Process information
    switch($phase)
    {
        case 0:
            // Check PHP version < 4.3.6
            if (version_compare(phpversion(), '4.3.6', '<')) {
                $fatal[] = str_replace ('{php_version}', phpversion(), $strWarningPHPversion);
            } elseif (ini_get ('file_uploads') != true) {
                // Check file_uploads
                $fatal[] = $strWarningFileUploads;
            }
            // Check database extention
            if (!phpAds_dbAvailable()) {
                $fatal[] = $strWarningDBavailable;
            }
            // Check for PREG extention
            if (!function_exists('preg_match')) {
                $fatal[] = $strWarningPREG;
            }
            // Check if config file is writable
            if (!MAX_Admin_Config::isConfigWritable()) {
                $fatal[] = $strConfigLockedDetected;
            }
            if (count($fatal) > 0) {
                $phase = 0;
            } else {
                $phase = 1;
            }
            break;
        case 1:
            // Set language
            $installvars['language'] = $max_language;
            // Go to next phase
            $phase = 2;
            break;
        case 2:
            // Setup database check
            if (isset($database_password) && ereg('^\*+$', $database_password)) {
                $database_password = $conf['database']['password'];
            }
            $GLOBALS['_MAX']['CONF']['database']['type']      = $database_type;
            $GLOBALS['_MAX']['CONF']['database']['host']      = $database_host;
            $GLOBALS['_MAX']['CONF']['database']['port']      = $database_port;
            $GLOBALS['_MAX']['CONF']['database']['username']  = $database_username;
            $GLOBALS['_MAX']['CONF']['database']['password']  = $database_password;
            $GLOBALS['_MAX']['CONF']['database']['name']      = $database_name;
            
            $table_type = trim($table_type);
            if (empty($table_type)) {
                unset($GLOBALS['_MAX']['CONF']['table']['type']);
            }
            else {
                $GLOBALS['_MAX']['CONF']['table']['type'] = $table_type;
            }
            $oDbh = &OA_DB::singleton();
            if (PEAR::isError($oDbh)) {
                $errormessage[0][] = $strCouldNotConnectToDB;
            } else {
                // Don't use a PEAR_Error handler
                PEAR::pushErrorHandling(null);
                // Get the database version number
                $version = $oDbh->queryOne('SELECT VERSION() AS version');
                
                if ($database_type == 'pgsql') {
                    $version = substr($version, 11);
                }
                
                if (PEAR::isError($version)) {
                    $errormessage[0][] = $strNoVersionInfo;
                } else {
                    if (!preg_match('/^\d+/', $version, $matches)) {
                        $errormessage[0][] = $strInvalidVersionInfo;
                    } else {
                        if ($matches[0] < 4) {
                            $errormessage[0][] = $strInvalidMySqlVersion;
                        } else {
                            // Drop test table if one exists
                            $result = $oDbh->exec('DROP TABLE max_tmp_dbpriviligecheck');
                            // Check if Openads can create tables
                            $result = $oDbh->exec('CREATE TABLE max_tmp_dbpriviligecheck (tmp int)');
                            $data = $oDbh->manager->listTableFields('max_tmp_dbpriviligecheck');
                            // Resore the PEAR_Error handler
                            PEAR::popErrorHandling();
                            if (!PEAR::isError($data)) {
                                $result = $oDbh->exec('DROP TABLE max_tmp_dbpriviligecheck');
                            } else {
                                $errormessage[0][] = $strCreateTableTestFailed;
                            }
                            // Check table type for mysql
                            if ($database_type == 'mysql' && !Max_Admin_DB::tableTypeIsSupported($table_type)) {
                                $errormessage[0][] = $strTableWrongType;
                            }
                        }
                    }
                }
            }
            // Check table prefix
            if (strlen($table_prefix) && !eregi("^[a-z][a-z0-9_]*$", $table_prefix)) {
                $errormessage[0][] = $strTablePrefixInvalid;
            }
            if (!isset($errormessage) || !count($errormessage)) {
                $installvars['database_type']       = $database_type;
                $installvars['database_host']       = $database_host;
                $installvars['database_port']       = $database_port;
                $installvars['database_username']   = $database_username;
                $installvars['database_password']   = $database_password;
                $installvars['database_name']       = $database_name;
                $installvars['table_prefix']        = $table_prefix;
                $installvars['table_type']          = $table_type;
                $installvars['dbUpgrade']           = false;
                // Create table names for .ini file
                $installvars['tbl_acls']                                  = 'acls';
                $installvars['tbl_acls_channel']                          = 'acls_channel';
                $installvars['tbl_ad_category_assoc']                     = 'ad_category_assoc';
                $installvars['tbl_ad_zone_assoc']                         = 'ad_zone_assoc';
                $installvars['tbl_affiliates']                            = 'affiliates';
                $installvars['tbl_agency']                                = 'agency';
                $installvars['tbl_application_variable']                  = 'application_variable';
                $installvars['tbl_banners']                               = 'banners';
                $installvars['tbl_cache']                                 = 'cache';
                $installvars['tbl_campaigns']                             = 'campaigns';
                $installvars['tbl_campaigns_trackers']                    = 'campaigns_trackers';
                $installvars['tbl_category']                              = 'category';
                $installvars['tbl_channel']                               = 'channel';
                $installvars['tbl_clients']                               = 'clients';
                $installvars['tbl_data_intermediate_ad']                  = 'data_intermediate_ad';
                $installvars['tbl_data_intermediate_ad_connection']       = 'data_intermediate_ad_connection';
                $installvars['tbl_data_intermediate_ad_variable_value']   = 'data_intermediate_ad_variable_value';
                $installvars['tbl_data_raw_ad_click']                     = 'data_raw_ad_click';
                $installvars['tbl_data_raw_ad_impression']                = 'data_raw_ad_impression';
                $installvars['tbl_data_raw_ad_request']                   = 'data_raw_ad_request';
                $installvars['tbl_data_raw_tracker_click']                = 'data_raw_tracker_click';
                $installvars['tbl_data_raw_tracker_impression']           = 'data_raw_tracker_impression';
                $installvars['tbl_data_raw_tracker_variable_value']       = 'data_raw_tracker_variable_value';
                $installvars['tbl_data_summary_ad_hourly']                = 'data_summary_ad_hourly';
                $installvars['tbl_data_summary_channel_daily']            = 'data_summary_channel_daily';
                $installvars['tbl_data_summary_zone_impression_history']  = 'data_summary_zone_impression_history';
                $installvars['tbl_images']                                = 'images';
                $installvars['tbl_log_maintenance_forecasting']           = 'log_maintenance_forecasting';
                $installvars['tbl_log_maintenance_statistics']            = 'log_maintenance_statistics';
                $installvars['tbl_log_maintenance_priority']              = 'log_maintenance_priority';
                $installvars['tbl_placement_zone_assoc']                  = 'placement_zone_assoc';
                $installvars['tbl_preference']                            = 'preference';
                $installvars['tbl_session']                               = 'session';
                $installvars['tbl_targetstats']                           = 'targetstats';
                $installvars['tbl_trackers']                              = 'trackers';
                $installvars['tbl_userlog']                               = 'userlog';
                $installvars['tbl_variables']                             = 'variables';
                $installvars['tbl_zones']                                 = 'zones';
                $installvars['store_webDir']                              = MAX_PATH . '/www/images';
                // Try to guess the web directory paths
                $path = dirname($_SERVER['PHP_SELF']);
                if (preg_match('#/www/admin$#', $path)) {
                    // User has web root configured as Max's root directory
                    // so can guess at all locations
                    $subpath = preg_replace('#/www/admin$#', '', $path);
                    $GLOBALS['_MAX']['CONF']['webpath']['admin']       = $_SERVER['HTTP_HOST'] . $subpath. '/www/admin';
                    $GLOBALS['_MAX']['CONF']['webpath']['delivery']    = $_SERVER['HTTP_HOST'] . $subpath. '/www/delivery';
                    $GLOBALS['_MAX']['CONF']['webpath']['deliverySSL'] = $_SERVER['HTTP_HOST'] . $subpath. '/www/delivery';
                    $GLOBALS['_MAX']['CONF']['webpath']['images']      = $_SERVER['HTTP_HOST'] . $subpath. '/www/images';
                    $GLOBALS['_MAX']['CONF']['webpath']['imagesSSL']   = $_SERVER['HTTP_HOST'] . $subpath. '/www/images';
                } else {
                    // User has web root configured as Max's www/admin directory,
                    // so can only guess the admin location
                    $GLOBALS['_MAX']['CONF']['webpath']['admin']    = $_SERVER['HTTP_HOST'] . '/';
                }
                //  the prefix info is necessary in global scope as well
                $GLOBALS['_MAX']['CONF']['table']['prefix'] = $table_prefix;

                if (Max_Admin_DB::checkDatabaseExists($installvars)) {
                    // Is this an upgrade from >= phpAdsNew 2.0
                    // or from a version of Max?
                    $upgrade = new MAX_Admin_Upgrade($table_prefix);
                    if ($upgrade->previousVersionExists(MAX_VERSION_READABLE)) {
                        // Upgrade the database!
                        $errors = array();
                        $errors = $upgrade->upgradeDatabase();
                        if (count($errors) > 0) {
                            // There were errors upgrading
                            $errormessage[0][] = $strErrorUpgrade;
                            foreach ($errors as $error) {
                                $errormessage[0][] = $error;
                            }
                        } else {
                            $installvars['dbUpgrade'] = true;
                            // Go to next phase
                            $phase = 3;
                        }
                    } else {
                        $errormessage[0][] = $strTableInUse;
                    }
                } else {
                    // Go to next phase
                    $phase = 3;
                }
            }
            break;
        case 3:
            if (isset($installvars['dbUpgrade']) && ($installvars['dbUpgrade'] != true)) {
                // Setup username / check the passwords
                $admin = trim($admin);
                if (!strlen($admin) || !strlen($admin_pw)) {
                    $errormessage[0][] = $strInvalidUserPwd;
                }
                if (strlen($admin_pw) && $admin_pw != $admin_pw2) {
                    $errormessage[0][] = $strNotSamePasswords;
                }
            }
            if (!isset($errormessage) || !count($errormessage)) {
                if (!MAX_Admin_Config::isConfigWritable()) {
                    // Configuration file is no longer writable
                    $fatal[] = $strConfigLockedDetected;
                }
                if (count($fatal) == 0) {
                    // Set up the configuration .ini file
                    $config = new MAX_Admin_Config();
                    $config->setConfigChange('max', 'language',        $installvars['language']);
                    $config->setConfigChange('max', 'installed',       true);
                    $config->setConfigChange('max', 'requireSSL',      false);
                    $config->setConfigChange('webpath', 'admin',       preg_replace('#/$#', '', $webpath_admin));
                    $config->setConfigChange('webpath', 'delivery',    preg_replace('#/$#', '', $webpath_delivery));
                    $config->setConfigChange('webpath', 'deliverySSL', preg_replace('#/$#', '', $webpath_deliverySSL));
                    $config->setConfigChange('webpath', 'images',      preg_replace('#/$#', '', $webpath_images));
                    $config->setConfigChange('webpath', 'imagesSSL',   preg_replace('#/$#', '', $webpath_imagesSSL));
                    $config->setConfigChange('store', 'mode',          0);
                    $config->setConfigChange('store', 'webDir',        $installvars['store_webDir']);
                    $config->setConfigChange('database', 'type',       $installvars['database_type']);
                    $config->setConfigChange('database', 'host',       $installvars['database_host']);
                    $config->setConfigChange('database', 'port',       $installvars['database_port']);
                    $config->setConfigChange('database', 'username',   $installvars['database_username']);
                    $config->setConfigChange('database', 'password',   $installvars['database_password']);
                    $config->setConfigChange('database', 'name',       $installvars['database_name']);
                    $config->setConfigChange('table', 'prefix',        $installvars['table_prefix']);
                    $config->setConfigChange('table', 'split',         false);
                    $config->setConfigChange('table', 'type',          $installvars['table_type']);
                    $config->setConfigChange('table', 'acls',                                   $installvars['tbl_acls']);
                    $config->setConfigChange('table', 'acls_channel',                           $installvars['tbl_acls_channel']);
                    $config->setConfigChange('table', 'ad_zone_assoc',                          $installvars['tbl_ad_zone_assoc']);
                    $config->setConfigChange('table', 'ad_category_assoc',                      $installvars['tbl_ad_category_assoc']);
                    $config->setConfigChange('table', 'agency',                                 $installvars['tbl_agency']);
                    $config->setConfigChange('table', 'application_variable',                   $installvars['tbl_application_variable']);
                    $config->setConfigChange('table', 'affiliates',                             $installvars['tbl_affiliates']);
                    $config->setConfigChange('table', 'banners',                                $installvars['tbl_banners']);
                    $config->setConfigChange('table', 'cache',                                  $installvars['tbl_cache']);
                    $config->setConfigChange('table', 'campaigns',                              $installvars['tbl_campaigns']);
                    $config->setConfigChange('table', 'campaigns_trackers',                     $installvars['tbl_campaigns_trackers']);
                    $config->setConfigChange('table', 'category',                               $installvars['tbl_category']);
                    $config->setConfigChange('table', 'channel',                                $installvars['tbl_channel']);
                    $config->setConfigChange('table', 'clients',                                $installvars['tbl_clients']);
                    $config->setConfigChange('table', 'data_intermediate_ad',                   $installvars['tbl_data_intermediate_ad']);
                    $config->setConfigChange('table', 'data_intermediate_ad_connection',        $installvars['tbl_data_intermediate_ad_connection']);
                    $config->setConfigChange('table', 'data_intermediate_ad_variable_value',    $installvars['tbl_data_intermediate_ad_variable_value']);
                    $config->setConfigChange('table', 'data_raw_ad_click',                      $installvars['tbl_data_raw_ad_click']);
                    $config->setConfigChange('table', 'data_raw_ad_impression',                 $installvars['tbl_data_raw_ad_impression']);
                    $config->setConfigChange('table', 'data_raw_ad_request',                    $installvars['tbl_data_raw_ad_request']);
                    $config->setConfigChange('table', 'data_raw_tracker_click',                 $installvars['tbl_data_raw_tracker_click']);
                    $config->setConfigChange('table', 'data_raw_tracker_impression',            $installvars['tbl_data_raw_tracker_impression']);
                    $config->setConfigChange('table', 'data_raw_tracker_variable_value',        $installvars['tbl_data_raw_tracker_variable_value']);
                    $config->setConfigChange('table', 'data_summary_ad_hourly',                 $installvars['tbl_data_summary_ad_hourly']);
                    $config->setConfigChange('table', 'data_summary_channel_daily',             $installvars['tbl_data_summary_channel_daily']);
                    $config->setConfigChange('table', 'data_summary_zone_impression_history',   $installvars['tbl_data_summary_zone_impression_history']);
                    $config->setConfigChange('table', 'images',                                 $installvars['tbl_images']);
                    $config->setConfigChange('table', 'log_maintenance_forecasting',            $installvars['tbl_log_maintenance_forecasting']);
                    $config->setConfigChange('table', 'log_maintenance_statistics',             $installvars['tbl_log_maintenance_statistics']);
                    $config->setConfigChange('table', 'log_maintenance_priority',               $installvars['tbl_log_maintenance_priority']);
                    $config->setConfigChange('table', 'placement_zone_assoc',                   $installvars['tbl_placement_zone_assoc']);
                    $config->setConfigChange('table', 'preference',                             $installvars['tbl_preference']);
                    $config->setConfigChange('table', 'session',                                $installvars['tbl_session']);
                    $config->setConfigChange('table', 'targetstats',                            $installvars['tbl_targetstats']);
                    $config->setConfigChange('table', 'trackers',                               $installvars['tbl_trackers']);
                    $config->setConfigChange('table', 'userlog',                                $installvars['tbl_userlog']);
                    $config->setConfigChange('table', 'variables',                              $installvars['tbl_variables']) ;
                    $config->setConfigChange('table', 'zones',                                  $installvars['tbl_zones']);
                    if (!$config->writeConfigChange()) {
                        // Unable to write the config file out
                        $fatal[] = $strErrorInstallConfig;
                    }
                }
                if (count($fatal) == 0) {
                    // Create the database
                    if ($oDbh = &OA_DB::singleton()) {
                        // Is this an installation, or an upgrade?
                        if ((!isset($installvars['dbUpgrade'])) || (!$installvars['dbUpgrade'])) {
                            $tables = &OA_DB_Table_Core::singleton();
                            if (!$tables->createAllTables() || !OA_DB::createFunctions()) {
                                $fatal[] = $strErrorInstallDatabase;
                            }
                        }
                    } else {
                        $fatal[] = $strErrorInstallDbConnect;
                    }
                }
                if (count($fatal) == 0) {
                    // Insert basic preferences into database
                    $preferences = new MAX_Admin_Preferences();

                    // Load preferences, needed below to check instance_id existance
                    $preferences->loadPrefs();

                    $preferences->setPrefChange('config_version', MAX_VERSION);
                    if ((!isset($installvars['dbUpgrade'])) || (!$installvars['dbUpgrade'])) {
                        $preferences->setPrefChange('admin',        $admin);
                        $preferences->setPrefChange('admin_pw',     md5($admin_pw));
                    }

                    // Generate a new instance ID if empty
                    if (empty($GLOBALS['_MAX']['PREF']['instance_id'])) {
                        $preferences->setPrefChange('instance_id',  sha1(uniqid('', true)));
                    }

                    if (!$preferences->writePrefChange()) {
                        $fatal[] = $strErrorInstallPrefs;
                    }
                }
                if (count($fatal) == 0) {
                    // Upgrade the Openads version in the database
                    if ((!isset($installvars['dbUpgrade'])) || (!$installvars['dbUpgrade'])) {
                        $upgrade = new MAX_Admin_Upgrade($installvars['table_prefix']);
                        if (!$upgrade->setInstalledVersion()) {
                            $fatal[] = $strErrorInstallVersion;
                        }
                    }
                }
                $phase = 4;
            }
            break;
        default:
            break;
    }
    // Prepare helpsystem
    if ($phase > 0) {
        phpAds_PrepareHelp();
    }
    // Create GUI
    phpAds_PageHeader("1");
    // Prepare helpbutton
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr><td height='20' align='right'>";
    if ($phase > 0) echo "<b><a href='javascript:toggleHelp();'><img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>&nbsp;".$strHelp."</a></b>";
    echo "</td></tr></table>";
    phpAds_ShowBreak();
    switch($phase)
    {
        case 0:
            // Preconditions failed
            echo "<form name='settingsform' method='post' action='install.php'>";
            echo "<br /><br /><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
            echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
            echo "<br /><span class='tab-s'>".$strInstallWelcome." ".MAX_VERSION_READABLE."</span><br />";
            echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
            echo "<span class='install'>".$strInstallMessage;
            if (count($fatal)) {
                echo "<br /><br /><div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
                echo "<span class='tab-r'>".$strMayNotFunction."</span><br /><br />".$strFixProblemsBefore."<ul>";
                for ($r = 0; $r < count($fatal); $r++) {
                    echo "<li>".$fatal[$r]."</li>";
                }
                echo "</ul>".$strFixProblemsAfter."<br /><br /></div>";
            }
            echo "</td></tr></table>";
            break;
        case 1:
            // Language selection
            echo "<form name='settingsform' method='post' action='install.php' onSubmit='return max_formValidate(this);'>";
            echo "<br /><br /><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
            echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
            echo "<br /><span class='tab-s'>".$strInstallWelcome." ".MAX_VERSION_READABLE."</span><br />";
            echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
            echo "<span class='install'>".$strInstallMessage."</td></tr></table><br /><br />";
            phpAds_ShowBreak();
            phpAds_ShowSettings(array (
                array (
                    'text'  => $strChooseInstallLanguage,
                    'items' => array (
                        array (
                            'type'  => 'select',
                            'name'  => 'max_language',
                            'text'  => $strLanguage,
                            'items' => MAX_Admin_Languages::AvailableLanguages()
                        )
                    )
                )
            ), $errormessage);
            break;
        case 2:
            // Database settings
            echo "<form name='settingsform' method='post' action='install.php' onSubmit='return max_formValidate(this);'>";
            echo "<br /><br /><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
            echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
            echo "<br /><span class='tab-s'>".$strInstallWelcome." ".MAX_VERSION_READABLE."</span><br />";
            echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
            echo "<span class='install'>".$strInstallMessage."</td></tr></table><br /><br />";
            phpAds_ShowBreak();
            phpAds_ShowSettings(array (
                array (
                    'text'  => $strDatabaseSettings,
                    'items' => array (
                        array (
                            'type'  => 'select',
                            'name'  => 'database_type',
                            'text'  => $strDbType,
                            'items' => Max_Admin_DB::getServerTypes()
                        ),
                        array (
                            'type'  => 'break'
                        ),
                        array (
                            'type'  => 'text',
                            'name'  => 'database_host',
                            'text'  => $strDbHost,
                            'req'   => true
                        ),
                        array (
                            'type'  => 'break'
                        ),
                        array (
                            'type'  => 'text',
                            'name'  => 'database_port',
                            'text'  => $strDbPort,
                            'req'   => true
                        ),
                        array (
                            'type'  => 'break'
                        ),
                        array (
                            'type'  => 'text',
                            'name'  => 'database_username',
                            'text'  => $strDbUser,
                            'req'   => true
                        ),
                        array (
                            'type'  => 'break'
                        ),
                        array (
                            'type'  => 'password',
                            'name'  => 'database_password',
                            'text'  => $strDbPassword,
                            'req'   => false
                        ),
                        array (
                            'type'  => 'break'
                        ),
                        array (
                            'type'  => 'text',
                            'name'  => 'database_name',
                            'text'  => $strDbName,
                            'req'   => true
                        )
                    )
                ),
                array (
                    'text'  => $strAdvancedSettings,
                    'items' => array (
                        array (
                            'type'  => 'text',
                            'name'  => 'table_prefix',
                            'text'  => $strTablesPrefix,
                            'req'   => false
                        ),
                        array (
                            'type'  => 'break'
                        ),
                        array (
                            'type'  => 'select',
                            'name'  => 'table_type',
                            'text'  => $strTablesType,
                            'items' => Max_Admin_DB::getTableTypes()
                        )
                    )
                )
            ), $errormessage);
            break;
        case 3:
            // Admin settings
            echo "<form name='settingsform' method='post' action='install.php' onSubmit='return max_formValidate(this);'>";
            echo "<br /><br /><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
            echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
            echo "<br /><span class='tab-s'>".$strInstallWelcome." ".MAX_VERSION_READABLE."</span><br />";
            echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
            echo "<span class='install'>".$strInstallMessage."</td></tr></table><br /><br />";
            phpAds_ShowBreak();
            if (isset($installvars['dbUpgrade']) && ($installvars['dbUpgrade'])) {
                phpAds_ShowSettings(array (
                    array (
                        'text'  => $strOtherSettings,
                        'items' => array (
                            array (
                                'type'  => 'url',
                                'name'  => 'webpath_admin',
                                'text'  => $strAdminUrlPrefix,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urln',
                                'name'  => 'webpath_delivery',
                                'text'  => $strDeliveryUrlPrefix,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urls',
                                'name'  => 'webpath_deliverySSL',
                                'text'  => $strDeliveryUrlPrefixSSL,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urln',
                                'name'  => 'webpath_images',
                                'text'  => $strImagesUrlPrefix,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urls',
                                'name'  => 'webpath_imagesSSL',
                                'text'  => $strImagesUrlPrefixSSL,
                                'size'  => 35,
                                'req'   => true
                            )
                        )
                    )
                ), $errormessage);
            } else {
                phpAds_ShowSettings(array (
                    array (
                        'text'  => $strAdminSettings,
                        'items' => array (
                            array (
                                'type'  => 'text',
                                'name'  => 'admin',
                                'text'  => $strUsername,
                                'size'  => 25,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'password',
                                'name'  => 'admin_pw',
                                'text'  => $strNewPassword,
                                'size'  => 25,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'password',
                                'name'  => 'admin_pw2',
                                'text'  => $strRepeatPassword,
                                'size'  => 25,
                                'check' => 'compare:admin_pw',
                                'req'   => true
                            )
                        )
                    ),
                    array (
                        'text'  => $strOtherSettings,
                        'items' => array (
                            array (
                                'type'  => 'url',
                                'name'  => 'webpath_admin',
                                'text'  => $strAdminUrlPrefix,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urln',
                                'name'  => 'webpath_delivery',
                                'text'  => $strDeliveryUrlPrefix,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urls',
                                'name'  => 'webpath_deliverySSL',
                                'text'  => $strDeliveryUrlPrefixSSL,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urln',
                                'name'  => 'webpath_images',
                                'text'  => $strImagesUrlPrefix,
                                'size'  => 35,
                                'req'   => true
                            ),
                            array (
                                'type'  => 'break'
                            ),
                            array (
                                'type'  => 'urls',
                                'name'  => 'webpath_imagesSSL',
                                'text'  => $strImagesUrlPrefixSSL,
                                'size'  => 35,
                                'req'   => true
                            )
                        )
                    )
                ), $errormessage);
            }
            break;
        case 4:
            // Admin settings
            if (count($fatal) == 0) {
                echo "<form name='settingsform' method='post' action='settings-index.php'>";
                echo "<br /><br /><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
                echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
                echo "<br /><span class='tab-s'>".$strInstallWelcome." ".MAX_VERSION_READABLE."</span><br />";
                echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
                echo "<span class='install'>".$strInstallSuccess."</td></tr></table><br /><br />";
            } else {
                echo "<form name='settingsform' method='post' action='settings-index.php'>";
                echo "<br /><br /><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
                echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
                echo "<br /><span class='tab-s'>".$strInstallWelcome." ".MAX_VERSION_READABLE."</span><br />";
                echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
                echo "<span class='install'>".$strInstallNotSuccessful."</td></tr></table><br /><br />";
                echo "<br /><br />";
                echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                echo "<tr><td><img src='images/error.gif'>&nbsp;&nbsp;</td>";
                echo "<td width='100%'><span class='tab-r'>".$strErrorOccured."</span></td></tr>";
                for ($r = 0; $r < count($fatal); $r++) {
                    echo "<tr><td>&nbsp;</td><td><span class='install'>".$fatal[$r]."</span></td></tr>";
                }
                echo "</table>";
            }
            break;
        default:
            break;
    }
    echo "<br /><br />";
    phpAds_ShowBreak();
    echo "<br />";
    echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
    echo "<input type='submit' name='proceed' value='".$strProceed."'>";
    echo "</td></tr></table>\n\n";
    if (isset($installvars) && count($installvars)) {
        foreach (array_keys($installvars) as $key) {
            echo "<input type='hidden' name='installvars[".$key."]' value='".$installvars[$key]."'>\n";
        }
    }
    echo "<input type='hidden' name='phase' value='".$phase."'>\n";
    echo "</form>";
}
echo "<br /><br />";

phpAds_PageFooter();

?>
