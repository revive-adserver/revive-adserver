<?php // $Revision: 1.0 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']					= "Install";
$GLOBALS['strChooseInstallLanguage']	= "Choose language for the installation procedure";
$GLOBALS['strLanguageSelection']		= "Language Selection";
$GLOBALS['strDatabaseSettings']			= "Database Settings";
$GLOBALS['strAdminSettings']			= "Administrator Settings";
$GLOBALS['strAdvancedSettings']			= "Advanced Settings";
$GLOBALS['strOtherSettings']			= "Other settings";

$GLOBALS['strWarning']					= "Warning";
$GLOBALS['strFatalError']				= "A fatal error occurred";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew is already installed on this system. If you want to configure it go to <a href='settings-index.php'>settings interface</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Could not connect to database, please recheck the settings you specified";
$GLOBALS['strCreateTableTestFailed']	= "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']	= "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']		= "Table prefix contains invalid characters";

$GLOBALS['strInstallMessage']			= "You are about to install phpAdsNew on your system. Click <b>Proceed</b> to start.";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew has detected that your <b>config.inc.php</b> file is not writeable by the server.<br> You can't proceed until you change permissions on the file. <br>Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and clients will be deleted.";
$GLOBALS['strTableNames']				= "Table Names";
$GLOBALS['strTablesPrefix']				= "Table names prefix";
$GLOBALS['strTablesType']				= "Table type";

$GLOBALS['strUrlPrefix']				= "URL Prefix";

$GLOBALS['strProceed']					= "Proceed &gt;";
$GLOBALS['strInstallDatabase']			= "Database structure installation";
$GLOBALS['strFunctionAlreadyExists']	= "Function %s already exists";
$GLOBALS['strFunctionInAllDotSqlErr']	= "Can't create a function from 'all.sql'";
$GLOBALS['strFunctionClickProceed']		= "Would you like to overwrite existing functions?";
$GLOBALS['strYes']						= "Yes";
$GLOBALS['strNo']						= "No";
$GLOBALS['strDatabaseCreated']			= "Database structure successfully created:";
$GLOBALS['strTableCreated']				= "Table <b>%s</b> successfully created";
$GLOBALS['strSequenceCreated']			= "Sequence <b>%s</b> successfully created";
$GLOBALS['strIndexCreated']				= "Index <b>%s</b> successfully created";
$GLOBALS['strFunctionCreated']			= "Function <b>%s</b> successfully created";
$GLOBALS['strFunctionReplaced']			= "Function <b>%s</b> successfully replaced";
$GLOBALS['strUnknownStatementExec']		= "Unknown statement executed";
$GLOBALS['strAdminPasswordSetup']		= "Admin Password Setup";
$GLOBALS['strRepeatPassword']			= "Repeat Password";
$GLOBALS['strNotSamePasswords']			= "Passwords did not match";
$GLOBALS['strInvalidUserPwd']			= "Invalid username or password";
$GLOBALS['strInstallCompleted']			= "Installation completed";
$GLOBALS['strInstallCompleted2']		= "Click <b>Proceed</b> go to configuration page and set up the other settings.";

$GLOBALS['strUpgrade']					= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "System up to date, no upgrade needed at the moment. Click <a href='index.php'>here</a> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']		= "System needs to be upgraded. Click <b>Proceed</b> to start.<br><br>Please be patient, upgrade can take up to 2 minutes, so don't click it twice!";
$GLOBALS['strServiceUnavalable']		= "The service is temporarily unavailable. System upgrade in progress";
$GLOBALS['strDownloadConfig']			= "Download your <b>config.inc.php</b> and upload it to your server, then click <b>Proceed</b>.";
$GLOBALS['strDownload']					= "Download";

$GLOBALS['strConfigNotWritable']		= "Your config.inc.php file is not writable";

// Settings translation strings
$GLOBALS['strChooseSection']			= "Choose Section";

$GLOBALS['strDbHost']					= "Database hostname";
$GLOBALS['strDbUser']					= "Database username";
$GLOBALS['strDbPassword']				= "Database password";
$GLOBALS['strDbName']					= "Database name";
$GLOBALS['strPersistentConnections']	= "Use persistent connections";
$GLOBALS['strInsertDelayed']			= "Use delayed inserts";
$GLOBALS['strCantConnectToDb']			= "Can't connect to database";

$GLOBALS['strAdminUsername']			= "Admin's username";
$GLOBALS['strAdminFullName']			= "Admin's full name";
$GLOBALS['strAdminEmail']				= "Admin's email address";
$GLOBALS['strAdminEmailHeaders']		= "Mail Headers for the reflection of the sender of the daily ad reports";
$GLOBALS['strAdminNovice']				= "Admin's delete actions need confirmation for safety";
$GLOBALS['strOldPassword']				= "Old Password";
$GLOBALS['strNewPassword']				= "New Password";
$GLOBALS['strInvalidUsername']			= "Invalid username";
$GLOBALS['strInvalidPassword']			= "Invalid password";

$GLOBALS['strGuiSettings']				= "User Interface Configuration";
$GLOBALS['strMyHeader']					= "My Header";
$GLOBALS['strMyFooter']					= "My Footer";
$GLOBALS['strTableBorderColor']			= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strAppName']					= "Application Name";
$GLOBALS['strCompanyName']				= "Company Name";
$GLOBALS['strOverrideGD']				= "Override GD Imageformat";
$GLOBALS['strTimeZone']					= "Time Zone";

$GLOBALS['strDayFullNames'] = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");

$GLOBALS['strIgnoreHosts']				= "Ignore Hosts";
$GLOBALS['strWarnLimit']				= "Warn Limit";
$GLOBALS['strWarnLimitErr']				= "Warn Limit should be a positive integer";
$GLOBALS['strBeginOfWeek']				= "Begin of Week";
$GLOBALS['strPercentageDecimals']		= "Percentage Decimals";
$GLOBALS['strCompactStats']				= "Use Compact Stats";
$GLOBALS['strLogAdviews']				= "Log Adviews";
$GLOBALS['strLogAdclicks']				= "Log Adclicks";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strWarnAdmin']				= "Warn Admin";
$GLOBALS['strWarnClient']				= "Warn Client";

$GLOBALS['strAllowedBannerTypes']		= "Allowed banner types";
$GLOBALS['strTypeSqlAllow']				= "Allow SQL stored banners";
$GLOBALS['strTypeWebAllow']				= "Allow Webserver stored banners";
$GLOBALS['strTypeUrlAllow']				= "Allow URL banners";
$GLOBALS['strTypeHtmlAllow']			= "Allow HTML banners";
$GLOBALS['strTypeWebSettings']			= "Web banners configuration";
$GLOBALS['strTypeWebMode']				= "Storing method";
$GLOBALS['strTypeWebModeLocal']			= "Local mode (stored in a local directory)";
$GLOBALS['strTypeWebModeFtp']			= "FTP mode (stored on a external FTP server)";
$GLOBALS['strTypeWebDir']				= "Local mode Web banner directory";
$GLOBALS['strTypeWebFtp']				= "FTP mode Web banner server";
$GLOBALS['strTypeWebUrl']				= "Public URL of local directory / FTP server";
$GLOBALS['strTypeHtmlSettings']			= "HTML banners configuration";
$GLOBALS['strTypeHtmlAuto']				= "Automatically change HTML banners in order to force click logging";
$GLOBALS['strTypeHtmlPhp']				= "Allow PHP expressions to be executed from within a HTML banner";

$GLOBALS['strBannerRetrieval']			= "Banner retrieval method";
$GLOBALS['strRetrieveRandom']			= "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']				= "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']					= "Full sequential banner retrieval";
$GLOBALS['strDefaultBannerUrl']			= "Default Banner URL";
$GLOBALS['strDefaultBannerTarget']		= "Default Banner Target";
$GLOBALS['strUseConditionalKeys']		= "Use conditional keywords";
$GLOBALS['strUseMultipleKeys']			= "Use multiple keywords";
$GLOBALS['strUseAcl']					= "Use display limitations";

$GLOBALS['strZonesSettings']			= "Zones Settings";
$GLOBALS['strZoneCache']				= "Cache zones, this should speed things up when using zones";
$GLOBALS['strZoneCacheLimit']			= "Time between cache updates (in seconds)";
$GLOBALS['strZoneCacheLimitErr']		= "Time between cache updates should be a positive integer";

$GLOBALS['strP3PSettings']				= "P3P Settings";
$GLOBALS['strUseP3P']					= "Use P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policy Location";

$GLOBALS['strClientWelcomeMessage']		= "Client Welcome Message";
$GLOBALS['strClientWelcomeEnabled']		= "Enable client welcome message";
$GLOBALS['strClientWelcomeText']		= "Client Welcome text<br>(HTML tags allowed)";

$GLOBALS['strDefaultBannerWeight']		= "Default banner weight";
$GLOBALS['strDefaultCampaignWeight']	= "Default campaign weight";

$GLOBALS['strDefaultBannerWErr']		= "Default banner weight should be a positive integer";
$GLOBALS['strDefaultCampaignWErr']		= "Default campaign weight should be a positive integer";

?>