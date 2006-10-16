<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				= "Install";
$GLOBALS['strChooseInstallLanguage']		= "Choose language for the installation procedure";
$GLOBALS['strLanguageSelection']		= "Language selection";
$GLOBALS['strDatabaseSettings']			= "Database settings";
$GLOBALS['strAdminSettings']			= "Administrator settings";
$GLOBALS['strAdvancedSettings']			= "Advanced database settings";
$GLOBALS['strOtherSettings']			= "Other settings";
$GLOBALS['strLicenseInformation']		= "License information";
$GLOBALS['strAdministratorAccount']		= "The administrator account";
$GLOBALS['strDatabasePage']				= "The ".$phpAds_dbmsname." database";
$GLOBALS['strInstallWarning']			= "Server and integrity check";
$GLOBALS['strCongratulations']			= "Congratulations!";
$GLOBALS['strInstallFailed']			= "Installation failed!";
$GLOBALS['strSpecifyAdmin']				= "Configure the administrator account";
$GLOBALS['strSpecifyLocaton']			= "Specify the location of ".$phpAds_productname." on the server";


$GLOBALS['strWarning']				= "Warning";
$GLOBALS['strFatalError']			= "A fatal error occurred";
$GLOBALS['strUpdateError']			= "An error occured while updating";
$GLOBALS['strUpdateDatabaseError']	= "Due to unknown reasons the update of the database structure wasn't succesful. The recommended way to proceed is to click <b>Retry updating</b> to try to correct these potential problems. If you are sure these errors won't affect the functionality of ".$phpAds_productname." you can click <b>Ignore errors</b> to continue. Ignoring these errors may cause serious problems and is not recommended!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." is already installed on this system. If you want to configure it go to <a href='settings-index.php'>settings interface</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Could not connect to the database, please recheck the settings you specified. Also make sure that a database with the name you specified already exists on the database server. ".$phpAds_productname." will not create the database for you, you must create it manually before running the installer.";
$GLOBALS['strCreateTableTestFailed']		= "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']		= "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']		= "Table prefix contains invalid characters";
$GLOBALS['strTableInUse']			= "The database which you specified is already used for ".$phpAds_productname.", please use a different table prefix, or read the manual for upgrading instructions.";
$GLOBALS['strTableWrongType']		= "The table type you selected isn't supported by your installation of ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Before you continue, please correct these potential problems:";
$GLOBALS['strFixProblemsBefore']		= "The following item(s) need to be corrected before you can install ".$phpAds_productname.". If you have any questions about this error message, please read the <i>Administrator guide</i>, which is part of the package you downloaded.";
$GLOBALS['strFixProblemsAfter']			= "If you are not able to correct the problems listed above, please contact the administrator of the server you are trying to install ".$phpAds_productname." on. The administrator of the server may be able to help you.";
$GLOBALS['strIgnoreWarnings']			= "Ignore warnings";
$GLOBALS['strWarningDBavailable']		= "The version of PHP you are using doesn't have support for connecting to a ".$phpAds_dbmsname." database server. You need to enable the PHP ".$phpAds_dbmsname." extension before you can proceed.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requires PHP 4.0.3 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningPHP5beta']			= "You trying to install ".$phpAds_productname." on a server running an early test version of PHP 5. These versions are not indended for production use and usually contain bugs. It is not recommended to run ".$phpAds_productname." on PHP 5, except for testing purposes.";
$GLOBALS['strWarningRegisterGlobals']		= "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningMagicQuotesGPC']		= "The PHP configuration variable magic_quotes_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strWarningMagicQuotesSybase']	= "The PHP configuration variable magic_quotes_sybase needs to be turned off.";
$GLOBALS['strWarningFileUploads']		= "The PHP configuration variable file_uploads needs to be turned on.";
$GLOBALS['strWarningTrackVars']			= "The PHP configuration variable track_vars needs to be turned on.";
$GLOBALS['strWarningPREG']				= "The version of PHP you are using doesn't have support for PERL compatible regular expressions. You need to enable the PREG extension before you can proceed.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." has detected that your <b>config.inc.php</b> file is not writeable by the server. You can't proceed until you change permissions on the file. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCacheLockedDetected']		= "You are using Files delivery caching and ".$phpAds_productname." has detected that the <b>cache</b> directory is not writeable by the server. You can't proceed until you change permissions of the folder. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strIgnoreErrors']			= "Ignore errors";
$GLOBALS['strRetry']				= "Retry";
$GLOBALS['strRetryUpdate']			= "Retry updating";
$GLOBALS['strTableNames']			= "Table Names";
$GLOBALS['strTablesPrefix']			= "Table names prefix";
$GLOBALS['strTablesType']			= "Table type";

$GLOBALS['strRevCorrupt']			= "The file <b>{filename}</b> is corrupt or has been modified. If you did not modify this file, please try to upload a new copy of this file to your server. If you modified this file yourself, you can safely ignore this warning.";
$GLOBALS['strRevTooOld']			= "The file <b>{filename}</b> is older than the one that is supposed to be used with this version of ".$phpAds_productname.". Please try to upload a new copy of this file to the server.";
$GLOBALS['strRevMissing']			= "The file <b>{filename}</b> could not be checked because it is missing. Please try to upload a new copy of this file to the server.";
$GLOBALS['strRevCVS']				= "You are trying to install a CVS checkout of ".$phpAds_productname.". This is not an official release and may be unstable or even non-functional. Are you sure you want to continue?";

$GLOBALS['strInstallWelcome']			= "Welcome to ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallMessageCheck']		= $phpAds_productname." has checked the integrity of the files you uploaded to the server and has checked wether the server is capable of running ".$phpAds_productname.". The following item(s) need your attention before you can continue.";
$GLOBALS['strInstallMessageAdmin']		= "Before you can continue you need to setup the administrator account. You can use this account to log into the administrator interface and manage your inventory and view statistics.";
$GLOBALS['strInstallMessageDatabase']	= $phpAds_productname." uses a ".$phpAds_dbmsname." database store the inventory and all of the statistics. Before you can continue you need to tell us which server you want to use and which username and password ".$phpAds_productname." needs to use to contact the server. If you do not know which information you should provide here, please contact the administrator of your server.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesful.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
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
$GLOBALS['strInvalidUserPwd']			= "Invalid username or password";

$GLOBALS['strUpgrade']				= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Your system is already up to date, no upgrade is needed at the moment. <br>Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']		= "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br><br>Depending on which version you are upgrading from and how many statistics are already stored in the database, this process can cause high load on your database server. Please be patient, the upgrade can take up to a couple of minutes.";
$GLOBALS['strSystemUpgradeBusy']		= "System upgrade in progress, please wait...";
$GLOBALS['strSystemRebuildingCache']		= "Rebuilding cache, please wait...";
$GLOBALS['strServiceUnavalable']		= "The service is temporarily unavailable. System upgrade in progress";

$GLOBALS['strConfigNotWritable']		= "Your config.inc.php file is not writable";
$GLOBALS['strPhpBug20144']				= "Your PHP version is affected by a <a href='http://bugs.php.net/bug.php?id=20114' target='_blank'>bug</a> which will prevent ".$phpAds_productname." from running correctly.
							Upgrading to PHP 4.3.0+ is required before installing ".$phpAds_productname.".";
$GLOBALS['strPhpBug24652']				= "You trying to install ".$phpAds_productname." on a server running an early test version of PHP 5.
										   These versions are not indended for production use and usually contain bugs.
										   One of these bugs prevents ".$phpAds_productname." from running correctly.
										   This <a href='http://bugs.php.net/bug.php?id=24652' target='_blank'>bug</a> is already fixed
										   and the final version of PHP 5 is not affected by this bug.";





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
$GLOBALS['strDatabaseSettings']			= "Database settings";
$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbLocal']				= "Connect to local server using sockets"; // Pg only
$GLOBALS['strDbHost']				= "Database hostname";
$GLOBALS['strDbPort']				= "Database port number";
$GLOBALS['strDbUser']				= "Database username";
$GLOBALS['strDbPassword']			= "Database password";
$GLOBALS['strDbName']				= "Database name";

$GLOBALS['strDatabaseOptimalisations']		= "Database optimalisations";
$GLOBALS['strPersistentConnections']		= "Use persistent connections";
$GLOBALS['strInsertDelayed']			= "Use delayed inserts";
$GLOBALS['strCompatibilityMode']		= "Use database compatibility mode";
$GLOBALS['strMysql4Compatibility']		= "Use MySQL 4 SQL mode to ensure that phpAdsNew will correctly work";
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

$GLOBALS['strUseAcl']				= "Evaluate delivery limitations during delivery";

$GLOBALS['strDeliverySettings']			= "Delivery settings";
$GLOBALS['strCacheType']				= "Delivery cache type";
$GLOBALS['strCacheFiles']				= "Files";
$GLOBALS['strCacheDatabase']			= "Database";
$GLOBALS['strCacheShmop']				= "Shared memory/Shmop";
$GLOBALS['strCacheSysvshm']				= "Shared memory/Sysvshm";
$GLOBALS['strExperimental']				= "Experimental";
$GLOBALS['strKeywordRetrieval']			= "Keyword retrieval";
$GLOBALS['strBannerRetrieval']			= "Banner retrieval method";
$GLOBALS['strRetrieveRandom']			= "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']			= "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']				= "Full sequential banner retrieval";
$GLOBALS['strUseConditionalKeys']		= "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']			= "Allow multiple keywords when using direct selection";

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
$GLOBALS['strTypeFTPErrorDir']			= "The host directory does not exist";
$GLOBALS['strTypeFTPErrorConnect']		= "Could not connect to the FTP server, the login or password are not correct";
$GLOBALS['strTypeFTPErrorHost']			= "The hostname of the FTP server is not correct";
$GLOBALS['strTypeDirError']				= "The local directory does not exist";

$GLOBALS['strDefaultBanners']			= "Default banners";
$GLOBALS['strDefaultBannerUrl']			= "Default image URL";
$GLOBALS['strDefaultBannerTarget']		= "Default destination URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner options";
$GLOBALS['strTypeHtmlAuto']			= "Automatically alter HTML banners in order to force click tracking";
$GLOBALS['strTypeHtmlPhp']			= "Allow PHP expressions to be executed from within a HTML banner";

$GLOBALS['strCookieSettings']			= "Cookie settings";
$GLOBALS['strPackCookies']				= "Pack cookies to avoid cookie overpopulation";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Host information and Geotargeting";

$GLOBALS['strRemoteHost']				= "Remote host";
$GLOBALS['strReverseLookup']			= "Try to determine the hostname of the visitor if it is not supplied by the server";
$GLOBALS['strProxyLookup']				= "Try to determine the real IP address of the visitor if he is using a proxy server";

$GLOBALS['strGeotargeting']				= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Type of geotargeting database";
$GLOBALS['strGeotrackingLocation'] 		= "Geotargeting database location";
$GLOBALS['strGeotrackingLocationError'] = "The geotargeting database does not exist in the location you specified";
$GLOBALS['strGeotrackingLocationNoHTTP']	= "The location you supplied is not a local directory on the hard drive of the server, but an URL to a file on a webserver. The location should look similar to this: <i>{example}</i>. The actual location depends on where you copied the database.";
$GLOBALS['strGeotrackingUnsupportedDB'] = "The geotargeting database supplied is not supported by this plug-in";
$GLOBALS['strGeoStoreCookie']			= "Store the result in a cookie for future reference";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statistics Settings";

$GLOBALS['strStatisticsFormat']			= "Statistics format";
$GLOBALS['strCompactStats']				= "Statistics format";
$GLOBALS['strLogAdviews']				= "Log an AdView everytime a banner is delivered";
$GLOBALS['strLogAdclicks']				= "Log an AdClick everytime a visitor clicks on a banner";
$GLOBALS['strLogSource']				= "Log the source parameter specified during invocation";
$GLOBALS['strGeoLogStats']				= "Log the country of the visitor in the statistics";
$GLOBALS['strLogHostnameOrIP']			= "Log the hostname or IP address of the visitor";
$GLOBALS['strLogIPOnly']				= "Only log the IP address of the visitor even if the hostname is known";
$GLOBALS['strLogIP']					= "Log the IP address of the visitor";
$GLOBALS['strLogBeacon']				= "Use a small beacon image to log AdViews to ensure only delivered banners are logged";

$GLOBALS['strRemoteHosts']				= "Remote hosts";
$GLOBALS['strIgnoreHosts']				= "Don't store statistics for visitors using one of the following IP addresses or hostnames";
$GLOBALS['strBlockAdviews']				= "Don't log AdViews if the visitor already seen the same banner within the specified number of seconds";
$GLOBALS['strBlockAdclicks']			= "Don't log AdClicks if the visitor already clicked on the same banner within the specified number of seconds";


$GLOBALS['strPreventLogging']			= "Prevent logging";
$GLOBALS['strEmailWarnings']			= "E-mail warnings";
$GLOBALS['strAdminEmailHeaders']		= "Add the following headers to each e-mail message sent by ".$phpAds_productname;
$GLOBALS['strWarnLimit']				= "Send a warning when the number of impressions left are less than specified here";
$GLOBALS['strWarnLimitErr']				= "Warn Limit should be a positive number";
$GLOBALS['strWarnLimitDays']			= "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnLimitDaysErr']			= "Warn Limit Days should be a positive number";
$GLOBALS['strWarnAdmin']				= "Send a warning to the administrator every time a campaign is almost expired";
$GLOBALS['strWarnClient']				= "Send a warning to the advertiser every time a campaign is almost expired";
$GLOBALS['strQmailPatch']				= "Enable qmail patch";

$GLOBALS['strAutoCleanTables']			= "Database pruning";
$GLOBALS['strAutoCleanStats']			= "Prune statistics";
$GLOBALS['strAutoCleanUserlog']			= "Prune user log";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maximum age of statistics <br>(3 weeks minimum)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "Maximum age of user log <br>(3 weeks minimum)";
$GLOBALS['strAutoCleanErr']				= "Maximum age must be at least 3 weeks";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Administrator settings";

$GLOBALS['strLoginCredentials']			= "Login credentials";
$GLOBALS['strAdminUsername']			= "Admin's username";
$GLOBALS['strInvalidUsername']			= "Invalid username";

$GLOBALS['strBasicInformation']			= "Basic information";
$GLOBALS['strAdminFullName']			= "Full name";
$GLOBALS['strAdminEmail']			= "Email address";
$GLOBALS['strCompanyName']			= "Company name";

$GLOBALS['strAdminCheckUpdates']		= "Check for updates";
$GLOBALS['strAdminCheckEveryLogin']		= "Every login";
$GLOBALS['strAdminCheckDaily']			= "Daily";
$GLOBALS['strAdminCheckWeekly']			= "Weekly";
$GLOBALS['strAdminCheckMonthly']		= "Monthly";
$GLOBALS['strAdminCheckNever']			= "Never";
$GLOBALS['strAdminCheckDevBuilds']		= "Prompt for newly released development versions";

$GLOBALS['strAdminNovice']			= "Admin's delete actions need confirmation for safety";
$GLOBALS['strUserlogEmail']			= "Log all outgoing email messages";
$GLOBALS['strUserlogPriority']			= "Log hourly priority calculations";
$GLOBALS['strUserlogAutoClean']			= "Log automatic cleaning of database";


// User interface settings
$GLOBALS['strGuiSettings']			= "User Interface Configuration";

$GLOBALS['strGeneralSettings']			= "General settings";
$GLOBALS['strAppName']				= "Application Name";
$GLOBALS['strMyHeader']				= "Header file location";
$GLOBALS['strMyHeaderError']		= "The header file does not exist in the location you specified";
$GLOBALS['strMyFooter']				= "Footer file location";
$GLOBALS['strMyFooterError']		= "The footer file does not exist in the location you specified";
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