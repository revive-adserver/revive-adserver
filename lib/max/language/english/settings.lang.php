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

/**
 * A file for holding the "settings" English translation information.
 *
 * @package    MaxUI
 * @subpackage Languages
 */

// Installer translation strings
$GLOBALS['strInstall']                      = "Install";
$GLOBALS['strChooseInstallLanguage']        = "Choose language for the installation procedure";
$GLOBALS['strLanguageSelection']            = "Language Selection";
$GLOBALS['strDatabaseSettings']             = "Database Settings";
$GLOBALS['strAdminSettings']                = "Administrator Settings";
$GLOBALS['strAdvancedSettings']             = "Advanced Settings";
$GLOBALS['strOtherSettings']                = "Other settings";

$GLOBALS['strWarning']                      = "Warning";
$GLOBALS['strFatalError']                   = "A fatal error occurred";
$GLOBALS['strUpdateError']                  = "An error occured while updating";
$GLOBALS['strUpdateDatabaseError']          = "Due to unknown reasons the update of the database structure wasn't succesful. The recommended way to proceed is to click <b>Retry updating</b> to try to correct these potential problems. If you are sure these errors won't affect the functionality of ".MAX_PRODUCT_NAME." you can click <b>Ignore errors</b> to continue. Ignoring these errors may cause serious problems and is not recommended!";
$GLOBALS['strAlreadyInstalled']             = MAX_PRODUCT_NAME." is already installed on this system. If you want to configure it go to <a href='settings-index.php'>settings interface</a>";
$GLOBALS['strCouldNotConnectToDB']          = "Could not connect to database, please recheck the settings you specified";
$GLOBALS['strCreateTableTestFailed']        = "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']        = "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']           = "Table prefix contains invalid characters";
$GLOBALS['strTableInUse']                   = "The database which you specified is already used for ".MAX_PRODUCT_NAME.", please use a different table prefix, or read the UPGRADE.txt file for upgrading instructions.";
$GLOBALS['strNoVersionInfo']                = "Unable to select the database version";
$GLOBALS['strInvalidVersionInfo']           = "Unable to determine the database version";
$GLOBALS['strInvalidMySqlVersion']          = MAX_PRODUCT_NAME." requires MySQL 4.0 or higher to function correctly. Please select a different database server.";
$GLOBALS['strTableWrongType']               = "The table type you selected isn't supported by your installation of ".phpAds_dbmsname;
$GLOBALS['strMayNotFunction']               = "Before you continue, please correct these potential problems:";
$GLOBALS['strFixProblemsBefore']            = "The following item(s) need to be corrected before you can install ".MAX_PRODUCT_NAME.". If you have any questions about this error message, please read the <i>Administrator Guide</i>, which is part of the package you downloaded.";
$GLOBALS['strFixProblemsAfter']             = "If you are not able to correct the problems listed above, please contact the administrator of the server you are trying to install ".MAX_PRODUCT_NAME." on. The administrator of the server may be able to help you.";
$GLOBALS['strIgnoreWarnings']               = "Ignore warnings";
$GLOBALS['strWarningDBavailable']           = "The version of PHP you are using doesn't have support for connecting to a ".phpAds_dbmsname." database server. You need to enable the PHP ".phpAds_dbmsname." extension before you can proceed.";
$GLOBALS['strWarningPHPversion']            = MAX_PRODUCT_NAME." requires PHP 4.3.6 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']       = "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningMagicQuotesGPC']        = "The PHP configuration variable magic_quotes_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']    = "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strWarningFileUploads']           = "The PHP configuration variable file_uploads needs to be turned on.";
$GLOBALS['strWarningTrackVars']             = "The PHP configuration variable track_vars needs to be turned on.";
$GLOBALS['strWarningPREG']                  = "The version of PHP you are using doesn't have support for PERL compatible regular expressions. You need to enable the PREG extension before you can proceed.";
$GLOBALS['strConfigLockedDetected']         = MAX_PRODUCT_NAME." has detected that the <b>max.conf.ini</b> file cannot be written by the web server. You can't proceed until you make the 'var' directory writable by the web server. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']                 = "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strIgnoreErrors']                 = "Ignore errors";
$GLOBALS['strRetryUpdate']                  = "Retry updating";
$GLOBALS['strTableNames']                   = "Table Names";
$GLOBALS['strTablesPrefix']                 = "Table names prefix";
$GLOBALS['strTablesType']                   = "Table type";

$GLOBALS['strInstallWelcome']               = "Welcome to ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']               = "Before you can use ".MAX_PRODUCT_NAME." it needs to be configured and <br /> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']               = "<b>The installation of ".MAX_PRODUCT_NAME." is now complete.</b><br /><br />In order for ".MAX_PRODUCT_NAME." to function correctly you also need
                                                to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
                                                <br /><br />Click <b>Proceed</b> to go the configuration page, where you can
                                                modify more settings. Please do not forget to lock the max.conf.ini file when you are finished to prevent security
                                                breaches, ie, make it read-only by the webserver.";
$GLOBALS['strUpdateSuccess']                = "<b>The upgrade of ".MAX_PRODUCT_NAME." was succesful.</b><br /><br />In order for ".MAX_PRODUCT_NAME." to function correctly you also need
                                                to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
                                                <br /><br />Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file
                                                to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']         = "<b>The installation of ".MAX_PRODUCT_NAME." was not succesful</b><br /><br />Some portions of the install process could not be completed.
                                                It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
                                                first step of the install process. If you want to know more on what the error message below means, and how to solve it,
                                                please consult the supplied documentation.";
$GLOBALS['strErrorOccured']                 = "The following error occured:";
$GLOBALS['strErrorInstallDatabase']         = "The database structure could not be created.";
$GLOBALS['strErrorInstallPrefs']            = "The administrator user preferences could not be written to the database.";
$GLOBALS['strErrorInstallVersion']          = "The Openads version number could not be written to the database.";
$GLOBALS['strErrorUpgrade']                 = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallDbConnect']        = "It was not possible to open a connection to the database.";

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
$GLOBALS['strChooseSection']                         = 'Choose Section';
$GLOBALS['strEditConfigNotPossible']                 = 'It is not possible to edit all settings because the configuration file is locked for security reasons. ' .
                                                       'If you want to make changes, you may need to unlock the configuration file for this installation first.';
$GLOBALS['strEditConfigPossible']                    = 'It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. ' .
                                                       'If you want to secure your system, you need to lock the configuration file for this installation.';
$GLOBALS['strUnableToWriteConfig']                   = 'Unable to write changes to the config file';
$GLOBALS['strUnableToWritePrefs']                    = 'Unable to commit preferences to the database';

// Administrator Settings
$GLOBALS['strAdministratorSettings']                 = 'Administrator Settings';
$GLOBALS['strLoginCredentials']                      = 'Login Credentials';
$GLOBALS['strAdminUsername']                         = 'Admin\'s Username';
$GLOBALS['strInvalidUsername']                       = 'Invalid Username';
$GLOBALS['strBasicInformation']                      = 'Basic Information';
$GLOBALS['strAdminFullName']                         = 'Admin\'s Full Name';
$GLOBALS['strAdminEmail']                            = 'Admin\'s Email Address';
$GLOBALS['strCompanyName']                           = 'Company Name';
$GLOBALS['strAdminCheckUpdates']                     = 'Check for Updates';
$GLOBALS['strAdminCheckEveryLogin']                  = 'Every Login';
$GLOBALS['strAdminCheckDaily']                       = 'Daily';
$GLOBALS['strAdminCheckWeekly']                      = 'Weekly';
$GLOBALS['strAdminCheckMonthly']                     = 'Monthly';
$GLOBALS['strAdminCheckNever']                       = 'Never';
$GLOBALS['strAdminNovice']                           = 'Admin\'s delete actions need confirmation for safety';
$GLOBALS['strUserlogEmail']                          = 'Log all outgoing email messages';

// Banner Settings
$GLOBALS['strBannerSettings']                        = 'Banner Settings';
$GLOBALS['strDefaultBanners']                        = 'Default Banners';
$GLOBALS['strDefaultBannerUrl']                      = 'Default Image URL';
$GLOBALS['strDefaultBannerDestination']              = 'Default Destination URL';
$GLOBALS['strAllowedBannerTypes']                    = 'Allowed Banner Types';
$GLOBALS['strTypeSqlAllow']                          = 'Allow SQL Local Banners';
$GLOBALS['strTypeWebAllow']                          = 'Allow Webserver Local Banners';
$GLOBALS['strTypeUrlAllow']                          = 'Allow External Banners';
$GLOBALS['strTypeHtmlAllow']                         = 'Allow HTML Banners';
$GLOBALS['strTypeTxtAllow']                          = 'Allow Text Ads';
$GLOBALS['strTypeHtmlSettings']                      = 'HTML Banner Options';
$GLOBALS['strTypeHtmlAuto']                          = 'Automatically alter HTML banners in order to force click tracking';
$GLOBALS['strTypeHtmlPhp']                           = 'Allow PHP expressions to be executed from within a HTML banner';

// Database Settings
$GLOBALS['strDatabaseSettings']                      = 'Database Settings';
$GLOBALS['strDatabaseServer']                        = 'Global Database Server Settings';
$GLOBALS['strDbLocal']                               = 'Connect to local server using sockets'; // Pg only
$GLOBALS['strDbType']                                = 'Database Type';
$GLOBALS['strDbHost']                                = 'Database Hostname';
$GLOBALS['strDbPort']                                = 'Database Port Number';
$GLOBALS['strDbUser']                                = 'Database Username';
$GLOBALS['strDbPassword']                            = 'Database Password';
$GLOBALS['strDbName']                                = 'Database Name';
$GLOBALS['strDatabaseOptimalisations']               = 'Global Database Optimisation Settings';
$GLOBALS['strPersistentConnections']                 = 'Use Persistent Connections';
$GLOBALS['strCantConnectToDb']                       = 'Can\'t Connect to Database';

// Debug Logging Settings
$GLOBALS['strDebugSettings']                         = 'Debug Logging';
$GLOBALS['strDebug']                                 = 'Global Debug Logging Settings';
$GLOBALS['strProduction']                            = 'Production server';
$GLOBALS['strEnableDebug']                           = 'Enable Debug Logging';
$GLOBALS['strDebugMethodNames']                      = 'Include method names in debug log';
$GLOBALS['strDebugLineNumbers']                      = 'Include line numbers in debug log';
$GLOBALS['strDebugType']                             = 'Debug Log Type';
$GLOBALS['strDebugTypeFile']                         = 'File';
$GLOBALS['strDebugTypeMcal']                         = 'mCal';
$GLOBALS['strDebugTypeSql']                          = 'SQL Database';
$GLOBALS['strDebugTypeSyslog']                       = 'Syslog';
$GLOBALS['strDebugName']                             = 'Debug Log Name, Calendar, SQL Table,<br />or Syslog Facility';
$GLOBALS['strDebugPriority']                         = 'Debug Priority Level';
$GLOBALS['strPEAR_LOG_DEBUG']                        = 'PEAR_LOG_DEBUG - Most Information';
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO - Default Information';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG - Least Information';
$GLOBALS['strDebugIdent']                            = 'Debug Identification String';
$GLOBALS['strDebugUsername']                         = 'mCal, SQL Server Username';
$GLOBALS['strDebugPassword']                         = 'mCal, SQL Server Password';

// Delivery Settings
$GLOBALS['strDeliverySettings']                      = 'Delivery Settings';
$GLOBALS['strWebPath']                               = 'Global ' . MAX_PRODUCT_NAME . ' Server Access Paths';
$GLOBALS['strTypeWebSettings']                       = 'Global Webserver Local Banner Storage Settings';
$GLOBALS['strTypeWebMode']                           = 'Storing Method';
$GLOBALS['strTypeWebModeLocal']                      = 'Local Directory';
$GLOBALS['strTypeDirError']                          = 'The local directory cannot be written to by the web server';
$GLOBALS['strTypeWebModeFtp']                        = 'External FTP Server';
$GLOBALS['strTypeWebDir']                            = 'Local Directory';
$GLOBALS['strTypeFTPHost']                           = 'FTP Host';
$GLOBALS['strTypeFTPDirectory']                      = 'Host Directory';
$GLOBALS['strTypeFTPUsername']                       = 'Login';
$GLOBALS['strTypeFTPPassword']                       = 'Password';
$GLOBALS['strTypeFTPPassive']                        = 'Use passive FTP'; 
$GLOBALS['strTypeFTPErrorDir']                       = 'The FTP Host Directory does not exist';
$GLOBALS['strTypeFTPErrorConnect']                   = 'Could not connect to the FTP Server, the Login or Password is not correct';
$GLOBALS['strTypeFTPErrorHost']                      = 'The FTP Host is not correct';
$GLOBALS['strDeliveryFilenames']                     = 'Global Delivery File Names';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'Ad Click';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'Ad Conversion Variables';
$GLOBALS['strDeliveryFilenamesAdContent']            = 'Ad Content';
$GLOBALS['strDeliveryFilenamesAdConversion']         = 'Ad Conversion';
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = 'Ad Conversion (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdFrame']              = 'Ad Frame';
$GLOBALS['strDeliveryFilenamesAdImage']              = 'Ad Image';
$GLOBALS['strDeliveryFilenamesAdJS']                 = 'Ad (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdLayer']              = 'Ad Layer';
$GLOBALS['strDeliveryFilenamesAdLog']                = 'Ad Log';
$GLOBALS['strDeliveryFilenamesAdPopup']              = 'Ad Popup';
$GLOBALS['strDeliveryFilenamesAdView']               = 'Ad View';
$GLOBALS['strDeliveryFilenamesXMLRPC']               = 'XML RPC Invocation';
$GLOBALS['strDeliveryFilenamesLocal']                = 'Local Invocation';
$GLOBALS['strDeliveryFilenamesFrontController']      = 'Front Controller';
$GLOBALS['strDeliveryFilenamesFlash']                = 'Flash Include (Can be a full URL)';
$GLOBALS['strDeliveryCaching']                       = 'Global Delivery Caching Settings';
$GLOBALS['strDeliveryCacheEnable']                   = 'Enable Delivery Caching';
$GLOBALS['strDeliveryCacheType']                     = 'Delivery Cache Type';
$GLOBALS['strCacheFiles']                            = 'File';
$GLOBALS['strCacheDatabase']                         = 'Database';
$GLOBALS['strDeliveryCacheLimit']                    = 'Time Between Cache Updates (seconds)';

$GLOBALS['strOrigin']                                = 'Use remote origin server';
$GLOBALS['strOriginType']                            = 'Origin server type';
$GLOBALS['strOriginHost']                            = 'Hostname for origin server';
$GLOBALS['strOriginPort']                            = 'Port number for origin database';
$GLOBALS['strOriginScript']                          = 'Script file for origin database';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'Origin timeout (seconds)';
$GLOBALS['strOriginProtocol']                        = 'Origin server protocol';

$GLOBALS['strDeliveryBanner']                        = 'Global Banner Delivery Settings';
$GLOBALS['strDeliveryAcls']                          = 'Evaluate banner delivery limitations during delivery';
$GLOBALS['strDeliveryObfuscate']                     = 'Obfuscate channel when delivering ads';
$GLOBALS['strDeliveryExecPhp']                       = 'Allow PHP code in ads to be executed<br />(Warning: Security risk)';
$GLOBALS['strDeliveryCtDelimiter']                   = '3rd Party Click Tracking Delimiter';
$GLOBALS['strP3PSettings']                           = 'Global P3P Privacy Policies';
$GLOBALS['strUseP3P']                                = 'Use P3P Policies';
$GLOBALS['strP3PCompactPolicy']                      = 'P3P Compact Policy';
$GLOBALS['strP3PPolicyLocation']                     = 'P3P Policy Location';

// General Settings
$GLOBALS['generalSettings']                          = 'Global General System Settings';
$GLOBALS['uiEnabled']                                = 'User Interface Enabled';
$GLOBALS['defaultLanguage']                          = 'Default System Language<br />(Each user can select their own language)';
$GLOBALS['requireSSL']                               = 'Force SSL Access on User Interface';
$GLOBALS['sslPort']                                  = 'SSL Port Used by Web Server';

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings']                  = 'Geotargeting Settings';
$GLOBALS['strGeotargeting']                          = 'Global Geotargeting Settings';
$GLOBALS['strGeotargetingType']                      = 'Geotargeting Module Type';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'MaxMind GeoIP Country Database Location<br />(Leave blank to use free database)';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'MaxMind GeoIP Region Database Location';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'MaxMind GeoIP City Database Location';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'MaxMind GeoIP Area Database Location';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'MaxMind GeoIP DMA Database Location';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'MaxMind GeoIP Organisation Database Location';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'MaxMind GeoIP ISP Database Location';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'MaxMind GeoIP Netspeed Database Location';
$GLOBALS['strGeoSaveStats']                          = 'Save the GeoIP data in the database logs';
$GLOBALS['strGeoShowUnavailable']                    = 'Show geotargeting delivery limitations even if GeoIP data unavailable';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'The MaxMind GeoIP Country Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'The MaxMind GeoIP Region Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'The MaxMind GeoIP City Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'The MaxMind GeoIP Area Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'The MaxMind GeoIP DMA Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'The MaxMind GeoIP Organisation Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'The MaxMind GeoIP ISP Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'The MaxMind GeoIP Netspeed Database does not exist in the location specified';

// Interface Settings
$GLOBALS['strInterfaceDefaults']                     = 'Interface Defaults';
$GLOBALS['strInventory']                             = 'Inventory';
$GLOBALS['strUploadConversions']                     = 'Upload Conversions';
$GLOBALS['strShowCampaignInfo']                      = 'Show extra campaign info on <i>Campaign overview</i> page';
$GLOBALS['strShowBannerInfo']                        = 'Show extra banner info on <i>Banner overview</i> page';
$GLOBALS['strShowCampaignPreview']                   = 'Show preview of all banners on <i>Banner overview</i> page';
$GLOBALS['strShowBannerHTML']                        = 'Show actual banner instead of plain HTML code for HTML banner preview';
$GLOBALS['strShowBannerPreview']                     = 'Show banner preview at the top of pages which deals with banners';
$GLOBALS['strHideInactive']                          = 'Hide inactive items from all overview pages';
$GLOBALS['strGUIShowMatchingBanners']                = 'Show matching banners on the <i>Linked banner</i> pages';
$GLOBALS['strGUIShowParentCampaigns']                = 'Show parent campaigns on the <i>Linked banner</i> pages';
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'Default Campaigns to Anonymous';
$GLOBALS['strStatisticsDefaults']                    = 'Statistics';
$GLOBALS['strBeginOfWeek']                           = 'Beginning of Week';
$GLOBALS['strPercentageDecimals']                    = 'Percentage Decimals';
$GLOBALS['strWeightDefaults']                        = 'Default Weight';
$GLOBALS['strDefaultBannerWeight']                   = 'Default Banner Weight';
$GLOBALS['strDefaultCampaignWeight']                 = 'Default Campaign Weight';
$GLOBALS['strDefaultBannerWErr']                     = 'Default banner weight should be a positive integer';
$GLOBALS['strDefaultCampaignWErr']                   = 'Default campaign weight should be a positive integer';

$GLOBALS['strPublisherDefaults']                     = 'Publisher defaults';
$GLOBALS['strModesOfPayment']                        = 'Modes of payment';
$GLOBALS['strCurrencies']                            = 'Currencies';
$GLOBALS['strCategories']                            = 'Categories';
$GLOBALS['strHelpFiles']                             = 'Help files';
$GLOBALS['strHasTaxID']                              = 'Tax ID';
$GLOBALS['strDefaultApproved']                       = 'Approved check box';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = 'Choose Advertiser';
$GLOBALS['strChooseCampaign']                        = 'Choose Campaign';
$GLOBALS['strChooseCampaignBanner']                  = 'Choose Banner';
$GLOBALS['strChooseTracker']                         = 'Choose Tracker';
$GLOBALS['strDefaultConversionStatus']               = 'Default Conversion Status';
$GLOBALS['strDefaultConversionType']                 = 'Default Conversion Type';
$GLOBALS['strCSVTemplateSettings']                   = 'CSV Template Settings';
$GLOBALS['strIncludeCountryInfo']                    = 'Include Country Info';
$GLOBALS['strIncludeBrowserInfo']                    = 'Include Browser Info';
$GLOBALS['strIncludeOSInfo']                         = 'Include OS Info';
$GLOBALS['strIncludeSampleRow']                      = 'Include Sample Row';
$GLOBALS['strCSVTemplateAdvanced']                   = 'Advanced Template';
$GLOBALS['strCSVTemplateIncVariables']               = 'Include Tracker Variables';

// Invocation Settings
$GLOBALS['strInvocationAndDelivery']                 = 'Invocation Settings';
$GLOBALS['strAllowedInvocationTypes']                = 'Allowed Invocation Types';
$GLOBALS['strIncovationDefaults']                    = 'Incovation Defaults';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'Enable 3rd Party Clicktracking by Default';

// Statistics & Maintenance Settings
$GLOBALS['strStatisticsSettings']                    = 'Statistics & Maintenance Settings';
$GLOBALS['strStatisticsLogging']                     = 'Global Statistics Logging Settings';
$GLOBALS['strCsvImport']                             = 'Allow upload of offline conversions';
$GLOBALS['strLogAdRequests']                         = 'Log an Ad Request every time an advertisement is requested';
$GLOBALS['strLogAdImpressions']                      = 'Log an Ad Impression every time an advertisement is viewed';
$GLOBALS['strLogAdClicks']                           = 'Log an Ad Click every time a viewer clicks on an advertisement';
$GLOBALS['strLogTrackerImpressions']                 = 'Log a Tracker Impression every time a tracker beacon viewed';
$GLOBALS['strReverseLookup']                         = 'Reverse lookup the hostnames of viewers when not supplied';
$GLOBALS['strProxyLookup']                           = 'Try to determine the real IP address of viewers behind a proxy server';
$GLOBALS['strSniff']                                 = 'Extract the viewer\'s O/S and web browser using phpSniff';
$GLOBALS['strPreventLogging']                        = 'Global Prevent Statistics Logging Settings';
$GLOBALS['strIgnoreHosts']                           = 'Don\'t store statistics for viewers using one of the following IP addresses or hostnames';
$GLOBALS['strBlockAdViews']                          = 'Don\'t log an Ad Impression if the viewer has seen the same ad within the specified time (seconds)';
$GLOBALS['strBlockAdViewsError']                     = 'Ad Impression block value must be a non-negative integer';
$GLOBALS['strBlockAdClicks']                         = 'Don\'t log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)';
$GLOBALS['strBlockAdClicksError']                    = 'Ad Click block value must be a non-negative integer';
$GLOBALS['strBlockAdConversions']                    = 'Don\'t log a Tracker Impression if the viewer has seen the page with the tracker beacon within the specified time (seconds)';
$GLOBALS['strBlockAdConversionsError']               = 'Tracker Impression block value must be a non-negative integer';
$GLOBALS['strMaintenaceSettings']                    = 'Global Maintenance Settings';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Process Statistics for AdServer Module';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Process Statistics for Tracker Module';
$GLOBALS['strMaintenanceOI']                         = 'Maintenance Operation Interval (minutes)';
$GLOBALS['strMaintenanceOIError']                    = 'The Maintenace Operation Interval is not valid - see documentation for valid values';
$GLOBALS['strMaintenanceCompactStats']               = 'Delete raw statistics after processing?';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Grace period before deleting processed statistics (seconds)';
$GLOBALS['strPrioritySettings']                      = 'Global Priority Settings';
$GLOBALS['strPriorityInstantUpdate']                 = 'Update advertisement priorities immediately when changes made in the UI';
$GLOBALS['strWarnCompactStatsGrace']                 = 'The Compact Stats Grace period must be a positive integer';
$GLOBALS['strDefaultImpConWindow']                   = 'Default Ad Impression Connection Window (seconds)';
$GLOBALS['strDefaultImpConWindowError']              = 'If set, the Default Ad Impression Connection Window must be a positive integer';
$GLOBALS['strDefaultCliConWindow']                   = 'Default Ad Click Connection Window (seconds)';
$GLOBALS['strDefaultCliConWindowError']              = 'If set, the Default Ad Click Connection Window must be a positive integer';
$GLOBALS['strEmailWarnings']                         = 'E-mail Warnings';
$GLOBALS['strAdminEmailHeaders']                     = 'Add the following headers to each e-mail message sent by ' . MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']                             = 'Send a warning when the number of impressions left are less than specified here';
$GLOBALS['strWarnLimitErr']                          = 'Warn Limit must be a positive integer';
$GLOBALS['strWarnAdmin']                             = 'Send a warning to the administrator every time a campaign is almost expired';
$GLOBALS['strWarnClient']                            = 'Send a warning to the advertiser every time a campaign is almost expired';
$GLOBALS['strWarnAgency']                            = 'Send a warning to the agency every time a campaign is almost expired';
$GLOBALS['strQmailPatch']                            = 'Enable qmail patch';

// UI Settings
$GLOBALS['strGuiSettings']                           = 'User Interface Settings';
$GLOBALS['strGeneralSettings']                       = 'General Settings';
$GLOBALS['strAppName']                               = 'Application Name';
$GLOBALS['strMyHeader']                              = 'Header File Location';
$GLOBALS['strMyHeaderError']                         = 'The header file does not exist in the location you specified';
$GLOBALS['strMyFooter']                              = 'Footer File Location';
$GLOBALS['strMyFooterError']                         = 'The footer file does not exist in the location you specified';
$GLOBALS['strDefaultTrackerStatus']                  = 'Default tracker status';
$GLOBALS['strDefaultTrackerType']                    = 'Default tracker type';

$GLOBALS['strMyLogo']                                = 'Name of custom logo file';
$GLOBALS['strMyLogoError']                           = 'The logo file does not exist in the admin/images directory';
$GLOBALS['strGuiHeaderForegroundColor']              = 'Color of the header foreground';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'Color of the header background';
$GLOBALS['strGuiActiveTabColor']                     = 'Color of the active tab';
$GLOBALS['strGuiHeaderTextColor']                    = 'Color of the text in the header';
$GLOBALS['strColorError']                            = 'Please enter colors in an RGB format, like \'0066CC\'';

$GLOBALS['strGzipContentCompression']                = 'Use GZIP Content Compression';
$GLOBALS['strClientInterface']                       = 'Advertiser Interface';
$GLOBALS['strReportsInterface']                      = 'Reports Interface';
$GLOBALS['strClientWelcomeEnabled']                  = 'Enable Advertiser Welcome Message';
$GLOBALS['strClientWelcomeText']                     = 'Welcome Text<br />(HTML Tags Allowed)';

$GLOBALS['strPublisherInterface']                    = 'Publisher interface';
$GLOBALS['strPublisherAgreementEnabled']             = 'Enable login control for publishers who haven\'t accepted Terms and Conditions';
$GLOBALS['strPublisherAgreementText']                = 'Login text (HTML tags allowed)';


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
