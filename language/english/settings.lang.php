<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				= "Install";
$GLOBALS['strChooseInstallLanguage']		= "Choose language for the installation procedure";
$GLOBALS['strLanguageSelection']		= "Language Selection";
$GLOBALS['strDatabaseSettings']			= "Database Settings";
$GLOBALS['strAdminSettings']			= "Administrator Settings";
$GLOBALS['strAdvancedSettings']			= "Advanced Settings";
$GLOBALS['strOtherSettings']			= "Other settings";

$GLOBALS['strWarning']				= "Warning";
$GLOBALS['strFatalError']			= "A fatal error occurred";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." is already installed on this system. If you want to configure it go to <a href='settings-index.php'>settings interface</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Could not connect to database, please recheck the settings you specified";
$GLOBALS['strCreateTableTestFailed']		= "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']		= "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']		= "Table prefix contains invalid characters";
$GLOBALS['strTableInUse']			= "The database which you specified is already used for ".$phpAds_productname.", please use a different table prefix, or read the manual for upgrading instructions.";
$GLOBALS['strMayNotFunction']			= "Before you continue, please correct these potential problems:";
$GLOBALS['strIgnoreWarnings']			= "Ignore warnings";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requires PHP 4.0 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningMagicQuotesGPC']		= "The PHP configuration variable magic_quotes_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strWarningFileUploads']		= "The PHP configuration variable file_uploads needs to be turned on.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." has detected that your <b>config.inc.php</b> file is not writeable by the server.<br> You can't proceed until you change permissions on the file. <br>Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strTableNames']			= "Table Names";
$GLOBALS['strTablesPrefix']			= "Table names prefix";
$GLOBALS['strTablesType']			= "Table type";

$GLOBALS['strInstallWelcome']			= "Welcome to ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesfull.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file 
						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "The following error occured:";
$GLOBALS['strErrorInstallDatabase']		= "The database structure could not be created.";
$GLOBALS['strErrorInstallConfig']		= "The configuration file or database could not be updated.";
$GLOBALS['strErrorInstallDbConnect']		= "It was not possible to open a connection to the database.";

$GLOBALS['strUrlPrefix']			= "URL Prefix";

$GLOBALS['strProceed']				= "Proceed &gt;";
$GLOBALS['strRepeatPassword']			= "Repeat Password";
$GLOBALS['strNotSamePasswords']			= "Passwords did not match";
$GLOBALS['strInvalidUserPwd']			= "Invalid username or password";

$GLOBALS['strUpgrade']				= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Your system is already up to date, no upgrade is needed at the moment. <br>Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']		= "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br>Please be patient, the upgrade can take up to a couple of minutes.";
$GLOBALS['strSystemUpgradeBusy']		= "System upgrade in progress, please wait...";
$GLOBALS['strSystemRebuildingCache']		= "Rebuilding cache, please wait...";
$GLOBALS['strServiceUnavalable']		= "The service is temporarily unavailable. System upgrade in progress";

$GLOBALS['strConfigNotWritable']		= "Your config.inc.php file is not writable";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Choose Section";
$GLOBALS['strDayFullNames'] 			= array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$GLOBALS['strEditConfigNotPossible']   		= "It is not possible to edit these settings because the configuration file is locked for security reasons. ".
										  "If you want to make changes, you need to unlock the config.inc.php file first.";
$GLOBALS['strEditConfigPossible']		= "It is possible to edit all settings because the configuration file is not locked, but this could lead to security leaks. ".
										  "If you want to secure your system, you need to lock the config.inc.php file.";



// Database
$GLOBALS['strDatabaseSettings']			= "Database Settings";
$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbHost']				= "Database hostname";
$GLOBALS['strDbUser']				= "Database username";
$GLOBALS['strDbPassword']			= "Database password";
$GLOBALS['strDbName']				= "Database name";

$GLOBALS['strDatabaseOptimalisations']		= "Database optimalisations";
$GLOBALS['strPersistentConnections']		= "Use persistent connections";
$GLOBALS['strInsertDelayed']			= "Use delayed inserts";
$GLOBALS['strCompatibilityMode']		= "Use database compatibility mode";
$GLOBALS['strCantConnectToDb']			= "Can't connect to database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Invocation and delivery settings";

$GLOBALS['strAllowedInvocationTypes']		= "Allowed invocation types";
$GLOBALS['strAllowRemoteInvocation']		= "Allow Remote Invocation";
$GLOBALS['strAllowRemoteJavascript']		= "Allow Remote Invocation for Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Allow Remote Invocation for Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Allow Remote Invocation using XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Allow Local mode";
$GLOBALS['strAllowInterstitial']		= "Allow Interstitials";
$GLOBALS['strAllowPopups']			= "Allow Popups";

$GLOBALS['strUseAcl']				= "Use delivery limitations";

$GLOBALS['strKeywordRetrieval']			= "Keyword retrieval";
$GLOBALS['strBannerRetrieval']			= "Banner retrieval method";
$GLOBALS['strRetrieveRandom']			= "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']			= "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']				= "Full sequential banner retrieval";
$GLOBALS['strUseConditionalKeys']		= "Use conditional keywords";
$GLOBALS['strUseMultipleKeys']			= "Use multiple keywords";

$GLOBALS['strZonesSettings']			= "Zone retrieval";
$GLOBALS['strZoneCache']			= "Cache zones, this should speed things up when using zones";
$GLOBALS['strZoneCacheLimit']			= "Time between cache updates (in seconds)";
$GLOBALS['strZoneCacheLimitErr']		= "Time between cache updates should be a positive integer";

$GLOBALS['strP3PSettings']			= "P3P Privacy Policies";
$GLOBALS['strUseP3P']				= "Use P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policy Location";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner settings";

$GLOBALS['strAllowedBannerTypes']		= "Allowed banner types";
$GLOBALS['strTypeSqlAllow']			= "Allow local banners (SQL)";
$GLOBALS['strTypeWebAllow']			= "Allow local banners (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Allow external banners";
$GLOBALS['strTypeHtmlAllow']			= "Allow HTML banners";
$GLOBALS['strTypeTxtAllow']			= "Allow Text ads";

$GLOBALS['strTypeWebSettings']			= "Local banner (Webserver) configuration";
$GLOBALS['strTypeWebMode']			= "Storing method";
$GLOBALS['strTypeWebModeLocal']			= "Local directory";
$GLOBALS['strTypeWebModeFtp']			= "External FTP server";
$GLOBALS['strTypeWebDir']			= "Local directory";
$GLOBALS['strTypeWebFtp']			= "FTP mode Web banner server";
$GLOBALS['strTypeWebUrl']			= "Public URL";
$GLOBALS['strTypeFTPHost']			= "FTP Host";
$GLOBALS['strTypeFTPDirectory']			= "Host directory";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Password";

$GLOBALS['strDefaultBanners']			= "Default banners";
$GLOBALS['strDefaultBannerUrl']			= "Default image URL";
$GLOBALS['strDefaultBannerTarget']		= "Default destination URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner options";
$GLOBALS['strTypeHtmlAuto']			= "Automatically alter HTML banners in order to force click tracking";
$GLOBALS['strTypeHtmlPhp']			= "Allow PHP expressions to be executed from within a HTML banner";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statistics Settings";

$GLOBALS['strStatisticsFormat']			= "Statistics format";
$GLOBALS['strLogBeacon']			= "Use beacons to log AdViews";
$GLOBALS['strCompactStats']			= "Use Compact Stats";
$GLOBALS['strLogAdviews']			= "Log AdViews";
$GLOBALS['strBlockAdviews']			= "Multiple log protection (sec.)";
$GLOBALS['strLogAdclicks']			= "Log AdClicks";
$GLOBALS['strBlockAdclicks']			= "Multiple log protection (sec.)";

$GLOBALS['strGeotargeting']			= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Type of geotargeting database";
$GLOBALS['strGeotrackingLocation'] 		= "Geotargeting database location";
$GLOBALS['strGeoLogStats']			= "Log the country of the visitor in the statistics";
$GLOBALS['strGeoStoreCookie']		= "Store the result in a cookie for future reference";

$GLOBALS['strEmailWarnings']			= "E-mail warnings";
$GLOBALS['strAdminEmailHeaders']		= "Mail Headers for the reflection of the sender of the daily ad reports";
$GLOBALS['strWarnLimit']			= "Warn Limit";
$GLOBALS['strWarnLimitErr']			= "Warn Limit should be a positive integer";
$GLOBALS['strWarnAdmin']			= "Warn Admin";
$GLOBALS['strWarnClient']			= "Warn Advertiser";
$GLOBALS['strQmailPatch']			= "Enable qmail patch";

$GLOBALS['strRemoteHosts']			= "Remote hosts";
$GLOBALS['strIgnoreHosts']			= "Ignore Hosts";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strProxyLookup']			= "Proxy Lookup";

$GLOBALS['strAutoCleanTables']			= "Database pruning";
$GLOBALS['strAutoCleanStats']			= "Prune statistics";
$GLOBALS['strAutoCleanUserlog']			= "Prune user log";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maximum age of statistics <br>(3 weeks minimum)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Maximum age of user log <br>(3 weeks minimum)";
$GLOBALS['strAutoCleanErr']			= "Maximum age must be at least 3 weeks";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Administrator settings";

$GLOBALS['strLoginCredentials']			= "Login credentials";
$GLOBALS['strAdminUsername']			= "Admin's username";
$GLOBALS['strOldPassword']			= "Old Password";
$GLOBALS['strNewPassword']			= "New Password";
$GLOBALS['strInvalidUsername']			= "Invalid username";
$GLOBALS['strInvalidPassword']			= "Invalid password";

$GLOBALS['strBasicInformation']			= "Basic information";
$GLOBALS['strAdminFullName']			= "Admin's full name";
$GLOBALS['strAdminEmail']			= "Admin's email address";
$GLOBALS['strCompanyName']			= "Company Name";

$GLOBALS['strAdminCheckUpdates']		= "Check for updates";
$GLOBALS['strAdminCheckEveryLogin']		= "Every login";
$GLOBALS['strAdminCheckDaily']			= "Daily";
$GLOBALS['strAdminCheckWeekly']			= "Weekly";
$GLOBALS['strAdminCheckMonthly']		= "Monthly";
$GLOBALS['strAdminCheckNever']			= "Never";

$GLOBALS['strAdminNovice']			= "Admin's delete actions need confirmation for safety";
$GLOBALS['strUserlogEmail']			= "Log all outgoing email messages";
$GLOBALS['strUserlogPriority']			= "Log hourly priority calculations";
$GLOBALS['strUserlogAutoClean']			= "Log automatic cleaning of database";


// User interface settings
$GLOBALS['strGuiSettings']			= "User Interface Configuration";

$GLOBALS['strGeneralSettings']			= "General settings";
$GLOBALS['strAppName']				= "Application Name";
$GLOBALS['strMyHeader']				= "My Header";
$GLOBALS['strMyFooter']				= "My Footer";
$GLOBALS['strGzipContentCompression']		= "Use GZIP content compression";

$GLOBALS['strClientInterface']			= "Advertiser interface";
$GLOBALS['strClientWelcomeEnabled']		= "Enable advertiser welcome message";
$GLOBALS['strClientWelcomeText']		= "Welcome text<br>(HTML tags allowed)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Interface defaults";

$GLOBALS['strInventory']			= "Inventory";
$GLOBALS['strShowCampaignInfo']			= "Show extra campaign info on <i>Campaign overview</i> page";
$GLOBALS['strShowBannerInfo']			= "Show extra banner info on <i>Banner overview</i> page";
$GLOBALS['strShowCampaignPreview']		= "Show preview of all banners on <i>Banner overview</i> page";
$GLOBALS['strShowBannerHTML']			= "Show actual banner instead of plain HTML code for HTML banner preview";
$GLOBALS['strShowBannerPreview']		= "Show banner preview at the top of pages which deals with banners";
$GLOBALS['strHideInactive']			= "Hide inactive items from all overview pages";
$GLOBALS['strGUIShowMatchingBanners']		= "Show matching banners on the <i>Linked banner</i> pages";
$GLOBALS['strGUIShowParentCampaigns']		= "Show parent campaigns on the <i>Linked banner</i> pages";
$GLOBALS['strGUILinkCompactLimit']		= "Hide non-linked campaigns or banners on the <i>Linked banner</i> pages when there are more than";

$GLOBALS['strStatisticsDefaults'] 		= "Statistics";
$GLOBALS['strBeginOfWeek']			= "Begin of Week";
$GLOBALS['strPercentageDecimals']		= "Percentage Decimals";

$GLOBALS['strWeightDefaults']			= "Default weight";
$GLOBALS['strDefaultBannerWeight']		= "Default banner weight";
$GLOBALS['strDefaultCampaignWeight']		= "Default campaign weight";
$GLOBALS['strDefaultBannerWErr']		= "Default banner weight should be a positive integer";
$GLOBALS['strDefaultCampaignWErr']		= "Default campaign weight should be a positive integer";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']				= "Time Zone";

?>