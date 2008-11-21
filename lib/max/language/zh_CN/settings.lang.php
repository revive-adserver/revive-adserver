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
$GLOBALS['strInstall']				= "安装";
$GLOBALS['strChooseInstallLanguage']		= "ѡ��װ��̵�����";
$GLOBALS['strLanguageSelection']		= "语言选择";
$GLOBALS['strDatabaseSettings']			= "数据库设置";
$GLOBALS['strAdminSettings']			= "管理员设置";
$GLOBALS['strAdvancedSettings']			= "高级设置";
$GLOBALS['strOtherSettings']			= "��������";

$GLOBALS['strWarning']				= "警告";
$GLOBALS['strFatalError']			= "����һ���������";
$GLOBALS['strUpdateError']			= "�����з���һ�����";
$GLOBALS['strUpdateDatabaseError']		= "��Ϊδ֪����,��ݿ�ṹ��û�гɹ�.������<b>������</b>4�����޸���ЩǱ�ڵĴ���. �����ȷ����Щ���󲻻�Ӱ��".$phpAds_productname."�Ĺ���,����Ե��<b>���Դ���</b>����.������Щ���������ɺ����ص�����,���Բ��Ƽ�ʹ��!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."�Ѿ���װ. �����������ϵͳ,�뵽 <a href='settings-index.php'>���ý���</a>";
$GLOBALS['strCouldNotConnectToDB']		= "����l����ݿ�,�����������";
$GLOBALS['strCreateTableTestFailed']		= "���ṩ���û�û��Ȩ�޴�����ݿ�ṹ,��jϵ��ݿ����Ա.";
$GLOBALS['strUpdateTableTestFailed']		= "���ṩ���û�û��Ȩ�޸�����ݿ�ṹ,��jϵ��ݿ����Ա.";
$GLOBALS['strTablePrefixInvalid']		= "��ݱ��ǰ׺��Ƿ��ַ�";
$GLOBALS['strTableInUse']			= "���ṩ����ݿ��Ѿ���".$phpAds_productname."ʹ��,��ʹ�ò�ͬ�ı�ǰ׺,���߲ο��û��ֲ���ϵͳ���ָ������.";
$GLOBALS['strTableWrongType']			= "��װ��".$phpAds_dbmsname."��֧������ѡ�����ݱ�����";
$GLOBALS['strMayNotFunction']			= "������һ��֮ǰ,�������ЩǱ�ڵĴ���:";
$GLOBALS['strFixProblemsBefore']		= "����װ".$phpAds_productname."֮ǰ��������������Ŀ.�����Դ�����Ϣ��ʲô����,��鿴<i>����Ա�ֲ�</i>,�ֲ�����������ص����ѹ������ҵ�.";
$GLOBALS['strFixProblemsAfter']			= "������޷����������г������,��jϵ��Ҫ��װ".$phpAds_productname."�ķ�����Ĺ���Ա.�˷�����Ĺ���Ա�����ܹ�����������Щ����";
$GLOBALS['strIgnoreWarnings']			= "���Ծ���";
$GLOBALS['strWarningDBavailable']		= "������ʹ�õ�PHP�汾��֧��".$phpAds_dbmsname."��ݿ�.�ڽ�������Ĳ���֮ǰ,����Ҫ����PHP��".$phpAds_dbmsname."��֧��";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname."��ҪPHP 4.0���߸�߰汾��������������ʹ�õİ汾��{php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP���ñ�register_globals��Ҫ��.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP���ñ�magic_quotes_gpc��Ҫ��.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP���ñ�magic_quotes_runtime��Ҫ�ر�.";
$GLOBALS['strWarningFileUploads']		= "PHP���ñ�file_uploads��Ҫ��.";
$GLOBALS['strWarningTrackVars']			= "PHP���ñ�track_vars��Ҫ��.";
$GLOBALS['strWarningPREG']			= "������ʹ�õ�PHP�汾��֧��PERL����ģʽ��������ʽ. �ڽ�������Ĳ���֮ǰ,����Ҫ����PREL������ʽ��֧��.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname."��⵽��������ļ�<b>config.inc.php</b>����д<br />������޸�Ȩ��֮����ܽ�����һ��.<br />�����֪����β�����ο��ĵ�.";
$GLOBALS['strCantUpdateDB']  			= "���ڲ��ܸ�����ݿ�.�����ȷ�Ͻ���,�������еĹ��,����Ϳͻ����ᱻɾ��.";
$GLOBALS['strIgnoreErrors']			= "���Դ���";
$GLOBALS['strRetryUpdate']			= "������";
$GLOBALS['strTableNames']			= "��ݱ�����";
$GLOBALS['strTablesPrefix']			= "名称前缀";
$GLOBALS['strTablesType']			= "表格类型";

$GLOBALS['strInstallWelcome']			= "��ӭʹ��".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "����ʹ��".$phpAds_productname."֮ǰ,��Ҫ����ϵͳ��<br />������ݿ�.��<b>��һ��</b>����.";
$GLOBALS['strInstallSuccess']			= "点击确定登入您的广告服务器.	<p><strong>下一步？</strong></p>	<div class='psub'>	  <p><b>登入以获取更新</b><br>	    <a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>加入". MAX_PRODUCT_NAME ."邮件列表</a> 以获得最新的更新通知和安全性警告.	  </p>	  <p><b>开始你的第一个广告</b><br>	    查看我们的 <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>快速入门指南</a>.	  </p>	</div>	<p><strong>可选的安装步骤</strong></p>	<div class='psub'>	  <p><b>锁定你的配置文件</b><br>	    这对你的系统安全是一个额外的帮助.  <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>查看更多</a>.	  </p>	  <p><b>设定一个维护任务（重要）</b><br>	    维护任务可以定时统计你的任务报表及广告投放计划.  <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>查看更多</a>	  </p>	  <p><b>查看你的系统设置</b><br>	    在时使用 ". MAX_PRODUCT_NAME ."之前，我们建议你重新确定你的系统设置（在“设置”选项卡内）.	  </p>	</div>";
$GLOBALS['strUpdateSuccess']			= "<b>".$phpAds_productname."��ɹ�.</b><br /><br />Ϊ��".$phpAds_productname."����ʹ��,����Ҫȷ��ά���ļ�ÿСʱ����һ��,�йص���Ϣ���Բο�����ĵ�.<br /><br />��<b>��һ��</b>��������ҳ��,����Խ��и�������.��������ɺ��벻Ҫ�����config.inc.php�Ա�֤��ȫ.";
$GLOBALS['strInstallNotSuccessful']		= "<b>". MAX_PRODUCT_NAME ."  的安装并不成功!</b><br /><br />其中某些安装过程无法完成.\n                                                可能这些问题只是暂时性的, 如果确实如此您只需点击 <b>继续</b> 并返回整个安装流程的第一步, 如果您希望了解下列错误信息的详情以及解决方法, 请自行阅读随机文档.";
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

$GLOBALS['strEditConfigNotPossible']   		= "由于安全原因无法编辑所有设定。如果你希望修改，你需要解锁配置文件。";
$GLOBALS['strEditConfigPossible']		= "由于配置文件已经解锁，所以所有配置均可修改。但是这可能导致安全问题。如果您希望确保系统安全，您需要锁定配置文件。";



// Database
$GLOBALS['strDatabaseSettings']			= "��ݿ�����";
$GLOBALS['strDatabaseServer']			= "全局数据库服务器设置";
$GLOBALS['strDbLocal']				= "使用本地套接字连接"; //Pgר��
$GLOBALS['strDbHost']				= "数据库主机名";
$GLOBALS['strDbPort']				= "数据库端口号";
$GLOBALS['strDbUser']				= "数据库用户名";
$GLOBALS['strDbPassword']			= "数据库密码";
$GLOBALS['strDbName']				= "数据库名";

$GLOBALS['strDatabaseOptimalisations']		= "全局数据库优化设置";
$GLOBALS['strPersistentConnections']		= "使用持久链接";
$GLOBALS['strCompatibilityMode']		= "ʹ����ݿ����ģʽ";
$GLOBALS['strCantConnectToDb']			= "无法链接数据库";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "生成设置";
$GLOBALS['strAllowedInvocationTypes']		= "允许生成模式";
$GLOBALS['strAllowRemoteInvocation']		= "����Զ�̵���";
$GLOBALS['strAllowRemoteJavascript']		= "����Զ�̵���Javascript";
$GLOBALS['strAllowRemoteFrames']		= "����Զ�̵���Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "����Զ�̵���XML-RPC";
$GLOBALS['strAllowLocalmode']			= "���?��ģʽ";
$GLOBALS['strAllowInterstitial']		= "�����϶ģʽ";
$GLOBALS['strAllowPopups']			= "���?��ģʽ";

$GLOBALS['strUseAcl']				= "�ڷ��͹����Ԥ�7�������";

$GLOBALS['strDeliverySettings']			= "发布设置";
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

$GLOBALS['strP3PSettings']			= "P3P隐私策略的全局设置";
$GLOBALS['strUseP3P']				= "使用P3P策略";
$GLOBALS['strP3PCompactPolicy']			= "P3P压缩策略";
$GLOBALS['strP3PPolicyLocation']		= "P3P策略地点";



// Banner Settings
$GLOBALS['strBannerSettings']			= "广告设置";

$GLOBALS['strAllowedBannerTypes']		= "允许的广告形式";
$GLOBALS['strTypeSqlAllow']			= "可使用本地数据库广告";
$GLOBALS['strTypeWebAllow']			= "可使用Webserver服务器本地广告";
$GLOBALS['strTypeUrlAllow']			= "使用外部广告";
$GLOBALS['strTypeHtmlAllow']			= "可使用HTML广告";
$GLOBALS['strTypeTxtAllow']			= "可使用文字广告";

$GLOBALS['strTypeWebSettings']			= "Webserver本地广告全局存储设置";
$GLOBALS['strTypeWebMode']			= "存储模式";
$GLOBALS['strTypeWebModeLocal']			= "本地目录";
$GLOBALS['strTypeWebModeFtp']			= "扩展FTP服务器";
$GLOBALS['strTypeWebDir']			= "本地目录";
$GLOBALS['strTypeWebFtp']			= "Ftpģʽ��������";
$GLOBALS['strTypeWebUrl']			= "������URL";
$GLOBALS['strTypeWebSslUrl']			= "Public URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "FTP主机";
$GLOBALS['strTypeFTPDirectory']			= "主机目录";
$GLOBALS['strTypeFTPUsername']			= "登录";
$GLOBALS['strTypeFTPPassword']			= "密码";
$GLOBALS['strTypeFTPErrorDir']			= "FTP主机目录不存在";
$GLOBALS['strTypeFTPErrorConnect']		= "无法链接FTP服务器，登录名或密码不正确";
$GLOBALS['strTypeFTPErrorHost']			= "FTP主机不正确";
$GLOBALS['strTypeDirError']			= "无法通过Web Server写入本地目录";

$GLOBALS['strDefaultBanners']			= "默认广告";
$GLOBALS['strDefaultBannerUrl']			= "默认图片URL";
$GLOBALS['strDefaultBannerTarget']		= "ȱʡ��Ŀ��URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML广告选项";
$GLOBALS['strTypeHtmlAuto']			= "自动转换HTML广告以实现点击跟踪";
$GLOBALS['strTypeHtmlPhp']			= "允许HTML格式广告中运行PHP表达式";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "�����Ϣ�͵���";

$GLOBALS['strRemoteHost']			= "Զ�����";
$GLOBALS['strReverseLookup']			= "反向查找浏览者的主机名";
$GLOBALS['strProxyLookup']			= "尝试查找通过代理服务器访问的访问者的真是IP地址";

$GLOBALS['strGeotargeting']			= "地理定位设置";
$GLOBALS['strGeotrackingType']			= "������ݿ�����";
$GLOBALS['strGeotrackingLocation'] 		= "������ݿ�λ��";
$GLOBALS['strGeotrackingLocationError'] 	= "����ָ����λ��û���ҵ�������ݿ�λ��";
$GLOBALS['strGeoStoreCookie']			= "������cookie�й��Ժ�ο�";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "统计与管理设置";

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
$GLOBALS['strIgnoreHosts']			= "来自以下IP地址或主机的访客数据不统计";
$GLOBALS['strBlockAdviews']			= "���������Ѿ������˹��,����¼ͬһ���������ʱ����";
$GLOBALS['strBlockAdclicks']			= "���������Ѿ�����˹��,����¼ͬһ��������ʱ����";


$GLOBALS['strPreventLogging']			= "全球防止统计登录设置";
$GLOBALS['strEmailWarnings']			= "邮件提醒";
$GLOBALS['strAdminEmailHeaders']		= $phpAds_productname."���͵�ÿһ������ʼ������ϴ��ʼ�ͷ";
$GLOBALS['strWarnLimit']			= "邮件提醒剩余曝光投放数以少于指定的数量";
$GLOBALS['strWarnLimitErr']			= "警告限制请使用正整数";
$GLOBALS['strWarnAdmin']			= "邮件提醒管理员项目即将过期";
$GLOBALS['strWarnClient']			= "邮件提醒客户项目即将过期";
$GLOBALS['strQmailPatch']			= "qmail的补丁";

$GLOBALS['strAutoCleanTables']			= "�Զ�������ݿ�";
$GLOBALS['strAutoCleanStats']			= "���ͳ�����";
$GLOBALS['strAutoCleanUserlog']			= "����û���¼";
$GLOBALS['strAutoCleanStatsWeeks']		= "ͳ����ݵ��������<br />(��С3��)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "�û���¼���������<br />(��С3��)";
$GLOBALS['strAutoCleanErr']			= "�������������3��";
$GLOBALS['strAutoCleanVacuum']			= "ÿ����շ�����ݱ�"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "管理员设置";

$GLOBALS['strLoginCredentials']			= "登录信任";
$GLOBALS['strAdminUsername']			= "管理员用户名";
$GLOBALS['strInvalidUsername']			= "用户名不正确";

$GLOBALS['strBasicInformation']			= "基本信息";
$GLOBALS['strAdminFullName']			= "管理员全名";
$GLOBALS['strAdminEmail']			= "管理员邮件地址";
$GLOBALS['strCompanyName']			= "公司名称";

$GLOBALS['strAdminCheckUpdates']		= "查找更新";
$GLOBALS['strAdminCheckEveryLogin']		= "ÿ�ε�¼";
$GLOBALS['strAdminCheckDaily']			= "ÿ��";
$GLOBALS['strAdminCheckWeekly']			= "ÿ��";
$GLOBALS['strAdminCheckMonthly']		= "ÿ��";
$GLOBALS['strAdminCheckNever']			= "�Ӳ�";

$GLOBALS['strAdminNovice']			= "出于安全，Admin的删除权限需要确认";
$GLOBALS['strUserlogEmail']			= "记录所有发出邮件信息";
$GLOBALS['strUserlogPriority']			= "��¼ÿСʱ�����ȼ�����";
$GLOBALS['strUserlogAutoClean']			= "��¼��ݿ���Զ�����";


// User interface settings
$GLOBALS['strGuiSettings']			= "用户界面设定";

$GLOBALS['strGeneralSettings']			= "一般设置";
$GLOBALS['strAppName']				= "应用名称";
$GLOBALS['strMyHeader']				= "页眉文件位置";
$GLOBALS['strMyHeaderError']			= "在您指定的位置下没有页眉文件";
$GLOBALS['strMyFooter']				= "页脚文件位置";
$GLOBALS['strMyFooterError']			= "在您指定的位置下没有页脚文件";
$GLOBALS['strGzipContentCompression']		= "使用GZIP进行压缩";

$GLOBALS['strClientInterface']			= "客户界面";
$GLOBALS['strClientWelcomeEnabled']		= "启用客户欢迎信息";
$GLOBALS['strClientWelcomeText']		= "欢迎辞";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "界面默认值";

$GLOBALS['strInventory']			= "系统管理";
$GLOBALS['strShowCampaignInfo']			= "在 <i>项目</i> 页中显示更多项目信息";
$GLOBALS['strShowBannerInfo']			= "在 <i>广告</i> 页中显示更多广告信息";
$GLOBALS['strShowCampaignPreview']		= "在 <i>广告</i> 页中预览所有广告";
$GLOBALS['strShowBannerHTML']			= "实际显示广告，以代替plain html代码的广告预览";
$GLOBALS['strShowBannerPreview']		= "在页首显示广告预览";
$GLOBALS['strHideInactive']			= "隐藏不活动内容";
$GLOBALS['strGUIShowMatchingBanners']		= "显示符合 <i>Linked banner</i> 的广告";
$GLOBALS['strGUIShowParentCampaigns']		= "显示<i>Linked banner</i> 的父项目";
$GLOBALS['strGUILinkCompactLimit']		= "��<i>l�ӹ��</i>ҳ������û��l�ӵ���Ŀ���棬����Ŀ����";

$GLOBALS['strStatisticsDefaults'] 		= "统计";
$GLOBALS['strBeginOfWeek']			= "一周的开始";
$GLOBALS['strPercentageDecimals']		= "十进制百分比";

$GLOBALS['strWeightDefaults']			= "默认权重";
$GLOBALS['strDefaultBannerWeight']		= "默认广告权重";
$GLOBALS['strDefaultCampaignWeight']		= "默认项目权重";
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
$GLOBALS['strAdminAccount'] = "管理员帐号";
$GLOBALS['strSpecifySyncSettings'] = "同步设置";
$GLOBALS['strOpenadsIdYour'] = "您的OpenX ID";
$GLOBALS['strBtnContinue'] = "继续》";
$GLOBALS['strBtnRecover'] = "恢复》";
$GLOBALS['strBtnStartAgain'] = "开始升级》";
$GLOBALS['strBtnGoBack'] = "《返回";
$GLOBALS['strBtnAgree'] = "我同意》";
$GLOBALS['strBtnDontAgree'] = "《我拒绝";
$GLOBALS['strBtnRetry'] = "重试";
$GLOBALS['strFixErrorsBeforeContinuing'] = "在继续之前请修复所有错误";
$GLOBALS['strWarningRegisterArgcArv'] = "如许运行维护脚本，您需要开启PHP配置变量中的register_argc_argv";
$GLOBALS['strInstallIntro'] = "谢谢您选择<a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>向导会指导您完成". MAX_PRODUCT_NAME ." 广告服务器的安装/升级流程。</p><p>为了帮助您完成安装过程，我们准备了<a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>快速安装指南</a>来帮助您安装并启动服务。关于". MAX_PRODUCT_NAME ."的安装和配置，如需更详细的信息，请访问<a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>管理员指南</a>。";
$GLOBALS['strRecoveryRequiredTitle'] = "你以前尝试升级遇到一个错误";
$GLOBALS['strRecoveryRequired'] = "你之前升级". MAX_PRODUCT_NAME ."中出现了一个错误，请点击恢复按钮恢复到错误产生之前的状态。";
$GLOBALS['strTermsTitle'] = "团队使用隐私策略";
$GLOBALS['strPolicyTitle'] = "隐私权政策";
$GLOBALS['strPolicyIntro'] = "请审阅并同意下列文档后再继续安装过程。";
$GLOBALS['strDbSetupTitle'] = "数据库设置";
$GLOBALS['strDbUpgradeIntro'] = "为安装". MAX_PRODUCT_NAME ."，系统为您检测出下列数据库信息。请检查并确认这些信息是正确的.<p>下一步将为您升级数据库。点击[继续]来升级您的系统。</p>";
$GLOBALS['strOaUpToDate'] = "您的". MAX_PRODUCT_NAME ."和数据库都使用的都是最新的版本，没有需要更新的。请点击继续进入管理员面板。";
$GLOBALS['strOaUpToDateCantRemove'] = "警告: 升级文件仍在var目录。因为权限不够，我们无法移除此档案。请先手动删除该文件吧。";
$GLOBALS['strRemoveUpgradeFile'] = "你需要删除删除var文件夹下的升级文件";
$GLOBALS['strSystemCheck'] = "系统检查";
$GLOBALS['strDbSuccessIntro'] = "". MAX_PRODUCT_NAME ." 数据库已经更新。请点击“继续”按钮进入管理员与发布设定。";
$GLOBALS['strDbSuccessIntroUpgrade'] = "您的系统已被成功更新。后面的页面将帮助您升级新建广告服务器的配置。";
$GLOBALS['strErrorWritePermissions'] = "文件权限错误。\n<br />在Linux下修正这个错误，请输入以下命令:";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "文件权限错误。您必须先修正这个错误才可继续下一步。";
$GLOBALS['strCheckDocumentation'] = "需要帮助，请参阅 <a href='". OX_PRODUCT_DOCSURL ."'>". MAX_PRODUCT_NAME ."  文档<a/>.";
$GLOBALS['strAdminUrlPrefix'] = "管理员界面路径";
$GLOBALS['strDeliveryUrlPrefix'] = "发布引擎路径";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "发布引擎路径（SSL）";
$GLOBALS['strImagesUrlPrefix'] = "图片存储路径";
$GLOBALS['strImagesUrlPrefixSSL'] = "图片存储路径（SSL）";
$GLOBALS['strUnableToWriteConfig'] = "无法修改配置文件";
$GLOBALS['strUnableToWritePrefs'] = "无法向数据库提交属性更改";
$GLOBALS['strImageDirLockedDetected'] = "<b>图片文件夹</b>不可写<br>在修改文件夹权限之前无法修改或创建相关文件夹。\n";
$GLOBALS['strConfigurationSetup'] = "配置检查表";
$GLOBALS['strConfigurationSettings'] = "配置设置";
$GLOBALS['strAdminPassword'] = "管理员密码";
$GLOBALS['strAdministratorEmail'] = "管理员邮件地址";
$GLOBALS['strTimezoneInformation'] = "时区信息（时区的修改将影响统计数据）";
$GLOBALS['strTimezone'] = "时区";
$GLOBALS['strTimezoneEstimated'] = "预计时区";
$GLOBALS['strTimezoneGuessedValue'] = "在PHP设定中的时区不正确";
$GLOBALS['strTimezoneSeeDocs'] = "请参阅 %DOCS% 了解在PHP中设定这个变量的方法。";
$GLOBALS['strTimezoneDocumentation'] = "文档";
$GLOBALS['strLoginSettingsTitle'] = "管理员登录";
$GLOBALS['strLoginSettingsIntro'] = "为了继续升级，请输入您". MAX_PRODUCT_NAME ." 管理员登录信息。您必须以管理员身份登录，以继续安装。";
$GLOBALS['strAdminSettingsTitle'] = "创建管理员账号";
$GLOBALS['strAdminSettingsIntro'] = "请完成这个表格来创建您的广告服务器管理员账号。";
$GLOBALS['strEnableAutoMaintenance'] = "运行期间的自动维护还未设定";
$GLOBALS['strDefaultBannerDestination'] = "默认链接地址";
$GLOBALS['strDbType'] = "数据库类型";
$GLOBALS['strDemoDataInstall'] = "安装演示数据";
$GLOBALS['strDemoDataIntro'] = "将默认安装数据加载到 ". MAX_PRODUCT_NAME ." 中，可以帮助您初次启动在线广告服务。最常见的广告类型和一些初始广告项目会被加载并被预先配置。我们强烈推荐新安装的系统都这么做。";
$GLOBALS['strDebugSettings'] = "调试日志";
$GLOBALS['strDebug'] = "调试日志设置";
$GLOBALS['strProduction'] = "产品服务器";
$GLOBALS['strEnableDebug'] = "启用调试日志";
$GLOBALS['strDebugMethodNames'] = "在调试日志中包括方法名";
$GLOBALS['strDebugLineNumbers'] = "在调试日志中包括方线程号码";
$GLOBALS['strDebugType'] = "调试日志类型";
$GLOBALS['strDebugTypeFile'] = "文件";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL数据库";
$GLOBALS['strDebugTypeSyslog'] = "系统日志";
$GLOBALS['strDebugName'] = "除错日志名，日历，SQL表格或系统日志工具";
$GLOBALS['strDebugPriority'] = "除错优先级";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - 所有信息";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - 默认信息";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - 最少信息";
$GLOBALS['strDebugIdent'] = "调试鉴定弦";
$GLOBALS['strDebugUsername'] = "mCal, SQL 服务器用户名";
$GLOBALS['strDebugPassword'] = "mCal, SQL 服务器密码";
$GLOBALS['strWebPath'] = "". MAX_PRODUCT_NAME ." 服务器路径";
$GLOBALS['strWebPathSimple'] = "页面路径";
$GLOBALS['strDeliveryPath'] = "发布路径";
$GLOBALS['strImagePath'] = "图片路径";
$GLOBALS['strDeliverySslPath'] = "发布SSL路径";
$GLOBALS['strImageSslPath'] = "图片SSL路径";
$GLOBALS['strImageStore'] = "图片文件夹";
$GLOBALS['strTypeFTPPassive'] = "使用被动FTP";
$GLOBALS['strDeliveryFilenames'] = "全局发布文件名";
$GLOBALS['strDeliveryFilenamesAdClick'] = "广告点击";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "广告转化参数";
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
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "生成远程调用XML";
$GLOBALS['strDeliveryFilenamesLocal'] = "生成本地的";
$GLOBALS['strDeliveryFilenamesFrontController'] = "字体控制器";
$GLOBALS['strDeliveryFilenamesFlash'] = "包括Flash（可以使用绝对路径）";
$GLOBALS['strDeliveryCaching'] = "全局发送缓存设置";
$GLOBALS['strDeliveryCacheLimit'] = "缓存刷新频率（秒）";
$GLOBALS['strOrigin'] = "使用远程源服务器";
$GLOBALS['strOriginType'] = "源服务器类型";
$GLOBALS['strOriginHost'] = "源服务器主机名";
$GLOBALS['strOriginPort'] = "源数据库端口号";
$GLOBALS['strOriginScript'] = "源数据库脚本文件";
$GLOBALS['strOriginTypeXMLRPC'] = "远程调用XML";
$GLOBALS['strOriginTimeout'] = "源暂停（秒）";
$GLOBALS['strOriginProtocol'] = "源服务器协议";
$GLOBALS['strDeliveryBanner'] = "广告发送全局设置";
$GLOBALS['strDeliveryAcls'] = "在分发时评估广告的分发";
$GLOBALS['strDeliveryObfuscate'] = "混淆通道时广告";
$GLOBALS['strDeliveryExecPhp'] = "可在广告中使用PHP代码<br/>（可能存在安全隐患）";
$GLOBALS['strDeliveryCtDelimiter'] = "第三方广告跟踪分隔符";
$GLOBALS['strGeotargetingSettings'] = "地理定位设置";
$GLOBALS['strGeotargetingType'] = "地理定位模块类型";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP 区域数据库地址";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP 城市数据地址";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP 大区数据库地址";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP DMA 数据库地址";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP 组织数据库地址";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP数据库地址";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP网速数据地址";
$GLOBALS['strGeoSaveStats'] = "在数据日志中保存GeoIP数据";
$GLOBALS['strGeoShowUnavailable'] = "如果没有GeoIP数据，则提示地理定位发布条件";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "在指定位置没有MaxMind GeoIP 国家数据库";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "在指定位置没有MaxMind GeoIP 区域数据库";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "在指定位置没有MaxMind GeoIP 城市数据库";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "在指定位置没有MaxMind GeoIP 大区数据库";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "在指定位置没有MaxMind GeoIP DMA数据库";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "在指定位置没有MaxMind GeoIP 组织数据库";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "在指定位置没有MaxMind GeoIP ISP数据库";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "在指定位置没有MaxMind GeoIP 网速数据库";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "默认匿名项目";
$GLOBALS['strModesOfPayment'] = "支付方式";
$GLOBALS['strCurrencies'] = "现金";
$GLOBALS['strCategories'] = "分类";
$GLOBALS['strHelpFiles'] = "帮助文件";
$GLOBALS['strHasTaxID'] = "税务ID";
$GLOBALS['strDefaultApproved'] = "勾选的复选框";
$GLOBALS['strInvocationDefaults'] = "默认生成";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "默认启用第三方点击跟踪";
$GLOBALS['strStatisticsLogging'] = "全局统计登录设置";
$GLOBALS['strCsvImport'] = "允许上传离线转化结果";
$GLOBALS['strLogAdRequests'] = "广告的每次请求都需要记录";
$GLOBALS['strLogAdImpressions'] = "广告的每次浏览都需要记录";
$GLOBALS['strLogAdClicks'] = "广告的每次点击都需要记录";
$GLOBALS['strLogTrackerImpressions'] = "广告每次的跟踪曝光都需要记录";
$GLOBALS['strBlockAdViews'] = "如果浏览者在在指定时间（秒）内浏览同一个广告，不计算广告曝光量";
$GLOBALS['strBlockAdViewsError'] = "广告曝光块值必须非负整数";
$GLOBALS['strBlockAdClicks'] = "如果浏览者在在指定时间（秒）内点击同一个广告，不计算广告点击数";
$GLOBALS['strBlockAdClicksError'] = "阻挡广告点击值应该为非负整数";
$GLOBALS['strMaintenaceSettings'] = "全球管理设置";
$GLOBALS['strMaintenanceOI'] = "管理运行间隔（分钟）";
$GLOBALS['strMaintenanceOIError'] = "维护操作间隔设定不合法 - 请阅读文档中关于合法时间的定义";
$GLOBALS['strMaintenanceCompactStats'] = "处理后是否删除原始统计数据";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "删除原始统计前的宽限时间(秒)";
$GLOBALS['strPrioritySettings'] = "全局优先权设定";
$GLOBALS['strPriorityInstantUpdate'] = "修改后广告优先级立即生效";
$GLOBALS['strWarnCompactStatsGrace'] = "紧缩统计格式的宽限时间必须是正整数";
$GLOBALS['strDefaultImpConWindow'] = "默认广告曝光链接窗口（秒）";
$GLOBALS['strDefaultImpConWindowError'] = "默认广告曝光链接窗口数应该为正整数";
$GLOBALS['strDefaultCliConWindow'] = "默认广告点击链接窗口（秒）";
$GLOBALS['strDefaultCliConWindowError'] = "默认广告点击链接窗口数应该为正整数";
$GLOBALS['strWarnLimitDays'] = "在指定日期之前发送一封提醒邮件";
$GLOBALS['strWarnLimitDaysErr'] = "提醒限制日期应该是一个整数";
$GLOBALS['strWarnAgency'] = "邮件提醒代理商项目即将过期";
$GLOBALS['strDefaultTrackerStatus'] = "默认跟踪状态";
$GLOBALS['strDefaultTrackerType'] = "默认跟踪模式";
$GLOBALS['strMyLogo'] = "自定义logo文件名";
$GLOBALS['strMyLogoError'] = "admin/images目录下没有logo文件";
$GLOBALS['strGuiHeaderForegroundColor'] = "页眉前景颜色";
$GLOBALS['strGuiHeaderBackgroundColor'] = "页眉背景颜色";
$GLOBALS['strGuiActiveTabColor'] = "激活标签的颜色";
$GLOBALS['strGuiHeaderTextColor'] = "页眉文本的颜色";
$GLOBALS['strColorError'] = "请使用RGB格式输入颜色信息，如'0066CC'";
$GLOBALS['strReportsInterface'] = "报告界面";
$GLOBALS['strPublisherAgreementText'] = "登录文本(支持HTML标签)";
$GLOBALS['requireSSL'] = "强制使用SSL访问用户界面(UI)";
$GLOBALS['sslPort'] = "Web服务器使用的SSL端口";
$GLOBALS['strEmailAddress'] = "电子邮件地址";
$GLOBALS['strAllowEmail'] = "全局允许发送电子邮件";
$GLOBALS['strEmailAddressName'] = "发送停止活动电子邮件的公司或者人名";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strTermsIntro'] = "". MAX_PRODUCT_NAME ." 在遵守Open Source license, the GNU General Public License的情况下可以被自由分发使用，请查看以下文档并确认以继续安装过程";
$GLOBALS['strDbSetupIntro'] = "请输入详细信息连接到数据库。如果你不确定这些信息，请联系您的系统管理员。<p>下一步将为您创建数据库，请点击[继续]进入下一步</p>";
$GLOBALS['strSystemCheckIntro'] = "安装向导正在检查您的Web服务器设置以便保证安装过程已经成功完成。	<p>请检查被高亮的问题来结束安装过程.</p>";
$GLOBALS['strConfigSettingsIntro'] = "请检查以下设定，进行必需的修改，如果您不确定，请使用默认选项";
$GLOBALS['strOpenadsUsername'] = "". MAX_PRODUCT_NAME ." 用户名";
$GLOBALS['strOpenadsPassword'] = "". MAX_PRODUCT_NAME ." 密码";
$GLOBALS['uiEnabled'] = "启用用户界面";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP 国家数据库<br />(如果不填则使用免费数据库)";
$GLOBALS['strPublisherDefaults'] = "网站默认设置";
$GLOBALS['strPublisherInterface'] = "网站界面";
$GLOBALS['strPublisherAgreementEnabled'] = "允许对没有接受协议的网站进行登录控制";
$GLOBALS['strAuditTrailSettings'] = "审计追踪设置";
$GLOBALS['strDbSocket'] = "数据库套接字";
$GLOBALS['strEmailAddresses'] = "电子邮件\"From\"地址";
$GLOBALS['strEmailFromName'] = "电子邮件\"From\"姓名";
$GLOBALS['strEmailFromAddress'] = "电子邮件\"From\"邮件地址";
$GLOBALS['strEmailFromCompany'] = "电子邮件\"From\"公司";
$GLOBALS['strIgnoreUserAgents'] = "<b>不</b> 记录在用户代理中包括下列字符串的客户端统计信息（一个一行）";
$GLOBALS['strEnforceUserAgents'] = "<b>只</b> 记录在用户代理中包括下列字符串的客户端统计信息（一个一行）";
$GLOBALS['strConversionTracking'] = "转化跟踪器设置";
$GLOBALS['strEnableConversionTracking'] = "启用转化跟踪";
$GLOBALS['strDbNameHint'] = "如果没有发现数据库，它将被创建";
$GLOBALS['strProductionSystem'] = "生产系统";
$GLOBALS['strTypeFTPErrorUpload'] = "不能将文件上传到你的FTP服务器，请检查权限";
$GLOBALS['strBannerLogging'] = "图片日志设定";
$GLOBALS['strBannerDelivery'] = "广告发布设定";
$GLOBALS['strEnableDashboardSyncNotice'] = "如果您希望使用面板，请开启  <a href='account-settings-update.php'>检查更新</a>";
$GLOBALS['strDashboardSettings'] = "面板设置";
$GLOBALS['strGlobalDefaultBannerUrl'] = "全局默认广告图片URL";
$GLOBALS['strCantConnectToDbDelivery'] = "无法连接数据来发布信息";
$GLOBALS['strDefaultConversionStatus'] = "默认转化规则";
$GLOBALS['strDefaultConversionType'] = "默认转化规则";
?>