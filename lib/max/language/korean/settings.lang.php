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
$GLOBALS['strInstall']				= "��ġ";
$GLOBALS['strChooseInstallLanguage']		= "��ġ�� ����� �� �����ϼ���.";
$GLOBALS['strLanguageSelection']		= "��� ����";
$GLOBALS['strDatabaseSettings']			= "�����ͺ��̽� ��d";
$GLOBALS['strAdminSettings']			= "���� ��d";
$GLOBALS['strAdvancedSettings']			= "��� ��d";
$GLOBALS['strOtherSettings']			= "��Ÿ ��d";

$GLOBALS['strWarning']				= "���";
$GLOBALS['strFatalError']			= "ġ������ �7� �߻��߽4ϴ�.";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."�� �̹� �ý��ۿ� ��ġ�Ǿ� �ֽ4ϴ�. ��d; �Ϸx� <a href='settings-index.php'>��d �������̽�</a>�� ����Ͻʽÿ�.";
$GLOBALS['strCouldNotConnectToDB']		= "�����ͺ��̽��� ������ �� ��4ϴ�. �Է��� ��d�� �´��� �ٽ� Ȯ���Ͻʽÿ�.";
$GLOBALS['strCreateTableTestFailed']		= "�Էµ� ����ڴ� �����ͺ��̽� ��v�� ���ϰų� ����Ʈ�� �� �ִ� ������ ��4ϴ�. �����ͺ��̽� ���ڿ��� �����Ͻʽÿ�.";
$GLOBALS['strUpdateTableTestFailed']		= "�Էµ� ����ڴ� �����ͺ��̽� ��v�� ����Ʈ�� �� �ִ� ������ ��4ϴ�. �����ͺ��̽� ���ڿ��� �����Ͻʽÿ�..";
$GLOBALS['strTablePrefixInvalid']		= "���̺� b�ξ�� ����� �� ��� ���ڰ� �ֽ4ϴ�.";
$GLOBALS['strTableInUse']			= "��d�� �����ͺ��̽��� �̹�".$phpAds_productname."���� ����ϰ� �ֽ4ϴ�. �ٸ� ���̺� b�ξ ����ϰų� ��׷��̵� ��ħ���� ����Ͻʽÿ�.";
$GLOBALS['strMayNotFunction']			= "��� �����ϱ� �� ��f�� ��d�Ͻʽÿ�. ��f�� ��d���� �ʰ� �����ϸ� ��f�� �߻��� �� �ֽ4ϴ�:";
$GLOBALS['strIgnoreWarnings']			= "��� ����";
$GLOBALS['strWarningDBavailable']		= "���� ������� PHP�� ".$phpAds_dbmsname." ����; ������� �ʽ4ϴ�. PHP ".$phpAds_dbmsname." Ȯ��; ��ġ�� ��=�� ��� �����Ͻʽÿ�.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requires PHP 4.0 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP ��d ���� register_globals�� ��d�ؾ� �մϴ�.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP ��d ���� magic_quotes_gpc�� ��d�ؾ� �մϴ�.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP ��d ���� magic_quotes_runtime; f���ؾ��մϴ�.";
$GLOBALS['strWarningFileUploads']		= "PHP ��d ���� file_uploads�� ��d�ؾ� �մϴ�.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." has detected that your <b>config.inc.php</b> file is not writeable by the server.<br /> You can't proceed until you change permissions on the file. <br />Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "���� �����ͺ��̽��� ������ �� ��4ϴ�. ��� �����ϸ� ��x�� ��d�� ���, ���, �����ְ� ��� ��f�˴ϴ�.";
$GLOBALS['strTableNames']			= "���̺� �̸�";
$GLOBALS['strTablesPrefix']			= "���̺� b�ξ�";
$GLOBALS['strTablesType']			= "���̺� ~��";

$GLOBALS['strInstallWelcome']			= "ȯ���մϴ�. ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br /> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br /><br />In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br /><br />Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesfull.</b><br /><br />In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
						   <br /><br />Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file 
						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br /><br />Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "��= �7� �߻��߽4ϴ�:";
$GLOBALS['strErrorInstallDatabase']		= "�����ͺ��̽� ��v�� ����� �ʾҽ4ϴ�.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "��d ���� �Ǵ� �����ͺ��̽��� ����Ʈ�� �� ��4ϴ�.";
$GLOBALS['strErrorInstallDbConnect']		= "�����ͺ��̽��� ������ �� ��4ϴ�.";

$GLOBALS['strUrlPrefix']			= "URL b�ξ�";

$GLOBALS['strProceed']				= "��� &gt;";
$GLOBALS['strRepeatPassword']			= "��й�ȣ Ȯ��";
$GLOBALS['strNotSamePasswords']			= "��й�ȣ�� ��ġ���� �ʽ4ϴ�.";
$GLOBALS['strInvalidUserPwd']			= "�߸�� ����� ID �Ǵ� ��й�ȣ�Դϴ�.";

$GLOBALS['strUpgrade']				= "��׷��̵�";
$GLOBALS['strSystemUpToDate']			= "�ý����� ������Ұ� �̹� �ֽ� �����Դϴ�. ��� ��׷��̵��� �� ��4ϴ�.<br /> Ȩ������� �̵��Ϸx� <b>���</b>; Ŭ���ϼ���.";
$GLOBALS['strSystemNeedsUpgrade']		= "�ý����� �ùٸ��� �����Ϸx� �����ͺ��̽� ��v�� ��d ����; ��׷��̵��ؾ� �մϴ�. �ý���; ��׷��̵��ϱ� '�� <b>���</b>; Ŭ���Ͻʽÿ�.<br />�ý���; ��׷��̵��ϴ� �� �� �� d�� �ɸ� �� �ֽ4ϴ�.";
$GLOBALS['strSystemUpgradeBusy']		= "�ý���; ��׷��̵����Դϴ�. ��� ��ٷ��ֽʽÿ�...";
$GLOBALS['strSystemRebuildingCache']		= "ĳ�ø� �籸�����Դϴ�. ��� ��ٷ��ֽʽÿ�...";
$GLOBALS['strServiceUnavalable']		= "�ý���; ��׷��̵� ���̹Ƿ� ���񽺸� ��õ��� �̿��� �� ��4ϴ�.";

$GLOBALS['strConfigNotWritable']		= "config.inc.php ���Ͽ� ���⸦ �� �� ��4ϴ�.";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "���� ����";
$GLOBALS['strDayFullNames'] 			= array("�Ͽ���","�����","ȭ����","�����","�����","�ݿ���","�����");
$GLOBALS['strEditConfigNotPossible']   		= "���Ȼ� ��d ������ ����ֱ� ������ ��d; ������ �� ��4ϴ�. ".
										  "��d; �����Ϸx� config.inc.php ������ ���; ��f�Ͻʽÿ�.";
$GLOBALS['strEditConfigPossible']		= "��d ������ ������� �ʱ� ������ ��� ��d; �����ϴ� ���� ��������, �̷����� ���� ��f�� �߻��� �� �ֽ4ϴ�.".
										  "�ý���; �����ϰ� �Ϸx� config.inc.php ���Ͽ� ���; ��d�ؾ� �մϴ�.";



// Database
$GLOBALS['strDatabaseSettings']			= "�����ͺ��̽� ��d";
$GLOBALS['strDatabaseServer']			= "�����ͺ��̽� ����";
$GLOBALS['strDbHost']				= "�����ͺ��̽� ȣ��Ʈ��";
$GLOBALS['strDbUser']				= "�����ͺ��̽� ������̸�";
$GLOBALS['strDbPassword']			= "�����ͺ��̽� ��й�ȣ";
$GLOBALS['strDbName']				= "�����ͺ��̽� �̸�";

$GLOBALS['strDatabaseOptimalisations']		= "�����ͺ��̽� ����ȭ";
$GLOBALS['strPersistentConnections']		= "���� /��(persistent connection) ���";
$GLOBALS['strCompatibilityMode']		= "�����ͺ��̽� ȣȯ ��� ���";
$GLOBALS['strCantConnectToDb']			= "�����ͺ��̽��� ������ �� ��4ϴ�.";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "��� ȣ�� �� ���/�� ��d";

$GLOBALS['strAllowedInvocationTypes']		= "���� ��� ȣ�� ~��";
$GLOBALS['strAllowRemoteInvocation']		= "��� ��� ȣ�� ���";
$GLOBALS['strAllowRemoteJavascript']		= "��� ��� ȣ�� ���(Javascript)";
$GLOBALS['strAllowRemoteFrames']		= "��� ��� ȣ�� ���(�w���)";
$GLOBALS['strAllowRemoteXMLRPC']		= "��� ȣ�� ���(XML-RPC)";
$GLOBALS['strAllowLocalmode']			= "���� ��� ���";
$GLOBALS['strAllowInterstitial']		= "������(Interstitial) ���";
$GLOBALS['strAllowPopups']			= "�˾� ���";

$GLOBALS['strUseAcl']				= "��� ����߿� ��� /�� f�� ��";

$GLOBALS['strDeliverySettings']			= "��� /�� ��d";
$GLOBALS['strCacheType']				= "��� /�� ĳ�� ~��";
$GLOBALS['strCacheFiles']				= "����";
$GLOBALS['strCacheDatabase']			= "�����ͺ��̽�";
$GLOBALS['strCacheShmop']				= "��/ �޸�(shmop)";
$GLOBALS['strKeywordRetrieval']			= "Ű��� �˻�";
$GLOBALS['strBannerRetrieval']			= "��� �˻� ���";
$GLOBALS['strRetrieveRandom']			= "���� ��� �˻�(�⺻)";
$GLOBALS['strRetrieveNormalSeq']		= "��� �˻�(�Ϲ�)";
$GLOBALS['strWeightSeq']			= "����ġ�� ��� �˻�";
$GLOBALS['strFullSeq']				= "��ü ��� �˻�";
$GLOBALS['strUseConditionalKeys']		= "��b ����; ����� �� �? �����ڸ� ����մϴ�.";
$GLOBALS['strUseMultipleKeys']			= "��b ����; ����� �� �ټ��� Ű��带 ����մϴ�.";

$GLOBALS['strZonesSettings']			= "���� �˻�";
$GLOBALS['strZoneCache']			= "ĳ�� ����, ĳ�� ����; ����ϸ� ����; ����� �� �ӵ��� ��� �մϴ�.";
$GLOBALS['strZoneCacheLimit']			= "ĳ�� ����Ʈ ����(�� ��')";
$GLOBALS['strZoneCacheLimitErr']		= "����Ʈ ���ݿ��� =�� ����� �� ��4ϴ�.";

$GLOBALS['strP3PSettings']			= "P3P ���� ��ȣ då";
$GLOBALS['strUseP3P']				= "P3P då ���";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact då";
$GLOBALS['strP3PPolicyLocation']		= "P3P då 'ġ"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "��� ��d";

$GLOBALS['strAllowedBannerTypes']		= "��� ���";
$GLOBALS['strTypeSqlAllow']			= "���� ���(SQL) - DB ���� ���";
$GLOBALS['strTypeWebAllow']			= "���� ���(%����) - % ���� ���";
$GLOBALS['strTypeUrlAllow']			= "�ܺ� ���";
$GLOBALS['strTypeHtmlAllow']			= "HTML ���";
$GLOBALS['strTypeTxtAllow']			= "�ؽ�Ʈ ����";

$GLOBALS['strTypeWebSettings']			= "���� ���(%����) ��d";
$GLOBALS['strTypeWebMode']			= "���� ���";
$GLOBALS['strTypeWebModeLocal']			= "���� ���͸�";
$GLOBALS['strTypeWebModeFtp']			= "�ܺ� FTP ����";
$GLOBALS['strTypeWebDir']			= "���� ���͸�";
$GLOBALS['strTypeWebFtp']			= "FTP ��� % ��� ����";
$GLOBALS['strTypeWebUrl']			= "��� URL";
$GLOBALS['strTypeWebSslUrl']			= "Public URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "FTP ȣ��Ʈ";
$GLOBALS['strTypeFTPDirectory']			= "ȣ��Ʈ ���͸�";
$GLOBALS['strTypeFTPUsername']			= "�α���ID";
$GLOBALS['strTypeFTPPassword']			= "��й�ȣ";

$GLOBALS['strDefaultBanners']			= "�⺻ ���";
$GLOBALS['strDefaultBannerUrl']			= "�⺻ �̹��� URL";
$GLOBALS['strDefaultBannerTarget']		= "�⺻ ��� URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML ��� �ɼ�";
$GLOBALS['strTypeHtmlAuto']			= "Ŭ�� Ʈ��ŷ; ��f �����ϱ� '�� HTML ��ʸ� �ڵ�8�� �����մϴ�.";
$GLOBALS['strTypeHtmlPhp']			= "HTML ��ʾȿ��� PHP �ڵ带 �����մϴ�.";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "��� ��d";

$GLOBALS['strStatisticsFormat']			= "��� ���";
$GLOBALS['strLogBeacon']			= "AdViews�� ����ϱ� '�� ��� �̹��� ����մϴ�.";
$GLOBALS['strCompactStats']			= "������ ��踦 ����մϴ�.";
$GLOBALS['strLogAdviews']			= "AdViews �α�";
$GLOBALS['strBlockAdviews']			= "���� �α� ����(��)";
$GLOBALS['strLogAdclicks']			= "AdClicks �α�";
$GLOBALS['strBlockAdclicks']			= "���� �α� ����(��)";

$GLOBALS['strGeotargeting']			= "�� d�� �߽�(Geotargeting)";
$GLOBALS['strGeotrackingType']			= "�� d�� �����ͺ��̽� ~��";
$GLOBALS['strGeotrackingLocation'] 		= "�� d�� �����ͺ��̽� 'ġ";
$GLOBALS['strGeoLogStats']			= "�湮�� ����; ��迡 ����մϴ�.";
$GLOBALS['strGeoStoreCookie']		= "���߿� ��v�ϱ� '�� ��Ű�� ��� �����մϴ�.";

$GLOBALS['strEmailWarnings']			= "�̸��� ���";
$GLOBALS['strAdminEmailHeaders']		= "���� ���� ���?�� �߼��ڿ� ���� d���� ���� ��� �����մϴ�.";
$GLOBALS['strWarnLimit']			= "���Ƚ�� f��(Warn Limit)";
$GLOBALS['strWarnLimitErr']			= "���Ƚ�� f��(Warn Limit): =�� ����� �� ��4ϴ�.";
$GLOBALS['strWarnAdmin']			= "���ڿ��� ��? �˸��ϴ�.";
$GLOBALS['strWarnClient']			= "�����ֿ��� ��? �˸��ϴ�.";
$GLOBALS['strQmailPatch']			= "qmail ��ġ�� ����մϴ�.(qmail; ����ϴ� ���)";

$GLOBALS['strRemoteHosts']			= "��� ȣ��Ʈ";
$GLOBALS['strIgnoreHosts']			= "������ ȣ��Ʈ";
$GLOBALS['strReverseLookup']			= "DNS ����v";
$GLOBALS['strProxyLookup']			= "�wϽ� ��v";

$GLOBALS['strAutoCleanTables']			= "�����ͺ��̽� d��";
$GLOBALS['strAutoCleanStats']			= "��� d��";
$GLOBALS['strAutoCleanUserlog']			= "����� �α� d��";
$GLOBALS['strAutoCleanStatsWeeks']		= "��=���� �7��� ��� �����<br />(�ּ� 3��)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "��=���� �7��� ����� �α� �����<br />(�ּ� 3��)";
$GLOBALS['strAutoCleanErr']			= "�ִ� ��x �Ⱓ: 3�� �̻��̾���մϴ�.";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "���� ��d";

$GLOBALS['strLoginCredentials']			= "�α��� d��";
$GLOBALS['strAdminUsername']			= "���� ID"; 
$GLOBALS['strOldPassword']			= "��x ��й�ȣ";
$GLOBALS['strNewPassword']			= "�� ��й�ȣ";
$GLOBALS['strInvalidUsername']			= "�߸�� ID"; 
$GLOBALS['strInvalidPassword']			= "�߸�� ��й�ȣ";

$GLOBALS['strBasicInformation']			= "�⺻ d��";
$GLOBALS['strAdminFullName']			= "���� ��ü �̸�";
$GLOBALS['strAdminEmail']			= "���� �̸���";
$GLOBALS['strCompanyName']			= "ȸ�� �̸�";

$GLOBALS['strAdminCheckUpdates']		= "����Ʈ �˻�";
$GLOBALS['strAdminCheckEveryLogin']		= "�α丶��";
$GLOBALS['strAdminCheckDaily']			= "����";
$GLOBALS['strAdminCheckWeekly']			= "�ְ�";
$GLOBALS['strAdminCheckMonthly']		= "��";
$GLOBALS['strAdminCheckNever']			= "����";

$GLOBALS['strAdminNovice']			= "����; '�� ���ڰ� ��f�ϱ� �� Ȯ���մϴ�.";
$GLOBALS['strUserlogEmail']			= "��� �ܺ� �߼� �̸��� �޽��� ����մϴ�.";
$GLOBALS['strUserlogPriority']			= "�Žð����� �켱��' ���; ����մϴ�.";
$GLOBALS['strUserlogAutoClean']			= "�����ͺ��̽� �ڵ� d���� ����մϴ�.";


// User interface settings
$GLOBALS['strGuiSettings']			= "����� �������̽� ��d";

$GLOBALS['strGeneralSettings']			= "�Ϲ� ��d";
$GLOBALS['strAppName']				= "�?� �wα׷� �̸�";
$GLOBALS['strMyHeader']				= "�� �Ӹ���";
$GLOBALS['strMyFooter']				= "�� �ٴڱ�";
$GLOBALS['strGzipContentCompression']		= "����Ʈ GZIP ���� ���";

$GLOBALS['strClientInterface']			= "������ �������̽�";
$GLOBALS['strClientWelcomeEnabled']		= "������ ȯ�� �޽��� ����մϴ�.";
$GLOBALS['strClientWelcomeText']		= "ȯ�� �޽���<br />(HTML �±� ����)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "�⺻ �������̽� ��d";

$GLOBALS['strInventory']			= "���";
$GLOBALS['strShowCampaignInfo']			= "<i>ķ���� ���</i> ������ ķ���� d���� �ڼ��� �����ݴϴ�.";
$GLOBALS['strShowBannerInfo']			= "<i>��� ���</i> ������ ��� d���� �ڼ��� �����ݴϴ�.";
$GLOBALS['strShowCampaignPreview']		= "<i>��� ���</i> ������ ����� �̸����⸦ ��� ǥ���մϴ�.";
$GLOBALS['strShowBannerHTML']			= "HTML �ڵ� ��ſ� ��f ��ʸ� ǥ���մϴ�.";
$GLOBALS['strShowBannerPreview']		= "��� ó�� ȭ�鿡�� ������ ��ܿ� ��� �̸����⸦ ǥ���մϴ�.";
$GLOBALS['strHideInactive']			= "������� �ʴ� �׸�; ��� ��� ������� ���ϴ�.";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>����� ���</i> ������ �ش� ��ʸ� ǥ���մϴ�.";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>����� ���</i> ������ �ش��ϴ� ��' ������; ǥ���մϴ�.";
$GLOBALS['strGUILinkCompactLimit']		= "<i>�׸��� ��: ��쿡�� <i>����� ���</i> ������ ����� ķ������ ��� ��ʴ� ���ϴ�.";

$GLOBALS['strStatisticsDefaults'] 		= "���";
$GLOBALS['strBeginOfWeek']			= "�� ���� ������";
$GLOBALS['strPercentageDecimals']		= "���2 �Ҽ�a";

$GLOBALS['strWeightDefaults']			= "����ġ �⺻��d";
$GLOBALS['strDefaultBannerWeight']		= "��� ����ġ �⺻��";
$GLOBALS['strDefaultCampaignWeight']		= "ķ���� ����ġ �⺻��";
$GLOBALS['strDefaultBannerWErr']		= "��� ����ġ�� �⺻��: d�� �Է��ؾ��մϴ�.";
$GLOBALS['strDefaultCampaignWErr']		= "ķ���� ����ġ�� �⺻��: d�� �Է��ؾ��մϴ�.";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "���̺� �׵θ� ���";
$GLOBALS['strTableBackColor']			= "���̺� ��� ���";
$GLOBALS['strTableBackColorAlt']		= "���̺� ��� ���(Alternative)";
$GLOBALS['strMainBackColor']			= "�� ��� ���";
$GLOBALS['strOverrideGD']			= "GD �̹��� ���; �����մϴ�.";
$GLOBALS['strTimeZone']				= "�ð� ����";

?>