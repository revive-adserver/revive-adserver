<?php // $Revision: 2.4 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/





// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']		= '.';


// Date & time configuration
$GLOBALS['date_format']				= "%d-%m-%Y";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m-%Y";
$GLOBALS['day_format']				= "%d-%m";
$GLOBALS['week_format']				= "%W-%Y";
$GLOBALS['weekiso_format']			= "%V-%G";



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome'] 				= "首页";
$GLOBALS['strHelp']				= "帮助";
$GLOBALS['strNavigation'] 			= "选项";
$GLOBALS['strShortcuts'] 			= "捷径";
$GLOBALS['strAdminstration'] 			= "系统管理";
$GLOBALS['strMaintenance']			= "系统维护";
$GLOBALS['strProbability']			= "访问比例";
$GLOBALS['strInvocationcode']			= "产生网页原始码";
$GLOBALS['strBasicInformation'] 		= "基本资料";
$GLOBALS['strContractInformation'] 		= "合同资料";
$GLOBALS['strLoginInformation'] 		= "登录资料";
$GLOBALS['strOverview']				= "总览";
$GLOBALS['strSearch']				= "<u>S</u>搜索";
$GLOBALS['strHistory']				= "历史纪录";
$GLOBALS['strPreferences'] 			= "喜好设置";
$GLOBALS['strDetails']				= "详细统计数据";
$GLOBALS['strCompact']				= "精简格式";
$GLOBALS['strVerbose']				= "完整格式";
$GLOBALS['strUser']				= "用户";
$GLOBALS['strEdit']				= "编辑";
$GLOBALS['strCreate']				= "新增";
$GLOBALS['strDuplicate']			= "复制";
$GLOBALS['strMoveTo']				= "移动到";
$GLOBALS['strDelete'] 				= "删除";
$GLOBALS['strActivate']				= "启用";
$GLOBALS['strDeActivate'] 			= "停用";
$GLOBALS['strConvert']				= "转换";
$GLOBALS['strRefresh']				= "更新";
$GLOBALS['strSaveChanges']		 	= "保存资料";
$GLOBALS['strUp'] 				= "上移";
$GLOBALS['strDown'] 				= "下移";
$GLOBALS['strSave'] 				= "保存";
$GLOBALS['strCancel']				= "取消";
$GLOBALS['strPrevious'] 			= "上一页";
$GLOBALS['strPrevious_Key'] 			= "<u>P</u>上一页";
$GLOBALS['strNext'] 				= "下一页";
$GLOBALS['strNext_Key'] 			= "<u>N</u>下一页";
$GLOBALS['strYes']				= "是";
$GLOBALS['strNo']				= "否";
$GLOBALS['strNone'] 				= "无";
$GLOBALS['strCustom']				= "自定义";
$GLOBALS['strDefault'] 				= "预设值";
$GLOBALS['strOther']				= "其他";
$GLOBALS['strUnknown']				= "未知";
$GLOBALS['strUnlimited'] 			= "无限制";
$GLOBALS['strUntitled']				= "未命名";
$GLOBALS['strAll'] 				= "全部";
$GLOBALS['strAvg'] 				= "平均";
$GLOBALS['strAverage']				= "平均";
$GLOBALS['strOverall'] 				= "概述";
$GLOBALS['strTotal'] 				= "总计";
$GLOBALS['strActive'] 				= "启用";
$GLOBALS['strFrom']				= "从";
$GLOBALS['strTo']				= "到";
$GLOBALS['strLinkedTo'] 			= "连结到";
$GLOBALS['strDaysLeft'] 			= "剩余天数";
$GLOBALS['strCheckAllNone']			= "检查所有 / 无";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "<u>E</u>全部展开";
$GLOBALS['strCollapseAll']			= "<u>C</u>全部收起";
$GLOBALS['strShowAll']				= "列出全部";
$GLOBALS['strNoAdminInteface']			= "服务不可用...";
$GLOBALS['strFilterBySource']			= "经过源过滤";
$GLOBALS['strFieldContainsErrors']		= "以下字段包含错误:";
$GLOBALS['strFieldFixBeforeContinue1']		= "在进行下一步之前必须";
$GLOBALS['strFieldFixBeforeContinue2']		= "改正错误";
$GLOBALS['strDelimiter']			= "分隔符";
$GLOBALS['strMiscellaneous']			= "杂项";
$GLOBALS['strCollectedAll']			= "所有收集的统计数据";
$GLOBALS['strCollectedToday']			= "今天的统计数据";
$GLOBALS['strCollected7Days']			= "七天内的统计数据";
$GLOBALS['strCollectedMonth']			= "本月的统计数据";
$GLOBALS['strUseQuotes']			= "使用引号";



// Properties
$GLOBALS['strName']				= "名称";
$GLOBALS['strSize']				= "尺寸";
$GLOBALS['strWidth'] 				= "宽度";
$GLOBALS['strHeight'] 				= "高度";
$GLOBALS['strURL2']				= "广告连结网址";
$GLOBALS['strTarget']				= "目标";
$GLOBALS['strLanguage'] 			= "语言";
$GLOBALS['strDescription'] 			= "内容描述";
$GLOBALS['strID']				= "代码";


// Login & Permissions
$GLOBALS['strAuthentification']			= "认证信息";
$GLOBALS['strWelcomeTo']			= "欢迎访问";
$GLOBALS['strEnterUsername']			= "输入您的用户名和密码登录";
$GLOBALS['strEnterBoth']			= "请输入您的用户名和密码";
$GLOBALS['strEnableCookies']			= "您必须启用cookies才能使用".$phpAds_productname;
$GLOBALS['strLogin'] 				= "登录";
$GLOBALS['strLogout'] 				= "注销";
$GLOBALS['strUsername'] 			= "用户名";
$GLOBALS['strPassword']				= "密码";
$GLOBALS['strAccessDenied']			= "无权访问";
$GLOBALS['strPasswordWrong']			= "密码错误";
$GLOBALS['strNotAdmin']				= "您的权限等级不足";
$GLOBALS['strDuplicateClientName']		= "您所选用的使用者代码已经有人使用了，请更换其他的使用者代码。";
$GLOBALS['strInvalidPassword']                  = "新密码不合法,请使用别的密码.";
$GLOBALS['strNotSamePasswords']                 = "您两次输入的密码不匹配";
$GLOBALS['strRepeatPassword']                   = "确认密码";
$GLOBALS['strOldPassword']                      = "旧密码";
$GLOBALS['strNewPassword']                      = "新密码";



// General advertising
$GLOBALS['strViews'] 				= "广告访问数";
$GLOBALS['strClicks']				= "广告点击数";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTR'] 				= "广告点击比 (CTR)";
$GLOBALS['strTotalViews'] 			= "总计访问数";
$GLOBALS['strTotalClicks'] 			= "总计点击数";
$GLOBALS['strViewCredits'] 			= "访问数购买量";
$GLOBALS['strClickCredits'] 			= "点击数购买量";


// Time and date related
$GLOBALS['strDate'] 				= "日期";
$GLOBALS['strToday'] 				= "本日";
$GLOBALS['strDay']				= "日期";
$GLOBALS['strDays']				= "日期";
$GLOBALS['strLast7Days']			= "最后 7 天";
$GLOBALS['strWeek'] 				= "周数";
$GLOBALS['strWeeks']				= "周数";
$GLOBALS['strMonths']				= "月";
$GLOBALS['strThisMonth'] 			= "本月";
$GLOBALS['strMonth'] 				= array("一月","二月","三月","四月","五月","六月","七月", "八月", "九月", "十月", "十一月", "十二月");
$GLOBALS['strDayShortCuts'] 			= array("周日","周一","周二","周三","周四","周五","周六");
$GLOBALS['strHour']				= "小时";
$GLOBALS['strSeconds']				= "秒";
$GLOBALS['strMinutes']				= "分";
$GLOBALS['strHours']				= "小时";
$GLOBALS['strTimes']				= "时间";


// Advertiser
$GLOBALS['strClient']				= "客户";
$GLOBALS['strClients'] 				= "客户";
$GLOBALS['strClientsAndCampaigns']		= "客户&项目";
$GLOBALS['strAddClient'] 			= "新增客户";
$GLOBALS['strAddClient_Key'] 			= "<u>n</u>新增客户";
$GLOBALS['strTotalClients'] 			= "客户总数";
$GLOBALS['strClientProperties']			= "客户属性";
$GLOBALS['strClientHistory']			= "客户历史";
$GLOBALS['strNoClients']			= "现在还没有客户";
$GLOBALS['strConfirmDeleteClient'] 		= "是否确定要删除此客户?";
$GLOBALS['strConfirmResetClientStats']		= "是否确定要删除此客户统计数据?";
$GLOBALS['strHideInactiveAdvertisers']		= "隐藏停用的客户";
$GLOBALS['strInactiveAdvertisersHidden']	= "停用的客户已经隐藏";


// Advertisers properties
$GLOBALS['strContact'] 				= "联系人";
$GLOBALS['strEMail'] 				= "电子邮件信箱";
$GLOBALS['strSendAdvertisingReport']		= "使用电子邮件传送广告报表";
$GLOBALS['strNoDaysBetweenReports']		= "广告报表寄送间隔天数";
$GLOBALS['strSendDeactivationWarning']		= "当广告项目被停用时发送警告电子邮件";
$GLOBALS['strAllowClientModifyInfo'] 		= "允许该使用者更动客户基本资料";
$GLOBALS['strAllowClientModifyBanner'] 		= "允许该使用者更动广告内容";
$GLOBALS['strAllowClientAddBanner'] 		= "允许该使用者新增广告";
$GLOBALS['strAllowClientDisableBanner'] 	= "允许该使用者停用广告";
$GLOBALS['strAllowClientActivateBanner'] 	= "允许该使用者启用广告";


// Campaign
$GLOBALS['strCampaign']				= "项目";
$GLOBALS['strCampaigns']			= "项目";
$GLOBALS['strTotalCampaigns'] 			= "项目总数";
$GLOBALS['strActiveCampaigns'] 			= "启用中项目总数";
$GLOBALS['strAddCampaign'] 			= "新增项目";
$GLOBALS['strAddCampaign_Key'] 			= "<u>n</u>新增项目";
$GLOBALS['strCreateNewCampaign']		= "新增项目";
$GLOBALS['strModifyCampaign']			= "编辑项目";
$GLOBALS['strMoveToNewCampaign']		= "移动至新的项目";
$GLOBALS['strBannersWithoutCampaign']		= "不属於任何项目的广告";
$GLOBALS['strDeleteAllCampaigns']		= "删除所有项目";
$GLOBALS['strCampaignStats']			= "项目统计";
$GLOBALS['strCampaignProperties']		= "项目属性";
$GLOBALS['strCampaignOverview']			= "项目总览";
$GLOBALS['strCampaignHistory']			= "项目历史";
$GLOBALS['strNoCampaigns']			= "现在没有任何项目存在";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "是否确定要删除此客户的所有项目?";
$GLOBALS['strConfirmDeleteCampaign']		= "是否确定要删除此项目?";
$GLOBALS['strConfirmResetCampaignStats']	= "是否确定要删除此项目的所有统计数据?";
$GLOBALS['strHideInactiveCampaigns']		= "隐藏停用的项目";
$GLOBALS['strInactiveCampaignsHidden']		= "停用的项目已经隐藏";


// Campaign properties
$GLOBALS['strDontExpire']			= "此项目永远不失效";
$GLOBALS['strActivateNow'] 			= "即刻启用此项目";
$GLOBALS['strLow']				= "低";
$GLOBALS['strHigh']				= "高";
$GLOBALS['strExpirationDate']			= "失效日期";
$GLOBALS['strActivationDate']			= "启用日期";
$GLOBALS['strViewsPurchased'] 			= "广告访问次数剩余量";
$GLOBALS['strClicksPurchased'] 			= "广告点击次数剩余量";
$GLOBALS['strCampaignWeight']			= "项目比重";
$GLOBALS['strHighPriority']			= "此项目的广告具有高优先权。<br>如果你用此项，本广告系统将尽量在期限内平均分配广告访问数。";
$GLOBALS['strLowPriority']			= "此项目的广告具有低优先权。<br>此项目将使用除了高优先权的项目之外的广告访问数。";
$GLOBALS['strTargetLimitAdviews']		= "限制广告访问数到";
$GLOBALS['strTargetPerDay']			= "每天";
$GLOBALS['strPriorityAutoTargeting']		= "把剩余的广告数平均分配到剩余的日期。目标广告访问数将因此每天重新设置。";
$GLOBALS['strCampaignWarningNoWeight']		= "此项目的优先权已经设为低,\n但是比重设置为零或者没有指定.\n这可能引起项目被设为无效,\n在比重设置为一个有效数值之前项目的广告将不能被发送. \n\n是否确认继续?";
$GLOBALS['strCampaignWarningNoTarget']		= "此项目的优先权已经设为高,\n但是广告访问数的目标值没有指定.\n这可能引起项目被设为无效,\n在广告访问数的目标值设置为一个有效数值之前项目的广告将不能被发送. \n\n是否确认继续?";



// Banners (General)
$GLOBALS['strBanner'] 				= "广告";
$GLOBALS['strBanners'] 				= "广告";
$GLOBALS['strAddBanner'] 			= "新增广告";
$GLOBALS['strAddBanner_Key'] 			= "<u>n</u>新增广告";
$GLOBALS['strModifyBanner'] 			= "编辑广告内容";
$GLOBALS['strActiveBanners'] 			= "启用中广告数";
$GLOBALS['strTotalBanners'] 			= "广告总数";
$GLOBALS['strShowBanner']			= "显示广告";
$GLOBALS['strShowAllBanners']	 		= "列出全部广告";
$GLOBALS['strShowBannersNoAdClicks']		= "列出无点选数的广告";
$GLOBALS['strShowBannersNoAdViews']		= "列出无推播数的广告";
$GLOBALS['strDeleteAllBanners']	 		= "删除所有广告";
$GLOBALS['strActivateAllBanners']		= "启用所有广告";
$GLOBALS['strDeactivateAllBanners']		= "停用所有广告";
$GLOBALS['strBannerOverview']			= "广告总览";
$GLOBALS['strBannerProperties']			= "广告属性";
$GLOBALS['strBannerHistory']			= "广告历史";
$GLOBALS['strBannerNoStats'] 			= "目前没有这个广告的统计数据";
$GLOBALS['strNoBanners']			= "目前没有任何广告";
$GLOBALS['strConfirmDeleteBanner']		= "是否确定删除此广告?";
$GLOBALS['strConfirmDeleteAllBanners']		= "是否确定要删除此项目的所有广告?";
$GLOBALS['strConfirmResetBannerStats']		= "是否确定要删除此广告的所有统计数据?";
$GLOBALS['strShowParentCampaigns']		= "显示上层项目";
$GLOBALS['strHideParentCampaigns']		= "隐藏上层项目";
$GLOBALS['strHideInactiveBanners']		= "隐藏停用的广告";
$GLOBALS['strInactiveBannersHidden']		= "停用的广告已经隐藏";
$GLOBALS['strAppendOthers']			= "附加其它";
$GLOBALS['strAppendTextAdNotPossible']		= "不能为文字广告附加其它广告";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "请选择广告储存方式";
$GLOBALS['strMySQLBanner'] 			= "广告图形保存于 SQL 数据库";
$GLOBALS['strWebBanner'] 			= "广告图形储存於网页主机上";
$GLOBALS['strURLBanner'] 			= "广告图形连结到特定网址";
$GLOBALS['strHTMLBanner'] 			= "HTML 文件型广告";
$GLOBALS['strTextBanner'] 			= "文字型广告";
$GLOBALS['strAutoChangeHTML']			= "自动转换 HTML 原始码以记录广告点选数";
$GLOBALS['strUploadOrKeep']			= "您想保留现有的图形<br>或者您想另外上传?";
$GLOBALS['strNewBannerFile'] 			= "请选择此广告您想使用的图片<br><br>";
$GLOBALS['strNewBannerURL'] 			= "广告图形网址 (包含 http://)";
$GLOBALS['strURL'] 				= "广告连结网址 (包含 http://)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "广告图形下方文字";
$GLOBALS['strKeyword'] 				= "关键字";
$GLOBALS['strWeight'] 				= "项目权重";
$GLOBALS['strAlt'] 				= "说明文字";
$GLOBALS['strStatusText']			= "状态列文字";
$GLOBALS['strBannerWeight']			= "广告权重";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "检查Flash文件中固定的超链接";
$GLOBALS['strConvertSWFLinks']			= "C转换Flash超链接";
$GLOBALS['strHardcodedLinks']			= "固定连接";
$GLOBALS['strConvertSWF']			= "<br>您刚才上载的Flash文件中包含了固定的超链接。phpAdsNew 将不能跟踪此广告的点击数，除非您转换此固定超链接。下面是在此Flash文件中找到的超链接的列表，如果您想转换此超链接，只需要简单的按<b>转换</b>，否则按<b>取消</b>.<br><br>请注意：如果您选择<b>转换</b>您刚才所上载的Flash文件将被修改。<br>请保留以前的备份文件。无论你广告的flash版本是什么，最后的文件需要Flash 4播放器（或者更高）才能正确播放。<br><br>";
$GLOBALS['strCompressSWF']			= "压缩SWF文件可以更快下载(需要Flash 6)";
$GLOBALS['strOverwriteSource']			= "修改源参数";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "HTML 模板";
$GLOBALS['strChooseNetwork']			= "选择您想使用的模板";
$GLOBALS['strMoreInformation']			= "更多信息...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "跟踪广告点击";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "发送限制";
$GLOBALS['strACL'] 				= "发送";
$GLOBALS['strACLAdd'] 				= "新增限制";
$GLOBALS['strACLAdd_Key'] 			= "<u>n</u>新增限制";
$GLOBALS['strNoLimitations']			= "无限制";
$GLOBALS['strApplyLimitationsTo']		= "应用限制";
$GLOBALS['strRemoveAllLimitations']		= "删除所有限制";
$GLOBALS['strEqualTo']				= "符合";
$GLOBALS['strDifferentFrom']			= "不符合";
$GLOBALS['strLaterThan']			= "晚于";
$GLOBALS['strLaterThanOrEqual']			= "晚于或等于";
$GLOBALS['strEarlierThan']			= "早于";
$GLOBALS['strEarlierThanOrEqual']		= "早于或等于";
$GLOBALS['strContains']				= "包含";
$GLOBALS['strNotContains']			= "不包含";
$GLOBALS['strAND']				= "AND";  						// logical operator
$GLOBALS['strOR']				= "OR"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "当下列条件成立时才显示广告：";
$GLOBALS['strWeekDay'] 				= "星期 (0 - 6)";
$GLOBALS['strTime'] 				= "时间";
$GLOBALS['strUserAgent'] 			= "使用者浏览器(Regexp)";
$GLOBALS['strDomain'] 				= "网域名称 (不含点)";
$GLOBALS['strClientIP'] 			= "使用者來源IP地址";
$GLOBALS['strSource'] 				= "来源代码";
$GLOBALS['strBrowser'] 				= "浏览";
$GLOBALS['strOS'] 				= "操作系统";
$GLOBALS['strCountry'] 				= "国家";
$GLOBALS['strContinent'] 			= "洲";
$GLOBALS['strUSState'] 				= "美国";
$GLOBALS['strReferer'] 				= "参考页面";
$GLOBALS['strDeliveryLimitations']		= "发送限制";
$GLOBALS['strDeliveryCapping']			= "发送封顶";
$GLOBALS['strTimeCapping']			= "此广告显示一次之后，对同一用户不再显示的时间间隔:";
$GLOBALS['strImpressionCapping']		= "此广告对同一用户显示不超过：";


// Publisher
$GLOBALS['strAffiliate']			= "发布者";
$GLOBALS['strAffiliates']			= "发布者";
$GLOBALS['strAffiliatesAndZones']		= "发布者&版位";
$GLOBALS['strAddNewAffiliate']			= "增加新发布者";
$GLOBALS['strAddNewAffiliate_Key']		= "<u>n</u>增加新发布者";
$GLOBALS['strAddAffiliate']			= "创建发布者";
$GLOBALS['strAffiliateProperties']		= "发布者属性";
$GLOBALS['strAffiliateOverview']		= "发布者总览";
$GLOBALS['strAffiliateHistory']			= "发布者历史";
$GLOBALS['strZonesWithoutAffiliate']	 	= "没有发布者的版位";
$GLOBALS['strMoveToNewAffiliate']		= "移动到新的发布者";
$GLOBALS['strNoAffiliates']			= "目前没有任何发布者存在";
$GLOBALS['strConfirmDeleteAffiliate']		= "是否确定删除此发布者?";
$GLOBALS['strMakePublisherPublic']		= "使此发布者所有的所有版位可以使用";


// Publisher (properties)
$GLOBALS['strWebsite']				= "站点";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "允许此用户修改个人设置";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "允许此用户修改个人版位";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "允许此用户连接广告到本人版位";
$GLOBALS['strAllowAffiliateAddZone'] 		= "允许此用户增加新的版位";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "允许此用户删除版位";


// Zone
$GLOBALS['strZone']				= "版位";
$GLOBALS['strZones']				= "版位";
$GLOBALS['strAddNewZone']			= "增加新版位";
$GLOBALS['strAddNewZone_Key']			= "<u>n</u>增加新版位";
$GLOBALS['strAddZone']				= "创建版位";
$GLOBALS['strModifyZone']			= "编辑版位";
$GLOBALS['strLinkedZones']			= "连结版位";
$GLOBALS['strZoneOverview']			= "版位总览";
$GLOBALS['strZoneProperties']			= "版位属性";
$GLOBALS['strZoneHistory']			= "版位历史";
$GLOBALS['strNoZones']				= "目前没有任何版位";
$GLOBALS['strConfirmDeleteZone']		= "是否确定要删除此版位？Do you really want to delete this zone?";
$GLOBALS['strZoneType']				= "版位类型Zone type";
$GLOBALS['strBannerButtonRectangle']		= "横幅，按钮或矩形";
$GLOBALS['strInterstitial']			= "空隙或漂浮的动态HTML";
$GLOBALS['strPopup']				= "弹出式";
$GLOBALS['strTextAdZone']			= "文字广告";
$GLOBALS['strShowMatchingBanners']		= "显示匹配的广告条";
$GLOBALS['strHideMatchingBanners']		= "隐藏匹配的广告条";


// Advanced zone settings
$GLOBALS['strAdvanced']				= "高级设置";
$GLOBALS['strChains']				= "链表";
$GLOBALS['strChainSettings']			= "链表设置";
$GLOBALS['strZoneNoDelivery']			= "如果此版位没有广告<br>能够发放，将...";
$GLOBALS['strZoneStopDelivery']			= "停止发放并且不显示任何广告";
$GLOBALS['strZoneOtherZone']			= "显示选定的版位";
$GLOBALS['strZoneUseKeywords']			= "请选择一个用下面关键字的广告";
$GLOBALS['strZoneAppend']			= "此版面所显示的广告上总是添加下面的HTML代码";
$GLOBALS['strAppendSettings']			= "添加和预先设置";
$GLOBALS['strZonePrependHTML']			= "此版面所显示的文字广告上预先加上HTML代码";
$GLOBALS['strZoneAppendHTML']			= "此版面所显示的文字广告上附加上HTML代码";
$GLOBALS['strZoneAppendSelectZone']		= "总是在此版位的广告上附加下面的弹出式或者空隙调用代码";


// Zone probability
$GLOBALS['strZoneProbListChain']		= "所有连接到此版位的广告现在并不生效,下面是应该跟随的版位链:";
$GLOBALS['strZoneProbNullPri']			= "所有连接到此版位的广告现在不能被激活";
$GLOBALS['strZoneProbListChainLoop']		= "跟随版位链将形成一个死循环,所以此版位的发送停止";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "请选择版位与广告连结的查询方式";
$GLOBALS['strBannerSelection']			= "选择广告";
$GLOBALS['strCampaignSelection']		= "选择项目";
$GLOBALS['strInteractive']			= "互动连结";
$GLOBALS['strRawQueryString']			= "关键字";
$GLOBALS['strIncludedBanners']			= "连结广告";
$GLOBALS['strLinkedBannersOverview']		= "连结广告";
$GLOBALS['strLinkedBannerHistory']		= "连结广告历史";
$GLOBALS['strNoZonesToLink']			= "目前没有版位可以和此广告连结";
$GLOBALS['strNoBannersToLink']			= "目前没有广告可以和此版位连接";
$GLOBALS['strNoLinkedBanners']			= "目前没有广告可以和此版位连接";
$GLOBALS['strMatchingBanners']			= "{count}符合的广告";
$GLOBALS['strNoCampaignsToLink']		= "目前没有项目可以和此版位连接";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "目前没有版位可以和此项目连结";
$GLOBALS['strSelectBannerToLink']		= "请您选择要连接到此版位的广告:";
$GLOBALS['strSelectCampaignToLink']		= "请您选择要连接到此版位的项目:";


// Append
$GLOBALS['strAppendType']				= "附加方式";
$GLOBALS['strAppendHTMLCode']			= "HTML代码";
$GLOBALS['strAppendWhat']				= "您想附加什么?";
$GLOBALS['strAppendZone']				= "附加一个指定的版位";
$GLOBALS['strAppendErrorZone']			= "您需要选择一个版位才能继续\\n.否则不能附加广告.";
$GLOBALS['strAppendBanner']				= "附加一个或多个单独的广告";
$GLOBALS['strAppendErrorBanner']		= "您需要选择一个或多个广告才能继续\\n,否则不能附加广告.";
$GLOBALS['strAppendKeyword']			= "使用关键字来附加广告";
$GLOBALS['strAppendErrorKeyword']		= "您需要指定一个或多个关键字才能继续\\n,否则不能附加广告.";


// Statistics
$GLOBALS['strStats'] 				= "统计数据";
$GLOBALS['strNoStats']				= "目前没有可用的统计数据";
$GLOBALS['strConfirmResetStats']		= "是否确定要删除现有的所有统计数据?";
$GLOBALS['strGlobalHistory']			= "全局历史";
$GLOBALS['strDailyHistory']			= "每日历史";
$GLOBALS['strDailyStats'] 			= "每日统计数据";
$GLOBALS['strWeeklyHistory']			= "每周历史";
$GLOBALS['strMonthlyHistory']			= "每月历史";
$GLOBALS['strCreditStats'] 			= "广告存量统计数据";
$GLOBALS['strDetailStats'] 			= "详细统计数据";
$GLOBALS['strTotalThisPeriod']			= "周期统计";
$GLOBALS['strAverageThisPeriod']		= "周期平均";
$GLOBALS['strDistribution']			= "分类";
$GLOBALS['strResetStats'] 			= "重新开始统计";
$GLOBALS['strSourceStats']			= "来源统计数据";
$GLOBALS['strSelectSource']			= "请选择您想查看的来源：";
$GLOBALS['strSizeDistribution']			= "按广告大小分类";
$GLOBALS['strCountryDistribution']		= "按国家分类";
$GLOBALS['strEffectivity']			= "有效";
$GLOBALS['strTargetStats']			= "目标数据统计";
$GLOBALS['strCampaignTarget']			= "目标";
$GLOBALS['strTargetRatio']			= "目标比例";
$GLOBALS['strTargetModifiedDay']		= "目标数据当天被修改，所以目标可能并不精确";
$GLOBALS['strTargetModifiedWeek']		= "目标数据当周被修改，所以目标可能并不精确";
$GLOBALS['strTargetModifiedMonth']		= "目标数据当月被修改，所以目标可能并不精确";
$GLOBALS['strNoTargetStats']			= "目前没有关于目标的统计数据";


// Hosts
$GLOBALS['strHosts']				= "主机";
$GLOBALS['strTopHosts'] 			= "前10位访问的主机";
$GLOBALS['strTopCountries'] 			= "前10位访问的国家";
$GLOBALS['strRecentHosts'] 			= "最经常访问的主机";


// Expiration
$GLOBALS['strExpired']				= "已失效";
$GLOBALS['strExpiration'] 			= "广告失效日期";
$GLOBALS['strNoExpiration'] 			= "未设定失效日期";
$GLOBALS['strEstimated'] 			= "估计失效日期";


// Reports
$GLOBALS['strReports']				= "广告报表";
$GLOBALS['strSelectReport']			= "请选择您想产生的报表";


// Userlog
$GLOBALS['strUserLog']				= "用户记录";
$GLOBALS['strUserLogDetails']			= "用户详细记录";
$GLOBALS['strDeleteLog']			= "删除记录";
$GLOBALS['strAction']				= "活动";
$GLOBALS['strNoActionsLogged']			= "没有活动记录";


// Code generation
$GLOBALS['strGenerateBannercode']		= "直接选择";
$GLOBALS['strChooseInvocationType']		= "请选择广告代码类型";
$GLOBALS['strGenerate']				= "产生";
$GLOBALS['strParameters']			= "参数设置";
$GLOBALS['strFrameSize']			= "分页尺寸";
$GLOBALS['strBannercode']			= "广告代码";
$GLOBALS['strOptional']				= "选择项";


// Errors
$GLOBALS['strMySQLError'] 			= "SQL 错误讯息:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] 从数据库读取客户的时候发生了一个错误.";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] 从数据库读取广告的时候发生了一个错误.";
$GLOBALS['strLogErrorViews'] 			= "[phpAds] 从数据库读取广告访问数的时候发生了一个错误.";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] 从数据库读取广告点击数的时候发生了一个错误.";
$GLOBALS['strErrorViews'] 			= "您必须填写访问数量或选择无限制选项!";
$GLOBALS['strErrorNegViews'] 			= "访问数量无法使用负数";
$GLOBALS['strErrorClicks'] 			= "您必须填写点击数量或选择无限制选项!";
$GLOBALS['strErrorNegClicks'] 			= "访问数量无法使用负数";
$GLOBALS['strNoMatchesFound']			= "没有找到符合的资料";
$GLOBALS['strErrorOccurred']			= "发生了一个错误";
$GLOBALS['strErrorUploadSecurity']		= "发现一个可能的安全漏洞,停止上载!";
$GLOBALS['strErrorUploadBasedir']		= "可能是因为php的安全模式设置或者open_basedir参数的限制,不能访问上载的文件";
$GLOBALS['strErrorUploadUnknown']		= "因为一个未知错误,不能访问上载的文件,请检查您的php设置";
$GLOBALS['strErrorStoreLocal']			= "在把广告保存到本地目录的时候发生了一个错误.这可能因为本地目录权限的错误设置";
$GLOBALS['strErrorStoreFTP']			= "在把广告通过FTP服务器上传的时候发生了一个错误.这可能因为服务器不能用或者FTP服务器的错误设置";
$GLOBALS['strErrorDBPlain']			= "检测到数据库的一个错误";
$GLOBALS['strErrorDBSerious']			= "检测到数据库的一个严重问题";
$GLOBALS['strErrorDBNoDataPlain']		= "因为数据库的一个错误,".$phpAds_productname."不能获取和存储数据.";
$GLOBALS['strErrorDBNoDataSerious']		= "因为数据库的一个严重问题,".$phpAds_productname."不能获取和存储数据.";
$GLOBALS['strErrorDBCorrupt']			= "数据表可能崩溃,需要修复.需要更多关于修复崩溃数据表的信息请查看<i>管理员手册</i>中<i>故障修复</i>一章";
$GLOBALS['strErrorDBContact']			= "请联系此服务器的管理员,通知他这个问题.";
$GLOBALS['strErrorDBSubmitBug']			= "如果此问题反复发生,可能是".$phpAds_productname."中的一个Bug所引起.请把下面的信息报告给".$phpAds_productname."的创建者.并且尽可能详细地描述引起此错误的操作过程.";
$GLOBALS['strMaintenanceNotActive']		= "维护脚本在最近24小时中没有运行,\n脚本必须每个小时运行一次,\n".$phpAds_productname."才能正常工作.\n\n请查看管理员手册来获取更多关于配置维护脚本的信息.";



// E-mail
$GLOBALS['strMailSubject'] 			= "广告报表";
$GLOBALS['strAdReportSent']			= "广告报表已寄送完成";
$GLOBALS['strMailSubjectDeleted']		= "已停用广告";
$GLOBALS['strMailHeader'] 			= "亲爱的{contact},\n";
$GLOBALS['strMailBannerStats'] 			= "以下为客户{clientname}的广告统计数据:";
$GLOBALS['strMailFooter'] 			= "致礼,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "下列广告已经被停用，原因是：";
$GLOBALS['strMailNothingLeft'] 			= "如果您愿意继续在我们网站刊登广告,请和我们联络,\n我们非常乐意为您服务.";
$GLOBALS['strClientDeactivated']		= "此项目已经被停用,原因是:";
$GLOBALS['strBeforeActivate']			= "广告启用日期未到";
$GLOBALS['strAfterExpire']			= "广告失效日期已到";
$GLOBALS['strNoMoreClicks']			= "已达点击数购买量";
$GLOBALS['strNoMoreViews']			= "已达访问数购买量";
$GLOBALS['strWeightIsNull']			= "此权重设置为零";
$GLOBALS['strWarnClientTxt']			= "您的广告访问数或点击数存量已剩下 {limit}次。\n当访问数或点击数存量已用尽时，您的广告将会自动停用.";
$GLOBALS['strViewsClicksLow']			= "广告访问数或点击数存量过低";
$GLOBALS['strNoViewLoggedInInterval']  		= "本报告的统计期间中没有任何的访问动作";
$GLOBALS['strNoClickLoggedInInterval']  	= "本报告的统计期间中没有任何的点击动作";
$GLOBALS['strMailReportPeriod']			= "本报表包含了自{startdate}至{enddate}的统计数据.";
$GLOBALS['strMailReportPeriodAll']		= "本报表包含了至{enddate}的所有统计数据.";
$GLOBALS['strNoStatsForCampaign'] 		= "本项目目前没有统计数据";


// Priority
$GLOBALS['strPriority']				= "优先权";


// Settings
$GLOBALS['strSettings'] 			= "系统设置";
$GLOBALS['strGeneralSettings']			= "一般设置";
$GLOBALS['strMainSettings']			= "主要设置";
$GLOBALS['strAdminSettings']			= "管理员设置";


// Product Updates
$GLOBALS['strProductUpdates']			= "产品升级";




/*********************************************************/
/* Keyboard shortcut assignments                         */
/*********************************************************/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']		= 'h';
$GLOBALS['keyUp']		= 'u';
$GLOBALS['keyNextItem']		= '.';
$GLOBALS['keyPreviousItem']	= ',';
$GLOBALS['keyList']		= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']		= 's';
$GLOBALS['keyCollapseAll']	= 'c';
$GLOBALS['keyExpandAll']	= 'e';
$GLOBALS['keyAddNew']		= 'n';
$GLOBALS['keyNext']		= 'n';
$GLOBALS['keyPrevious']		= 'p';

?>
