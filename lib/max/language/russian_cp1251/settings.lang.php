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

// Installer translation strings
$GLOBALS['strInstall']					= "";
$GLOBALS['strChooseInstallLanguage']	= "    ";
$GLOBALS['strLanguageSelection']		= " ";
$GLOBALS['strDatabaseSettings']			= "  ";
$GLOBALS['strAdminSettings']			= " ";
$GLOBALS['strAdvancedSettings']			= " ";
$GLOBALS['strOtherSettings']			= " ";

$GLOBALS['strWarning']					= "";
$GLOBALS['strFatalError']				= "  ";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew     .     ,   <a href='settings-index.php'> </a>";
$GLOBALS['strCouldNotConnectToDB']		= "     ,    ";
$GLOBALS['strCreateTableTestFailed']	= "           , ,    .";
$GLOBALS['strUpdateTableTestFailed']	= "          , ,    .";
$GLOBALS['strTablePrefixInvalid']		= "      ";
$GLOBALS['strTableInUse']				= "       phpAdsNew, ,      ,       .";
$GLOBALS['strMayNotFunction']			= "   , ,    :";
$GLOBALS['strIgnoreWarnings']			= " ";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew     PHP 3.0.8  .    {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "  PHP register_globals    (on).";
$GLOBALS['strWarningMagicQuotesGPC']	= "  PHP magic_quotes_gpc    (on).";
$GLOBALS['strWarningMagicQuotesRuntime']= "  PHP magic_quotes_runtime    (on).";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew ,    <b>config.inc.php</b>     .<br>    ,        . <br>  ,    ,   .";
$GLOBALS['strCantUpdateDB']  			= "     .    ,   ,       .";
$GLOBALS['strTableNames']				= " ";
$GLOBALS['strTablesPrefix']				= "   ";
$GLOBALS['strTablesType']				= " ";

$GLOBALS['strInstallWelcome']			= "   phpAdsNew";
$GLOBALS['strInstallMessage']			= "      phpAdsNew,     <br>  . ٸ <b></b>  .";
$GLOBALS['strInstallSuccess']			= "<b> phpAdsNew ..</b><br><br>   phpAdsNew   
										   ,      .          .
										   <br><br>ٸ <b></b>     ,    
										     . ,     config.inc.php,      -     .";
$GLOBALS['strInstallNotSuccessful']		= "<b> phpAdsNew  </b><br><br>       .
										   ,    ,        <b></b>   
										      .               , 
										      .";
$GLOBALS['strErrorOccured']				= "  :";
$GLOBALS['strErrorInstallDatabase']		= "      .";
$GLOBALS['strErrorInstallConfig']		= "        .";
$GLOBALS['strErrorInstallDbConnect']	= "      .";

$GLOBALS['strUrlPrefix']				= " URL";

$GLOBALS['strProceed']					= " &gt;";
$GLOBALS['strRepeatPassword']			= " ";
$GLOBALS['strNotSamePasswords']			= "  ";
$GLOBALS['strInvalidUserPwd']			= "    ";

$GLOBALS['strUpgrade']					= "";
$GLOBALS['strSystemUpToDate']			= "    . <br>ٸ  <b></b>     .";
$GLOBALS['strSystemNeedsUpgrade']		= "            . ٸ <b></b>,    . <br> ?     .";
$GLOBALS['strSystemUpgradeBusy']		= "  ? ? ...";
$GLOBALS['strServiceUnavalable']		= "  .   ";

$GLOBALS['strConfigNotWritable']		= "  config.inc.php       ";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= " ";
$GLOBALS['strDayFullNames'] 			= array("","","","","","","");
$GLOBALS['strEditConfigNotPossible']    = "   ,        . ".
										  "    ,      onfig.inc.php.";
$GLOBALS['strEditConfigPossible']		= "   ,      ,         . ".
										  "     ,     config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "  ";
$GLOBALS['strDatabaseServer']			= "  ";
$GLOBALS['strDbHost']					= " ";
$GLOBALS['strDbUser']					= " ";
$GLOBALS['strDbPassword']				= "";
$GLOBALS['strDbName']					= "  ";

$GLOBALS['strDatabaseOptimalisations']	= "  ";
$GLOBALS['strPersistentConnections']	= "  ";
$GLOBALS['strInsertDelayed']			= "  ";
$GLOBALS['strCompatibilityMode']		= "     ";
$GLOBALS['strCantConnectToDb']			= "     ";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "   ";

$GLOBALS['strKeywordRetrieval']			= "   ";
$GLOBALS['strBannerRetrieval']			= "  ";
$GLOBALS['strRetrieveRandom']			= "  ( )";
$GLOBALS['strRetrieveNormalSeq']		= "  ";
$GLOBALS['strWeightSeq']				= "    ";
$GLOBALS['strFullSeq']					= "  ";
$GLOBALS['strUseConditionalKeys']		= "     ";
$GLOBALS['strUseMultipleKeys']			= "      ";
$GLOBALS['strUseAcl']					= "      ";

$GLOBALS['strDeliverySettings']                 = " ";
$GLOBALS['strCacheType']                                = "  ";
$GLOBALS['strCacheFiles']                               = "";
$GLOBALS['strCacheDatabase']                    = " ";
$GLOBALS['strCacheShmop']                               = "  (shmop)";

$GLOBALS['strZonesSettings']			= " ";
$GLOBALS['strZoneCache']				= "  (      )";
$GLOBALS['strZoneCacheLimit']			= "    ( )";
$GLOBALS['strZoneCacheLimitErr']		= "        ";

$GLOBALS['strP3PSettings']				= " P3P (    ) ";
$GLOBALS['strUseP3P']					= " P3P-";
$GLOBALS['strP3PCompactPolicy']			= "  P3P";
$GLOBALS['strP3PPolicyLocation']		= "  P3P-";



// Banner Settings
$GLOBALS['strBannerSettings']			= " ";

$GLOBALS['strTypeHtmlSettings']			= " HTML-";
$GLOBALS['strTypeHtmlAuto']				= "  HTML-   ";
$GLOBALS['strTypeHtmlPhp']				= "  PHP-  HTML-";

$GLOBALS['strTypeWebSettings']			= " -";
$GLOBALS['strTypeWebMode']				= " ";
$GLOBALS['strTypeWebModeLocal']			= "  (   )";
$GLOBALS['strTypeWebModeFtp']			= "FTP- (   FTP-)";
$GLOBALS['strTypeWebDir']				= "     -";
$GLOBALS['strTypeWebFtp']				= "  FTP-  -";
$GLOBALS['strTypeWebUrl']				= "  URL    FTP-";
$GLOBALS['strDefaultBanners']			= "  ";
$GLOBALS['strDefaultBannerUrl']			= "URL   ";
$GLOBALS['strDefaultBannerTarget']		= "   ";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= " ";

$GLOBALS['strStatisticsFormat']			= " ";
$GLOBALS['strLogBeacon']				= "    ";
$GLOBALS['strCompactStats']				= "  ";
$GLOBALS['strLogAdviews']				= " ";
$GLOBALS['strLogAdclicks']				= " ";

$GLOBALS['strGeotrackingType']                  = "    ";
$GLOBALS['strGeotrackingLocation']              = "    ";
$GLOBALS['strGeotargeting']                     = "";
$GLOBALS['strGeoLogStats']                      = "    ";
$GLOBALS['strGeoStoreCookie']           = "      ";


$GLOBALS['strEmailWarnings']			= "  ";
$GLOBALS['strAdminEmailHeaders']		= "        ";
$GLOBALS['strWarnLimit']				= "  ";
$GLOBALS['strWarnLimitErr']				= "       ";
$GLOBALS['strWarnAdmin']				= " ";
$GLOBALS['strWarnClient']				= " ";

$GLOBALS['strRemoteHosts']				= " ";
$GLOBALS['strIgnoreHosts']				= " ";
$GLOBALS['strReverseLookup']			= "  DNS";
$GLOBALS['strProxyLookup']				= " ";



// Administrator settings
$GLOBALS['strAdministratorSettings']	= " ";

$GLOBALS['strLoginCredentials']			= "    ";
$GLOBALS['strAdminUsername']			= " -";
$GLOBALS['strOldPassword']				= " ";
$GLOBALS['strNewPassword']				= " ";
$GLOBALS['strInvalidUsername']			= "  ";
$GLOBALS['strInvalidPassword']			= " ";

$GLOBALS['strBasicInformation']			= " ";
$GLOBALS['strAdminFullName']			= "  ";
$GLOBALS['strAdminEmail']				= "   ";
$GLOBALS['strCompanyName']				= " ";

$GLOBALS['strAdminNovice']				= "       ";



// User interface settings
$GLOBALS['strGuiSettings']				= "  ";

$GLOBALS['strGeneralSettings']			= " ";
$GLOBALS['strAppName']					= " ";
$GLOBALS['strMyHeader']					= " ";
$GLOBALS['strMyFooter']					= " ";

$GLOBALS['strClientInterface']			= " ";
$GLOBALS['strClientWelcomeEnabled']		= "    ";
$GLOBALS['strClientWelcomeText']		= "    <br>(  HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "   ";

$GLOBALS['strStatisticsDefaults'] 		= "";
$GLOBALS['strBeginOfWeek']				= " ";
$GLOBALS['strPercentageDecimals']		= " ";

$GLOBALS['strWeightDefaults']			= "  ";
$GLOBALS['strDefaultBannerWeight']		= "   ";
$GLOBALS['strDefaultCampaignWeight']	= "   ";
$GLOBALS['strDefaultBannerWErr']		= "        ";
$GLOBALS['strDefaultCampaignWErr']		= "        ";

$GLOBALS['strAllowedBannerTypes']		= "  ";
$GLOBALS['strTypeSqlAllow']				= " ,   SQL";
$GLOBALS['strTypeWebAllow']				= " ,   ";
$GLOBALS['strTypeUrlAllow']				= " URL-";
$GLOBALS['strTypeHtmlAllow']			= " HTML-";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "  ";
$GLOBALS['strTableBackColor']			= "  ";
$GLOBALS['strTableBackColorAlt']		= "   ";
$GLOBALS['strMainBackColor']			= "  ";
$GLOBALS['strOverrideGD']				= "     GD";
$GLOBALS['strTimeZone']					= " ";

?>
