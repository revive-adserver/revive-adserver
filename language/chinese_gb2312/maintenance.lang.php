<?php // $Revision: 2.0 $

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


// Main strings
$GLOBALS['strChooseSection']			= "选择部分";


// Priority
$GLOBALS['strRecalculatePriority']		= "重新计算优先权";
$GLOBALS['strHighPriorityCampaigns']		= "高优先权项目";
$GLOBALS['strAdViewsAssigned']			= "分配的广告访问数";
$GLOBALS['strLowPriorityCampaigns']		= "低优先权项目";
$GLOBALS['strPredictedAdViews']			= "预定的广告访问数";
$GLOBALS['strPriorityDaysRunning']		= $phpAds_productname."可以在现在有{days}天数据的基础上预估每天的优先权.";
$GLOBALS['strPriorityBasedLastWeek']		= "在上周和本周数据基础上的预估值.";
$GLOBALS['strPriorityBasedLastDays']		= "T在前几天数据的基础上的预估值.";
$GLOBALS['strPriorityBasedYesterday']		= "在昨天数据的基础上的预估值";
$GLOBALS['strPriorityNoData']			= "现在没有足够的数据来精确估算此广告服务器今天点击数的预计值。所以只在实时数据的基础上分配优先权.";
$GLOBALS['strPriorityEnoughAdViews']		= "有足够的访问数来完全满足预定的所有高优先权的方案.";
$GLOBALS['strPriorityNotEnoughAdViews']		= "还不知道是否有足够的推播数来完全满足预定的所有高优先权的方案,所以所有低优先权的方案已经暂时停用了.";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "重建广告缓存区";
$GLOBALS['strBannerCacheExplaination']		= "广告缓存区包含了用来显示广告的HTML代码的一个副本.使用广告缓存区可以提高广告发放的速度,因为不再需要每次发放的时候都要生出那个一次HTML代码.因为此广告缓存区包含了".$phpAds_productname."和广告的URL地址,所以缓存区需要在每次".$phpAds_productname."移动到网页服务器的另一个位置的时候重建.";


// Cache
$GLOBALS['strCache']				= "发送缓存区";
$GLOBALS['strAge']				= "寿命";
$GLOBALS['strRebuildDeliveryCache']		= "重建发送缓存区";
$GLOBALS['strDeliveryCacheExplaination']	= "发送缓存区可以提高广告的发放速度.发送缓存区包含连接到此版位的所有广告的一个副本,当广告实际发放给用户的时候减少了一些数据库的查询.此缓存区通常在一个版位或者版位的一个广告改动的时候重建,它可能会过期.所以缓存区会每个小时自动重建一次,但您也可以手工重建.";
$GLOBALS['strDeliveryCacheSharedMem']		= "现在使用共享内存来存放发送缓存区.";
$GLOBALS['strDeliveryCacheDatabase']		= "现在使用数据库来存放发送缓存区.";
$GLOBALS['strDeliveryCacheFiles']		= "现在使用您服务器上的多个文件来存放发送缓存区.";


// Storage
$GLOBALS['strStorage']				= "存储";
$GLOBALS['strMoveToDirectory']			= "把存储在数据库中的图片移动到一个目录";
$GLOBALS['strStorageExplaination']		= "本地广告使用的图片存储在数据库或者一个目录中.如果您把图片存储到一个目录,减小了数据库的负载会提高运行速度.";


// Storage
$GLOBALS['strStatisticsExplaination']		= "您已经启用了<i>简洁报表</i>,但是老的报表还是详细格式.您想把详细格式的报表转换成新的简洁格式吗?";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "查看升级. 请稍候...";
$GLOBALS['strAvailableUpdates']			= "可用升级";
$GLOBALS['strDownloadZip']			= "下载(.zip)";
$GLOBALS['strDownloadGZip']			= "下载(.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname."有新的版本可用\\n\\n您想知道更多关于此次升级的消息吗?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname."有新的版本可用\\n\\n强烈推荐您尽快升级,\\n因为此次新版本包含了一个或多个安全补丁!";

$GLOBALS['strUpdateServerDown']			= "因为未知原因不能得到升级信息,请稍候再试.";

$GLOBALS['strNoNewVersionAvailable']		= "您的".$phpAds_productname."是最新版的.现在没有可用的升级版本.";

$GLOBALS['strNewVersionAvailable']		= "<b>一个新版本".$phpAds_productname."可用</b><br>推荐您安装此次更新,因为可能修补了一些存在的问题和增加了一些新的功能.更多的有关升级的信息请参考下面的相关文档.";

$GLOBALS['strSecurityUpdate']			= "<b>强烈推荐您尽快安装此次更新，因为包含了一些安全补丁</b>您现在使用的".$phpAds_productname."的版本的漏洞可能被攻击和不安全.更多的有关升级的信息请参考下面的相关文档.";

$GLOBALS['strNotAbleToCheck']			= "<b>因为您的服务器XML扩展功能不能使用,".$phpAds_productname."无法检查是否有新的版本可以使用.</b>";

$GLOBALS['strForUpdatesLookOnWebsite']		= "如果您想知道是否有新的版本可用,请访问我们的网站.";

$GLOBALS['strClickToVisitWebsite']		= "请点击这里来访问我们的网站.";
$GLOBALS['strCurrentlyUsing']			= "您现在使用的是";
$GLOBALS['strRunningOn']			= "运行在";
$GLOBALS['strAndPlain']				= "和";


// Stats conversion
$GLOBALS['strConverting']			= "转换中";
$GLOBALS['strConvertingStats']			= "统计数据转换中...";
$GLOBALS['strConvertStats']			= "转换统计数据";
$GLOBALS['strConvertAdViews']			= "访问数已经转换完毕,";
$GLOBALS['strConvertAdClicks']			= "点击数已经转换完毕...";
$GLOBALS['strConvertNothing']			= "没有数据可以转换...";
$GLOBALS['strConvertFinished']			= "完毕...";

$GLOBALS['strConvertExplaination']		= "您现在使用简洁格式来保存报表,但是还有一些报表是详细格式.<br>详细格式的报表没有转换成简洁格式将不能在页面上直接使用.<br>在转换您的报表之前,保存数据库的一个备份!<br>是否确认要把详细格式的报表转换成新的简洁格式?<br>";

$GLOBALS['strConvertingExplaination']		= "所有剩余的详细格式的报表正在转换成简洁格式<br>根据详细格式的数目而需要时间不同，可能需要几分钟。在浏览其他页面之前一定要等到转换完成。<br>下面您将看到数据库修改的记录.<br>";

$GLOBALS['strConvertFinishedExplaination']  	= "剩余的详细格式的报表已经转换成功。数据现在要再次使用，下面您将看到数据库修改的记录<br>";


?>
