<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id:settings.lang.php 20042 2008-05-09 01:10:00Z aj.tarachanowicz@openx.org $
*/

// Installer translation strings
$GLOBALS['strInstall']                      = "Install";
$GLOBALS['strChooseInstallLanguage']        = "Choose language for the installation procedure";
$GLOBALS['strLanguageSelection']            = "Language Selection";
$GLOBALS['strDatabaseSettings']             = "Database Settings";
$GLOBALS['strAdminSettings']                = "Administrator Settings";
$GLOBALS['strAdminAccount']                 = "Administrator Account";
$GLOBALS['strAdministrativeSettings']       = "Administrative Settings";
$GLOBALS['strAdvancedSettings']             = "Advanced Settings";
$GLOBALS['strOtherSettings']                = "Other settings";
$GLOBALS['strSpecifySyncSettings']          = "Synchronisation settings";
$GLOBALS['strLicenseInformation']           = "License information";
$GLOBALS['strOpenadsIdYour']                = "Your OpenX ID";
$GLOBALS['strOpenadsIdSettings']            = "OpenX ID Settings";
$GLOBALS['strWarning']                      = "Warning";
$GLOBALS['strFatalError']                   = "A fatal error occurred";
$GLOBALS['strUpdateError']                  = "An error occured while updating";
$GLOBALS['strBtnContinue']                  = "Continue »";
$GLOBALS['strBtnRecover']                   = "Recover »";
$GLOBALS['strBtnStartAgain']                   = "Start Upgrade Again »";
$GLOBALS['strBtnGoBack']                    = "« Go Back";
$GLOBALS['strBtnAgree']                     = "I Agree »";
$GLOBALS['strBtnDontAgree']                 = "« I Disagree";
$GLOBALS['strBtnRetry']                     = "Retry";
$GLOBALS['strUpdateDatabaseError']          = "Due to unknown reasons the update of the database structure wasn't succesful. The recommended way to proceed is to click <b>Retry updating</b> to try to correct these potential problems. If you are sure these errors won't affect the functionality of ".MAX_PRODUCT_NAME." you can click <b>Ignore errors</b> to continue. Ignoring these errors may cause serious problems and is not recommended!";
$GLOBALS['strAlreadyInstalled']             = "" . MAX_PRODUCT_NAME." is already installed on this system. If you want to configure it go to the <a href='account-index.php'>settings interface</a>";
$GLOBALS['strCouldNotConnectToDB']          = "Could not connect to database, please recheck the settings you specified";
$GLOBALS['strCreateTableTestFailed']        = "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']        = "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']           = "Table prefix contains invalid characters";
$GLOBALS['strTableInUse']                   = "The database which you specified is already used for ".MAX_PRODUCT_NAME.", please use a different table prefix, or read the UPGRADE.txt file for upgrading instructions.";
$GLOBALS['strNoVersionInfo']                = "Unable to select the database version";
$GLOBALS['strInvalidVersionInfo']           = "Unable to determine the database version";
$GLOBALS['strInvalidMySqlVersion']          = "" . MAX_PRODUCT_NAME." requires MySQL 4.0 or higher to function correctly. Please select a different database server.";
$GLOBALS['strTableWrongType']               = "The table type you selected isn't supported by your installation of ".phpAds_dbmsname;
$GLOBALS['strMayNotFunction']               = "Before you continue, please correct these potential problems:";
$GLOBALS['strFixProblemsBefore']            = "The following item(s) need to be corrected before you can install ".MAX_PRODUCT_NAME.". If you have any questions about this error message, please read the <i>Administrator Guide</i>, which is part of the package you downloaded.";
$GLOBALS['strFixProblemsAfter']             = "If you are not able to correct the problems listed above, please contact the administrator of the server you are trying to install ".MAX_PRODUCT_NAME." on. The administrator of the server may be able to help you.";
$GLOBALS['strIgnoreWarnings']               = "Ignore warnings";
$GLOBALS['strWarningDBavailable']           = "The version of PHP you are using doesn't have support for connecting to a ".phpAds_dbmsname." database server. You need to enable the PHP ".phpAds_dbmsname." extension before you can proceed.";
$GLOBALS['strWarningPHPversion']            = "" . MAX_PRODUCT_NAME." requires PHP 5.1.4 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']       = "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningRegisterArgcArv']       = "The PHP configuration variable register_argc_argv needs to be turned on to run maintenance from the command line.";
$GLOBALS['strWarningMagicQuotesGPC']        = "The PHP configuration variable magic_quotes_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']    = "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strWarningFileUploads']           = "The PHP configuration variable file_uploads needs to be turned on.";
$GLOBALS['strWarningTrackVars']             = "The PHP configuration variable track_vars needs to be turned on.";
$GLOBALS['strWarningPREG']                  = "The version of PHP you are using doesn't have support for PERL compatible regular expressions. You need to enable the PREG extension before you can proceed.";
$GLOBALS['strConfigLockedDetected']         = "" . MAX_PRODUCT_NAME." has detected that the <b>max.conf.php</b> file cannot be written by the web server. You can't proceed until you make the 'var' directory writable by the web server. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']                 = "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strIgnoreErrors']                 = "Ignore errors";
$GLOBALS['strRetryUpdate']                  = "Retry updating";
$GLOBALS['strTableNames']                   = "Table Names";
$GLOBALS['strTablesPrefix']                 = "Table names prefix";
$GLOBALS['strTablesType']                   = "Table type";


$GLOBALS['strRecoveryRequiredTitle']    = "Your previous upgrade attempt encountered an error";
$GLOBALS['strRecoveryRequired']         = "There was an error while processing your previous upgrade and " . MAX_PRODUCT_NAME . " must attempt to recover the upgrade process. Please click the Recover button below.";

$GLOBALS['strProductUpToDateTitle']     =  MAX_PRODUCT_NAME . " is up to date";
$GLOBALS['strOaUpToDate']               = "Your " . MAX_PRODUCT_NAME . " database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the OpenX administration panel.";
$GLOBALS['strOaUpToDateCantRemove']     = "The UPGRADE file is still present inside of your 'var' folder. We are unable to remove this file because of insufficient permissions. Please delete this file yourself.";
$GLOBALS['strRemoveUpgradeFile']               = "You must remove the UPGRADE file from the 'var' folder.";
$GLOBALS['strInstallSuccess']               = "Clicking 'Continue' will log you in to your ad server.
<p><strong>What next?</strong></p>
<div class='psub'>";
$GLOBALS['strInstallSuccess2'] ="
  <p><b>Serving your first ad campaign</b><br>
    Use our <a href='".OX_PRODUCT_DOCSURL."/wizard/qsg-firstcampaign' target='_blank'>quick start guide to start serving your first ad campaign</a>.
  </p>
</div>
<p><strong>Optional installation steps</strong></p>
<div class='psub'>
  <p><b>Lock your configuration files</b><br>
    This is a good extra security step to protect your ad server configuration settings from being altered.  <a href='".OX_PRODUCT_DOCSURL."/wizard/lock-config' target='_blank'>Find out more</a>.
  </p>
  <p><b>Set up a regular maintenance task</b><br>
    A maintenance script is recommended to ensure timely reporting and the best possible ad delivery performance.  <a href='".OX_PRODUCT_DOCSURL."/wizard/setup-cron' target='_blank'>Find out more</a>
  </p>
  <p><b>Review your system configuration settings</b><br>
    Before you start using ".MAX_PRODUCT_NAME." we suggest you review your settings within the 'Settings' tab.
  </p>
</div>";
$GLOBALS['strInstallNotSuccessful']         = "<b>The installation of ".MAX_PRODUCT_NAME." was not succesful</b><br /><br />Some portions of the install process could not be completed.
                                                It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
                                                first step of the install process. If you want to know more on what the error message below means, and how to solve it,
                                                please consult the supplied documentation.";
$GLOBALS['strDbSuccessIntro']               = "The " . MAX_PRODUCT_NAME . " database has now been created. Please click the 'Continue' button to proceed with configuring " . MAX_PRODUCT_NAME . " Administrator and Delivery settings.";
$GLOBALS['strDbSuccessIntroUpgrade']        = "Your system has been successfully upgraded.  The remaining screens will help you update the configuration of your new ad server.";
$GLOBALS['strErrorOccured']                 = "The following error occured:";
$GLOBALS['strErrorInstallDatabase']         = "The database structure could not be created.";
$GLOBALS['strErrorInstallPrefs']            = "The administrator user preferences could not be written to the database.";
$GLOBALS['strErrorInstallVersion']          = "The " . MAX_PRODUCT_NAME . " version number could not be written to the database.";
$GLOBALS['strErrorUpgrade']                 = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallDbConnect']        = "It was not possible to open a connection to the database.";

$GLOBALS['strErrorWritePermissions']        = "File permission errors have been detected, and must be fixed before you can continue.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsCommand']   = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin']     = "File permission errors have been detected, and must be fixed before you can continue.";
$GLOBALS['strCheckDocumentation']           = "For more help, please see the <a href=\"".OX_PRODUCT_DOCSURL."\">" . MAX_PRODUCT_NAME . " documentation</a>.";

$GLOBALS['strAdminUrlPrefix']               = "Admin Interface URL";
$GLOBALS['strDeliveryUrlPrefix']            = "Delivery Engine URL";
$GLOBALS['strDeliveryUrlPrefixSSL']         = "Delivery Engine URL (SSL)";
$GLOBALS['strImagesUrlPrefix']              = "Image Store URL";
$GLOBALS['strImagesUrlPrefixSSL']           = "Image Store URL (SSL)";

$GLOBALS['strInvalidUserPwd']               = "Invalid username or password";

$GLOBALS['strUpgrade']                      = "Upgrade";
$GLOBALS['strSystemUpToDate']               = "Your system is already up to date, no upgrade is needed at the moment. <br />Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']           = "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br /><br />Depending on which version you are upgrading from and how many statistics are already stored in the database, this process can cause high load on your database server. Please be patient, the upgrade can take up to a couple of minutes.";
$GLOBALS['strSystemUpgradeBusy']            = "System upgrade in progress, please wait...";
$GLOBALS['strSystemRebuildingCache']        = "Rebuilding cache, please wait...";
$GLOBALS['strServiceUnavalable']            = "The service is temporarily unavailable. System upgrade in progress";

/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']                         = "Choose Section";
$GLOBALS['strEditConfigNotPossible']                 = "It is not possible to edit all settings because the configuration file is locked for security reasons. ".
                                                       "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible']                    = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. ".
                                                       "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig']                   = "Unable to write changes to the config file";
$GLOBALS['strUnableToWritePrefs']                    = "Unable to commit preferences to the database";
$GLOBALS['strImageDirLockedDetected']	             = "The supplied <b>Images Folder</b> is not writeable by the server. <br>You can't proceed until you either change permissions of the folder or create the folder.";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = "Configuration checklist";
$GLOBALS['strConfigurationSettings']                 = "Configuration settings";

// Administrator Settings
$GLOBALS['strAdministratorSettings']                 = "Administrator Settings";
$GLOBALS['strAdministratorAccount']                  = "The Administrator Account";
$GLOBALS['strLoginCredentials']                      = "Login Credentials";
$GLOBALS['strAdminUsername']                         = "Administrator  Username";
$GLOBALS['strAdminPassword']                         = "Administrator  Password";
$GLOBALS['strInvalidUsername']                       = "Invalid Username";
$GLOBALS['strBasicInformation']                      = "Basic Information";
$GLOBALS['strAdminFullName']                         = "Admin's Full Name";
$GLOBALS['strAdminEmail']                            = "Admin's email Address";
$GLOBALS['strAdministratorEmail']                    = "Administrator email Address";
$GLOBALS['strCompanyName']                           = "Company Name";
$GLOBALS['strAdminCheckUpdates']                     = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack']                       = "Share technical information with the OpenX Team to help with development and testing.";
$GLOBALS['strAdminShareData']                        = "Share ad volume information anonymously to participate in the community data sharing program.";
$GLOBALS['strAdminCheckEveryLogin']                  = "Every Login";
$GLOBALS['strAdminCheckDaily']                       = "Daily";
$GLOBALS['strAdminCheckWeekly']                      = "Weekly";
$GLOBALS['strAdminCheckMonthly']                     = "Monthly";
$GLOBALS['strAdminCheckNever']                       = "Never";
$GLOBALS['strNovice']                                = "Delete actions require confirmation for safety";
$GLOBALS['strUserlogEmail']                          = "Log all outgoing email messages";
$GLOBALS['strEnableDashboard']                       = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice']             = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone']                              = "Timezone";
$GLOBALS['strTimezoneEstimated']                     = "Estimated Timezone";
$GLOBALS['strTimezoneGuessedValue']                  = "Server timezone not correctly set in PHP";
$GLOBALS['strTimezoneSeeDocs']                       = "Please see the %DOCS% about setting this variable for PHP.";
$GLOBALS['strTimezoneDocumentation']                 = "documentation";
$GLOBALS['strAdminSettingsTitle']                    = "Create an administrator account";
$GLOBALS['strAdminSettingsIntro']                    = "Please complete this form to create your ad server administration account.";
$GLOBALS['strConfigSettingsIntro']                   = "Please check the configuration settings below and make any required changes before proceeding. If unsure, leave the default values.";

$GLOBALS['strEnableAutoMaintenance']	             = "Automatically perform maintenance during delivery if scheduled maintenance is not set up";

// OpenX ID Settings
$GLOBALS['strOpenadsUsername']                       = "" . MAX_PRODUCT_NAME . " Username";
$GLOBALS['strOpenadsPassword']                       = "" . MAX_PRODUCT_NAME . " Password";
$GLOBALS['strOpenadsEmail']                          = "" . MAX_PRODUCT_NAME . " email";

// Database Settings
$GLOBALS['strDatabaseSettings']                      = "Database Settings";
$GLOBALS['strDatabaseServer']                        = "Database Server Settings";
$GLOBALS['strDbLocal']                               = "Use local socket connection";
$GLOBALS['strDbType']                                = "Database Type";
$GLOBALS['strDbHost']                                = "Database Hostname";
$GLOBALS['strDbSocket']                              = "Database Socket";
$GLOBALS['strDbPort']                                = "Database Port Number";
$GLOBALS['strDbUser']                                = "Database Username";
$GLOBALS['strDbPassword']                            = "Database Password";
$GLOBALS['strDbName']                                = "Database Name";
$GLOBALS['strDbNameHint']                            = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations']               = "Database Optimisation Settings";
$GLOBALS['strPersistentConnections']                 = "Use Persistent Connections";
$GLOBALS['strCantConnectToDb']                       = "Can't Connect to Database";
$GLOBALS['strCantConnectToDbDelivery']               = 'Can\'t Connect to Database for Delivery';
$GLOBALS['strDemoDataInstall']                       = "Install Demo Data";
$GLOBALS['strDemoDataIntro']                         = "Default setup data can be loaded into ". MAX_PRODUCT_NAME ." to help you get started serving online advertising. The most common banner types, as well as some initial campaigns can be loaded and pre-configured. This is highly recommended for new installations.";



// Email Settings
$GLOBALS['strEmailSettings']                         = "Email Settings";
$GLOBALS['strEmailAddresses']                        = "Email 'From' Address";
$GLOBALS['strEmailFromName']                         = "Email 'From' Name";
$GLOBALS['strEmailFromAddress']                      = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany']                      = "Email 'From' Company";
$GLOBALS['strUseManagerDetails']                     = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch']                            = "qmail patch";
$GLOBALS['strEnableQmailPatch']                      = "Enable qmail patch";
$GLOBALS['strEmailHeader']                           = "Email headers";
$GLOBALS['strEmailLog']                              = "Email log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings']                    = "Audit Trail Settings";
$GLOBALS['strEnableAudit']                           = "Enable Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking']             = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug']                                 = "Debug Logging Settings";
$GLOBALS['strProduction']                            = "Production server";
$GLOBALS['strEnableDebug']                           = "Enable Debug Logging";
$GLOBALS['strDebugMethodNames']                      = "Include method names in debug log";
$GLOBALS['strDebugLineNumbers']                      = "Include line numbers in debug log";
$GLOBALS['strDebugType']                             = "Debug Log Type";
$GLOBALS['strDebugTypeFile']                         = "File";
$GLOBALS['strDebugTypeMcal']                         = "mCal";
$GLOBALS['strDebugTypeSql']                          = "SQL Database";
$GLOBALS['strDebugTypeSyslog']                       = "Syslog";
$GLOBALS['strDebugName']                             = "Debug Log Name, Calendar, SQL Table,<br />or Syslog Facility";
$GLOBALS['strDebugPriority']                         = "Debug Priority Level";
$GLOBALS['strPEAR_LOG_DEBUG']                        = "PEAR_LOG_DEBUG - Most Information";
$GLOBALS['strPEAR_LOG_INFO']                         = "PEAR_LOG_INFO - Default Information";
$GLOBALS['strPEAR_LOG_NOTICE']                       = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING']                      = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR']                          = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT']                         = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT']                        = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG']                        = "PEAR_LOG_EMERG - Least Information";
$GLOBALS['strDebugIdent']                            = "Debug Identification String";
$GLOBALS['strDebugUsername']                         = "mCal, SQL Server Username";
$GLOBALS['strDebugPassword']                         = "mCal, SQL Server Password";
$GLOBALS['strProductionSystem']                      = "Production System";

// Delivery Settings
$GLOBALS['strDeliverySettings']                      = "Delivery Settings";
$GLOBALS['strWebPath']                               =  MAX_PRODUCT_NAME ." Server Access Paths";
$GLOBALS['strWebPathSimple']                         = "Web path";
$GLOBALS['strDeliveryPath']                          = "Delivery path";
$GLOBALS['strImagePath']                             = "Images path";
$GLOBALS['strDeliverySslPath']                       = "Delivery SSL path";
$GLOBALS['strImageSslPath']                          = "Images SSL path";
$GLOBALS['strImageStore']                            = "Images folder";
$GLOBALS['strTypeWebSettings']                       = "Webserver Local Banner Storage Settings";
$GLOBALS['strTypeWebMode']                           = "Storing Method";
$GLOBALS['strTypeWebModeLocal']                      = "Local Directory";
$GLOBALS['strTypeDirError']                          = "The local directory cannot be written to by the web server";
$GLOBALS['strTypeWebModeFtp']                        = "External FTP Server";
$GLOBALS['strTypeWebDir']                            = "Local Directory";
$GLOBALS['strTypeFTPHost']                           = "FTP Host";
$GLOBALS['strTypeFTPDirectory']                      = "Host Directory";
$GLOBALS['strTypeFTPUsername']                       = "Login";
$GLOBALS['strTypeFTPPassword']                       = "Password";
$GLOBALS['strTypeFTPPassive']                        = "Use passive FTP";
$GLOBALS['strTypeFTPErrorDir']                       = "The FTP Host Directory does not exist";
$GLOBALS['strTypeFTPErrorConnect']                   = "Could not connect to the FTP Server, the Login or Password is not correct";
$GLOBALS['strTypeFTPErrorNoSupport']                 = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload']                    = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost']                      = "The FTP Host is not correct";
$GLOBALS['strDeliveryFilenames']                     = "Delivery File Names";
$GLOBALS['strDeliveryFilenamesAdClick']              = "Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = "Ad Conversion Variables";
$GLOBALS['strDeliveryFilenamesAdContent']            = "Ad Content";
$GLOBALS['strDeliveryFilenamesAdConversion']         = "Ad Conversion";
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = "Ad Conversion (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame']              = "Ad Frame";
$GLOBALS['strDeliveryFilenamesAdImage']              = "Ad Image";
$GLOBALS['strDeliveryFilenamesAdJS']                 = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer']              = "Ad Layer";
$GLOBALS['strDeliveryFilenamesAdLog']                = "Ad Log";
$GLOBALS['strDeliveryFilenamesAdPopup']              = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView']               = "Ad View";
$GLOBALS['strDeliveryFilenamesXMLRPC']               = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal']                = "Local Invocation";
$GLOBALS['strDeliveryFilenamesFrontController']      = "Front Controller";
$GLOBALS['strDeliveryFilenamesFlash']                = "Flash Include (Can be a full URL)";
$GLOBALS['strDeliveryCaching']                       = "Banner Delivery Cache Settings";
$GLOBALS['strDeliveryCacheLimit']                    = "Time Between Banner Cache Updates (seconds)";
$GLOBALS['strDeliveryCacheStore']                    = "Banner Delivery Cache Store Type";

$GLOBALS['strErrorInCacheStorePlugin']               = "Some errors were reported by the '%s' delivery store plugin:";
$GLOBALS['strDeliveryCacheStorage']                  = "Delivery cache storage type";

$GLOBALS['strOrigin']                                = "Use remote origin server";
$GLOBALS['strOriginType']                            = "Origin server type";
$GLOBALS['strOriginHost']                            = "Hostname for origin server";
$GLOBALS['strOriginPort']                            = "Port number for origin database";
$GLOBALS['strOriginScript']                          = "Script file for origin database";
$GLOBALS['strOriginTypeXMLRPC']                      = "XMLRPC";
$GLOBALS['strOriginTimeout']                         = "Origin timeout (seconds)";
$GLOBALS['strOriginProtocol']                        = "Origin server protocol";

$GLOBALS['strDeliveryAcls']                          = "Evaluate banner delivery limitations during delivery";
$GLOBALS['strDeliveryAclsDirectSelection']           = "Evaluate banner delivery limitations for direct selected ads";
$GLOBALS['strDeliveryObfuscate']                     = "Obfuscate channel when delivering ads";
$GLOBALS['strDeliveryExecPhp']                       = "Allow PHP code in ads to be executed<br />(Warning: Security risk)";
$GLOBALS['strDeliveryCtDelimiter']                   = "3rd Party Click Tracking Delimiter";
$GLOBALS['strGlobalDefaultBannerUrl']                = "Global default Banner Image URL";
$GLOBALS['strP3PSettings']                           = "P3P Privacy Policies";
$GLOBALS['strUseP3P']                                = "Use P3P Policies";
$GLOBALS['strP3PCompactPolicy']                      = "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation']                     = "P3P Policy Location";

// General Settings
$GLOBALS['generalSettings']                          = "Global General System Settings";
$GLOBALS['uiEnabled']                                = "User Interface Enabled";
$GLOBALS['defaultLanguage']                          = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings']                  = "Geotargeting Settings";
$GLOBALS['strGeotargeting']                          = "Geotargeting Settings";
$GLOBALS['strGeotargetingType']                      = "Geotargeting Module Type";
$GLOBALS['strGeotargetingUseBundledCountryDb']       = "Use the bundled MaxMind GeoLiteCountry database";
$GLOBALS['strGeotargetingGeoipCountryLocation']      = "MaxMind GeoIP Country Database Location";
$GLOBALS['strGeotargetingGeoipRegionLocation']       = "MaxMind GeoIP Region Database Location";
$GLOBALS['strGeotargetingGeoipCityLocation']         = "MaxMind GeoIP City Database Location";
$GLOBALS['strGeotargetingGeoipAreaLocation']         = "MaxMind GeoIP Area Database Location";
$GLOBALS['strGeotargetingGeoipDmaLocation']          = "MaxMind GeoIP DMA Database Location";
$GLOBALS['strGeotargetingGeoipOrgLocation']          = "MaxMind GeoIP Organisation Database Location";
$GLOBALS['strGeotargetingGeoipIspLocation']          = "MaxMind GeoIP ISP Database Location";
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = "MaxMind GeoIP Netspeed Database Location";
$GLOBALS['strGeoSaveStats']                          = "Save the GeoIP data in the database logs";
$GLOBALS['strGeoShowUnavailable']                    = "Show geotargeting delivery limitations even if GeoIP data unavailable";
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = "The MaxMind GeoIP Country Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = "The MaxMind GeoIP Region Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipCityLocationError']     = "The MaxMind GeoIP City Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = "The MaxMind GeoIP Area Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = "The MaxMind GeoIP DMA Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = "The MaxMind GeoIP Organisation Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipIspLocationError']      = "The MaxMind GeoIP ISP Database does not exist in the location specified";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "The MaxMind GeoIP Netspeed Database does not exist in the location specified";

// Interface Settings
$GLOBALS['strInventory']                             = "Inventory";
$GLOBALS['strUploadConversions']                     = "Upload Conversions";
$GLOBALS['strShowCampaignInfo']                      = "Show extra campaign info on <i>Campaigns</i> page";
$GLOBALS['strShowBannerInfo']                        = "Show extra banner info on <i>Banners</i> page";
$GLOBALS['strShowCampaignPreview']                   = "Show preview of all banners on <i>Banners</i> page";
$GLOBALS['strShowBannerHTML']                        = "Show actual banner instead of plain HTML code for HTML banner preview";
$GLOBALS['strShowBannerPreview']                     = "Show banner preview at the top of pages which deal with banners";
$GLOBALS['strHideInactive']                          = "Hide inactive items from all overview pages";
$GLOBALS['strGUIShowMatchingBanners']                = "Show matching banners on the <i>Linked banner</i> pages";
$GLOBALS['strGUIShowParentCampaigns']                = "Show parent campaigns on the <i>Linked banner</i> pages";
$GLOBALS['strShowEntityId']                          = "Show entity identifiers";
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = "Default Campaigns to Anonymous";
$GLOBALS['strStatisticsDefaults']                    = "Statistics";
$GLOBALS['strBeginOfWeek']                           = "Beginning of Week";
$GLOBALS['strPercentageDecimals']                    = "Percentage Decimals";
$GLOBALS['strWeightDefaults']                        = "Default Weight";
$GLOBALS['strDefaultBannerWeight']                   = "Default Banner Weight";
$GLOBALS['strDefaultCampaignWeight']                 = "Default Campaign Weight";
$GLOBALS['strDefaultBannerWErr']                     = "Default banner weight should be a positive integer";
$GLOBALS['strDefaultCampaignWErr']                   = "Default campaign weight should be a positive integer";
$GLOBALS['strConfirmationUI']                        = "Confirmation in User Interface";

$GLOBALS['strPublisherDefaults']                     = "Website defaults";
$GLOBALS['strModesOfPayment']                        = "Modes of payment";
$GLOBALS['strCurrencies']                            = "Currencies";
$GLOBALS['strCategories']                            = "Categories";
$GLOBALS['strHelpFiles']                             = "Help files";
$GLOBALS['strHasTaxID']                              = "Tax ID";
$GLOBALS['strDefaultApproved']                       = "Approved check box";

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = "Choose Advertiser";
$GLOBALS['strChooseCampaign']                        = "Choose Campaign";
$GLOBALS['strChooseCampaignBanner']                  = "Choose Banner";
$GLOBALS['strChooseTracker']                         = "Choose Tracker";
$GLOBALS['strDefaultConversionStatus']               = "Default Conversion Status";
$GLOBALS['strDefaultConversionType']                 = "Default Conversion Type";
$GLOBALS['strCSVTemplateSettings']                   = "CSV Template Settings";
$GLOBALS['strIncludeCountryInfo']                    = "Include Country Info";
$GLOBALS['strIncludeBrowserInfo']                    = "Include Browser Info";
$GLOBALS['strIncludeOSInfo']                         = "Include OS Info";
$GLOBALS['strIncludeSampleRow']                      = "Include Sample Row";
$GLOBALS['strCSVTemplateAdvanced']                   = "Advanced Template";
$GLOBALS['strCSVTemplateIncVariables']               = "Include Tracker Variables";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes']                = "Allowed Invocation Types";
$GLOBALS['strInvocationDefaults']                    = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery']                         = "Banner Delivery Settings";

// Banner Logging Settings
$GLOBALS['strBannerLogging']                         = "Banner Logging Settings";
$GLOBALS['strLogAdRequests']                         = "Log a request every time a banner is requested";
$GLOBALS['strLogAdImpressions']                      = "Log an impression every time a banner is viewed";
$GLOBALS['strLogAdClicks']                           = "Log a click every time a viewer clicks on a banner";
$GLOBALS['strLogTrackerImpressions']                 = "Log a tracker impression every time a tracker beacon is viewed";
$GLOBALS['strReverseLookup']                         = "Reverse lookup the hostnames of viewers when not supplied";
$GLOBALS['strProxyLookup']                           = "Try to determine the real IP address of viewers behind a proxy server";
$GLOBALS['strPreventLogging']                        = "Block Banner Logging Settings";
$GLOBALS['strIgnoreHosts']                           = "Don't log any statistics for viewers using any of the following IP addresses or hostnames";
$GLOBALS['strIgnoreUserAgents']                      = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents']                     = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

// Banner Storage Settings
$GLOBALS['strBannerStorage']                         = "Banner Storage Settings";

// Campaign ECPM settings
$GLOBALS['strEnableECPM']                            = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM']                    = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant']                 = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM']                    = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns']                  = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings']                   = "Maintenance Settings";
$GLOBALS['strConversionTracking']                    = "Conversion Tracking Settings";
$GLOBALS['strEnableConversionTracking']              = "Enable Conversion Tracking";
$GLOBALS['strCsvImport']                             = "Allow upload of offline conversions";
$GLOBALS['strBlockAdViews']                          = "Don't count Ad Impressions if the viewer has seen the same ad/zone pair within the specified time (seconds)";
$GLOBALS['strBlockAdViewsError']                     = "Ad Impression block value must be a non-negative integer";
$GLOBALS['strBlockAdClicks']                         = "Don't count Ad Clicks if the viewer has clicked on the same ad/zone pair within the specified time (seconds)";
$GLOBALS['strBlockAdClicksError']                    = "Ad Click block value must be a non-negative integer";
$GLOBALS['strMaintenanceOI']                         = "Maintenance Operation Interval (minutes)";
$GLOBALS['strMaintenanceOIError']                    = "The Maintenace Operation Interval is not valid - see documentation for valid values";
$GLOBALS['strPrioritySettings']                      = "Priority Settings";
$GLOBALS['strPriorityInstantUpdate']                 = "Update advertisement priorities immediately when changes made in the UI";
$GLOBALS['strDefaultImpConWindow']                   = "Default Ad Impression Connection Window (seconds)";
$GLOBALS['strDefaultImpConWindowError']              = "If set, the Default Ad Impression Connection Window must be a positive integer";
$GLOBALS['strDefaultCliConWindow']                   = "Default Ad Click Connection Window (seconds)";
$GLOBALS['strDefaultCliConWindowError']              = "If set, the Default Ad Click Connection Window must be a positive integer";
$GLOBALS['strAdminEmailHeaders']                     = "Add the following headers to each email message sent by ". MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']                             = "Send a warning when the number of impressions left are less than specified here";
$GLOBALS['strWarnLimitErr']                          = "Warn Limit must be a positive integer";
$GLOBALS['strWarnLimitDays']                         = "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnLimitDaysErr']                      = "Warn Limit Days should be a positive number";
$GLOBALS['strAllowEmail']                            = "Globally allow sending of emails";
$GLOBALS['strEmailAddressFrom']                      = "Email address to send reports FROM";
$GLOBALS['strEmailAddressName']                      = "Company or personal name to sign off email with";
$GLOBALS['strWarnAdmin']                             = "Send a warning to the administrator every time a campaign is almost expired";
$GLOBALS['strWarnClient']                            = "Send a warning to the advertiser every time a campaign is almost expired";
$GLOBALS['strWarnAgency']                            = "Send a warning to the agency every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings']                           = "User Interface Settings";
$GLOBALS['strGeneralSettings']                       = "General Settings";
$GLOBALS['strAppName']                               = "Application Name";
$GLOBALS['strMyHeader']                              = "Header File Location";
$GLOBALS['strMyHeaderError']                         = "The header file does not exist in the location you specified";
$GLOBALS['strMyFooter']                              = "Footer File Location";
$GLOBALS['strMyFooterError']                         = "The footer file does not exist in the location you specified";
$GLOBALS['strDefaultTrackerStatus']                  = "Default tracker status";
$GLOBALS['strDefaultTrackerType']                    = "Default tracker type";
$GLOBALS['strSSLSettings']                           = "SSL Settings";
$GLOBALS['requireSSL']                               = "Force SSL Access on User Interface";
$GLOBALS['sslPort']                                  = "SSL Port Used by Web Server";
$GLOBALS['strDashboardSettings']                     = "Dashboard Settings";

$GLOBALS['strMyLogo']                                = "Name/URL of custom logo file";
$GLOBALS['strMyLogoError']                           = "The logo file does not exist in the admin/images directory";
$GLOBALS['strGuiHeaderForegroundColor']              = "Color of the header foreground";
$GLOBALS['strGuiHeaderBackgroundColor']              = "Color of the header background";
$GLOBALS['strGuiActiveTabColor']                     = "Color of the active tab";
$GLOBALS['strGuiHeaderTextColor']                    = "Color of the text in the header";
$GLOBALS['strColorError']                            = "Please enter colors in an RGB format, like '0066CC'";

$GLOBALS['strGzipContentCompression']                = "Use GZIP Content Compression";
$GLOBALS['strClientInterface']                       = "Advertiser Interface";
$GLOBALS['strReportsInterface']                      = "Reports Interface";
$GLOBALS['strClientWelcomeEnabled']                  = "Enable Advertiser Welcome Message";
$GLOBALS['strClientWelcomeText']                     = "Welcome Text<br />(HTML Tags Allowed)";

$GLOBALS['strPublisherInterface']                    = "Website interface";
$GLOBALS['strPublisherAgreementEnabled']             = "Enable login control for websites who haven't accepted Terms and Conditions";
$GLOBALS['strPublisherAgreementText']                = "Login text (HTML tags allowed)";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate']                = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash']                       = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError']            = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings']                        = "Plugin Settings";
$GLOBALS['strEnableNewPlugins']                      = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions']                    = "Use merged delivery functions file";

/*-------------------------------------------------------*/
/* Unknown (unused?) translations                        */
/*-------------------------------------------------------*/

$GLOBALS['strExperimental']                 = "Experimental";
$GLOBALS['strKeywordRetrieval']             = "Keyword retrieval";
$GLOBALS['strBannerRetrieval']              = "Banner retrieval method";
$GLOBALS['strRetrieveRandom']               = "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']            = "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']                    = "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']                      = "Full sequential banner retrieval";
$GLOBALS['strUseKeywords']                  = "Use keywords to select banners";
$GLOBALS['strUseConditionalKeys']           = "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']              = "Allow multiple keywords when using direct selection";

$GLOBALS['strTableBorderColor']             = "Table Border Color";
$GLOBALS['strTableBackColor']               = "Table Back Color";
$GLOBALS['strTableBackColorAlt']            = "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']                = "Main Back Color";
$GLOBALS['strOverrideGD']                   = "Override GD Imageformat";
$GLOBALS['strTimeZone']                     = "Time Zone";

?>
