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

// Main strings
$GLOBALS['strChooseSection']			= "选择章节";


// Priority
$GLOBALS['strRecalculatePriority']		= "重新计算优先级";
$GLOBALS['strHighPriorityCampaigns']		= "������Ȩ��Ŀ";
$GLOBALS['strAdViewsAssigned']			= "����Ĺ�������";
$GLOBALS['strLowPriorityCampaigns']		= "������Ȩ��Ŀ";
$GLOBALS['strPredictedAdViews']			= "Ԥ���Ĺ�������";
$GLOBALS['strPriorityDaysRunning']		= $phpAds_productname."������������{days}�����ݵĻ�����Ԥ��ÿ�������Ȩ.";
$GLOBALS['strPriorityBasedLastWeek']		= "�����ܺͱ������ݻ����ϵ�Ԥ��ֵ.";
$GLOBALS['strPriorityBasedLastDays']		= "T��ǰ�������ݵĻ����ϵ�Ԥ��ֵ.";
$GLOBALS['strPriorityBasedYesterday']		= "���������ݵĻ����ϵ�Ԥ��ֵ";
$GLOBALS['strPriorityNoData']			= "����û���㹻����������ȷ����˹�����������������Ԥ��ֵ������ֻ��ʵʱ���ݵĻ����Ϸ�������Ȩ.";
$GLOBALS['strPriorityEnoughAdViews']		= "���㹻�ķ���������ȫ����Ԥ�������и�����Ȩ�ķ���.";
$GLOBALS['strPriorityNotEnoughAdViews']		= "����֪���Ƿ����㹻���Ʋ�������ȫ����Ԥ�������и�����Ȩ�ķ���,�������е�����Ȩ�ķ����Ѿ���ʱͣ����.";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "�ؽ���滺����";
$GLOBALS['strBannerCacheExplaination']		= "广告数据库缓存的作用是加速广告的投放<br />\n该缓存需要在以下情况下更新：\n    <ul>\n        <li>您升级了OpenX</li>\n        <li>您将OpenX迁移到一个新的服务器上</li>\n    </ul>";


// Cache
$GLOBALS['strCache']				= "发布缓存";
$GLOBALS['strAge']				= "年龄";
$GLOBALS['strRebuildDeliveryCache']		= "重构数据库广告缓存";
$GLOBALS['strDeliveryCacheExplaination']	= "���ͻ�����������߹��ķ����ٶ�.���ͻ������������ӵ��˰�λ�����й���һ������,�����ʵ�ʷ��Ÿ��û���ʱ�������һЩ���ݿ�Ĳ�ѯ.�˻�����ͨ����һ����λ���߰�λ��һ�����Ķ���ʱ���ؽ�,�����ܻ����.���Ի�������ÿ��Сʱ�Զ��ؽ�һ��,����Ҳ�����ֹ��ؽ�.";
$GLOBALS['strDeliveryCacheSharedMem']		= "共享内存目前正被发布缓存占用";
$GLOBALS['strDeliveryCacheDatabase']		= "数据正在存储发布缓存";
$GLOBALS['strDeliveryCacheFiles']		= "发布缓存正在存储到你服务器上的多个文件";


// Storage
$GLOBALS['strStorage']				= "存储";
$GLOBALS['strMoveToDirectory']			= "将图片从数据库中移动到目录下";
$GLOBALS['strStorageExplaination']		= "图片文件可存储在数据库或文件系统中。存储在文件系统中将比存储在数据库中效率更高。";


// Storage
$GLOBALS['strStatisticsExplaination']		= "您已经启用了<i>紧缩统计</i>, 但是您的报表还是详细格式, 您是否愿意把现有的详细格式转换为紧缩格式?";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "查找更新，请稍候……";
$GLOBALS['strAvailableUpdates']			= "提供的更新";
$GLOBALS['strDownloadZip']			= "下载（.zip）";
$GLOBALS['strDownloadGZip']			= "下载（.tar.gz）";

$GLOBALS['strUpdateAlert']			= $phpAds_productname."���µİ汾����\\n\\n����֪��������ڴ˴���������Ϣ��?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname."���µİ汾����\\n\\nǿ���Ƽ�����������,\\n��Ϊ�˴��°汾������һ��������ȫ����!";

$GLOBALS['strUpdateServerDown']			= "由于不明原因，导致无法获取更新信息。<br>请稍后再试一下。";

$GLOBALS['strNoNewVersionAvailable']		= "您". MAX_PRODUCT_NAME ."的版本已是最新的。";

$GLOBALS['strNewVersionAvailable']		= " <b>". MAX_PRODUCT_NAME ."的新版本已经发布。</b><br /> 由于修改一些已知的问题及增加了一些新功能。所以建议您安装这个更新。如果您希望进一步了解相关细心，请参阅文件中的相关文档。\n";

$GLOBALS['strSecurityUpdate']			= "<b>由于涉及若干个安全更新，所以强烈建议您升级。</b> \n您现在的". MAX_PRODUCT_NAME ."版本，可能因为攻击而变得不可靠。如果希望了解进一步的信息，请参阅文件中的相关文档。";

$GLOBALS['strNotAbleToCheck']			= " <b>由于您服务器上没有XML引申，所以". MAX_PRODUCT_NAME ."无法查找是否有新的更新提供。</b>";

$GLOBALS['strForUpdatesLookOnWebsite']		= "如果您希望知道是否有新的版本提供，请查阅我们的网站。";

$GLOBALS['strClickToVisitWebsite']		= "点击访问官方网站";
$GLOBALS['strCurrentlyUsing']			= "你正在使用的";
$GLOBALS['strRunningOn']			= "运行的";
$GLOBALS['strAndPlain']				= "与";


// Stats conversion
$GLOBALS['strConverting']			= "ת����";
$GLOBALS['strConvertingStats']			= "ͳ������ת����...";
$GLOBALS['strConvertStats']			= "ת��ͳ������";
$GLOBALS['strConvertAdViews']			= "�������Ѿ�ת�����,";
$GLOBALS['strConvertAdClicks']			= "������Ѿ�ת�����...";
$GLOBALS['strConvertNothing']			= "û�����ݿ���ת��...";
$GLOBALS['strConvertFinished']			= "���...";

$GLOBALS['strConvertExplaination']		= "������ʹ�ü���ʽ�����汨��,���ǻ���һЩ��������ϸ��ʽ.<br />��ϸ��ʽ�ı���û��ת���ɼ���ʽ��������ҳ����ֱ��ʹ��.<br />��ת�����ı���֮ǰ,�������ݿ��һ������!<br />�Ƿ�ȷ��Ҫ����ϸ��ʽ�ı���ת�����µļ���ʽ?<br />";

$GLOBALS['strConvertingExplaination']		= "����ʣ�����ϸ��ʽ�ı�������ת���ɼ���ʽ<br />������ϸ��ʽ����Ŀ����Ҫʱ�䲻ͬ��������Ҫ�����ӡ����������ҳ��֮ǰһ��Ҫ�ȵ�ת����ɡ�<br />���������������ݿ��޸ĵļ�¼.<br />";

$GLOBALS['strConvertFinishedExplaination']  	= "ʣ�����ϸ��ʽ�ı����Ѿ�ת���ɹ�����������Ҫ�ٴ�ʹ�ã����������������ݿ��޸ĵļ�¼<br />";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "检查广告缓存";
$GLOBALS['strBannerCacheErrorsFound'] = "经查，数据库广告缓存发现错误。在手工修正这些错误之前，这些广告将无法正常运行。";
$GLOBALS['strBannerCacheOK'] = "未发现错误，您的数据库广告缓存已是最新的";
$GLOBALS['strBannerCacheDifferencesFound'] = "经查，数据库广告缓存不是最新的，需要重建。点击这里自动更新缓存。";
$GLOBALS['strBannerCacheRebuildButton'] = "重构";
$GLOBALS['strUpdateAlert'] = "". MAX_PRODUCT_NAME ." 新版本已发布。                 \n\n您希望了解更多关于新版本的信息吗？?";
$GLOBALS['strUpdateAlertSecurity'] = "". MAX_PRODUCT_NAME ." 新版本已发布。                 \n\n由于提供了很多安全方面的修改? 所以强烈建议您更新到新版本。";
$GLOBALS['strBannerCacheFixed'] = "成功完成广告数据库缓存重构, 数据库缓存已经更新.";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncoding'] = "编码";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." 在数据库中使用UTF-8格式保存各种数据。<br />在任何可能情况下，您的数据会被自动转换为这种编码。<br />如果升级后您发现错乱的字符，并且您知道所用的编码，您可以使用这个工具来将数据转换为UTF-8格式。";
$GLOBALS['strEncodingConvertFrom'] = "从此编码转换：";
$GLOBALS['strEncodingConvert'] = "转换";
$GLOBALS['strEncodingConvertTest'] = "转换测试";
$GLOBALS['strConvertThese'] = "如您继续，则下列数据会被修改";
$GLOBALS['strAppendCodes'] = "附加代码";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "自动维护程序在上个小时没有被执行，请检查你的设置。";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "自动维护程序已经启动，但是他没有被触发，自动程序被触发当". MAX_PRODUCT_NAME ."发布广告时，为性能考虑，你最好设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>自动维护</a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "自动维护程序已经被禁用，所以当". MAX_PRODUCT_NAME ."发布广告时，自动维护程序不会被广告所触发，为了性能考虑，你必需设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>计划维护</a>。当然，如果你不设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>计划维护</a>的话，你<i>必需</i><a href='account-settings-maintenance.php'>开启自动维护程序</a>以确保 ". MAX_PRODUCT_NAME ." 运行正常. ";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "自动维护程序已经启动，但是他没有被触发，自动程序被触发当". MAX_PRODUCT_NAME ."发布广告时，为性能考虑，你最好设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>自动维护</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "自动维护程序已经被禁用。为保证". MAX_PRODUCT_NAME ."能够正常运行，请设定<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>计划维护任务</a>或<a href='account-settings-maintenance.php'>重新开启自动维护程序</a>。为性能考虑，你最好设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>自动维护</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "计划维护运行正常";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "自动维护程序运行正常";
$GLOBALS['strAutoMantenaceEnabled'] = "自动维护程序任然开启。为性能考虑，你最好<a href='account-settings-maintenance.php'>关闭自动维护</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "自动维护程序已被禁用";
$GLOBALS['strAutoMaintenanceEnabled'] = "自动维护程序已经开启。为性能考虑，你最好<a href='account-settings-maintenance.php'>关闭自动维护</a>.";
$GLOBALS['strCheckACLs'] = "检查ACL";
$GLOBALS['strScheduledMaintenance'] = "计划维护任务似乎正常运行中。";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "自动维护程序已经开启，但是他没有被触发。请注意自动维护程序只有在广告被访问时才会被触发。";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "为性能考虑，请设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>计划维护任务</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "自动维护程序已经启用，将会每个小时进行一次维护。";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "自动维护程序已经被禁用，但是一个维护任务正在运行中。为确定". MAX_PRODUCT_NAME ."运行正常你必须设置<a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>计划维护任务</a>或<a href='settings-admin.php'>开启自动维护程序</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "自动维护程序已经被禁用，所以当". MAX_PRODUCT_NAME ."发布广告时，维护程序将不会被触发，如果你没有计划去运行<a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>计划维护程序</a>,你必须 <a href='settings-admin.php'>开启自动维护程序</a>以保证". MAX_PRODUCT_NAME ." 正常运行。";
$GLOBALS['strAllBannerChannelCompiled'] = "所有的广告/频道限制已经被重新设置。";
$GLOBALS['strBannerChannelResult'] = "广告/频道限制结果";
$GLOBALS['strChannelCompiledLimitationsValid'] = "所有的频道限制设置正常";
$GLOBALS['strBannerCompiledLimitationsValid'] = "所有的广告限制设置正常";
$GLOBALS['strErrorsFound'] = "找到错误";
$GLOBALS['strRepairCompiledLimitations'] = "有些限制设置有误，你可以点击按钮以修复这些问题<br />";
$GLOBALS['strRecompile'] = "重算";
$GLOBALS['strAppendCodesDesc'] = "在某些环境下广告引擎在发布附属代码跟踪信息时会不一致，有以下链接确认附属代码。";
$GLOBALS['strCheckAppendCodes'] = "检查附属代码";
$GLOBALS['strAppendCodesRecompiled'] = "所有附属代码已经被重设";
$GLOBALS['strAppendCodesResult'] = "附属代码重设结果";
$GLOBALS['strAppendCodesValid'] = "所有的跟踪附属代码正常";
$GLOBALS['strRepairAppenedCodes'] = "有些附属代码有误，你可以点击按钮以修复这些问题";
$GLOBALS['strScheduledMaintenanceNotRun'] = "计划维护程序在上个小时中并没有运行，这意味着你可能没有设置正确";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "在某些环境下广告发布引擎会不同意广告条和频道的ACL，请点击下面的链接来验证数据库中的ACL";
$GLOBALS['strServerCommunicationError'] = "<b>与更新服务器的通信超时，因此".MAX_PRODUCT_NAME." 无法检查此时是否有可用的新版本。请稍后重试。</b>";
?>