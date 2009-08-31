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
$Id$
*/

// Installer translation strings
$GLOBALS['strInstall']				= "安装";
$GLOBALS['strChooseInstallLanguage']		= "ѡ��װ��̵�����";
$GLOBALS['strLanguageSelection']		= "语言选择";
$GLOBALS['strDatabaseSettings']			= "数�?�库设置";
$GLOBALS['strAdminSettings']			= "管�?�员设置";
$GLOBALS['strAdvancedSettings']			= "高级设置";
$GLOBALS['strOtherSettings']			= "��������";

$GLOBALS['strWarning']				= "警告";
$GLOBALS['strFatalError']			= "����һ���������";
$GLOBALS['strUpdateError']			= "�����з���һ�����";
$GLOBALS['strUpdateDatabaseError']		= "��Ϊδ֪����,��ݿ�ṹ��û�гɹ�.������<b>������</b>4�����޸���ЩǱ�ڵĴ���. �����ȷ����Щ���󲻻�Ӱ��".MAX_PRODUCT_NAME."�Ĺ���,����Ե��<b>���Դ���</b>����.������Щ���������ɺ����ص�����,���Բ��Ƽ�ʹ��!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME."�Ѿ���װ. �����������ϵͳ,�뵽 <a href='settings-index.php'>���ý���</a>";
$GLOBALS['strCouldNotConnectToDB']		= "����l����ݿ�,�����������";
$GLOBALS['strCreateTableTestFailed']		= "���ṩ���û�û��Ȩ�޴�����ݿ�ṹ,��jϵ��ݿ����Ա.";
$GLOBALS['strUpdateTableTestFailed']		= "���ṩ���û�û��Ȩ�޸�����ݿ�ṹ,��jϵ��ݿ����Ա.";
$GLOBALS['strTablePrefixInvalid']		= "��ݱ��ǰ׺��Ƿ��ַ�";
$GLOBALS['strTableInUse']			= "���ṩ����ݿ��Ѿ���".MAX_PRODUCT_NAME."ʹ��,��ʹ�ò�ͬ�ı�ǰ׺,���߲ο��û��ֲ���ϵͳ���ָ������.";
$GLOBALS['strTableWrongType']			= "��װ��".$phpAds_dbmsname."��֧������ѡ�����ݱ�����";
$GLOBALS['strMayNotFunction']			= "������һ��֮ǰ,�������ЩǱ�ڵĴ���:";
$GLOBALS['strFixProblemsBefore']		= "����װ".MAX_PRODUCT_NAME."֮ǰ��������������Ŀ.�����Դ�����Ϣ��ʲô����,��鿴<i>����Ա�ֲ�</i>,�ֲ�����������ص����ѹ������ҵ�.";
$GLOBALS['strFixProblemsAfter']			= "������޷����������г������,��jϵ��Ҫ��װ".MAX_PRODUCT_NAME."�ķ�����Ĺ���Ա.�˷�����Ĺ���Ա�����ܹ�����������Щ����";
$GLOBALS['strIgnoreWarnings']			= "���Ծ���";
$GLOBALS['strWarningDBavailable']		= "������ʹ�õ�PHP�汾��֧��".$phpAds_dbmsname."��ݿ�.�ڽ�������Ĳ���֮ǰ,����Ҫ����PHP��".$phpAds_dbmsname."��֧��";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME."��ҪPHP 4.0���߸�߰汾��������������ʹ�õİ汾��{php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP���ñ�register_globals��Ҫ��.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP���ñ�magic_quotes_gpc��Ҫ��.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP���ñ�magic_quotes_runtime��Ҫ�ر�.";
$GLOBALS['strWarningFileUploads']		= "PHP���ñ�file_uploads��Ҫ��.";
$GLOBALS['strWarningTrackVars']			= "PHP���ñ�track_vars��Ҫ��.";
$GLOBALS['strWarningPREG']			= "������ʹ�õ�PHP�汾��֧��PERL����ģʽ��������ʽ. �ڽ�������Ĳ���֮ǰ,����Ҫ����PREL������ʽ��֧��.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME."��⵽��������ļ�<b>config.inc.php</b>����д<br />������޸�Ȩ��֮����ܽ�����һ��.<br />�����֪����β�����ο��ĵ�.";
$GLOBALS['strCantUpdateDB']  			= "���ڲ��ܸ�����ݿ�.�����ȷ�Ͻ���,�������еĹ��,����Ϳͻ����ᱻɾ��.";
$GLOBALS['strIgnoreErrors']			= "���Դ���";
$GLOBALS['strRetryUpdate']			= "������";
$GLOBALS['strTableNames']			= "��ݱ�����";
$GLOBALS['strTablesPrefix']			= "�??称�?缀";
$GLOBALS['strTablesType']			= "表格类型";

$GLOBALS['strInstallWelcome']			= "��ӭʹ��".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "����ʹ��".MAX_PRODUCT_NAME."֮ǰ,��Ҫ����ϵͳ��<br />������ݿ�.��<b>��һ��</b>����.";
$GLOBALS['strInstallSuccess']			= "点击确定登入您的广告�?务器.	<p><strong>下一步？</strong></p>	<div class='psub'>	  <p><b>登入以获�?�更新</b><br>	    <a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>加入". MAX_PRODUCT_NAME ."邮件列表</a> 以获得最新的更新通知和安全性警告.	  </p>	  <p><b>开始你的第一个广告</b><br>	    查看我们的 <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>快速入门指�?�</a>.	  </p>	</div>	<p><strong>�?�选的安装步骤</strong></p>	<div class='psub'>	  <p><b>�?定你的�?置文件</b><br>	    这对你的系统安全是一个�?外的帮助.  <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>查看更多</a>.	  </p>	  <p><b>设定一个维护任务（�?�?）</b><br>	    维护任务�?�以定时统计你的任务报表�?�广告投放计划.  <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>查看更多</a>	  </p>	  <p><b>查看你的系统设置</b><br>	    在时使用 ". MAX_PRODUCT_NAME ."之�?，我们建议你�?新确定你的系统设置（在“设置�?选项�?�内）.	  </p>	</div>";
$GLOBALS['strUpdateSuccess']			= "<b>".MAX_PRODUCT_NAME."��ɹ�.</b><br /><br />Ϊ��".MAX_PRODUCT_NAME."����ʹ��,����Ҫȷ��ά���ļ�ÿСʱ����һ��,�йص���Ϣ���Բο�����ĵ�.<br /><br />��<b>��һ��</b>��������ҳ��,����Խ��и�������.��������ɺ��벻Ҫ�����config.inc.php�Ա�֤��ȫ.";
$GLOBALS['strInstallNotSuccessful']		= "<b>". MAX_PRODUCT_NAME ."  的安装并�?�?功!</b><br /><br />其中�?些安装过程无法完�?.\n                                                �?�能这些问题�?�是暂时性的, 如果确实如此您�?�需点击 <b>继续</b> 并返回整个安装�?程的第一步, 如果您希望了解下列错误信�?�的详情以�?�解决方法, 请自行阅读�?机文档.";
$GLOBALS['strErrorOccured']			= "�����������:";
$GLOBALS['strErrorInstallDatabase']		= "���ܴ�����ݿ�.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "T�����ļ�������ݿⲻ�ܸ���.";
$GLOBALS['strErrorInstallDbConnect']		= "����l�ӵ���ݿ�.";

$GLOBALS['strUrlPrefix']			= "URLǰ׺";

$GLOBALS['strProceed']				= "继续>";
$GLOBALS['strInvalidUserPwd']			= "������û��������";

$GLOBALS['strUpgrade']				= "��";
$GLOBALS['strSystemUpToDate']			= "���ϵͳ�Ѿ������°�,���ڲ���Ҫ��<br />��<b>��һ��</b>�ص���ҳ.";
$GLOBALS['strSystemNeedsUpgrade']		= "��ݿ�ṹ�������ļ���Ҫ����������<b>��һ��</b>��ʼ��<br />��ʱ������ݿ�ͳ����ݵĶ��ٶ�ͬ,����̿�������ϵͳ��ݿ⸺�����.�����ĵȴ�,������Ҫ�����ӵ�ʱ��.";
$GLOBALS['strSystemUpgradeBusy']		= "ϵͳ���У����Ժ�...";
$GLOBALS['strSystemRebuildingCache']		= "�ؽ��������У����Ժ�...";
$GLOBALS['strServiceUnavalable']		= "������ʱ������,ϵͳ����...";

$GLOBALS['strConfigNotWritable']		= "��������ļ�config.inc.php����д";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection'] = "选择章节";
$GLOBALS['strDayFullNames'][0] = "星期天";
$GLOBALS['strDayFullNames'][1] = "星期一";
$GLOBALS['strDayFullNames'][2] = "星期二";
$GLOBALS['strDayFullNames'][3] = "星期三";
$GLOBALS['strDayFullNames'][4] = "星期四";
$GLOBALS['strDayFullNames'][5] = "星期五";
$GLOBALS['strDayFullNames'][6] = "星期六";

$GLOBALS['strEditConfigNotPossible']   		= "由于安全原因无法编辑所有设定。如果你希望修改，你需�?解�?�?置文件。";
$GLOBALS['strEditConfigPossible']		= "由于�?置文件已�?解�?，所以所有�?置�?��?�修改。但是这�?�能导致安全问题。如果您希望确�?系统安全，您需�?�?定�?置文件。";



// Database
$GLOBALS['strDatabaseSettings']			= "��ݿ�����";
$GLOBALS['strDatabaseServer']			= "全局数�?�库�?务器设置";
$GLOBALS['strDbLocal']				= "使用本地套接字连接"; //Pgר��
$GLOBALS['strDbHost']				= "数�?�库主机�??";
$GLOBALS['strDbPort']				= "数�?�库端�?��?�";
$GLOBALS['strDbUser']				= "数�?�库用户�??";
$GLOBALS['strDbPassword']			= "数�?�库密�?";
$GLOBALS['strDbName']				= "数�?�库�??";

$GLOBALS['strDatabaseOptimalisations']		= "全局数�?�库优化设置";
$GLOBALS['strPersistentConnections']		= "使用�?久链接";
$GLOBALS['strCompatibilityMode']		= "ʹ����ݿ����ģʽ";
$GLOBALS['strCantConnectToDb']			= "无法链接数�?�库";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "生�?设置";
$GLOBALS['strAllowedInvocationTypes']		= "�?许生�?模�?";
$GLOBALS['strAllowRemoteInvocation']		= "����Զ�̵���";
$GLOBALS['strAllowRemoteJavascript']		= "����Զ�̵���Javascript";
$GLOBALS['strAllowRemoteFrames']		= "����Զ�̵���Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "����Զ�̵���XML-RPC";
$GLOBALS['strAllowLocalmode']			= "���?��ģʽ";
$GLOBALS['strAllowInterstitial']		= "�����϶ģʽ";
$GLOBALS['strAllowPopups']			= "���?��ģʽ";

$GLOBALS['strUseAcl']				= "�ڷ��͹����Ԥ�7�������";

$GLOBALS['strDeliverySettings']			= "�?�布设置";
$GLOBALS['strCacheType']			= "���ͻ���������";
$GLOBALS['strCacheFiles']			= "文件";
$GLOBALS['strCacheDatabase']			= "��ݿ�";
$GLOBALS['strCacheShmop']			= "�����ڴ�/shmop";
$GLOBALS['strCacheSysvshm']			= "�����ڴ�/Sysvshm";
$GLOBALS['strExperimental']			= "ʵ���Ե�";
$GLOBALS['strKeywordRetrieval']			= "��ȡ�ؼ���";
$GLOBALS['strBannerRetrieval']			= "����ȡģʽ";
$GLOBALS['strRetrieveRandom']			= "������ȡ(ȱʡ)";
$GLOBALS['strRetrieveNormalSeq']		= "��ȡ��ͨϵ�й��";
$GLOBALS['strWeightSeq']			= "��ȡȨ��ϵ�й��";
$GLOBALS['strFullSeq']				= "��ȡȫ��ϵ�еĹ��";
$GLOBALS['strUseConditionalKeys']		= "ֱ�ӹ��ѡȡ������ʹ���߼�����";
$GLOBALS['strUseMultipleKeys']			= "ֱ�ӹ��ѡȡ������ʹ�ö��ؼ���";

$GLOBALS['strZonesSettings']			= "��ȡ��λ";
$GLOBALS['strZoneCache']			= "�����λ����ʹ�ð�λʱ��ѡ���ܹ���������ٶ�";
$GLOBALS['strZoneCacheLimit']			= "��������µ�ʱ����(��)";
$GLOBALS['strZoneCacheLimitErr']		= "��������µ�ʱ����Ӧ����һ������";

$GLOBALS['strP3PSettings']			= "P3P�?�?策略的全局设置";
$GLOBALS['strUseP3P']				= "使用P3P策略";
$GLOBALS['strP3PCompactPolicy']			= "P3P压缩策略";
$GLOBALS['strP3PPolicyLocation']		= "P3P策略地点";



// Banner Settings
$GLOBALS['strBannerSettings']			= "广告设置";

$GLOBALS['strAllowedBannerTypes']		= "�?许的广告形�?";
$GLOBALS['strTypeSqlAllow']			= "�?�使用本地数�?�库广告";
$GLOBALS['strTypeWebAllow']			= "�?�使用Webserver�?务器本地广告";
$GLOBALS['strTypeUrlAllow']			= "使用外部广告";
$GLOBALS['strTypeHtmlAllow']			= "�?�使用HTML广告";
$GLOBALS['strTypeTxtAllow']			= "�?�使用文字广告";

$GLOBALS['strTypeWebSettings']			= "Webserver本地广告全局存储设置";
$GLOBALS['strTypeWebMode']			= "存储模�?";
$GLOBALS['strTypeWebModeLocal']			= "本地目录";
$GLOBALS['strTypeWebModeFtp']			= "扩展FTP�?务器";
$GLOBALS['strTypeWebDir']			= "本地目录";
$GLOBALS['strTypeWebFtp']			= "Ftpģʽ��������";
$GLOBALS['strTypeWebUrl']			= "������URL";
$GLOBALS['strTypeWebSslUrl']			= "Public URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "FTP主机";
$GLOBALS['strTypeFTPDirectory']			= "主机目录";
$GLOBALS['strTypeFTPUsername']			= "登录";
$GLOBALS['strTypeFTPPassword']			= "密�?";
$GLOBALS['strTypeFTPErrorDir']			= "FTP主机目录�?存在";
$GLOBALS['strTypeFTPErrorConnect']		= "无法链接FTP�?务器，登录�??或密�?�?正确";
$GLOBALS['strTypeFTPErrorHost']			= "FTP主机�?正确";
$GLOBALS['strTypeDirError']			= "无法通过Web Server写入本地目录";

$GLOBALS['strDefaultBanners']			= "默认广告";
$GLOBALS['strDefaultBannerUrl']			= "默认图片URL";
$GLOBALS['strDefaultBannerTarget']		= "ȱʡ��Ŀ��URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML广告选项";
$GLOBALS['strTypeHtmlAuto']			= "自动转�?�HTML广告以实现点击跟踪";
$GLOBALS['strTypeHtmlPhp']			= "�?许HTML格�?广告中�?行PHP表达�?";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "�����Ϣ�͵���";

$GLOBALS['strRemoteHost']			= "Զ�����";
$GLOBALS['strReverseLookup']			= "�??�?�查找�?览者的主机�??";
$GLOBALS['strProxyLookup']			= "�?试查找通过代�?��?务器访问的访问者的真是IP地�?�";

$GLOBALS['strGeotargeting']			= "地�?�定�?设置";
$GLOBALS['strGeotrackingType']			= "������ݿ�����";
$GLOBALS['strGeotrackingLocation'] 		= "������ݿ�λ��";
$GLOBALS['strGeotrackingLocationError'] 	= "����ָ����λ��û���ҵ�������ݿ�λ��";
$GLOBALS['strGeoStoreCookie']			= "������cookie�й��Ժ�ο�";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "统计与管�?�设置";

$GLOBALS['strStatisticsFormat']			= "�����ʽ";
$GLOBALS['strCompactStats']			= "ʹ�ü��ģʽ";
$GLOBALS['strLogAdviews']			= "��¼��������";
$GLOBALS['strLogAdclicks']			= "��¼�������";
$GLOBALS['strLogSource']			= "��¼���ù���е�4Դ����";
$GLOBALS['strGeoLogStats']			= "��¼�����ߵĹ��";
$GLOBALS['strLogHostnameOrIP']			= "��¼�����ߵ�������IP��ַ";
$GLOBALS['strLogIPOnly']			= "��������δ֪,���¼�����ߵ�IP��ַ";
$GLOBALS['strLogIP']				= "��¼�����ߵ�IP��ַ";
$GLOBALS['strLogBeacon']			= "ʹ���źŵ�4��¼��������,���Ա�ֻ֤��¼���ͳɹ��Ĺ��";

$GLOBALS['strRemoteHosts']			= "Զ�����";
$GLOBALS['strIgnoreHosts']			= "�?�自以下IP地�?�或主机的访客数�?��?统计";
$GLOBALS['strBlockAdviews']			= "���������Ѿ������˹��,����¼ͬһ���������ʱ����";
$GLOBALS['strBlockAdclicks']			= "���������Ѿ�����˹��,����¼ͬһ��������ʱ����";


$GLOBALS['strPreventLogging']			= "全�?�防止统计登录设置";
$GLOBALS['strEmailWarnings']			= "邮件�??醒";
$GLOBALS['strAdminEmailHeaders']		= MAX_PRODUCT_NAME."���͵�ÿһ������ʼ������ϴ��ʼ�ͷ";
$GLOBALS['strWarnLimit']			= "邮件�??醒剩余�?光投放数以少于指定的数�?";
$GLOBALS['strWarnLimitErr']			= "警告�?制请使用正整数";
$GLOBALS['strWarnAdmin']			= "邮件�??醒管�?�员项目�?�将过期";
$GLOBALS['strWarnClient']			= "邮件�??醒客户项目�?�将过期";
$GLOBALS['strQmailPatch']			= "qmail的补�?";

$GLOBALS['strAutoCleanTables']			= "�Զ�������ݿ�";
$GLOBALS['strAutoCleanStats']			= "���ͳ�����";
$GLOBALS['strAutoCleanUserlog']			= "����û���¼";
$GLOBALS['strAutoCleanStatsWeeks']		= "ͳ����ݵ��������<br />(��С3��)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "�û���¼���������<br />(��С3��)";
$GLOBALS['strAutoCleanErr']			= "�������������3��";
$GLOBALS['strAutoCleanVacuum']			= "ÿ����շ�����ݱ�"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "管�?�员设置";

$GLOBALS['strLoginCredentials']			= "登录信任";
$GLOBALS['strAdminUsername']			= "管�?�员用户�??";
$GLOBALS['strInvalidUsername']			= "用户�??�?正确";

$GLOBALS['strBasicInformation']			= "基本信�?�";
$GLOBALS['strAdminFullName']			= "管�?�员全�??";
$GLOBALS['strAdminEmail']			= "管�?�员邮件地�?�";
$GLOBALS['strCompanyName']			= "公�?��??称";

$GLOBALS['strAdminCheckUpdates']		= "查找更新";
$GLOBALS['strAdminCheckEveryLogin']		= "ÿ�ε�¼";
$GLOBALS['strAdminCheckDaily']			= "ÿ��";
$GLOBALS['strAdminCheckWeekly']			= "ÿ��";
$GLOBALS['strAdminCheckMonthly']		= "ÿ��";
$GLOBALS['strAdminCheckNever']			= "�Ӳ�";

$GLOBALS['strAdminNovice']			= "出于安全，Admin的删除�?��?需�?确认";
$GLOBALS['strUserlogEmail']			= "记录所有�?�出邮件信�?�";
$GLOBALS['strUserlogPriority']			= "��¼ÿСʱ�����ȼ�����";
$GLOBALS['strUserlogAutoClean']			= "��¼��ݿ���Զ�����";


// User interface settings
$GLOBALS['strGuiSettings']			= "用户界�?�设定";

$GLOBALS['strGeneralSettings']			= "一般设置";
$GLOBALS['strAppName']				= "应用�??称";
$GLOBALS['strMyHeader']				= "页眉文件�?置";
$GLOBALS['strMyHeaderError']			= "在您指定的�?置下没有页眉文件";
$GLOBALS['strMyFooter']				= "页脚文件�?置";
$GLOBALS['strMyFooterError']			= "在您指定的�?置下没有页脚文件";
$GLOBALS['strGzipContentCompression']		= "使用GZIP进行压缩";

$GLOBALS['strClientInterface']			= "客户界�?�";
$GLOBALS['strClientWelcomeEnabled']		= "�?�用客户欢迎信�?�";
$GLOBALS['strClientWelcomeText']		= "欢迎辞";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "界�?�默认值";

$GLOBALS['strInventory']			= "系统管�?�";
$GLOBALS['strShowCampaignInfo']			= "在 <i>项目</i> 页中显示更多项目信�?�";
$GLOBALS['strShowBannerInfo']			= "在 <i>广告</i> 页中显示更多广告信�?�";
$GLOBALS['strShowCampaignPreview']		= "在 <i>广告</i> 页中预览所有广告";
$GLOBALS['strShowBannerHTML']			= "实际显示广告，以代替plain html代�?的广告预览";
$GLOBALS['strShowBannerPreview']		= "在页首显示广告预览";
$GLOBALS['strHideInactive']			= "�?�?�?活动内容";
$GLOBALS['strGUIShowMatchingBanners']		= "显示符�?� <i>Linked banner</i> 的广告";
$GLOBALS['strGUIShowParentCampaigns']		= "显示<i>Linked banner</i> 的父项目";
$GLOBALS['strGUILinkCompactLimit']		= "��<i>l�ӹ��</i>ҳ������û��l�ӵ���Ŀ���棬����Ŀ����";

$GLOBALS['strStatisticsDefaults'] 		= "统计";
$GLOBALS['strBeginOfWeek']			= "一周的开始";
$GLOBALS['strPercentageDecimals']		= "�??进制百分比";

$GLOBALS['strWeightDefaults']			= "默认�?��?";
$GLOBALS['strDefaultBannerWeight']		= "默认广告�?��?";
$GLOBALS['strDefaultCampaignWeight']		= "默认项目�?��?";
$GLOBALS['strDefaultBannerWErr']		= "ȱʡ���Ȩ��ֵӦ����һ��������";
$GLOBALS['strDefaultCampaignWErr']		= "ȱʡ��ĿȨ��ֵӦ����һ��������";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "���ߵ���ɫ";
$GLOBALS['strTableBackColor']			= "���ı���ɫ";
$GLOBALS['strTableBackColorAlt']		= "���ı���ɫ(��ѡ)";
$GLOBALS['strMainBackColor']			= "��Ҫ����ɫ";
$GLOBALS['strOverrideGD']			= "����GDͼ�ο��ʽ";
$GLOBALS['strTimeZone']				= "ʱ��";



// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strAdminAccount'] = "管�?�员�?�?�";
$GLOBALS['strSpecifySyncSettings'] = "�?�步设置";
$GLOBALS['strOpenadsIdYour'] = "您的OpenX ID";
$GLOBALS['strBtnContinue'] = "继续》";
$GLOBALS['strBtnRecover'] = "�?��?》";
$GLOBALS['strBtnStartAgain'] = "开始�?�级》";
$GLOBALS['strBtnGoBack'] = "《返回";
$GLOBALS['strBtnAgree'] = "我�?��?》";
$GLOBALS['strBtnDontAgree'] = "《我拒�?";
$GLOBALS['strBtnRetry'] = "�?试";
$GLOBALS['strFixErrorsBeforeContinuing'] = "在继续之�?请修�?所有错误";
$GLOBALS['strWarningRegisterArgcArv'] = "如许�?行维护脚本，您需�?开�?�PHP�?置�?��?中的register_argc_argv";
$GLOBALS['strInstallIntro'] = "谢谢您选择<a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>�?�导会指导您完�?". MAX_PRODUCT_NAME ." 广告�?务器的安装/�?�级�?程。</p><p>为了帮助您完�?安装过程，我们准备了<a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>快速安装指�?�</a>�?�帮助您安装并�?�动�?务。关于". MAX_PRODUCT_NAME ."的安装和�?置，如需更详细的信�?�，请访问<a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>管�?�员指�?�</a>。";
$GLOBALS['strRecoveryRequiredTitle'] = "你以�?�?试�?�级�?�到一个错误";
$GLOBALS['strRecoveryRequired'] = "你之�?�?�级". MAX_PRODUCT_NAME ."中出现了一个错误，请点击�?��?按钮�?��?到错误产生之�?的状�?。";
$GLOBALS['strTermsTitle'] = "团队使用�?�?策略";
$GLOBALS['strPolicyTitle'] = "�?�?�?�政策";
$GLOBALS['strPolicyIntro'] = "请审阅并�?��?下列文档�?��?继续安装过程。";
$GLOBALS['strDbSetupTitle'] = "数�?�库设置";
$GLOBALS['strDbUpgradeIntro'] = "为安装". MAX_PRODUCT_NAME ."，系统为您检测出下列数�?�库信�?�。请检查并确认这些信�?�是正确的.<p>下一步将为您�?�级数�?�库。点击[继续]�?��?�级您的系统。</p>";
$GLOBALS['strOaUpToDate'] = "您的". MAX_PRODUCT_NAME ."和数�?�库都使用的都是最新的版本，没有需�?更新的。请点击继续进入管�?�员�?��?�。";
$GLOBALS['strOaUpToDateCantRemove'] = "警告: �?�级文件�?在var目录。因为�?��?�?够，我们无法移除此档案。请先手动删除该文件�?�。";
$GLOBALS['strRemoveUpgradeFile'] = "你需�?删除删除var文件夹下的�?�级文件";
$GLOBALS['strSystemCheck'] = "系统检查";
$GLOBALS['strDbSuccessIntro'] = "". MAX_PRODUCT_NAME ." 数�?�库已�?更新。请点击“继续�?按钮进入管�?�员与�?�布设定。";
$GLOBALS['strDbSuccessIntroUpgrade'] = "您的系统已被�?功更新。�?��?�的页�?�将帮助您�?�级新建广告�?务器的�?置。";
$GLOBALS['strErrorWritePermissions'] = "文件�?��?错误。\n<br />在Linux下修正这个错误，请输入以下命令:";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "文件�?��?错误。您必须先修正这个错误�?�?�继续下一步。";
$GLOBALS['strCheckDocumentation'] = "需�?帮助，请�?�阅 <a href='". OX_PRODUCT_DOCSURL ."'>". MAX_PRODUCT_NAME ."  文档<a/>.";
$GLOBALS['strAdminUrlPrefix'] = "管�?�员界�?�路径";
$GLOBALS['strDeliveryUrlPrefix'] = "�?�布引擎路径";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "�?�布引擎路径（SSL）";
$GLOBALS['strImagesUrlPrefix'] = "图片存储路径";
$GLOBALS['strImagesUrlPrefixSSL'] = "图片存储路径（SSL）";
$GLOBALS['strUnableToWriteConfig'] = "无法修改�?置文件";
$GLOBALS['strUnableToWritePrefs'] = "无法�?�数�?�库�??交属性更改";
$GLOBALS['strImageDirLockedDetected'] = "<b>图片文件夹</b>�?�?�写<br>在修改文件夹�?��?之�?无法修改或创建相关文件夹。\n";
$GLOBALS['strConfigurationSetup'] = "�?置检查表";
$GLOBALS['strConfigurationSettings'] = "�?置设置";
$GLOBALS['strAdminPassword'] = "管�?�员密�?";
$GLOBALS['strAdministratorEmail'] = "管�?�员邮件地�?�";
$GLOBALS['strTimezoneInformation'] = "时区信�?�（时区的修改将影�?统计数�?�）";
$GLOBALS['strTimezone'] = "时区";
$GLOBALS['strTimezoneEstimated'] = "预计时区";
$GLOBALS['strTimezoneGuessedValue'] = "在PHP设定中的时区�?正确";
$GLOBALS['strTimezoneSeeDocs'] = "请�?�阅 %DOCS% 了解在PHP中设定这个�?��?的方法。";
$GLOBALS['strTimezoneDocumentation'] = "文档";
$GLOBALS['strLoginSettingsTitle'] = "管�?�员登录";
$GLOBALS['strLoginSettingsIntro'] = "为了继续�?�级，请输入您". MAX_PRODUCT_NAME ." 管�?�员登录信�?�。您必须以管�?�员身份登录，以继续安装。";
$GLOBALS['strAdminSettingsTitle'] = "创建管�?�员账�?�";
$GLOBALS['strAdminSettingsIntro'] = "请完�?这个表格�?�创建您的广告�?务器管�?�员账�?�。";
$GLOBALS['strEnableAutoMaintenance'] = "�?行期间的自动维护还未设定";
$GLOBALS['strDefaultBannerDestination'] = "默认链接地�?�";
$GLOBALS['strDbType'] = "数�?�库类型";
$GLOBALS['strDemoDataInstall'] = "安装演示数�?�";
$GLOBALS['strDemoDataIntro'] = "将默认安装数�?�加载到 ". MAX_PRODUCT_NAME ." 中，�?�以帮助您�?次�?�动在线广告�?务。最常�?的广告类型和一些�?始广告项目会被加载并被预先�?置。我们强烈推�??新安装的系统都这么�?�。";
$GLOBALS['strDebugSettings'] = "调试日志";
$GLOBALS['strDebug'] = "调试日志设置";
$GLOBALS['strProduction'] = "产�?�?务器";
$GLOBALS['strEnableDebug'] = "�?�用调试日志";
$GLOBALS['strDebugMethodNames'] = "在调试日志中包括方法�??";
$GLOBALS['strDebugLineNumbers'] = "在调试日志中包括方线程�?��?";
$GLOBALS['strDebugType'] = "调试日志类型";
$GLOBALS['strDebugTypeFile'] = "文件";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL数�?�库";
$GLOBALS['strDebugTypeSyslog'] = "系统日志";
$GLOBALS['strDebugName'] = "除错日志�??，日历，SQL表格或系统日志工具";
$GLOBALS['strDebugPriority'] = "除错优先级";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - 所有信�?�";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - 默认信�?�";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - 最少信�?�";
$GLOBALS['strDebugIdent'] = "调试鉴定弦";
$GLOBALS['strDebugUsername'] = "mCal, SQL �?务器用户�??";
$GLOBALS['strDebugPassword'] = "mCal, SQL �?务器密�?";
$GLOBALS['strWebPath'] = "". MAX_PRODUCT_NAME ." �?务器路径";
$GLOBALS['strWebPathSimple'] = "页�?�路径";
$GLOBALS['strDeliveryPath'] = "�?�布路径";
$GLOBALS['strImagePath'] = "图片路径";
$GLOBALS['strDeliverySslPath'] = "�?�布SSL路径";
$GLOBALS['strImageSslPath'] = "图片SSL路径";
$GLOBALS['strImageStore'] = "图片文件夹";
$GLOBALS['strTypeFTPPassive'] = "使用被动FTP";
$GLOBALS['strDeliveryFilenames'] = "全局�?�布文件�??";
$GLOBALS['strDeliveryFilenamesAdClick'] = "广告点击";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "广告转化�?�数";
$GLOBALS['strDeliveryFilenamesAdContent'] = "广告内容";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "广告转化";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "广告转化（JavaScript）";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "广告框架";
$GLOBALS['strDeliveryFilenamesAdImage'] = "广告图片";
$GLOBALS['strDeliveryFilenamesAdJS'] = "广告（JavaScript）";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "广告层";
$GLOBALS['strDeliveryFilenamesAdLog'] = "广告记录";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "弹出广告";
$GLOBALS['strDeliveryFilenamesAdView'] = "广告预览";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "生�?远程调用XML";
$GLOBALS['strDeliveryFilenamesLocal'] = "生�?本地的";
$GLOBALS['strDeliveryFilenamesFrontController'] = "字体控制器";
$GLOBALS['strDeliveryFilenamesFlash'] = "包括Flash（�?�以使用�?对路径）";
$GLOBALS['strDeliveryCaching'] = "全局�?��?缓存设置";
$GLOBALS['strDeliveryCacheLimit'] = "缓存刷新频率（秒）";
$GLOBALS['strOrigin'] = "使用远程�?�?务器";
$GLOBALS['strOriginType'] = "�?�?务器类型";
$GLOBALS['strOriginHost'] = "�?�?务器主机�??";
$GLOBALS['strOriginPort'] = "�?数�?�库端�?��?�";
$GLOBALS['strOriginScript'] = "�?数�?�库脚本文件";
$GLOBALS['strOriginTypeXMLRPC'] = "远程调用XML";
$GLOBALS['strOriginTimeout'] = "�?暂�?�（秒）";
$GLOBALS['strOriginProtocol'] = "�?�?务器�??议";
$GLOBALS['strDeliveryBanner'] = "广告�?��?全局设置";
$GLOBALS['strDeliveryAcls'] = "在分�?�时评估广告的分�?�";
$GLOBALS['strDeliveryObfuscate'] = "混淆通�?�时广告";
$GLOBALS['strDeliveryExecPhp'] = "�?�在广告中使用PHP代�?<br/>（�?�能存在安全�?患）";
$GLOBALS['strDeliveryCtDelimiter'] = "第三方广告跟踪分隔符";
$GLOBALS['strGeotargetingSettings'] = "地�?�定�?设置";
$GLOBALS['strGeotargetingType'] = "地�?�定�?模�?�类型";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP 区域数�?�库地�?�";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP 城市数�?�地�?�";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP 大区数�?�库地�?�";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP DMA 数�?�库地�?�";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP 组织数�?�库地�?�";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP数�?�库地�?�";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP网速数�?�地�?�";
$GLOBALS['strGeoSaveStats'] = "在数�?�日志中�?存GeoIP数�?�";
$GLOBALS['strGeoShowUnavailable'] = "如果没有GeoIP数�?�，则�??示地�?�定�?�?�布�?�件";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "在指定�?置没有MaxMind GeoIP 国家数�?�库";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "在指定�?置没有MaxMind GeoIP 区域数�?�库";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "在指定�?置没有MaxMind GeoIP 城市数�?�库";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "在指定�?置没有MaxMind GeoIP 大区数�?�库";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "在指定�?置没有MaxMind GeoIP DMA数�?�库";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "在指定�?置没有MaxMind GeoIP 组织数�?�库";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "在指定�?置没有MaxMind GeoIP ISP数�?�库";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "在指定�?置没有MaxMind GeoIP 网速数�?�库";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "默认匿�??项目";
$GLOBALS['strModesOfPayment'] = "支付方�?";
$GLOBALS['strCurrencies'] = "现金";
$GLOBALS['strCategories'] = "分类";
$GLOBALS['strHelpFiles'] = "帮助文件";
$GLOBALS['strHasTaxID'] = "税务ID";
$GLOBALS['strDefaultApproved'] = "勾选的�?选框";
$GLOBALS['strInvocationDefaults'] = "默认生�?";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "默认�?�用第三方点击跟踪";
$GLOBALS['strStatisticsLogging'] = "全局统计登录设置";
$GLOBALS['strCsvImport'] = "�?许上传离线转化结果";
$GLOBALS['strLogAdRequests'] = "广告的�?次请求都需�?记录";
$GLOBALS['strLogAdImpressions'] = "广告的�?次�?览都需�?记录";
$GLOBALS['strLogAdClicks'] = "广告的�?次点击都需�?记录";
$GLOBALS['strLogTrackerImpressions'] = "广告�?次的跟踪�?光都需�?记录";
$GLOBALS['strBlockAdViews'] = "如果�?览者在在指定时间（秒）内�?览�?�一个广告，�?计算广告�?光�?";
$GLOBALS['strBlockAdViewsError'] = "广告�?光�?�值必须�?�负整数";
$GLOBALS['strBlockAdClicks'] = "如果�?览者在在指定时间（秒）内点击�?�一个广告，�?计算广告点击数";
$GLOBALS['strBlockAdClicksError'] = "阻挡广告点击值应该为�?�负整数";
$GLOBALS['strMaintenaceSettings'] = "全�?�管�?�设置";
$GLOBALS['strMaintenanceOI'] = "管�?��?行间隔（分钟）";
$GLOBALS['strMaintenanceOIError'] = "维护�?作间隔设定�?�?�法 - 请阅读文档中关于�?�法时间的定义";
$GLOBALS['strMaintenanceCompactStats'] = "处�?��?�是�?�删除原始统计数�?�";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "删除原始统计�?的宽�?时间(秒)";
$GLOBALS['strPrioritySettings'] = "全局优先�?�设定";
$GLOBALS['strPriorityInstantUpdate'] = "修改�?�广告优先级立�?�生效";
$GLOBALS['strWarnCompactStatsGrace'] = "紧缩统计格�?的宽�?时间必须是正整数";
$GLOBALS['strDefaultImpConWindow'] = "默认广告�?光链接窗�?�（秒）";
$GLOBALS['strDefaultImpConWindowError'] = "默认广告�?光链接窗�?�数应该为正整数";
$GLOBALS['strDefaultCliConWindow'] = "默认广告点击链接窗�?�（秒）";
$GLOBALS['strDefaultCliConWindowError'] = "默认广告点击链接窗�?�数应该为正整数";
$GLOBALS['strWarnLimitDays'] = "在指定日期之�?�?��?一�?�??醒邮件";
$GLOBALS['strWarnLimitDaysErr'] = "�??醒�?制日期应该是一个整数";
$GLOBALS['strWarnAgency'] = "邮件�??醒代�?�商项目�?�将过期";
$GLOBALS['strDefaultTrackerStatus'] = "默认跟踪状�?";
$GLOBALS['strDefaultTrackerType'] = "默认跟踪模�?";
$GLOBALS['strMyLogo'] = "自定义logo文件�??";
$GLOBALS['strMyLogoError'] = "admin/images目录下没有logo文件";
$GLOBALS['strGuiHeaderForegroundColor'] = "页眉�?景颜色";
$GLOBALS['strGuiHeaderBackgroundColor'] = "页眉背景颜色";
$GLOBALS['strGuiActiveTabColor'] = "激活标签的颜色";
$GLOBALS['strGuiHeaderTextColor'] = "页眉文本的颜色";
$GLOBALS['strColorError'] = "请使用RGB格�?输入颜色信�?�，如'0066CC'";
$GLOBALS['strReportsInterface'] = "报告界�?�";
$GLOBALS['strPublisherAgreementText'] = "登录文本(支�?HTML标签)";
$GLOBALS['requireSSL'] = "强制使用SSL访问用户界�?�(UI)";
$GLOBALS['sslPort'] = "Web�?务器使用的SSL端�?�";
$GLOBALS['strEmailAddress'] = "电�?邮件地�?�";
$GLOBALS['strAllowEmail'] = "全局�?许�?��?电�?邮件";
$GLOBALS['strEmailAddressName'] = "�?��?�?�止活动电�?邮件的公�?�或者人�??";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strTermsIntro'] = "". MAX_PRODUCT_NAME ." 在�?�守Open Source license, the GNU General Public License的情况下�?�以被自由分�?�使用，请查看以下文档并确认以继续安装过程";
$GLOBALS['strDbSetupIntro'] = "请输入详细信�?�连接到数�?�库。如果你�?确定这些信�?�，请�?�系您的系统管�?�员。<p>下一步将为您创建数�?�库，请点击[继续]进入下一步</p>";
$GLOBALS['strSystemCheckIntro'] = "安装�?�导正在检查您的Web�?务器设置以便�?�?安装过程已�?�?功完�?。	<p>请检查被高亮的问题�?�结�?�安装过程.</p>";
$GLOBALS['strConfigSettingsIntro'] = "请检查以下设定，进行必需的修改，如果您�?确定，请使用默认选项";
$GLOBALS['strOpenadsUsername'] = "". MAX_PRODUCT_NAME ." 用户�??";
$GLOBALS['strOpenadsPassword'] = "". MAX_PRODUCT_NAME ." 密�?";
$GLOBALS['uiEnabled'] = "�?�用用户界�?�";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP 国家数�?�库<br />(如果�?填则使用�?费数�?�库)";
$GLOBALS['strPublisherDefaults'] = "网站默认设置";
$GLOBALS['strPublisherInterface'] = "网站界�?�";
$GLOBALS['strPublisherAgreementEnabled'] = "�?许对没有接�?��??议的网站进行登录控制";
$GLOBALS['strAuditTrailSettings'] = "审计追踪设置";
$GLOBALS['strDbSocket'] = "数�?�库套接字";
$GLOBALS['strEmailAddresses'] = "电�?邮件\"From\"地�?�";
$GLOBALS['strEmailFromName'] = "电�?邮件\"From\"姓�??";
$GLOBALS['strEmailFromAddress'] = "电�?邮件\"From\"邮件地�?�";
$GLOBALS['strEmailFromCompany'] = "电�?邮件\"From\"公�?�";
$GLOBALS['strIgnoreUserAgents'] = "<b>�?</b> 记录在用户代�?�中包括下列字符串的客户端统计信�?�（一个一行）";
$GLOBALS['strEnforceUserAgents'] = "<b>�?�</b> 记录在用户代�?�中包括下列字符串的客户端统计信�?�（一个一行）";
$GLOBALS['strConversionTracking'] = "转化跟踪器设置";
$GLOBALS['strEnableConversionTracking'] = "�?�用转化跟踪";
$GLOBALS['strDbNameHint'] = "如果没有�?�现数�?�库，它将被创建";
$GLOBALS['strProductionSystem'] = "生产系统";
$GLOBALS['strTypeFTPErrorUpload'] = "�?能将文件上传到你的FTP�?务器，请检查�?��?";
$GLOBALS['strBannerLogging'] = "图片日志设定";
$GLOBALS['strBannerDelivery'] = "广告�?�布设定";
$GLOBALS['strEnableDashboardSyncNotice'] = "如果您希望使用�?��?�，请开�?�  <a href='account-settings-update.php'>检查更新</a>";
$GLOBALS['strDashboardSettings'] = "�?��?�设置";
$GLOBALS['strGlobalDefaultBannerUrl'] = "全局默认广告图片URL";
$GLOBALS['strCantConnectToDbDelivery'] = "无法连接数�?��?��?�布信�?�";
$GLOBALS['strDefaultConversionStatus'] = "默认转化规则";
$GLOBALS['strDefaultConversionType'] = "默认转化规则";
?>