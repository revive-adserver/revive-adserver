<?php // $Revision: 2.3 $

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
$GLOBALS['strInstall']				= "安装";
$GLOBALS['strChooseInstallLanguage']		= "选择安装过程的语言";
$GLOBALS['strLanguageSelection']		= "选择语言";
$GLOBALS['strDatabaseSettings']			= "数据库设置";
$GLOBALS['strAdminSettings']			= "管理员设置";
$GLOBALS['strAdvancedSettings']			= "高级设置";
$GLOBALS['strOtherSettings']			= "其他设置";

$GLOBALS['strWarning']				= "警告";
$GLOBALS['strFatalError']			= "发生一个致命错误";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."已经安装. 如果您想配置系统,请到 <a href='settings-index.php'>设置界面</a>";
$GLOBALS['strCouldNotConnectToDB']		= "不能连接数据库,请检查您的设置";
$GLOBALS['strCreateTableTestFailed']		= "您提供的用户没有权限创建数据库结构,请联系数据库管理员.";
$GLOBALS['strUpdateTableTestFailed']		= "您提供的用户没有权限更新数据库结构,请联系数据库管理员.";
$GLOBALS['strTablePrefixInvalid']		= "数据表的前缀包含非法字符";
$GLOBALS['strTableInUse']			= "您提供的数据库已经被".$phpAds_productname."使用,请使用不同的表前缀,或者参考用户手册中系统升级的指导部分.";
$GLOBALS['strMayNotFunction']			= "进行下一步之前,请改正这些潜在的错误:";
$GLOBALS['strIgnoreWarnings']			= "忽略警告";
$GLOBALS['strWarningDBavailable']		= "您现在使用的PHP版本不支持".$phpAds_dbmsname."数据库.在进行下面的步骤之前,您需要启用PHP对".$phpAds_dbmsname."的支持";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname."需要PHP 4.0或者更高版本才能正常工作。您现在使用的版本是{php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP设置变量register_globals需要打开.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP设置变量magic_quotes_gpc需要打开.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP设置变量magic_quotes_runtime需要关闭.";
$GLOBALS['strWarningFileUploads']		= "PHP设置变量file_uploads需要打开.";
$GLOBALS['strWarningTrackVars']			= "PHP设置变量track_vars需要打开.";
$GLOBALS['strWarningPREG']			= "您现在使用的PHP版本不支持PERL兼容模式的正则表达式. 在进行下面的步骤之前,您需要启用PREL正则表达式的支持.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname."检测到您的配置文件<b>config.inc.php</b>不可写<br>请必须修改权限之后才能进行下一步.<br>如果您不知道如何操作请参考文档.";
$GLOBALS['strCantUpdateDB']  			= "现在不能更新数据库.如果您确认进行,所有已有的广告,报表和客户都会被删除.";
$GLOBALS['strTableNames']			= "数据表名字";
$GLOBALS['strTablesPrefix']			= "数据表前缀";
$GLOBALS['strTablesType']			= "数据表类型";

$GLOBALS['strInstallWelcome']			= "欢迎使用".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "在您使用".$phpAds_productname."之前,需要配置系统和<br>创建数据库.按<b>下一步</b>继续.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname."安装完成.</b><br><br>为了".$phpAds_productname."的正常使用,您还需要确认维护文件每小时运行一次,有关的信息可以参考相关文档.<br><br>按<b>下一步</b>进入配置页面,您可以进行更多的设置.在配置完成候请不要忘记锁定config.inc.php以保证安全.";
$GLOBALS['strUpdateSuccess']			= "<b>".$phpAds_productname."升级成功.</b><br><br>为了".$phpAds_productname."的正常使用,您还需要确认维护文件每小时运行一次,有关的信息可以参考相关文档.<br><br>按<b>下一步</b>进入配置页面,您可以进行更多的设置.在配置完成候请不要忘记锁定config.inc.php以保证安全.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname."安装不能完成</b><br><br>安装中的一些部分不能进行.这些问题可能只是暂时性的,这样您可以简单的按<b>下一步</b>并且返回到安装的第一步,如果您想知道更多关于错误的信息和如何解决,请参考相关文档.";
$GLOBALS['strErrorOccured']			= "有下面错误发生:";
$GLOBALS['strErrorInstallDatabase']		= "不能创建数据库.";
$GLOBALS['strErrorInstallConfig']		= "T配置文件或者数据库不能更新.";
$GLOBALS['strErrorInstallDbConnect']		= "不能连接到数据库.";

$GLOBALS['strUrlPrefix']			= "URL前缀";

$GLOBALS['strProceed']				= "下一步 &gt;";
$GLOBALS['strRepeatPassword']			= "确认密码";
$GLOBALS['strNotSamePasswords']			= "密码不匹配";
$GLOBALS['strInvalidUserPwd']			= "错误的用户名或密码";

$GLOBALS['strUpgrade']				= "升级";
$GLOBALS['strSystemUpToDate']			= "您的系统已经是最新版,现在不需要升级<br>按<b>下一步</b>回到首页.";
$GLOBALS['strSystemNeedsUpgrade']		= "数据库结构和配置文件需要升级才能正常工作。按<b>下一步</b>开始升级。<br>升级时间因数据库统计数据的多少而不同,这个过程可能引起系统数据库负载升高.请耐心等待,可能需要几分钟的时间.";
$GLOBALS['strSystemUpgradeBusy']		= "系统升级中，请稍候...";
$GLOBALS['strSystemRebuildingCache']		= "重建缓存区中，请稍候...";
$GLOBALS['strServiceUnavalable']		= "服务暂时不可用,系统升级中...";

$GLOBALS['strConfigNotWritable']		= "您的配置文件config.inc.php不可写";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "选择部分";
$GLOBALS['strDayFullNames'] 			= array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$GLOBALS['strEditConfigNotPossible']   		= "因为安全原因配置文件已经被锁定,所以不能修改配置<br>如果您想修改,您需要使config.inc.php文件可写.";
$GLOBALS['strEditConfigPossible']		= "现在可以修改所有配置,因为配置文件没有锁定,这样可能导致安全问题.<br>如果您想保护您的系统,您需要锁定config.inc.php文件.";



// Database
$GLOBALS['strDatabaseSettings']			= "数据库设置";
$GLOBALS['strDatabaseServer']			= "数据库设置";
$GLOBALS['strDbHost']				= "数据库主机";
$GLOBALS['strDbUser']				= "数据库用户名";
$GLOBALS['strDbPassword']			= "数据库密码";
$GLOBALS['strDbName']				= "数据库名字";
	
$GLOBALS['strDatabaseOptimalisations']		= "数据库优化";
$GLOBALS['strPersistentConnections']		= "使用永久连接";
$GLOBALS['strInsertDelayed']			= "使用延迟插入";
$GLOBALS['strCompatibilityMode']		= "使用数据库兼容模式";
$GLOBALS['strCantConnectToDb']			= "不能连接到数据库";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "调用和发送设置";
$GLOBALS['strAllowedInvocationTypes']		= "允许的调用方式";
$GLOBALS['strAllowRemoteInvocation']		= "允许远程调用";
$GLOBALS['strAllowRemoteJavascript']		= "允许远程调用Javascript";
$GLOBALS['strAllowRemoteFrames']		= "允许远程调用Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "允许远程调用XML-RPC";
$GLOBALS['strAllowLocalmode']			= "允许本地模式";
$GLOBALS['strAllowInterstitial']		= "允许空隙模式";
$GLOBALS['strAllowPopups']			= "允许弹出模式";

$GLOBALS['strUseAcl']				= "在发送过程中预估发送限制";

$GLOBALS['strDeliverySettings']			= "发送设置";
$GLOBALS['strCacheType']			= "发送缓冲区类型";
$GLOBALS['strCacheFiles']			= "文件";
$GLOBALS['strCacheDatabase']			= "数据库";
$GLOBALS['strCacheShmop']			= "共享内存(shmop)";
$GLOBALS['strKeywordRetrieval']			= "获取关键字";
$GLOBALS['strBannerRetrieval']			= "广告获取模式";
$GLOBALS['strRetrieveRandom']			= "随机广告获取(缺省)";
$GLOBALS['strRetrieveNormalSeq']		= "获取普通系列广告";
$GLOBALS['strWeightSeq']			= "获取权重系列广告";
$GLOBALS['strFullSeq']				= "获取全部系列的广告";
$GLOBALS['strUseConditionalKeys']		= "直接广告选取中允许使用逻辑操作";
$GLOBALS['strUseMultipleKeys']			= "直接广告选取中允许使用多个关键字";

$GLOBALS['strZonesSettings']			= "获取版位";
$GLOBALS['strZoneCache']			= "缓存版位，在使用版位时此选项能够提高运行速度";
$GLOBALS['strZoneCacheLimit']			= "缓存区更新的时间间隔(秒)";
$GLOBALS['strZoneCacheLimitErr']		= "缓存区更新的时间间隔应该是一个整数";

$GLOBALS['strP3PSettings']			= "P3P隐私策略";
$GLOBALS['strUseP3P']				= "使用P3P策略";
$GLOBALS['strP3PCompactPolicy']			= "P3P缩略策略";
$GLOBALS['strP3PPolicyLocation']		= "P3P策略位置"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "广告设置";

$GLOBALS['strAllowedBannerTypes']		= "允许的广告类型";
$GLOBALS['strTypeSqlAllow']			= "允许本地广告（本地数据库）";
$GLOBALS['strTypeWebAllow']			= "允许本地广告（本地网页服务器）";
$GLOBALS['strTypeUrlAllow']			= "允许外部广告";
$GLOBALS['strTypeHtmlAllow']			= "允许HTML广告";
$GLOBALS['strTypeTxtAllow']			= "允许文字广告";

$GLOBALS['strTypeWebSettings']			= "本地广告（本地网页服务器）设置";
$GLOBALS['strTypeWebMode']			= "存储方式";
$GLOBALS['strTypeWebModeLocal']			= "本地目录";
$GLOBALS['strTypeWebModeFtp']			= "外部Ftp服务器";
$GLOBALS['strTypeWebDir']			= "本地目录";
$GLOBALS['strTypeWebFtp']			= "Ftp模式广告服务器";
$GLOBALS['strTypeWebUrl']			= "公开的URL";
$GLOBALS['strTypeFTPHost']			= "FTP主机";
$GLOBALS['strTypeFTPDirectory']			= "主机目录";
$GLOBALS['strTypeFTPUsername']			= "登录";
$GLOBALS['strTypeFTPPassword']			= "密码";

$GLOBALS['strDefaultBanners']			= "缺省广告";
$GLOBALS['strDefaultBannerUrl']			= "缺省的图片URL";
$GLOBALS['strDefaultBannerTarget']		= "缺省的目标URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML广告选项";
$GLOBALS['strTypeHtmlAuto']			= "自动修改HTML广告以记录点击数";
$GLOBALS['strTypeHtmlPhp']			= "允许在HTML广告内执行php代码";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "主机信息和地域";

$GLOBALS['strRemoteHost']			= "远程主机";
$GLOBALS['strReverseLookup']			= "如果服务器没有提供访问者的主机名,反向查询域名";
$GLOBALS['strProxyLookup']			= "如果访问者使用了代理,查询真实IP地址";

$GLOBALS['strGeotargeting']			= "地域";
$GLOBALS['strGeotrackingType']			= "地域数据库类型";
$GLOBALS['strGeotrackingLocation'] 		= "地域数据库位置";
$GLOBALS['strGeoStoreCookie']			= "保存结果到cookie中供以后参考";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "报表设置";

$GLOBALS['strStatisticsFormat']			= "报表格式";
$GLOBALS['strCompactStats']			= "使用简洁模式";
$GLOBALS['strLogAdviews']			= "记录广告访问数";
$GLOBALS['strLogAdclicks']			= "记录广告点击数";
$GLOBALS['strLogSource']			= "记录调用过程中的来源参数";
$GLOBALS['strGeoLogStats']			= "记录访问者的国家";
$GLOBALS['strLogHostnameOrIP']			= "记录访问者的主机名和IP地址";
$GLOBALS['strLogIPOnly']			= "如果主机名未知,仅记录访问者的IP地址";
$GLOBALS['strLogIP']				= "记录访问者的IP地址";
$GLOBALS['strLogBeacon']			= "使用信号灯来记录广告访问数,可以保证只记录发送成功的广告";

$GLOBALS['strRemoteHosts']			= "远程主机";
$GLOBALS['strIgnoreHosts']			= "不记录下列IP地址或者主机名的访问者的数据";
$GLOBALS['strBlockAdviews']			= "如果访问者已经访问了广告,不记录同一广告访问数的时间间隔";
$GLOBALS['strBlockAdclicks']			= "如果访问者已经点击了广告,不记录同一广告点击数的时间间隔";


$GLOBALS['strEmailWarnings']			= "电子邮件警告";
$GLOBALS['strAdminEmailHeaders']		= "显示每日报表发送者的邮件头";
$GLOBALS['strWarnLimit']			= "警告限制";
$GLOBALS['strWarnLimitErr']			= "警告限制必须是一个正整数";
$GLOBALS['strWarnAdmin']			= "警告管理员";
$GLOBALS['strWarnClient']			= "警告客户";
$GLOBALS['strQmailPatch']			= "启用qmail补丁";

$GLOBALS['strAutoCleanTables']			= "自动清理数据库";
$GLOBALS['strAutoCleanStats']			= "清除统计数据";
$GLOBALS['strAutoCleanUserlog']			= "清除用户记录";
$GLOBALS['strAutoCleanStatsWeeks']		= "统计数据的最大寿命<br>(最小3周)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "用户记录的最大寿命<br>(最小3周)";
$GLOBALS['strAutoCleanErr']			= "最大寿命必须大于3周";
$GLOBALS['strAutoCleanVacuum']			= "每晚真空分析数据表"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "管理员设置";

$GLOBALS['strLoginCredentials']			= "登录信息";
$GLOBALS['strAdminUsername']			= "管理员名字";
$GLOBALS['strOldPassword']			= "旧密码";
$GLOBALS['strNewPassword']			= "新密码";
$GLOBALS['strInvalidUsername']			= "错误用户名";
$GLOBALS['strInvalidPassword']			= "错误密码";

$GLOBALS['strBasicInformation']			= "基本信息";
$GLOBALS['strAdminFullName']			= "管理员全名";
$GLOBALS['strAdminEmail']			= "管理员的电子邮件地址";
$GLOBALS['strCompanyName']			= "公司名字";

$GLOBALS['strAdminCheckUpdates']		= "检查更新";
$GLOBALS['strAdminCheckEveryLogin']		= "每次登录";
$GLOBALS['strAdminCheckDaily']			= "每天";
$GLOBALS['strAdminCheckWeekly']			= "每周";
$GLOBALS['strAdminCheckMonthly']		= "每月";
$GLOBALS['strAdminCheckNever']			= "从不";

$GLOBALS['strAdminNovice']			= "管理员的删除操作需要确认以保证安全";
$GLOBALS['strUserlogEmail']			= "记录发出的所有电子邮件信息";
$GLOBALS['strUserlogPriority']			= "记录每小时的优先级计算";
$GLOBALS['strUserlogAutoClean']			= "记录数据库的自动清理";


// User interface settings
$GLOBALS['strGuiSettings']			= "用户界面设置";

$GLOBALS['strGeneralSettings']			= "一般设置";
$GLOBALS['strAppName']				= "程序名字";
$GLOBALS['strMyHeader']				= "页面顶部";
$GLOBALS['strMyFooter']				= "页面底部";
$GLOBALS['strGzipContentCompression']		= "使用GZIP内容压缩";

$GLOBALS['strClientInterface']			= "客户界面";
$GLOBALS['strClientWelcomeEnabled']		= "启用客户欢迎信息";
$GLOBALS['strClientWelcomeText']		= "欢迎文字<br>(允许HTML标记)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "缺省界面";

$GLOBALS['strInventory']			= "详细目录";
$GLOBALS['strShowCampaignInfo']			= "在<i>项目总览</i>页面显示额外项目信息";
$GLOBALS['strShowBannerInfo']			= "在<i>广告总览</i>页面显示额外广告信息";
$GLOBALS['strShowCampaignPreview']		= "在<i>广告总览</i>页面显示所有广告的预览";
$GLOBALS['strShowBannerHTML']			= "HTML广告的预览显示实际的广告而不是普通HTML代码";
$GLOBALS['strShowBannerPreview']		= "在处理广告的页面顶部显示广告预览";
$GLOBALS['strHideInactive']			= "所有的总览页面隐藏已经停用的项目";
$GLOBALS['strGUIShowMatchingBanners']		= "在<i>连接广告</i>页面显示符合的广告";
$GLOBALS['strGUIShowParentCampaigns']		= "在<i>连接广告</i>页面显示上层项目";
$GLOBALS['strGUILinkCompactLimit']		= "在<i>连接广告</i>页面隐藏没有连接的项目或广告，当数目大于";

$GLOBALS['strStatisticsDefaults'] 		= "统计数据";
$GLOBALS['strBeginOfWeek']			= "一周的开始";
$GLOBALS['strPercentageDecimals']		= "百分比精确度";

$GLOBALS['strWeightDefaults']			= "缺省权重值";
$GLOBALS['strDefaultBannerWeight']		= "缺省广告权重值";
$GLOBALS['strDefaultCampaignWeight']		= "缺省项目权重值";
$GLOBALS['strDefaultBannerWErr']		= "缺省广告权重值应该是一个正整数";
$GLOBALS['strDefaultCampaignWErr']		= "缺省项目权重值应该是一个正整数";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "表格边的颜色";
$GLOBALS['strTableBackColor']			= "表格的背景色";
$GLOBALS['strTableBackColorAlt']		= "表格的背景色(可选)";
$GLOBALS['strMainBackColor']			= "主要背景色";
$GLOBALS['strOverrideGD']			= "覆盖GD图形库格式";
$GLOBALS['strTimeZone']				= "时区";

?>