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
$GLOBALS['strInstall']				= "����";
$GLOBALS['strChooseInstallLanguage']		= "��� �� ��� ������";
$GLOBALS['strLanguageSelection']		= "����� ���";
$GLOBALS['strDatabaseSettings']			= "������ ���� ������";
$GLOBALS['strAdminSettings']			= "������ ����";
$GLOBALS['strAdvancedSettings']			= "������ �������";
$GLOBALS['strOtherSettings']			= "������ �����";

$GLOBALS['strWarning']				= "�����";
$GLOBALS['strFatalError']			= "���� ����� ������";
$GLOBALS['strUpdateError']			= "��� ����� ���� ������";
$GLOBALS['strUpdateDatabaseError']	= "������ �� ������ ����� ���� ������� �� �����. ���� ������� ������ ��� ����� <b>��� ����� ����</b> ��� ����� ����� ����� �������. �� ��� ���� ������ ��� �� ������ ����� ������ ".$phpAds_productname." ��� ���� ����� <b>����� �������</b> ��� ������. ������� ������� ��� ���� ����� ���� ����� ��� �� �����!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." ��� ������ ������ ��. �� ��� ���� ���� ���� �� �<a href='settings-index.php'>������ ����</a>";
$GLOBALS['strCouldNotConnectToDB']		= "�� ���� ������ ����� �������, ��� ���� ���� �� ������� �����.";
$GLOBALS['strCreateTableTestFailed']		= "��� ������ ����� ��� ����� ����� ������ �� ����� ���� ���� �������, ��� ��� ��� �� ������ ����.";
$GLOBALS['strUpdateTableTestFailed']		= "��� ������ ����� ��� �� ����� ������ ���� �������. ��� ��� ��� �� �������.";
$GLOBALS['strTablePrefixInvalid']		= "������ ������� ����� ������ ������.";
$GLOBALS['strTableInUse']			= "���� ������� ����� ���� ��� ������ �� ".$phpAds_productname.", ��� ��� ������� ������ ����, �� ��� �� ������ ���� ������ �����.";
$GLOBALS['strTableWrongType']		= "��� ����� ����� ���� ���� ������ ".$phpAds_dbmsname."���";
$GLOBALS['strMayNotFunction']			= "���� ���� �����, ��� ��� �� ����� �������� ����:";
$GLOBALS['strFixProblemsBefore']		= "�����(��) ���(��) ������ ����� ���� ����� ���� ������ �� ".$phpAds_productname.". �� �� �� ���� ���� ���� ��, ��� ��� �� �<i>����� �������������</i>, ����� ������ ������.";
$GLOBALS['strFixProblemsAfter']			= "�� ��� �������� ���� �� ����� ������ ����, �� ��� �� �� ������ �� ���� ����� ��� ���� ������ �� ".$phpAds_productname.". ���� ���� ���� ����� �� �� ����� ������.";
$GLOBALS['strIgnoreWarnings']			= "����� �������";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." ���� PHP 4.0 �� ����� ����� ���� ��� ����� ����. ��� ����� ��� ������ {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "�����������  PHP �� ������ <B>register_globals</B> ����� ����� ������.";
$GLOBALS['strWarningMagicQuotesGPC']		= "�����������  PHP �� ������  <B>magic_quotes_gpc</B>  ����� ����� ������.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "�����������  PHP �� ������  <B>magic_quotes_runtime</B>  ����� ����� ������.";
$GLOBALS['strWarningFileUploads']		= "�����������  PHP �� ������  <B>file_uploads</B>  ����� ����� ������.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." ���� ������ <b>config.inc.php</b> ���� ������.<br> �� ���� ������ �� ����� �� ����� ����� ����� ��. <br>��� �� ������ ������ �� ���� ���� ���� ����� ���.";
$GLOBALS['strCantUpdateDB']  			= "�� ���� ����� �� ���� ������� ���� �� ����� ������, �� ������� �������, ��������� �������� �����.";
$GLOBALS['strIgnoreErrors']			= "����� �������";
$GLOBALS['strRetryUpdate']			= "��� ����� ����";
$GLOBALS['strTableNames']			= "���� �������";
$GLOBALS['strTablesPrefix']			= "������ �� ������";
$GLOBALS['strTablesType']			= "���� �������";

$GLOBALS['strInstallWelcome']			= "������ ����� �".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "���� ������ �-".$phpAds_productname." �� ���� �� ������ ������ ����� ���� ������.<br>��� <b>����</b> ��������.";
$GLOBALS['strInstallSuccess']			= "<b>������ �� ".$phpAds_productname." ������� ���� ��.</b><br><br>��� �- ".$phpAds_productname." ����� ���� ���� �� ����� ����� ������� ���� �� ���. ���� ���� ����� ���� �� ���� ����� ������ ������. <br><br>��� <b>����</b> ��� ����� ����� ������/������, ���� ����� ����� ������ ������. ��� �� ���� ����� �� ����� <B> config.inc.php</B> ���� ������, ��� ����� ������ ������� ����.";
$GLOBALS['strUpdateSuccess']			= "<b>������ �� ".$phpAds_productname." ������ ������.</b><br><br>��� �-".$phpAds_productname." ����� ���� ���� �� ������ ����� ������� ���� �� ��� (�� ��� ��� ���� ���� ��� ����) ���� ���� ����� �� ���� ����� ������ ������. <br><br>��� <b>����</b> ��� ����� ����� ���� ������. ��� �� ���� ����� �� �����  <B>config.inc.php</B> ������ ����� �����.";
$GLOBALS['strInstallNotSuccessful']		= "<b>������ �� ".$phpAds_productname."�� ������</b><br><br>����� ������� ������ ������ �� ������. ���� ������ ��� �� ������ ����, ����� �� ���� ��� <b>����</b> ������ ���� ������ �� ����� ������. �� ��� ���� ���� ���� �� ������ ������ ������ ���, ����� ����� ����, ��� ������ ������ ������.";
$GLOBALS['strErrorOccured']			= "������ ���� ����:";
$GLOBALS['strErrorInstallDatabase']		= "���� ���� ������� �� ��� �������.";
$GLOBALS['strErrorInstallConfig']		= "���� ������������ �� ���� ������� �� ���� �������.";
$GLOBALS['strErrorInstallDbConnect']		= "�� ���� ��� ������ ����� �������.";

$GLOBALS['strUrlPrefix']			= "������ URL";

$GLOBALS['strProceed']				= "���� &gt;";
$GLOBALS['strInvalidUserPwd']			= "�� ����� �� ����� ������";

$GLOBALS['strUpgrade']				= "�����";
$GLOBALS['strSystemUpToDate']			= "������ ��� ����� �������, �� ���� ����� ���� ��. <br>��� �� <b>����</b> ��� ����� ����� ����.";
$GLOBALS['strSystemNeedsUpgrade']		= "���� ���� ������� ����� ������������ ������ ������ ��� ������� ����� �����.<br>��� ����� ������� ����� ������ ������ ���� ���� ��� ����.";
$GLOBALS['strSystemUpgradeBusy']		= "����� ����� ������ �������, ��� ����...";
$GLOBALS['strSystemRebuildingCache']		= "���� �� ����� ������ ����, ��� ����...";
$GLOBALS['strServiceUnavalable']		= "������ ���� ����� �����. ����� ����� ������ �������";

$GLOBALS['strConfigNotWritable']		= "���� �-<B>config.inc.php</B> ���� ���� ������.";






/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "��� �����";
$GLOBALS['strDayFullNames'] 			= array("�����","���","�����","�����","�����","����","���");
$GLOBALS['strEditConfigNotPossible']    	= "�� ���� ����� ������ ��� ����� ����� ������������ ���� ������ ���������.<br> "."�� ������ ����� �������, ���� ����� ���� �� ������";
$GLOBALS['strEditConfigPossible']		= "���� ����� �� �� ������� ����� ����� ������������ ���� ����.<br>������ ���� ������� ��� ��� �� ����� <B> config.inc.php</B>.";
;



// Database
$GLOBALS['strDatabaseSettings']			= "������ ���� ������";
$GLOBALS['strDatabaseServer']			= "��� ���� �������";
$GLOBALS['strDbLocal']				= "����� ���� ������ ������� ������ (sockets)"; 
$GLOBALS['strDbHost']				= "���� �����";
$GLOBALS['strDbPort']				= "���� ����� �� ���� ������� (port)";
$GLOBALS['strDbUser']				= "�� ������ ����� �������";
$GLOBALS['strDbPassword']			= "������ �� ���� �������";
$GLOBALS['strDbName']				= "��� �� ���� �������";

$GLOBALS['strDatabaseOptimalisations']		= "����� ���� �������";
$GLOBALS['strPersistentConnections']		= " ����� ������ ���� (���� ������� ���� ����)";
$GLOBALS['strInsertDelayed']			= " ����� ������ ���� ����� (���� ������� ���� ���� ������ �������)";
$GLOBALS['strCompatibilityMode']		= " ����� ������� ���� ������";
$GLOBALS['strCantConnectToDb']			= " �� ����� ������ ����� �������";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "������ ����� ����� �� ������";

$GLOBALS['strAllowedInvocationTypes']		= "���� ����� ������";
$GLOBALS['strAllowRemoteInvocation']		= " ���� ����� ������";
$GLOBALS['strAllowRemoteJavascript']		= " ���� ����� ������ �� ��� Javascript";
$GLOBALS['strAllowRemoteFrames']		= " ���� ����� ������ ���� ������";
$GLOBALS['strAllowRemoteXMLRPC']		= " ���� ����� ������ �� ��� XML-RPC";
$GLOBALS['strAllowLocalmode']			= " ���� ����� ������";
$GLOBALS['strAllowInterstitial']		= " ���� ������ ����";
$GLOBALS['strAllowPopups']			= " ���� ������ ������";

$GLOBALS['strUseAcl']				= " ����� ������� �����";

$GLOBALS['strDeliverySettings']			= "������ �����";
$GLOBALS['strCacheType']				= "��� ����� ������";
$GLOBALS['strCacheFiles']				= "�����";
$GLOBALS['strCacheDatabase']			= "���� ������";
$GLOBALS['strCacheShmop']				= "����� �����/Shmop";
$GLOBALS['strCacheSysvshm']				= "����� �����/Sysvshm";
$GLOBALS['strExperimental']				= "������";

$GLOBALS['strKeywordRetrieval']			= "����� ��� ����� ����";
$GLOBALS['strBannerRetrieval']			= " ���� ����� �������";
$GLOBALS['strRetrieveRandom']			= " ����� ������ (����� ����)";
$GLOBALS['strRetrieveNormalSeq']		= " ����� ������ �����";
$GLOBALS['strWeightSeq']			= " ����� ������ ����� ����";
$GLOBALS['strFullSeq']				= " ����� ������ ����";
$GLOBALS['strUseConditionalKeys']		= " ����� ������ ����";
$GLOBALS['strUseMultipleKeys']			= " ����� ������ ����� ����";

$GLOBALS['strZonesSettings']			= "����� ������";
$GLOBALS['strZoneCache']			= " ����� ����� �����. (���� ����� �� ������ ������ ����.)";
$GLOBALS['strZoneCacheLimit']			= " ���� ���� ������ ����� ����� (������)";
$GLOBALS['strZoneCacheLimitErr']		= " ���� ���� ������ ����� ����� ���� ����� ���� �����";

$GLOBALS['strP3PSettings']			= "������� ������ ���� P3P";
$GLOBALS['strUseP3P']				= " ����� �������� P3P";
$GLOBALS['strP3PCompactPolicy']			= "������ P3P ��������";
$GLOBALS['strP3PPolicyLocation']		= "����� ������ �-P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "������ ������";

$GLOBALS['strAllowedBannerTypes']		= "���� ������ ������";
$GLOBALS['strTypeSqlAllow']			= " ���� ������ ������� (SQL)";
$GLOBALS['strTypeWebAllow']			= " ���� ������ ������� (Webserver)";
$GLOBALS['strTypeUrlAllow']			= " ���� ������ ��������";
$GLOBALS['strTypeHtmlAllow']			= " ���� ������ ���� HTML";
$GLOBALS['strTypeTxtAllow']			= " ���� ������ ����������";

$GLOBALS['strTypeWebSettings']			= "������������ ���� ����� (����)";
$GLOBALS['strTypeWebMode']			= "���� ������";
$GLOBALS['strTypeWebModeLocal']			= "������ ������";
$GLOBALS['strTypeWebModeFtp']			= "��� FTP ������";
$GLOBALS['strTypeWebDir']			= "������ ������";
$GLOBALS['strTypeWebFtp']			= "��� ������ ������ FTP";
$GLOBALS['strTypeWebUrl']			= "����� URL �������";
$GLOBALS['strTypeFTPHost']			= "���� FTP";
$GLOBALS['strTypeFTPDirectory']			= "������ FTP";
$GLOBALS['strTypeFTPUsername']			= "�� �����";
$GLOBALS['strTypeFTPPassword']			= "�����";

$GLOBALS['strTypeFTPErrorDir']			= "������ ���� ���� �����";
$GLOBALS['strTypeFTPErrorConnect']		= "�� ���� ��� ������ ���� �-FTP, �� ������ �� ������ ������";
$GLOBALS['strTypeFTPErrorHost']			= "�� ��� �-FTP ���� ����";
$GLOBALS['strTypeFTPErrorDir']			= "����� ����� ���� �����";
$GLOBALS['strTypeFTPErrorConnect']		= "�� ���� ������ ���� �-FTP, �� ������ �� ������ ������";
$GLOBALS['strTypeFTPErrorHost']			= "�� ���� ����� �� �-FTP ����";
$GLOBALS['strTypeDirError']				= "������� ������� ���� �����";



$GLOBALS['strDefaultBanners']			= "������ ������ ���� ������";
$GLOBALS['strDefaultBannerUrl']			= "����� URL �� ���� �����";
$GLOBALS['strDefaultBannerTarget']		= "����� URL ����� ������";

$GLOBALS['strTypeHtmlSettings']			= "������� ���� HTML";
$GLOBALS['strTypeHtmlAuto']			= " ��� �� ���� �������� ��� ����� ���� ��� ������.";
$GLOBALS['strTypeHtmlPhp']			= " ���� ����� ������ PHP ���� ������ ���� HTML ";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "���� ����� ����� �������� (Geotargeting)";
$GLOBALS['strRemoteHosts']			= "����� �������";

$GLOBALS['strReverseLookup']			= "��� ����� �� ����� ������ �� ����� �� ����� �� ���� �����";
$GLOBALS['strProxyLookup']				= "��� ����� �� ����� �-IP ������� �� ����� �� ��� ����� ����� ������ (proxy).";

$GLOBALS['strGeotargeting']				= "Geotargeting - ����� ��������";
$GLOBALS['strGeotrackingType']			= "��� ���� ����";
$GLOBALS['strGeotrackingLocation'] 		= "����� ���� ����";
$GLOBALS['strGeotrackingLocationError'] = "���� ������� �� ���� �������� ���� ���� ������ �����";
$GLOBALS['strGeoStoreCookie']			= "���� �� ������ ����� (cookie) �������� ������";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "������ ���������";

$GLOBALS['strStatisticsFormat']			= "����� ���������";
$GLOBALS['strCompactStats']			= " ����� ���������� ��������";
$GLOBALS['strLogAdviews']			= " ��� ������";
$GLOBALS['strLogAdclicks']				= "��� ����� ��� ��� ������ ���� �� ����";
$GLOBALS['strLogSource']				= "��� �� ����� ����� �������� ���� ������";
$GLOBALS['strGeoLogStats']				= "��� ���������� �� ���� ���� ���� �����";
$GLOBALS['strLogHostnameOrIP']			= "��� �� ����� ������ �� ����� �-IP �� �����";
$GLOBALS['strLogIPOnly']				= "��� �� ����� �-IP �� ����� ����� �� �� ������ ����";
$GLOBALS['strLogIP']					= "��� �� ����� �-IP �� �����";
$GLOBALS['strLogBeacon']			= " ����� ������ ������ ������";


$GLOBALS['strIgnoreHosts']				= "�� ���� ��������� ������� �������� ���� ������ �-IP �� ���� ������� �����";
$GLOBALS['strBlockAdviews']				= "�� ���� ������ �� ����� ��� ���� ����� ��� ����� ���� ������ �����.";
$GLOBALS['strBlockAdclicks']			= "�� ���� ������ �� ����� ��� ��� �� ���� ����� ����� ���� ������ �����";


$GLOBALS['strPreventLogging']			= "��� �������";
$GLOBALS['strEmailWarnings']			= "����� �������";
$GLOBALS['strAdminEmailHeaders']		= "���� �� ������ ���� ��� ������ ����� �� ��� ".$phpAds_productname;
$GLOBALS['strWarnLimit']				= "��� ����� ���� ���� ������� ����� ���� ���� ������ ���";

$GLOBALS['strWarnAdmin']			= " ��� ����� ���� ��� ��� ������ ������ ���� �����";
$GLOBALS['strWarnClient']			= " ��� ����� ����� ��� ��� ������� ��� ���� ����";
$GLOBALS['strQmailPatch']			= " ���� ���� qmail ";

$GLOBALS['strAutoCleanTables']			= " ����� ���� �������";
$GLOBALS['strAutoCleanStats']			= " ����� ���������";
$GLOBALS['strAutoCleanUserlog']			= " ����� ����� �����";
$GLOBALS['strAutoCleanStatsWeeks']		= " ��� ����� �� ��������� <br>(3 ������ �������)";
$GLOBALS['strAutoCleanUserlogWeeks']		= " ��� ����� �� ����� ����� <br>(3 ������ �������)";
$GLOBALS['strAutoCleanErr']			= " ��� ����� ���� ����� 3 ������ �����";
$GLOBALS['strAutoCleanVacuum']			= " ��� ������ ���� �������� �� ����"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "������ ������";

$GLOBALS['strLoginCredentials']			= "������ �������";
$GLOBALS['strAdminUsername']			= "�� ������ - ����";
$GLOBALS['strInvalidUsername']			= "�� ����� ����";

$GLOBALS['strBasicInformation']			= "���� �����";
$GLOBALS['strAdminFullName']			= "��� ���� �� �����";
$GLOBALS['strAdminEmail']			= "����� ������� �� �����";
$GLOBALS['strCompanyName']			= "�� �����/�����";

$GLOBALS['strAdminCheckUpdates']		= "���� �������";
$GLOBALS['strAdminCheckEveryLogin']		= "��� �������";
$GLOBALS['strAdminCheckDaily']			= "�����";
$GLOBALS['strAdminCheckWeekly']			= "������";
$GLOBALS['strAdminCheckMonthly']		= "������";
$GLOBALS['strAdminCheckNever']			= "�� ���";

$GLOBALS['strAdminNovice']			= " ������ ������ �� ����� ������ ����� ����� ������";
$GLOBALS['strUserlogEmail']			= " ��� �� �� ������� �����";
$GLOBALS['strUserlogPriority']			= " ��� �� ������ ��������� �� ���";
$GLOBALS['strUserlogAutoClean']			= " ��� ����� ������� �� ���� �������";


// User interface settings
$GLOBALS['strGuiSettings']			= "������ ���� �����";

$GLOBALS['strGeneralSettings']			= "������ ������";
$GLOBALS['strAppName']				= "�� ������ �����";
$GLOBALS['strMyHeader']				= "����� ����� ��� ����� ������:";
$GLOBALS['strMyHeaderError']		= "����� ����� �� ����� ������ �����";
$GLOBALS['strMyFooter']				= "����� ����� ��� ����� ������:";
$GLOBALS['strMyFooterError']		= "����� ����� �� ����� ������ �����";
$GLOBALS['strGzipContentCompression']		= "����� ������-����� GZIP";

$GLOBALS['strClientInterface']			= "���� �����";
$GLOBALS['strClientWelcomeEnabled']		= "���� ����� ����� ����� �������� ������";
$GLOBALS['strClientWelcomeText']		= "����� �����/���� ������ �����...<br>(����� ����� ���� HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "����� ���� ������";

$GLOBALS['strInventory']			= "����";
$GLOBALS['strShowCampaignInfo']			= " ��� ���� ���� ���� ������ ����� <i>����� ������</i>";
$GLOBALS['strShowBannerInfo']			= " ��� ���� ���� ���� ���� ����� <i>����� ������</i>";
$GLOBALS['strShowCampaignPreview']		= " ����� ����� �� �� ������� ����� <i>����� ������</i>";
$GLOBALS['strShowBannerHTML']			= " ��� ���� ���� ����� ��� ���� ��  HTML, ���� ����� ������ ���� HTML";
$GLOBALS['strShowBannerPreview']		= " ����� ������ �� ������ ������ ����� ����� �������";
$GLOBALS['strHideInactive']			= " ���� ����� �� ������ ��� ����� ����� ������";
$GLOBALS['strGUIShowMatchingBanners']		= " ��� ������ ������ ������ <i>������ �������</i>";
$GLOBALS['strGUIShowParentCampaigns']		= " ���� ������-�� ������ <i>������ �������</i>";
$GLOBALS['strGUILinkCompactLimit']		= " ���� �������� �� ������ �� ������, ������ <i>���� �����</i>, ���� �� ���� �-";

$GLOBALS['strStatisticsDefaults'] 		= "���������";
$GLOBALS['strBeginOfWeek']			= "����� ����� ����";
$GLOBALS['strPercentageDecimals']		= "����� �������";

$GLOBALS['strWeightDefaults']			= "���� ������ (����� ����)";
$GLOBALS['strDefaultBannerWeight']		= "���� ���� ������ (����� ����)";
$GLOBALS['strDefaultCampaignWeight']		= "���� ������ ������ (����� ����)";
$GLOBALS['strDefaultBannerWErr']		= "���� ������ �� ���� ���� ����� ���� �����";
$GLOBALS['strDefaultCampaignWErr']		= "���� ������ ������ ���� ����� ���� �����";


// Not used at the moment
$GLOBALS['strTableBorderColor']			= "��� ������ �� �����";
$GLOBALS['strTableBackColor']			= "��� ���� �� �����";
$GLOBALS['strTableBackColorAlt']		= "��� ����  �� �����(�����)";
$GLOBALS['strMainBackColor']			= "��� ��� ����";
$GLOBALS['strOverrideGD']			= "���� ����� ������ GD";
$GLOBALS['strTimeZone']				= "����� ���";


?>