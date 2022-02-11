<?php

/*
  +---------------------------------------------------------------------------+
  | Revive Adserver                                                           |
  | http://www.revive-adserver.com                                            |
  |                                                                           |
  | Copyright: See the COPYRIGHT.txt file.                                    |
  | License: GPLv2 or later, see the LICENSE.txt file.                        |
  +---------------------------------------------------------------------------+
 */

// Set text direction and characterset

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%Y-%m-%d";
$GLOBALS['month_format'] = "%Y-%m";
$GLOBALS['day_format'] = "%m-%d";
$GLOBALS['week_format'] = "%Y-%W";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "首页";
$GLOBALS['strHelp'] = "帮助";
$GLOBALS['strStartOver'] = "重新开始";
$GLOBALS['strShortcuts'] = "快捷方式";
$GLOBALS['strActions'] = "操作";
$GLOBALS['strAdminstration'] = "库存";
$GLOBALS['strMaintenance'] = "维护";
$GLOBALS['strProbability'] = "权重";
$GLOBALS['strInvocationcode'] = "生成代码";
$GLOBALS['strBasicInformation'] = "基本信息";
$GLOBALS['strAppendTrackerCode'] = "附加追踪器代码";
$GLOBALS['strOverview'] = "查看";
$GLOBALS['strSearch'] = "搜索（<u>S</u>）";
$GLOBALS['strDetails'] = "详细";
$GLOBALS['strUpdateSettings'] = "更新设置";
$GLOBALS['strCheckForUpdates'] = "检查新版本";
$GLOBALS['strWhenCheckingForUpdates'] = "检查新版本时";
$GLOBALS['strCompact'] = "精简视图";
$GLOBALS['strUser'] = "用户";
$GLOBALS['strDuplicate'] = "重复";
$GLOBALS['strCopyOf'] = "副本";
$GLOBALS['strMoveTo'] = "移至";
$GLOBALS['strDelete'] = "删除";
$GLOBALS['strActivate'] = "启用";
$GLOBALS['strConvert'] = "转化";
$GLOBALS['strRefresh'] = "刷新";
$GLOBALS['strSaveChanges'] = "保存";
$GLOBALS['strUp'] = "向上";
$GLOBALS['strDown'] = "向下";
$GLOBALS['strSave'] = "保存​​";
$GLOBALS['strCancel'] = "取消";
$GLOBALS['strBack'] = "返回";
$GLOBALS['strPrevious'] = "上一页";
$GLOBALS['strNext'] = "下一页";
$GLOBALS['strYes'] = "是";
$GLOBALS['strNo'] = "否";
$GLOBALS['strNone'] = "无";
$GLOBALS['strCustom'] = "自定义";
$GLOBALS['strDefault'] = "默认";
$GLOBALS['strUnknown'] = "未知";
$GLOBALS['strUnlimited'] = "无限制";
$GLOBALS['strUntitled'] = "未命名";
$GLOBALS['strAll'] = "全部";
$GLOBALS['strAverage'] = "平均";
$GLOBALS['strOverall'] = "总计";
$GLOBALS['strTotal'] = "总计";
$GLOBALS['strFrom'] = "从";
$GLOBALS['strTo'] = "到";
$GLOBALS['strAdd'] = "添加";
$GLOBALS['strLinkedTo'] = "链接到";
$GLOBALS['strDaysLeft'] = "剩余天数";
$GLOBALS['strCheckAllNone'] = "全选";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "展开（<u>E</u>）";
$GLOBALS['strCollapseAll'] = "折叠（<u>C</u>）";
$GLOBALS['strShowAll'] = "显示所有";
$GLOBALS['strNoAdminInterface'] = "管理屏幕已关闭以进行维护。 这不会影响您的市场活动的交付。";
$GLOBALS['strFieldContainsErrors'] = "以下字段包含错误：";
$GLOBALS['strFieldFixBeforeContinue1'] = "在您可以继续之前，您需要";
$GLOBALS['strFieldFixBeforeContinue2'] = "更正这些错误。";
$GLOBALS['strMiscellaneous'] = "杂项";
$GLOBALS['strCollectedAllStats'] = "所有统计数据";
$GLOBALS['strCollectedToday'] = "今天";
$GLOBALS['strCollectedYesterday'] = "昨天";
$GLOBALS['strCollectedThisWeek'] = "本周";
$GLOBALS['strCollectedLastWeek'] = "上周";
$GLOBALS['strCollectedThisMonth'] = "本月";
$GLOBALS['strCollectedLastMonth'] = "上月";
$GLOBALS['strCollectedLast7Days'] = "过去 7 天";
$GLOBALS['strCollectedSpecificDates'] = "自定义";
$GLOBALS['strValue'] = "值";
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strNotice'] = "通知";

// Dashboard
// Dashboard Errors
$GLOBALS['strDashboardSystemMessage'] = "系统消息";
$GLOBALS['strDashboardErrorHelp'] = "如果此错误重复出现，请描述问题详情并在 <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a> 上发布。";

// Priority
$GLOBALS['strPriority'] = "优先级";
$GLOBALS['strPriorityLevel'] = "优先级";
$GLOBALS['strOverrideAds'] = "优先广告";
$GLOBALS['strHighAds'] = "Contract Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Advertisements";
$GLOBALS['strLowAds'] = "普通项目";

// Properties
$GLOBALS['strName'] = "名称";
$GLOBALS['strSize'] = "规格";
$GLOBALS['strWidth'] = "宽";
$GLOBALS['strHeight'] = "高";
$GLOBALS['strTarget'] = "目标窗口";
$GLOBALS['strLanguage'] = "语言";
$GLOBALS['strDescription'] = "详细描述";
$GLOBALS['strVariables'] = "变量";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "详细描述";

// User access
$GLOBALS['strWorkingAs'] = "用户组";
$GLOBALS['strWorkingAs_Key'] = "用户组（<u>W</u>）";
$GLOBALS['strWorkingAs'] = "用户组";
$GLOBALS['strSwitchTo'] = "切换到";
$GLOBALS['strWorkingFor'] = "%s 账户";
$GLOBALS['strRecentlyUsed'] = "最近使用";
$GLOBALS['strLinkUser'] = "添加";
$GLOBALS['strLinkUser_Key'] = "添加新的用户（<u>U</u>）";
$GLOBALS['strUsernameToLink'] = "用户名";
$GLOBALS['strNewUserWillBeCreated'] = "正在添加新的用户";
$GLOBALS['strToLinkProvideEmail'] = "请输入 Email";
$GLOBALS['strToLinkProvideUsername'] = "请输入用户名";
$GLOBALS['strUserAccountUpdated'] = "用户已经成功更新。";
$GLOBALS['strUserWasDeleted'] = "用户已经彻底删除。";
$GLOBALS['strLinkUserHelpUser'] = "用户名";
$GLOBALS['strLinkUserHelpEmail'] = "Email";
$GLOBALS['strDateLinked'] = "添加日期";

// Login & Permissions
$GLOBALS['strUserAccess'] = "用户";
$GLOBALS['strAdminAccess'] = "管理员权限";
$GLOBALS['strUserProperties'] = "用户";
$GLOBALS['strPermissions'] = "权限";
$GLOBALS['strAuthentification'] = "身份验证";
$GLOBALS['strWelcomeTo'] = "欢迎使用";
$GLOBALS['strEnterUsername'] = "请输入您的用户名和密码";
$GLOBALS['strEnterBoth'] = "请输入您的用户名和密码";
$GLOBALS['strEnableCookies'] = "在使用 {$PRODUCT_NAME} 之前，您需要启用 cookie功能。";
$GLOBALS['strSessionIDNotMatch'] = "会话出现错误，请重新登录。";
$GLOBALS['strLogin'] = "登录";
$GLOBALS['strLogout'] = "注销";
$GLOBALS['strUsername'] = "用户名";
$GLOBALS['strPassword'] = "密码";
$GLOBALS['strPasswordRepeat'] = "密码确认";
$GLOBALS['strAccessDenied'] = "访问被拒绝";
$GLOBALS['strUsernameOrPasswordWrong'] = "用户名或密码不正确，请再试一次。";
$GLOBALS['strPasswordWrong'] = "密码不正确。";
$GLOBALS['strNotAdmin'] = "您的帐户没有使用此功能所需的权限，您可以登录到其它帐户使用。";
$GLOBALS['strDuplicateClientName'] = "该用户名已存在，请使用其它用户名。";
$GLOBALS['strInvalidPassword'] = "新密码不可用，请使用其它密码。";
$GLOBALS['strInvalidEmail'] = "邮箱格式不正确，请使用正确的邮箱地址。";
$GLOBALS['strNotSamePasswords'] = "密码输入不一致。";
$GLOBALS['strRepeatPassword'] = "密码确认";
$GLOBALS['strDeadLink'] = "您的链接已失效。";
$GLOBALS['strNoPlacement'] = "您选择的Camaign不存在。请尝试 这个<a href='{link}'>link</a>。";

// General advertising
$GLOBALS['strRequests'] = "投放请求";
$GLOBALS['strImpressions'] = "素材展示";
$GLOBALS['strClicks'] = "素材点击";
$GLOBALS['strConversions'] = "数据追踪";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCTR'] = "点击率";
$GLOBALS['strTotalClicks'] = "总点击次数";
$GLOBALS['strTotalConversions'] = "总转化数";
$GLOBALS['strDateTime'] = "时间";
$GLOBALS['strTrackerID'] = "追踪器 ID";
$GLOBALS['strTrackerName'] = "追踪器名称";
$GLOBALS['strTrackerImageTag'] = "图片";
$GLOBALS['strTrackerJsTag'] = "Javascript";
$GLOBALS['strBanners'] = "素材";
$GLOBALS['strCampaigns'] = "项目";
$GLOBALS['strCampaignID'] = "项目 ID";
$GLOBALS['strCampaignName'] = "项目名称";
$GLOBALS['strCountry'] = "国家";
$GLOBALS['strStatsAction'] = "行为";
$GLOBALS['strWindowDelay'] = "时延";
$GLOBALS['strStatsVariables'] = "变量";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "包月";
$GLOBALS['strFinanceCTR'] = "CTR";

// Time and date related
$GLOBALS['strDate'] = "日期";
$GLOBALS['strDay'] = "日期";
$GLOBALS['strDays'] = "天";
$GLOBALS['strWeek'] = "周";
$GLOBALS['strWeeks'] = "周";
$GLOBALS['strSingleMonth'] = "个月";
$GLOBALS['strMonths'] = "个月";
$GLOBALS['strDayOfWeek'] = "星期";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = '周日';
$GLOBALS['strDayFullNames'][1] = '周一';
$GLOBALS['strDayFullNames'][2] = '週二';
$GLOBALS['strDayFullNames'][3] = '周三';
$GLOBALS['strDayFullNames'][4] = '周四';
$GLOBALS['strDayFullNames'][5] = '周五';
$GLOBALS['strDayFullNames'][6] = '周六';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = '日';
$GLOBALS['strDayShortCuts'][1] = '一';
$GLOBALS['strDayShortCuts'][2] = '二';
$GLOBALS['strDayShortCuts'][3] = '三';
$GLOBALS['strDayShortCuts'][4] = '四';
$GLOBALS['strDayShortCuts'][5] = '五';
$GLOBALS['strDayShortCuts'][6] = '六';

$GLOBALS['strHour'] = "小时";
$GLOBALS['strSeconds'] = "秒";
$GLOBALS['strMinutes'] = "分钟";
$GLOBALS['strHours'] = "小时";

// Advertiser
$GLOBALS['strClient'] = "客户";
$GLOBALS['strClients'] = "客户";
$GLOBALS['strClientsAndCampaigns'] = "按项目";
$GLOBALS['strAddClient'] = "添加新的客户";
$GLOBALS['strClientProperties'] = "客户";
$GLOBALS['strNoClients'] = "您还没有添加客户。在添加新的项目前，您需要先<a href='advertiser-edit.php'>添加客户</a>。";
$GLOBALS['strConfirmDeleteClient'] = "您真的要删除这个客户吗？";
$GLOBALS['strConfirmDeleteClients'] = "您真的要删除所有选中的客户吗？";
$GLOBALS['strHideInactive'] = "隐藏没有投放记录的行";
$GLOBALS['strInactiveAdvertisersHidden'] = "个没有投放记录的客户已被隐藏";
$GLOBALS['strAdvertiserCampaigns'] = "查看项目列表";

// Advertisers properties
$GLOBALS['strContact'] = "联系人";
$GLOBALS['strContactName'] = "姓名";
$GLOBALS['strSendAdvertisingReport'] = "通过 Email 发送项目报表";
$GLOBALS['strNoDaysBetweenReports'] = "项目报表发送周期（天）";
$GLOBALS['strSendDeactivationWarning'] = "当系统自动启用或停用项目投放时通过 Email 发送通知";
$GLOBALS['strAllowClientModifyBanner'] = "修改素材";
$GLOBALS['strAllowClientDisableBanner'] = "停用素材";
$GLOBALS['strAllowClientActivateBanner'] = "启用素材";
$GLOBALS['strAdvertiserLimitation'] = "禁止在同一个页面上重复投放属于该客户的素材";
$GLOBALS['strAllowAuditTrailAccess'] = "查看日志";

// Campaign
$GLOBALS['strCampaign'] = "项目";
$GLOBALS['strCampaigns'] = "项目";
$GLOBALS['strAddCampaign'] = "添加新的项目";
$GLOBALS['strAddCampaign_Key'] = "添加新的项目（<u>N</u>）";
$GLOBALS['strCampaignForAdvertiser'] = "到";
$GLOBALS['strLinkedCampaigns'] = "项目关联";
$GLOBALS['strCampaignProperties'] = "项目";
$GLOBALS['strCampaignOverview'] = "项目近况";
$GLOBALS['strNoCampaigns'] = "您还没有为该客户添加项目。";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "您还没有添加项目。在添加新的项目前，您需要先<a href='advertiser-edit.php'>添加客户</a>。";
$GLOBALS['strConfirmDeleteCampaign'] = "您真的要删除该项目吗？";
$GLOBALS['strConfirmDeleteCampaigns'] = "您真的要删除所有选中的项目吗？";
$GLOBALS['strShowParentAdvertisers'] = "显示项目所属的客户";
$GLOBALS['strHideParentAdvertisers'] = "隐藏项目所属的客户";
$GLOBALS['strHideInactiveCampaigns'] = "隐藏未启用的项目";
$GLOBALS['strInactiveCampaignsHidden'] = "个未启用的项目已被隐藏";
$GLOBALS['strPriorityInformation'] = "权重";
$GLOBALS['strECPMInformation'] = "eCPM 优先级";
$GLOBALS['strHiddenCampaign'] = "项目";
$GLOBALS['strHiddenAdvertiser'] = "客户";
$GLOBALS['strHiddenTracker'] = "追踪器";
$GLOBALS['strHiddenWebsite'] = "媒体";
$GLOBALS['strHiddenZone'] = "广告位";
$GLOBALS['strCampaignDelivery'] = "项目对比";
$GLOBALS['strCompanionPositioning'] = "尝试在同一页面集中投放该项目的素材";
$GLOBALS['strSelectUnselectAll'] = "全选";
$GLOBALS['strCampaignsOfAdvertiser'] = "属于"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "对不支持 cookie 的用户忽略投放控制";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "所有项目";
$GLOBALS['strCalculatedForThisCampaign'] = "仅该项目";
$GLOBALS['strLinkingZonesProblem'] = "Problem occured when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occured when unlinking zones";
$GLOBALS['strZonesLinked'] = "个版位已经成功关联";
$GLOBALS['strZonesUnlinked'] = "个版位已经成功解除关联";
$GLOBALS['strZonesSearch'] = "搜索";
$GLOBALS['strZonesSearchTitle'] = "按名称搜索媒体或广告位";
$GLOBALS['strNoWebsitesAndZones'] = "没有媒体或广告位";
$GLOBALS['strToLink'] = "可以关联";
$GLOBALS['strToUnlink'] = "可以解除关联";
$GLOBALS['strLinked'] = "关联";
$GLOBALS['strAvailable'] = "可用";
$GLOBALS['strShowing'] = "显示";
$GLOBALS['strEditZone'] = "编辑广告位";
$GLOBALS['strEditWebsite'] = "编辑媒体";


// Campaign properties
$GLOBALS['strDontExpire'] = "长期投放";
$GLOBALS['strActivateNow'] = "立即启用";
$GLOBALS['strSetSpecificDate'] = "指定日期";
$GLOBALS['strLow'] = "低";
$GLOBALS['strHigh'] = "高";
$GLOBALS['strExpirationDate'] = "停用日期";
$GLOBALS['strExpirationDateComment'] = "指定该项目投放周期的最后一天";
$GLOBALS['strActivationDate'] = "启用日期";
$GLOBALS['strActivationDateComment'] = "指定该项目投放周期的第一天";
$GLOBALS['strImpressionsRemaining'] = "剩余展示量";
$GLOBALS['strClicksRemaining'] = "剩余点击";
$GLOBALS['strConversionsRemaining'] = "剩余转化";
$GLOBALS['strImpressionsBooked'] = "素材展示上限";
$GLOBALS['strClicksBooked'] = "素材点击上限";
$GLOBALS['strConversionsBooked'] = "数据追踪上限";
$GLOBALS['strCampaignWeight'] = "权重";
$GLOBALS['strAnonymous'] = "隐藏该项目的客户以及该项目关联的媒体";
$GLOBALS['strTargetPerDay'] = " / 天";
$GLOBALS['strCampaignStatusInactive'] = "已停用";
$GLOBALS['strCampaignStatusRunning'] = "正在投放";
$GLOBALS['strCampaignStatusPaused'] = "已暂停";
$GLOBALS['strCampaignStatusAwaiting'] = "即将启用";
$GLOBALS['strCampaignStatusExpired'] = "已过期";
$GLOBALS['strCampaignStatusApproval'] = "待批准";
$GLOBALS['strCampaignStatusRejected'] = "已拒绝";
$GLOBALS['strCampaignStatusAdded'] = "已添加";
$GLOBALS['strCampaignStatusStarted'] = "已启用";
$GLOBALS['strCampaignStatusRestarted'] = "已重新启用";
$GLOBALS['strCampaignStatusDeleted'] = "已删除";
$GLOBALS['strCampaignType'] = "项目类型";
$GLOBALS['strType'] = "类型";
$GLOBALS['strContract'] = "标准合同";
$GLOBALS['strOverride'] = "优先";
$GLOBALS['strStandardContract'] = "标准合同";
$GLOBALS['strStandardContractInfo'] = "通过控制每天的投放量，保证该项目的总投放量均匀分布到投放周期中的每一天。";
$GLOBALS['strRemnant'] = "普通项目";
$GLOBALS['strRemnantInfo'] = "无特殊规则的普通项目。";
$GLOBALS['strPricing'] = "结算";
$GLOBALS['strPricingModel'] = "结算方式";
$GLOBALS['strSelectPricingModel'] = "-- 选择结算方式 --";
$GLOBALS['strRatePrice'] = "单价";
$GLOBALS['strMinimumImpressions'] = "每日最低展示量";
$GLOBALS['strLimit'] = "限制";
$GLOBALS['strWhyDisabled'] = "为何禁用？";
$GLOBALS['strBackToCampaigns'] = "返回项目列表";
$GLOBALS['strCampaignBanners'] = "转到素材列表";
$GLOBALS['strCookies'] = "Cookie";

// Tracker
$GLOBALS['strTracker'] = "追踪器";
$GLOBALS['strTrackers'] = "追踪器";
$GLOBALS['strAddTracker'] = "添加新的追踪器";
$GLOBALS['strTrackerForAdvertiser'] = "到";
$GLOBALS['strNoTrackers'] = "您还没有为该客户添加追踪器";
$GLOBALS['strConfirmDeleteTrackers'] = "您真的要删除所有选中的追踪器吗？";
$GLOBALS['strConfirmDeleteTracker'] = "您真的要删除该追踪器吗？";
$GLOBALS['strTrackerProperties'] = "追踪器";
$GLOBALS['strDefaultStatus'] = "默认审核状态";
$GLOBALS['strStatus'] = "状态";
$GLOBALS['strLinkedTrackers'] = "追踪器关联";
$GLOBALS['strTrackerInformation'] = "追踪器信息";
$GLOBALS['strConversionWindow'] = "数据追踪有效期限";
$GLOBALS['strUniqueWindow'] = "指定时间段内唯一";
$GLOBALS['strClick'] = "点击";
$GLOBALS['strView'] = "查看";
$GLOBALS['strManual'] = "手动";
$GLOBALS['strImpression'] = "素材展示";
$GLOBALS['strConversionType'] = "数据类型";
$GLOBALS['strLinkCampaignsByDefault'] = "自动关联新的项目";
$GLOBALS['strBackToTrackers'] = "返回追踪器列表";
$GLOBALS['strIPAddress'] = "IP 地址";

// Banners (General)
$GLOBALS['strBanner'] = "素材";
$GLOBALS['strBanners'] = "素材";
$GLOBALS['strAddBanner'] = "添加新的素材";
$GLOBALS['strAddBanner_Key'] = "添加新的素材（<u>N</u>）";
$GLOBALS['strBannerToCampaign'] = "到";
$GLOBALS['strShowBanner'] = "显示素材";
$GLOBALS['strBannerProperties'] = "素材";
$GLOBALS['strNoBanners'] = "您还没有为该项目添加素材。";
$GLOBALS['strNoBannersAddCampaign'] = "您还没有添加素材。在添加新的素材前，您需要先<a href='campaign-edit.php?clientid=%s'>添加项目</a>。";
$GLOBALS['strNoBannersAddAdvertiser'] = "您还没有添加素材。在添加新的素材前，您需要先<a href='advertiser-edit.php'>添加客户</a>。";
$GLOBALS['strConfirmDeleteBanner'] = "删除素材会同时删除相关的投放记录。\\n您真的要删除该素材吗？";
$GLOBALS['strConfirmDeleteBanners'] = "删除素材会同时删除相关的投放记录。\\n您真的要删除所有选中的素材吗？";
$GLOBALS['strShowParentCampaigns'] = "显示素材所属的项目";
$GLOBALS['strHideParentCampaigns'] = "隐藏素材所属的项目";
$GLOBALS['strHideInactiveBanners'] = "隐藏停用的素材";
$GLOBALS['strInactiveBannersHidden'] = "个停用的素材已被隐藏";
$GLOBALS['strBannersOfCampaign'] = "属于"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "素材";
$GLOBALS['strCampaignPreferences'] = "项目";
$GLOBALS['strDefaultBanners'] = "默认素材";
$GLOBALS['strDefaultBannerUrl'] = "默认图片 URL";
$GLOBALS['strDefaultBannerDestination'] = "默认着陆页 URL";
$GLOBALS['strAllowedBannerTypes'] = "允许的Banner类型";
$GLOBALS['strTypeSqlAllow'] = "允许 SQL 本地Banner";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "请选择素材的类型";
$GLOBALS['strMySQLBanner'] = "上传本地Banner到数据库";
$GLOBALS['strWebBanner'] = "上传本地图片到服务器";
$GLOBALS['strURLBanner'] = "链接到外部Banner";
$GLOBALS['strHTMLBanner'] = "创建HTML Banner";
$GLOBALS['strTextBanner'] = "创建一个文本素材";
$GLOBALS['strUploadOrKeep'] = "您希望保持现有的图片，还是上传新的图片？";
$GLOBALS['strNewBannerFile'] = "请选择您要上传的图片<br /><br /><br />";
$GLOBALS['strNewBannerURL'] = "图片 URL (包括 http://)";
$GLOBALS['strURL'] = "着陆页 URL（包括 http://）";
$GLOBALS['strKeyword'] = "关键字";
$GLOBALS['strTextBelow'] = "图片下方显示文字";
$GLOBALS['strWeight'] = "权重";
$GLOBALS['strAlt'] = "图片无法显示时的替换文字";
$GLOBALS['strStatusText'] = "状态栏信息";
$GLOBALS['strBannerWeight'] = "Banner权重";
$GLOBALS['strAdserverTypeGeneric'] = "通用 HTML Banner";
$GLOBALS['strGenericOutputAdServer'] = "一般";
$GLOBALS['strBackToBanners'] = "返回素材列表";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "在素材前附加 HTML 代码";
$GLOBALS['strBannerAppendHTML'] = "在素材后附加 HTML 代码";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "投放控制";
$GLOBALS['strACL'] = "投放控制";
$GLOBALS['strAllBannersInCampaign'] = "该项目下的所有素材";
$GLOBALS['strOnlyDisplayWhen'] = "仅当符合条件时显示素材：";
$GLOBALS['strWeekDays'] = "工作日";
$GLOBALS['strTime'] = "时间";
$GLOBALS['strDomain'] = "域名";
$GLOBALS['strSource'] = "来源";
$GLOBALS['strBrowser'] = "浏览器";
$GLOBALS['strOS'] = "操作系统";

$GLOBALS['strDeliveryCappingReset'] = "投放控制周期";
$GLOBALS['strDeliveryCappingTotal'] = "次（总计）";
$GLOBALS['strDeliveryCappingSession'] = "次／会话";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['limit'] = "限制展示";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "限制展示";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "限制展示";

// Website
$GLOBALS['strAffiliate'] = "媒体";
$GLOBALS['strAffiliates'] = "媒体";
$GLOBALS['strAffiliatesAndZones'] = "按版位";
$GLOBALS['strAddNewAffiliate'] = "添加新的媒体";
$GLOBALS['strAffiliateProperties'] = "媒体";
$GLOBALS['strNoAffiliates'] = "您还没有添加媒体。在添加新的版位前，您需要先<a href='affiliate-edit.php'>添加媒体</a>。";
$GLOBALS['strConfirmDeleteAffiliate'] = "您真的要删除该媒体吗？";
$GLOBALS['strConfirmDeleteAffiliates'] = "您真的要删除所有选中的媒体吗？";
$GLOBALS['strShowParentAffiliates'] = "显示版位所属的媒体";
$GLOBALS['strHideParentAffiliates'] = "隐藏版位所属的媒体";

// Website (properties)
$GLOBALS['strWebsite'] = "媒体";
$GLOBALS['strWebsiteURL'] = "媒体 URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "修改版位";
$GLOBALS['strAllowAffiliateLinkBanners'] = "设置素材关联";
$GLOBALS['strAllowAffiliateAddZone'] = "添加新的版位";
$GLOBALS['strAllowAffiliateDeleteZone'] = "删除版位";
$GLOBALS['strAllowAffiliateGenerateCode'] = "生成广告代码";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "邮编";
$GLOBALS['strCountry'] = "国家";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "查看版位列表";

// Zone
$GLOBALS['strZone'] = "广告位";
$GLOBALS['strZones'] = "版位";
$GLOBALS['strAddNewZone'] = "添加新的版位";
$GLOBALS['strAddNewZone_Key'] = "添加新的版位（<u>N</u>）";
$GLOBALS['strZoneToWebsite'] = "到";
$GLOBALS['strLinkedZones'] = "版位关联";
$GLOBALS['strAvailableZones'] = "可关联的版位";
$GLOBALS['strZoneProperties'] = "版位";
$GLOBALS['strZoneHistory'] = "投放记录";
$GLOBALS['strNoZones'] = "您还没有为该媒体添加版位。";
$GLOBALS['strNoZonesAddWebsite'] = "您还没有添加版位。在添加新的版位前，您需要先<a href='affiliate-edit.php'>添加媒体</a>。";
$GLOBALS['strConfirmDeleteZone'] = "您真的要删除该版位吗？";
$GLOBALS['strConfirmDeleteZones'] = "您真的要删除所有选中的版位吗？";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "检测到该版位有项目关联。如果您删除它，这些关联将被解除。这可能会影响您的收入。";
$GLOBALS['strZoneType'] = "版位类型";
$GLOBALS['strBannerButtonRectangle'] = "图片（横幅、按钮、矩形等）";
$GLOBALS['strInterstitial'] = "DHTML";
$GLOBALS['strTextAdZone'] = "文字链接";
$GLOBALS['strEmailAdZone'] = "Email";
$GLOBALS['strZoneVideoInstream'] = "嵌入视频";
$GLOBALS['strZoneVideoOverlay'] = "悬浮视频";
$GLOBALS['strShowMatchingBanners'] = "显示项目及素材";
$GLOBALS['strHideMatchingBanners'] = "仅显示项目列表";
$GLOBALS['strCampaignLinkedAds'] = "关联到该版位的项目";
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled.  Contact your Administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = '属于'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "返回版位列表";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB 标准全尺寸旗标（468 x 60）";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB 标准摩天大楼（120 x 600）";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB 标准排行榜（728 x 90）";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB 标准按钮 1（120 x 90）";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB 标准按钮 2（120 x 60）";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB 标准半尺寸旗标（234 x 60）";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB 标准小旗标（88 x 31）";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB 标准方形按钮（125 x 125）";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB 标准小尺寸矩形（180 x 150）";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB 标准方形弹窗（250 x 250）";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB 标准纵向旗标（120 x 240）";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB 标准中等尺寸矩形（300 x 250）";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB 标准大尺寸矩形（336 x 280）";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB 标准纵向矩形（240 x 400）";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB 标准加宽摩天大楼（160 x 600）";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB 标准后台弹窗（720 x 300）";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 标准 3:1 矩形（300 x 100）";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "高级";
$GLOBALS['strChainSettings'] = "版位链设置";
$GLOBALS['strZoneNoDelivery'] = "当该版位关联的所有素材都无法展示时...";
$GLOBALS['strZoneStopDelivery'] = "不展示任何素材";
$GLOBALS['strZoneOtherZone'] = "展示其它版位的素材";
$GLOBALS['strZoneAppend'] = "在该版位展示的素材后附加 HTML 代码";
$GLOBALS['strAppendSettings'] = "附加代码";
$GLOBALS['strZonePrependHTML'] = "在该版位展示的素材前附加 HTML 代码";
$GLOBALS['strZoneAppendNoBanner'] = "在没有任何素材展示时仍然投放附加代码";

// Zone probability

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "请选择关联方式";
$GLOBALS['strLinkedBanners'] = "按素材关联";
$GLOBALS['strCampaignDefaults'] = "按项目批量关联";
$GLOBALS['strWithXBanners'] = "%d 个素材";
$GLOBALS['strRawQueryString'] = "关键词";
$GLOBALS['strIncludedBanners'] = "素材关联";
$GLOBALS['strMatchingBanners'] = "{count} 个规格匹配的素材";
$GLOBALS['strNoCampaignsToLink'] = "目前没有项目适用于该版位";
$GLOBALS['strNoTrackersToLink'] = "目前没有追踪器适用于该项目";
$GLOBALS['strNoZonesToLinkToCampaign'] = "目前没有版位适用于该项目";
$GLOBALS['strSelectCampaignToLink'] = "请选择您要关联到该版位的项目：";
$GLOBALS['strSelectAdvertiser'] = "选择客户";
$GLOBALS['strSelectPlacement'] = "选择项目";
$GLOBALS['strSelectAd'] = "选择素材";
$GLOBALS['strSelectPublisher'] = "选择没提";
$GLOBALS['strSelectZone'] = "选择广告位";
$GLOBALS['strStatusPending'] = "待定";
$GLOBALS['strStatusApproved'] = "已批准";
$GLOBALS['strStatusDisapproved'] = "未批准";
$GLOBALS['strStatusDuplicate'] = "重复";
$GLOBALS['strStatusOnHold'] = "搁置";
$GLOBALS['strStatusIgnore'] = "忽略";
$GLOBALS['strConnectionType'] = "类型";
$GLOBALS['strConnTypeSale'] = "订单";
$GLOBALS['strConnTypeLead'] = "展示";
$GLOBALS['strConnTypeSignUp'] = "注册";
$GLOBALS['strShortcutEditStatuses'] = "编辑审核状态";
$GLOBALS['strShortcutShowStatuses'] = "显示审核状态";

// Statistics
$GLOBALS['strStats'] = "报表";
$GLOBALS['strNoStats'] = "暂时没有投放记录";
$GLOBALS['strNoStatsForPeriod'] = "%s 到 %s 暂时没有投放记录";
$GLOBALS['strPublisherDistribution'] = "按媒体";
$GLOBALS['strCampaignDistribution'] = "按项目";
$GLOBALS['strViewBreakdown'] = "时间视图";
$GLOBALS['strBreakdownByDay'] = "日期";
$GLOBALS['strBreakdownByWeek'] = "周";
$GLOBALS['strBreakdownByMonth'] = "个月";
$GLOBALS['strBreakdownByDow'] = "星期";
$GLOBALS['strBreakdownByHour'] = "小时";
$GLOBALS['strItemsPerPage'] = "每页显示";
$GLOBALS['strExportStatisticsToExcel'] = "导出为 Excel 格式（<u>E</u>）";

// Expiration
$GLOBALS['strDaysAgo'] = "天前";
$GLOBALS['strCampaignStop'] = "停止Campaign";

// Reports
$GLOBALS['strAdvancedReports'] = "更多...";
$GLOBALS['strStartDate'] = "开始日期";
$GLOBALS['strEndDate'] = "结束日期";
$GLOBALS['strPeriod'] = "时间段";
$GLOBALS['strWorksheets'] = "选择视图";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "所有客户";
$GLOBALS['strAnonAdvertisers'] = "匿名广告客户";
$GLOBALS['strAllPublishers'] = "所有媒体";
$GLOBALS['strAnonPublishers'] = "匿名媒体";
$GLOBALS['strAllAvailZones'] = "所有可用广告位";

// Userlog
$GLOBALS['strUserLog'] = "日志";
$GLOBALS['strUserLogDetails'] = "用户日志详情";
$GLOBALS['strDeleteLog'] = "删除日志";
$GLOBALS['strAction'] = "行为";

// Code generation
$GLOBALS['strGenerateBannercode'] = "代码";
$GLOBALS['strChooseInvocationType'] = "请选择调用方式";
$GLOBALS['strGenerate'] = "生成";
$GLOBALS['strParameters'] = "参数设置";
$GLOBALS['strFrameSize'] = "框架大小";
$GLOBALS['strBannercode'] = "素材代码";
$GLOBALS['strBackToTheList'] = "选择其它报表";
$GLOBALS['strCharset'] = "字符集";
$GLOBALS['strAutoDetect'] = "自动检测";

// Errors
$GLOBALS['strNoMatchesFound'] = "没有找到匹配的信息。";
$GLOBALS['strErrorOccurred'] = "发生错误。";
$GLOBALS['strErrorDBPlain'] = "访问数据库时发生错误。";
$GLOBALS['strErrorDBSerious'] = "检测到数据库存在严重问题。";
$GLOBALS['strErrorDBNoDataPlain'] = "数据库异常，{$PRODUCT_NAME} 无法存取数据。";
$GLOBALS['strErrorDBNoDataSerious'] = "数据库异常，{$PRODUCT_NAME} 无法读取数据。";
$GLOBALS['strErrorDBCorrupt'] = "数据表异常，请参考 <i>Administrator guide</i> 中的 <i>Troubleshooting</i> 章节尝试修复。";
$GLOBALS['strErrorDBContact'] = "请联系系统管理员。";
$GLOBALS['strMaintenanceNotActive'] = "距离上次运行维护任务已经超过 24 小时。\\n为保证 {$PRODUCT_NAME} 正常工作，维护任务运行的间隔不应该超过 1 小时。\\n\\n请参考管理员手册配置维护任务。";
$GLOBALS['strErrorLinkingBanner'] = "将素材关联到该版位时发生错误：";
$GLOBALS['strUnableToLinkBanner'] = "无法关联该素材：";
$GLOBALS['strErrorEditingCampaignRevenue'] = "收入金额数字格式无效。";
$GLOBALS['strErrorEditingCampaignECPM'] = "ECPM 数字格式无效。";
$GLOBALS['strErrorEditingZone'] = "修改版位时发生错误：";
$GLOBALS['strUnableToChangeZone'] = "无法修改该版位：";
$GLOBALS['strDatesConflict'] = "该项目与其它已经关联的项目的日期有重叠。";
$GLOBALS['strEmailNoDates'] = "Email 类型的版位所关联的项目必须设置启用和停用日期。";
$GLOBALS['strWarningInaccurateStats'] = "部分投放记录采用了非 UTC 时区，可能导致显示不准确。";
$GLOBALS['strWarningInaccurateReadMore'] = "查看详细解释";
$GLOBALS['strWarningInaccurateReport'] = "该报表中的部分投放记录采用了非 UTC 时区，可能导致显示不准确。";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "表示必填的项目";
$GLOBALS['strFormContainsErrors'] = "表单填写有错误，请修正。";
$GLOBALS['strXRequiredField'] = "%s 为必填。";
$GLOBALS['strEmailField'] = "Email 格式无效。";
$GLOBALS['strNumericField'] = "必须为数字。";
$GLOBALS['strGreaterThanZeroField'] = "必须大于 0。";
$GLOBALS['strXGreaterThanZeroField'] = "%s 必须大于 0。";
$GLOBALS['strXPositiveWholeNumberField'] = "%s 必须是正整数。";
$GLOBALS['strInvalidWebsiteURL'] = "媒体 URL 格式无效。";

// Email
$GLOBALS['strSirMadam'] = "先生／女士";
$GLOBALS['strMailSubject'] = "项目报表";
$GLOBALS['strClientDeactivated'] = "该项目已被停用";
$GLOBALS['strBeforeActivate'] = "还没到项目启用日期";
$GLOBALS['strAfterExpire'] = "已过了项目停用日期";
$GLOBALS['strNoMoreImpressions'] = "已达到素材展示上限";
$GLOBALS['strNoMoreClicks'] = "已达到素材点击上线";
$GLOBALS['strNoMoreConversions'] = "已达到订单上限";
$GLOBALS['strWeightIsNull'] = "权重设置为零";
$GLOBALS['strRevenueIsNull'] = "收入设置为零";
$GLOBALS['strTargetIsNull'] = "每日投放量上限设置为零，您需要设置项目停用日期以及每日投放量上限";

// Priority
$GLOBALS['strPriority'] = "优先级";

// Preferences
$GLOBALS['strPreferences'] = "设置";
$GLOBALS['strUserPreferences'] = "信息";
$GLOBALS['strChangePassword'] = "更新密码";
$GLOBALS['strChangeEmail'] = "更新 Email";
$GLOBALS['strCurrentPassword'] = "当前密码";
$GLOBALS['strChooseNewPassword'] = "新密码";
$GLOBALS['strReenterNewPassword'] = "新密码确认";
$GLOBALS['strNameLanguage'] = "姓名与语言";
$GLOBALS['strAccountPreferences'] = "账户首选项";
$GLOBALS['strCampaignEmailReportsPreferences'] = "报表";
$GLOBALS['strTimezonePreferences'] = "时区";
$GLOBALS['strAdminEmailWarnings'] = "通知管理员";
$GLOBALS['strAgencyEmailWarnings'] = "通知用户组联系人";
$GLOBALS['strAdveEmailWarnings'] = "通知客户联系人";
$GLOBALS['strFullName'] = "姓名";
$GLOBALS['strEmailAddress'] = "Email";
$GLOBALS['strUserDetails'] = "用户信息";
$GLOBALS['strUserInterfacePreferences'] = "界面";
$GLOBALS['strPluginPreferences'] = "插件";
$GLOBALS['strColumnName'] = "列名";
$GLOBALS['strShowColumn'] = "显示";
$GLOBALS['strCustomColumnName'] = "自定义列名";
$GLOBALS['strColumnRank'] = "排序";

// Long names
$GLOBALS['strRevenue'] = "收入";
$GLOBALS['strNumberOfItems'] = "追踪器数据计数";
$GLOBALS['strRevenueCPC'] = "CPC 收入";
$GLOBALS['strECPM'] = "eCPM";
$GLOBALS['strPendingConversions'] = "待审数据";
$GLOBALS['strImpressionSR'] = "素材展示 SR";
$GLOBALS['strClickSR'] = "素材点击 SR";

// Short names
$GLOBALS['strRevenue_short'] = "收入";
$GLOBALS['strNumberOfItems_short'] = "计数";
$GLOBALS['strRevenueCPC_short'] = "CPC 收入";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "请求";
$GLOBALS['strImpressions_short'] = "展示";
$GLOBALS['strClicks_short'] = "素材点击";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "数据";
$GLOBALS['strPendingConversions_short'] = "待审";
$GLOBALS['strImpressionSR_short'] = "展示 SR";
$GLOBALS['strClickSR_short'] = "素材点击 SR";

// Global Settings
$GLOBALS['strConfiguration'] = "系统";
$GLOBALS['strGlobalSettings'] = "全局";
$GLOBALS['strGeneralSettings'] = "常规设置";
$GLOBALS['strMainSettings'] = "主要设置";
$GLOBALS['strPlugins'] = "插件";
$GLOBALS['strChooseSection'] = '请选择任务';

// Product Updates
$GLOBALS['strProductUpdates'] = "升级";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "升级完成";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "升级失败";

// Agency
$GLOBALS['strAgencyManagement'] = "用户组";
$GLOBALS['strAgency'] = "用户组";
$GLOBALS['strAddAgency'] = "添加新的用户组";
$GLOBALS['strAddAgency_Key'] = "添加新的用户组（<u>N</u>）";
$GLOBALS['strTotalAgencies'] = "用户组数";
$GLOBALS['strAgencyProperties'] = "用户组";
$GLOBALS['strNoAgencies'] = "您还没有添加用户组";
$GLOBALS['strConfirmDeleteAgency'] = "您真的要删除该用户组吗？";
$GLOBALS['strHideInactiveAgencies'] = "隐藏停用的用户组";
$GLOBALS['strInactiveAgenciesHidden'] = "个用户组已被隐藏";
$GLOBALS['strSwitchAccount'] = "切换到该组";
$GLOBALS['strAgencyStatusInactive'] = "已停用";

// Channels
$GLOBALS['strChannelToWebsite'] = "到";
$GLOBALS['strChannelLimitations'] = "投放控制";
$GLOBALS['strChannelsOfWebsite'] = '属于'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "变量名";
$GLOBALS['strVariableDescription'] = "详细描述";
$GLOBALS['strVariableDataType'] = "数据类型";
$GLOBALS['strVariablePurpose'] = "目的";
$GLOBALS['strGeneric'] = "一般";
$GLOBALS['strNumItems'] = "追踪器数据计数";
$GLOBALS['strVariableIsUnique'] = "检查唯一性";
$GLOBALS['strNumber'] = "数字";
$GLOBALS['strString'] = "文本";
$GLOBALS['strTrackFollowingVars'] = "追踪以下变量";
$GLOBALS['strAddVariable'] = "添加变量";
$GLOBALS['strNoVarsToTrack'] = "您还没有添加要追踪的变量";
$GLOBALS['strVariableRejectEmpty'] = "检查非空";
$GLOBALS['strTrackingSettings'] = "追踪器设置";
$GLOBALS['strTrackerType'] = "追踪器类型";
$GLOBALS['strTrackerTypeJS'] = "追踪 JavaScript 变量";
$GLOBALS['strTrackerTypeDefault'] = "追踪 JavaScript 变量（向后兼容，需转义）";
$GLOBALS['strTrackerTypeDOM'] = "通过 DOM 追踪 HTML 元素";
$GLOBALS['strTrackerTypeCustom'] = "自定义 JavaScript 代码";
$GLOBALS['strVariableCode'] = "Javascript 追踪代码";

// Password recovery
$GLOBALS['strForgotPassword'] = "忘记密码";
$GLOBALS['strEmailRequired'] = "请输入您的 Email";
$GLOBALS['strPwdRecEnterEmail'] = "请输入您的 Email";
$GLOBALS['strPwdRecEnterPassword'] = "请输入您的新密码";
$GLOBALS['strProceed'] = "继续 >";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditTrail'] = "日志";
$GLOBALS['strAuditTrailGoTo'] = "转到日志列表";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "转到项目列表";


$GLOBALS['strUnsavedChanges'] = "该页面上有尚未保存的更新，请在编辑完成后按“保存”按钮";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "您已经成功切换到<b>%s</b>组。";
$GLOBALS['strYouDontHaveAccess'] = "没有权限访问该页面，已经为您重定向。";

$GLOBALS['strAdvertiserHasBeenAdded'] = "新客户<a href='%s'>%s</a>已经成功添加，现在可以<a href='%s'>添加新项目</a>。";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "客户<a href='%s'>%s</a>已经成功更新。";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "客户<b>%s</b>已经成功删除。";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "所有选中的客户已经成功删除。";

$GLOBALS['strTrackerHasBeenAdded'] = "新追踪器<a href='%s'>%s</a>已经成功添加。";
$GLOBALS['strTrackerHasBeenUpdated'] = "追踪器<a href='%s'>%s</a>已经成功更新。";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "追踪器<a href='%s'>%s</a>的变量已经成功更新。";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "追踪器<a href='%s'>%s</a>关联的所有项目已经成功更新。";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "追踪器<a href='%s'>%s</a>的附加追踪代码已经成功更新。";
$GLOBALS['strTrackerHasBeenDeleted'] = "追踪器<b>%s</b>已经成功删除。";
$GLOBALS['strTrackersHaveBeenDeleted'] = "所有选中的追踪器已经成功删除。";
$GLOBALS['strTrackerHasBeenDuplicated'] = "已经成功从<a href='%s'>%s</a>克隆出新的追踪器<a href='%s'>%s</a>。";
$GLOBALS['strTrackerHasBeenMoved'] = "追踪器<b>%s</b>已经成功移至客户<b>%s</b>。";

$GLOBALS['strCampaignHasBeenAdded'] = "新项目<a href='%s'>%s</a>已经成功添加，现在可以<a href='%s'>添加新素材</a>。";
$GLOBALS['strCampaignHasBeenUpdated'] = "项目<a href='%s'>%s</a>已经成功更新。";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "项目<a href='%s'>%s</a>关联的所有追踪器已经成功更新。";
$GLOBALS['strCampaignHasBeenDeleted'] = "项目<b>%s</b>已经成功删除。";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "所有选中的项目已经成功删除。";
$GLOBALS['strCampaignHasBeenDuplicated'] = "已经成功从<a href='%s'>%s</a>克隆出新的项目<a href='%s'>%s</a>。";
$GLOBALS['strCampaignHasBeenMoved'] = "项目<b>%s</b>已经成功移至客户<b>%s</b>。";

$GLOBALS['strBannerHasBeenAdded'] = "新素材<a href='%s'>%s</a>已经成功添加。";
$GLOBALS['strBannerHasBeenUpdated'] = "素材<a href='%s'>%s</a>已经成功更新。";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "素材<a href='%s'>%s</a>的高级设置已经成功更新。";
$GLOBALS['strBannerAclHasBeenUpdated'] = "素材<a href='%s'>%s</a>的投放控制选项已经成功更新。";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "素材<a href='%s'>%s</a>的投放控制选项已经成功应用到 %d 个素材。";
$GLOBALS['strBannerHasBeenDeleted'] = "素材<b>%s</b>已经成功删除。";
$GLOBALS['strBannersHaveBeenDeleted'] = "所有选中的素材已经成功删除。";
$GLOBALS['strBannerHasBeenDuplicated'] = "已经成功从<a href='%s'>%s</a>克隆出新的素材<a href='%s'>%s</a>。";
$GLOBALS['strBannerHasBeenMoved'] = "素材<b>%s</b>已经成功移至项目<b>%s</b>。";
$GLOBALS['strBannerHasBeenActivated'] = "素材<a href='%s'>%s</a>已经成功启用。";
$GLOBALS['strBannerHasBeenDeactivated'] = "素材<a href='%s'>%s</a>已经成功停用。";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> 个版位已经成功关联";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> 个版位已经成功解除关联";

$GLOBALS['strWebsiteHasBeenAdded'] = "新媒体<a href='%s'>%s</a>已经成功添加，现在可以<a href='%s'>添加新版位</a>。";
$GLOBALS['strWebsiteHasBeenUpdated'] = "媒体<a href='%s'>%s</a>已经成功更新。";
$GLOBALS['strWebsiteHasBeenDeleted'] = "媒体<b>%s</b>已经成功删除。";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "所有选中的媒体已经成功删除。";

$GLOBALS['strZoneHasBeenAdded'] = "版位<a href='%s'>%s</a>已经成功添加。";
$GLOBALS['strZoneHasBeenUpdated'] = "版位<a href='%s'>%s</a>已经成功更新。";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "版位<a href='%s'>%s</a>的高级设置已经成功更新。";
$GLOBALS['strZoneHasBeenDeleted'] = "版位<b>%s</b>已经成功删除。";
$GLOBALS['strZonesHaveBeenDeleted'] = "所有选中的版位已经成功删除。";
$GLOBALS['strZoneHasBeenDuplicated'] = "已经成功从<a href='%s'>%s</a>克隆出新的版位<a href='%s'>%s</a>。";
$GLOBALS['strZoneHasBeenMoved'] = "版位<b>%s</b>已经成功移至媒体<b>%s</b>。";
$GLOBALS['strZoneLinkedBanner'] = "素材已经成功关联到版位<a href='%s'>%s</a>。";
$GLOBALS['strZoneLinkedCampaign'] = "项目已经成功关联到版位<a href='%s'>%s</a>。";
$GLOBALS['strZoneRemovedBanner'] = "素材已经成功从版位<a href='%s'>%s</a>解除关联。";
$GLOBALS['strZoneRemovedCampaign'] = "项目已经成功从版位<a href='%s'>%s</a>解除关联。";


$GLOBALS['strUserPreferencesUpdated'] = "您的<b>%s</b>已经成功更新。";
$GLOBALS['strEmailChanged'] = "您的 E-mail 已经成功更新。";
$GLOBALS['strPasswordChanged'] = "您的密码已经成功更新。";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b>已经成功更新。";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b>已经成功更新。";

// Report error messages
$GLOBALS['strReportErrorUnknownCode'] = "未知的错误代码 #";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
