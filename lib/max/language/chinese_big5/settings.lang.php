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
$GLOBALS['strInstall']				= "�w��";
$GLOBALS['strChooseInstallLanguage']		= "��ܦw�˹L�{���y��";
$GLOBALS['strLanguageSelection']		= "��ܻy��";
$GLOBALS['strDatabaseSettings']			= "��Ʈw�]�w";
$GLOBALS['strAdminSettings']			= "�޲z��]�w";
$GLOBALS['strAdvancedSettings']			= "���ų]�w";
$GLOBALS['strOtherSettings']			= "��L�]�w";

$GLOBALS['strWarning']				= "ĵ�i";
$GLOBALS['strFatalError']			= "�o�ͤ@�ӭP�R��~";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."�w�g�w��. �p�G�z�Q�t�m�t��,�Ш� <a href='settings-index.php'>�]�w�ɭ�</a>";
$GLOBALS['strCouldNotConnectToDB']		= "����s����Ʈw,���ˬd�z���]�w";
$GLOBALS['strCreateTableTestFailed']		= "�z���Ѫ��Τ�S���v���Ыظ�Ʈw���c,���p�Y��Ʈw�޲z��.";
$GLOBALS['strUpdateTableTestFailed']		= "�z���Ѫ��Τ�S���v����s��Ʈw���c,���p�Y��Ʈw�޲z��.";
$GLOBALS['strTablePrefixInvalid']		= "�ƾڪ?�e��]�t�D�k�r��";
$GLOBALS['strTableInUse']			= "�z���Ѫ���Ʈw�w�g�Q".$phpAds_productname."�ϥ�,�ШϥΤ��P����e��,�Ϊ̰ѦҥΤ��U���t�ΤɯŪ���ɳ���.";
$GLOBALS['strTableWrongType']			= "�z�w�˪�".$phpAds_dbmsname."�����z�ҿ�ܪ��ƾڪ�����"; 
$GLOBALS['strMayNotFunction']			= "�i��U�@�B���e,�Ч勵�o�Ǽ�b����~:";
$GLOBALS['strIgnoreWarnings']			= "����ĵ�i";
$GLOBALS['strWarningDBavailable']		= "�z�{�b�ϥΪ�PHP���������".$phpAds_dbmsname."��Ʈw.�b�i��U�����B�J���e,�z�ݭn�ҥ�PHP��".$phpAds_dbmsname."�����";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname."�ݭnPHP 4.0�Ϊ̧󰪪����~�ॿ�`�u�@�C�z�{�b�ϥΪ������O{php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP�]�w�ܶqregister_globals�ݭn���}.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP�]�w�ܶqmagic_quotes_gpc�ݭn���}.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP�]�w�ܶqmagic_quotes_runtime�ݭn��.";
$GLOBALS['strWarningFileUploads']		= "PHP�]�w�ܶqfile_uploads�ݭn���}.";
$GLOBALS['strWarningTrackVars']			= "PHP�]�w�ܶqtrack_vars�ݭn���}.";
$GLOBALS['strWarningPREG']			= "�z�{�b�ϥΪ�PHP���������PERL�ݮe�Ҧ������h��F��. �b�i��U�����B�J���e,�z�ݭn�ҥ�PREL���h��F�������.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname."�˴��z���t�m���<b>config.inc.php</b>���i�g<br />�Х����ק��v������~��i��U�@�B.<br />�p�G�z�����D�p��ާ@�аѦҤ���.";
$GLOBALS['strCantUpdateDB']  			= "�{�b�����s��Ʈw.�p�G�z�T�{�i��,�Ҧ��w�����s�i,���M�Ȥ᳣�|�Q�R��.";
$GLOBALS['strTableNames']			= "�ƾڪ�W�r";
$GLOBALS['strTablesPrefix']			= "�ƾڪ�e��";
$GLOBALS['strTablesType']			= "�ƾڪ�����";

$GLOBALS['strInstallWelcome']			= "�w��ϥ�".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "�b�z�ϥ�".$phpAds_productname."���e,�ݭn�t�m�t�ΩM<br />�Ыظ�Ʈw.��<b>�U�@�B</b>�~��.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname."�w�˧���.</b><br /><br />���F".$phpAds_productname."�����`�ϥ�,�z�ٻݭn�T�{���@���C�p�ɹB��@��,����H���i�H�ѦҬ������.<br /><br />��<b>�U�@�B</b>�i�J�t�m����,�z�i�H�i���h���]�w.�b�t�m�����ԽФ��n�ѰO��wconfig.inc.php�H�O�Ҧw��.";
$GLOBALS['strUpdateSuccess']			= "<b>".$phpAds_productname."�ɯŦ��\.</b><br /><br />���F".$phpAds_productname."�����`�ϥ�,�z�ٻݭn�T�{���@���C�p�ɹB��@��,����H���i�H�ѦҬ������.<br /><br />��<b>�U�@�B</b>�i�J�t�m����,�z�i�H�i���h���]�w.�b�t�m�����ԽФ��n�ѰO��wconfig.inc.php�H�O�Ҧw��.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname."�w�ˤ��৹��</b><br /><br />�w�ˤ����@�ǳ����i��.�o�ǰ��D�i��u�O�Ȯɩʪ�,�o�˱z�i�H²�檺��<b>�U�@�B</b>�åB��^��w�˪��Ĥ@�B,�p�G�z�Q���D��h����~���H���M�p��ѨM,�аѦҬ������.";
$GLOBALS['strErrorOccured']			= "���U����~�o��:";
$GLOBALS['strErrorInstallDatabase']		= "����Ыظ�Ʈw.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "T�t�m���Ϊ̸�Ʈw�����s.";
$GLOBALS['strErrorInstallDbConnect']		= "����s�����Ʈw.";

$GLOBALS['strUrlPrefix']			= "URL�e��";

$GLOBALS['strProceed']				= "�U�@�B &gt;";
$GLOBALS['strRepeatPassword']			= "�T�{�K�X";
$GLOBALS['strNotSamePasswords']			= "�K�X���ǰt";
$GLOBALS['strInvalidUserPwd']			= "��~���Τ�W�αK�X";

$GLOBALS['strUpgrade']				= "�ɯ�";
$GLOBALS['strSystemUpToDate']			= "�z���t�Τw�g�O�̷s��,�{�b���ݭn�ɯ�<br />��<b>�U�@�B</b>�^�쭺��.";
$GLOBALS['strSystemNeedsUpgrade']		= "��Ʈw���c�M�t�m���ݭn�ɯŤ~�ॿ�`�u�@�C��<b>�U�@�B</b>�}�l�ɯšC<br />�ɯŮɶ��]��Ʈw�έp�ƾڪ��h�֦Ӥ��P,�o�ӹL�{�i��ް_�t�θ�Ʈw�t��@��.�Э@�ߵ���,�i��ݭn�X���j��ɶ�.";
$GLOBALS['strSystemUpgradeBusy']		= "�t�ΤɯŤ��A�еy��...";
$GLOBALS['strSystemRebuildingCache']		= "���ؽw�s�Ϥ��A�еy��...";
$GLOBALS['strServiceUnavalable']		= "�A�ȼȮɤ��i��,�t�ΤɯŤ�...";

$GLOBALS['strConfigNotWritable']		= "�z���t�m���config.inc.php���i�g";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "��ܳ���";
$GLOBALS['strDayFullNames'] 			= array("�P�d�","�P�d@","�P�dG","�P�dT","�P�e|","�P�d�","�P�d�");
$GLOBALS['strEditConfigNotPossible']   		= "�]���w����]�t�m���w�g�Q��w,�ҥH����ק�t�m<br />�p�G�z�Q�ק�,�z�ݭn��config.inc.php���i�g.";
$GLOBALS['strEditConfigPossible']		= "�{�b�i�H�ק�Ҧ��t�m,�]���t�m���S����w,�o�˥i��ɭP�w�����D.<br />�p�G�z�Q�O�@�z���t��,�z�ݭn��wconfig.inc.php���.";



// Database
$GLOBALS['strDatabaseSettings']			= "��Ʈw�]�w";
$GLOBALS['strDatabaseServer']			= "��Ʈw�]�w";
$GLOBALS['strDbHost']				= "��Ʈw�D��";
$GLOBALS['strDbPort']				= "��Ʈw�ݤf��";
$GLOBALS['strDbUser']				= "��Ʈw�Τ�W";
$GLOBALS['strDbPassword']			= "��Ʈw�K�X";
$GLOBALS['strDbName']				= "��Ʈw�W�r";
	
$GLOBALS['strDatabaseOptimalisations']		= "��Ʈw�u��";
$GLOBALS['strPersistentConnections']		= "�ϥΥä[�s��";
$GLOBALS['strCompatibilityMode']		= "�ϥθ�Ʈw�ݮe�Ҧ�";
$GLOBALS['strCantConnectToDb']			= "����s�����Ʈw";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "�եΩM�o�e�]�w";
$GLOBALS['strAllowedInvocationTypes']		= "���\���եΤ覡";
$GLOBALS['strAllowRemoteInvocation']		= "���\���{�ե�";
$GLOBALS['strAllowRemoteJavascript']		= "���\���{�ե�Javascript";
$GLOBALS['strAllowRemoteFrames']		= "���\���{�ե�Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "���\���{�ե�XML-RPC";
$GLOBALS['strAllowLocalmode']			= "���\���a�Ҧ�";
$GLOBALS['strAllowInterstitial']		= "���\�ŻؼҦ�";
$GLOBALS['strAllowPopups']			= "���\�u�X�Ҧ�";

$GLOBALS['strUseAcl']				= "�b�o�e�L�{���w��o�e����";

$GLOBALS['strDeliverySettings']			= "�o�e�]�w";
$GLOBALS['strCacheType']			= "�o�e�w�R������";
$GLOBALS['strCacheFiles']			= "���";
$GLOBALS['strCacheDatabase']			= "��Ʈw";
$GLOBALS['strCacheShmop']			= "�@�ɤ��s/shmop";
$GLOBALS['strCacheSysvshm']			= "�@�ɤ��s/Sysvshm";
$GLOBALS['strExperimental']			= "����ʪ�";
$GLOBALS['strKeywordRetrieval']			= "�������r";
$GLOBALS['strBannerRetrieval']			= "�s�i���Ҧ�";
$GLOBALS['strRetrieveRandom']			= "�H��s�i���(�w�])";
$GLOBALS['strRetrieveNormalSeq']		= "���q�t�C�s�i";
$GLOBALS['strWeightSeq']			= "����v���t�C�s�i";
$GLOBALS['strFullSeq']				= "�������t�C���s�i";
$GLOBALS['strUseConditionalKeys']		= "�����s�i����\�ϥ��޿�ާ@";
$GLOBALS['strUseMultipleKeys']			= "�����s�i����\�ϥΦh������r";

$GLOBALS['strZonesSettings']			= "����";
$GLOBALS['strZoneCache']			= "�w�s����A�b�ϥΪ���ɦ��ﶵ�����B��t��";
$GLOBALS['strZoneCacheLimit']			= "�w�s�ϧ�s���ɶ����j(��)";
$GLOBALS['strZoneCacheLimitErr']		= "�w�s�ϧ�s���ɶ����j3�ӬO�@�Ӿ��";

$GLOBALS['strP3PSettings']			= "P3P��p����";
$GLOBALS['strUseP3P']				= "�ϥ�P3P����";
$GLOBALS['strP3PCompactPolicy']			= "P3P�Y������";
$GLOBALS['strP3PPolicyLocation']		= "P3P������m"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "�s�i�]�w";

$GLOBALS['strAllowedBannerTypes']		= "���\���s�i����";
$GLOBALS['strTypeSqlAllow']			= "���\���a�s�i�]���a��Ʈw�^";
$GLOBALS['strTypeWebAllow']			= "���\���a�s�i�]���a���A���^";
$GLOBALS['strTypeUrlAllow']			= "���\�~���s�i";
$GLOBALS['strTypeHtmlAllow']			= "���\HTML�s�i";
$GLOBALS['strTypeTxtAllow']			= "���\��r�s�i";

$GLOBALS['strTypeWebSettings']			= "���a�s�i�]���a���A���^�]�w";
$GLOBALS['strTypeWebMode']			= "�s�x�覡";
$GLOBALS['strTypeWebModeLocal']			= "���a�ؿ�";
$GLOBALS['strTypeWebModeFtp']			= "�~��Ftp��A��";
$GLOBALS['strTypeWebDir']			= "���a�ؿ�";
$GLOBALS['strTypeWebFtp']			= "Ftp�Ҧ��s�i��A��";
$GLOBALS['strTypeWebUrl']			= "���}��URL";
$GLOBALS['strTypeWebSslUrl']			= "Public URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "FTP�D��";
$GLOBALS['strTypeFTPDirectory']			= "�D��ؿ�";
$GLOBALS['strTypeFTPUsername']			= "�n��";
$GLOBALS['strTypeFTPPassword']			= "�K�X";
$GLOBALS['strTypeFTPErrorDir']			= "�D��ؿ�s�b";
$GLOBALS['strTypeFTPErrorConnect']		= "����s����FTP��A��,�Τ�W�Ϊ̱K�X��~";
$GLOBALS['strTypeFTPErrorHost']			= "FTP��A���D��D��W��~";
$GLOBALS['strTypeDirError']			= "���a�ؿ�s�b";

$GLOBALS['strDefaultBanners']			= "�w�]�s�i";
$GLOBALS['strDefaultBannerUrl']			= "�w�]���Ϥ�URL";
$GLOBALS['strDefaultBannerTarget']		= "�w�]���ؼ�URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML�s�i�ﶵ";
$GLOBALS['strTypeHtmlAuto']			= "�۰ʭק�HTML�s�i�H�O���I;��";
$GLOBALS['strTypeHtmlPhp']			= "���\�bHTML�s�i�����php�N�X";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "�D��H���M�a��";

$GLOBALS['strRemoteHost']			= "���{�D��";
$GLOBALS['strReverseLookup']			= "�p�G��A���S�����ѳX�ݪ̪��D��W,�ϦV�d�߰�W";
$GLOBALS['strProxyLookup']			= "�p�G�X�ݪ̨ϥΤF�N�z,�d�߯u��IP�a�}";

$GLOBALS['strGeotargeting']			= "�a��";
$GLOBALS['strGeotrackingType']			= "�a���Ʈw����";
$GLOBALS['strGeotrackingLocation'] 		= "�a���Ʈw��m";
$GLOBALS['strGeoStoreCookie']			= "�O�s���G��cookie���ѥH��Ѧ�";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "���]�w";

$GLOBALS['strStatisticsFormat']			= "���榡";
$GLOBALS['strCompactStats']			= "�ϥ�²��Ҧ�";
$GLOBALS['strLogAdviews']			= "�O��s�i�X�ݼ�";
$GLOBALS['strLogAdclicks']			= "�O��s�i�I;��";
$GLOBALS['strLogSource']			= "�O��եιL�{�����ӷ��Ѽ�";
$GLOBALS['strGeoLogStats']			= "�O��X�ݪ̪���a";
$GLOBALS['strLogHostnameOrIP']			= "�O��X�ݪ̪��D��W�MIP�a�}";
$GLOBALS['strLogIPOnly']			= "�p�G�D��W����,�ȰO��X�ݪ̪�IP�a�}";
$GLOBALS['strLogIP']				= "�O��X�ݪ̪�IP�a�}";
$GLOBALS['strLogBeacon']			= "�ϥΫH���O�ӰO��s�i�X�ݼ�,�i�H�O�ҥu�O��o�e���\���s�i";

$GLOBALS['strRemoteHosts']			= "���{�D��";
$GLOBALS['strIgnoreHosts']			= "���O��U�CIP�a�}�Ϊ̥D��W���X�ݪ̪��ƾ�";
$GLOBALS['strBlockAdviews']			= "�p�G�X�ݪ̤w�g�X�ݤF�s�i,���O��P�@�s�i�X�ݼƪ��ɶ����j";
$GLOBALS['strBlockAdclicks']			= "�p�G�X�ݪ̤w�g�I;�F�s�i,���O��P�@�s�i�I;�ƪ��ɶ����j";


$GLOBALS['strEmailWarnings']			= "�q�l�l��ĵ�i";
$GLOBALS['strAdminEmailHeaders']		= "��ܨC����o�e�̪��l���Y";
$GLOBALS['strWarnLimit']			= "ĵ�i����";
$GLOBALS['strWarnLimitErr']			= "ĵ�i������O�@�ӥ����";
$GLOBALS['strWarnAdmin']			= "ĵ�i�޲z��";
$GLOBALS['strWarnClient']			= "ĵ�i�Ȥ�";
$GLOBALS['strQmailPatch']			= "�ҥ�qmail�ɤB";

$GLOBALS['strAutoCleanTables']			= "�۰ʲM�z��Ʈw";
$GLOBALS['strAutoCleanStats']			= "�M���έp�ƾ�";
$GLOBALS['strAutoCleanUserlog']			= "�M���Τ�O��";
$GLOBALS['strAutoCleanStatsWeeks']		= "�έp�ƾڪ��̤j�ةR<br />(�̤p3�P)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "�Τ�O��̤j�ةR<br />(�̤p3�P)";
$GLOBALS['strAutoCleanErr']			= "�̤j�ةR�����j��3�P";
$GLOBALS['strAutoCleanVacuum']			= "�C�߯u�Ť*R�ƾڪ�"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "�޲z��]�w";

$GLOBALS['strLoginCredentials']			= "�n��H��";
$GLOBALS['strAdminUsername']			= "�޲z��W�r";
$GLOBALS['strOldPassword']			= "�±K�X";
$GLOBALS['strNewPassword']			= "�s�K�X";
$GLOBALS['strInvalidUsername']			= "��~�Τ�W";
$GLOBALS['strInvalidPassword']			= "��~�K�X";

$GLOBALS['strBasicInformation']			= "�򥻫H��";
$GLOBALS['strAdminFullName']			= "�޲z����W";
$GLOBALS['strAdminEmail']			= "�޲z��q�l�l��a�}";
$GLOBALS['strCompanyName']			= "���q�W�r";

$GLOBALS['strAdminCheckUpdates']		= "�ˬd��s";
$GLOBALS['strAdminCheckEveryLogin']		= "�C���n��";
$GLOBALS['strAdminCheckDaily']			= "�C��";
$GLOBALS['strAdminCheckWeekly']			= "�C�g";
$GLOBALS['strAdminCheckMonthly']		= "�C��";
$GLOBALS['strAdminCheckNever']			= "�q��";

$GLOBALS['strAdminNovice']			= "�޲z��R���ާ@�ݭn�T�{�H�O�Ҧw��";
$GLOBALS['strUserlogEmail']			= "�O��o�X���Ҧ��q�l�l��H��";
$GLOBALS['strUserlogPriority']			= "�O��C�p�ɪ��u��ŭp��";
$GLOBALS['strUserlogAutoClean']			= "�O���Ʈw���۰ʲM�z";


// User interface settings
$GLOBALS['strGuiSettings']			= "�Τ�ɭ��]�w";

$GLOBALS['strGeneralSettings']			= "�@��]�w";
$GLOBALS['strAppName']				= "�{�ǦW�r";
$GLOBALS['strMyHeader']				= "��������";
$GLOBALS['strMyFooter']				= "��������";
$GLOBALS['strGzipContentCompression']		= "�ϥ�GZIP���e#�Y";

$GLOBALS['strClientInterface']			= "�Ȥ�ɭ�";
$GLOBALS['strClientWelcomeEnabled']		= "�ҥΫȤ��w��H��";
$GLOBALS['strClientWelcomeText']		= "�w���r<br />(���\HTML�аO)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "�w�]�ɭ�";

$GLOBALS['strInventory']			= "�Բӥؿ�";
$GLOBALS['strShowCampaignInfo']			= "�b<i>�����`��</i>��������B�~���ثH��";
$GLOBALS['strShowBannerInfo']			= "�b<i>�s�i�`��</i>��������B�~�s�i�H��";
$GLOBALS['strShowCampaignPreview']		= "�b<i>�s�i�`��</i>������ܩҦ��s�i���w��";
$GLOBALS['strShowBannerHTML']			= "HTML�s�i���w����ܹ�ڪ��s�i�Ӥ��O���qHTML�N�X";
$GLOBALS['strShowBannerPreview']		= "�b�B�z�s�i������������ܼs�i�w��";
$GLOBALS['strHideInactive']			= "�Ҧ����`�����äw�g���Ϊ�����";
$GLOBALS['strGUIShowMatchingBanners']		= "�b<i>�s���s�i</i>������ܲŦX���s�i";
$GLOBALS['strGUIShowParentCampaigns']		= "�b<i>�s���s�i</i>������ܤW�h����";
$GLOBALS['strGUILinkCompactLimit']		= "�b<i>�s���s�i</i>�������èS���s�������ةμs�i�A��ƥؤj��";

$GLOBALS['strStatisticsDefaults'] 		= "�έp�ƾ�";
$GLOBALS['strBeginOfWeek']			= "�@�P���}�l";
$GLOBALS['strPercentageDecimals']		= "�ʤ$��T��";

$GLOBALS['strWeightDefaults']			= "�w�]�v����";
$GLOBALS['strDefaultBannerWeight']		= "�w�]�s�i�v����";
$GLOBALS['strDefaultCampaignWeight']		= "�w�]�����v����";
$GLOBALS['strDefaultBannerWErr']		= "�w�]�s�i�v����3�ӬO�@�ӥ����";
$GLOBALS['strDefaultCampaignWErr']		= "�w�]�����v����3�ӬO�@�ӥ����";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "����䪺�C��";
$GLOBALS['strTableBackColor']			= "��檺�I����";
$GLOBALS['strTableBackColorAlt']		= "��檺�I����(�i��)";
$GLOBALS['strMainBackColor']			= "�D�n�I����";
$GLOBALS['strOverrideGD']			= "�л\GD�ϧήw�榡";
$GLOBALS['strTimeZone']				= "�ɰ�";

?>
