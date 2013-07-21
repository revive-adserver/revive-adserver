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

// Main strings
$GLOBALS['strChooseSection']			= "选择章节";


// Priority
$GLOBALS['strRecalculatePriority']		= "�?新计算优先级";
$GLOBALS['strHighPriorityCampaigns']		= "������Ȩ��Ŀ";
$GLOBALS['strAdViewsAssigned']			= "����Ĺ�������";
$GLOBALS['strLowPriorityCampaigns']		= "������Ȩ��Ŀ";
$GLOBALS['strPredictedAdViews']			= "Ԥ���Ĺ�������";
$GLOBALS['strPriorityDaysRunning']		= MAX_PRODUCT_NAME."������������{days}����ݵĻ���Ԥ��ÿ�������Ȩ.";
$GLOBALS['strPriorityBasedLastWeek']		= "�����ܺͱ�����ݻ��ϵ�Ԥ��ֵ.";
$GLOBALS['strPriorityBasedLastDays']		= "T��ǰ������ݵĻ��ϵ�Ԥ��ֵ.";
$GLOBALS['strPriorityBasedYesterday']		= "��������ݵĻ��ϵ�Ԥ��ֵ";
$GLOBALS['strPriorityNoData']			= "����û���㹻���������ȷ����˹����������������Ԥ��ֵ������ֻ��ʵʱ��ݵĻ��Ϸ�������Ȩ.";
$GLOBALS['strPriorityEnoughAdViews']		= "���㹻�ķ���������ȫ����Ԥ�������и�����Ȩ�ķ���.";
$GLOBALS['strPriorityNotEnoughAdViews']		= "����֪���Ƿ����㹻���Ʋ�������ȫ����Ԥ�������и�����Ȩ�ķ���,�������е�����Ȩ�ķ����Ѿ���ʱͣ����.";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "�ؽ���滺����";
$GLOBALS['strBannerCacheExplaination']		= "广告数�?�库缓存的作用是加速广告的投放<br />\n该缓存需�?在以下情况下更新：\n    <ul>\n        <li>您�?�级了OpenX</li>\n        <li>您将OpenX�?移到一个新的�?务器上</li>\n    </ul>";


// Cache
$GLOBALS['strCache']				= "�?�布缓存";
$GLOBALS['strAge']				= "年龄";
$GLOBALS['strRebuildDeliveryCache']		= "�?构数�?�库广告缓存";
$GLOBALS['strDeliveryCacheExplaination']	= "���ͻ����������߹��ķ����ٶ�.���ͻ���������ӵ��˰�λ�����й���һ������,�����ʵ�ʷ��Ÿ��û���ʱ�������һЩ��ݿ�Ĳ�ѯ.�˻�����ͨ����һ����λ���߰�λ��һ�����Ķ���ʱ���ؽ�,����ܻ����.���Ի������ÿ��Сʱ�Զ��ؽ�һ��,����Ҳ�����ֹ��ؽ�.";
$GLOBALS['strDeliveryCacheSharedMem']		= "共享内存目�?正被�?�布缓存�?�用";
$GLOBALS['strDeliveryCacheDatabase']		= "数�?�正在存储�?�布缓存";
$GLOBALS['strDeliveryCacheFiles']		= "�?�布缓存正在存储到你�?务器上的多个文件";


// Storage
$GLOBALS['strStorage']				= "存储";
$GLOBALS['strMoveToDirectory']			= "将图片从数�?�库中移动到目录下";
$GLOBALS['strStorageExplaination']		= "图片文件�?�存储在数�?�库或文件系统中。存储在文件系统中将比存储在数�?�库中效率更高。";


// Storage
$GLOBALS['strStatisticsExplaination']		= "您已�?�?�用了<i>紧缩统计</i>, 但是您的报表还是详细格�?, 您是�?�愿�?把现有的详细格�?转�?�为紧缩格�??";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "查找更新，请�?候……";
$GLOBALS['strAvailableUpdates']			= "�??供的更新";
$GLOBALS['strDownloadZip']			= "下载（.zip）";
$GLOBALS['strDownloadGZip']			= "下载（.tar.gz）";

$GLOBALS['strUpdateAlert']			= MAX_PRODUCT_NAME."���µİ汾����\\n\\n����֪�������ڴ˴������Ϣ��?";
$GLOBALS['strUpdateAlertSecurity']		= MAX_PRODUCT_NAME."���µİ汾����\\n\\nǿ���Ƽ������,\\n��Ϊ�˴��°汾����һ��������ȫ����!";

$GLOBALS['strUpdateServerDown']			= "由于�?明原因，导致无法获�?�更新信�?�。<br>请�?�?��?试一下。";

$GLOBALS['strNoNewVersionAvailable']		= "您". MAX_PRODUCT_NAME ."的版本已是最新的。";

$GLOBALS['strNewVersionAvailable']		= " <b>". MAX_PRODUCT_NAME ."的新版本已�?�?�布。</b><br /> 由于修改一些已知的问题�?�增加了一些新功能。所以建议您安装这个更新。如果您希望进一步了解相关细心，请�?�阅文件中的相关文档。\n";

$GLOBALS['strSecurityUpdate']			= "<b>由于涉�?�若干个安全更新，所以强烈建议您�?�级。</b> \n您现在的". MAX_PRODUCT_NAME ."版本，�?�能因为攻击而�?�得�?�?��?�。如果希望了解进一步的信�?�，请�?�阅文件中的相关文档。";

$GLOBALS['strNotAbleToCheck']			= " <b>由于您�?务器上没有XML引申，所以". MAX_PRODUCT_NAME ."无法查找是�?�有新的更新�??供。</b>";

$GLOBALS['strForUpdatesLookOnWebsite']		= "如果您希望知�?�是�?�有新的版本�??供，请查阅我们的网站。";

$GLOBALS['strClickToVisitWebsite']		= "点击访问官方网站";
$GLOBALS['strCurrentlyUsing']			= "你正在使用的";
$GLOBALS['strRunningOn']			= "�?行的";
$GLOBALS['strAndPlain']				= "与";


// Stats conversion
$GLOBALS['strConverting']			= "ת����";
$GLOBALS['strConvertingStats']			= "ͳ�����ת����...";
$GLOBALS['strConvertStats']			= "ת��ͳ�����";
$GLOBALS['strConvertAdViews']			= "�������Ѿ�ת�����,";
$GLOBALS['strConvertAdClicks']			= "������Ѿ�ת�����...";
$GLOBALS['strConvertNothing']			= "û����ݿ���ת��...";
$GLOBALS['strConvertFinished']			= "���...";

$GLOBALS['strConvertExplaination']		= "������ʹ�ü���ʽ�����汨��,���ǻ���һЩ��������ϸ��ʽ.<br />��ϸ��ʽ�ı���û��ת���ɼ���ʽ��������ҳ����ֱ��ʹ��.<br />��ת����ı���֮ǰ,������ݿ��һ������!<br />�Ƿ�ȷ��Ҫ����ϸ��ʽ�ı���ת�����µļ���ʽ?<br />";

$GLOBALS['strConvertingExplaination']		= "����ʣ�����ϸ��ʽ�ı�������ת���ɼ���ʽ<br />�����ϸ��ʽ����Ŀ����Ҫʱ�䲻ͬ��������Ҫ�����ӡ����������ҳ��֮ǰһ��Ҫ�ȵ�ת����ɡ�<br />����������ݿ��޸ĵļ�¼.<br />";

$GLOBALS['strConvertFinishedExplaination']  	= "ʣ�����ϸ��ʽ�ı����Ѿ�ת���ɹ����������Ҫ�ٴ�ʹ�ã�����������ݿ��޸ĵļ�¼<br />";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "检查广告缓存";
$GLOBALS['strBannerCacheErrorsFound'] = "�?查，数�?�库广告缓存�?�现错误。在手工修正这些错误之�?，这些广告将无法正常�?行。";
$GLOBALS['strBannerCacheOK'] = "未�?�现错误，您的数�?�库广告缓存已是最新的";
$GLOBALS['strBannerCacheDifferencesFound'] = "�?查，数�?�库广告缓存�?是最新的，需�?�?建。点击这里自动更新缓存。";
$GLOBALS['strBannerCacheRebuildButton'] = "�?构";
$GLOBALS['strUpdateAlert'] = "". MAX_PRODUCT_NAME ." 新版本已�?�布。                 \n\n您希望了解更多关于新版本的信�?��?�？?";
$GLOBALS['strUpdateAlertSecurity'] = "". MAX_PRODUCT_NAME ." 新版本已�?�布。                 \n\n由于�??供了很多安全方�?�的修改? 所以强烈建议您更新到新版本。";
$GLOBALS['strBannerCacheFixed'] = "�?功完�?广告数�?�库缓存�?构, 数�?�库缓存已�?更新.";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncoding'] = "编�?";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." 在数�?�库中使用UTF-8格�?�?存�?��?数�?�。<br />在任何�?�能情况下，您的数�?�会被自动转�?�为这�?编�?。<br />如果�?�级�?�您�?�现错乱的字符，并且您知�?�所用的编�?，您�?�以使用这个工具�?�将数�?�转�?�为UTF-8格�?。";
$GLOBALS['strEncodingConvertFrom'] = "从此编�?转�?�：";
$GLOBALS['strEncodingConvert'] = "转�?�";
$GLOBALS['strEncodingConvertTest'] = "转�?�测试";
$GLOBALS['strConvertThese'] = "如您继续，则下列数�?�会被修改";
$GLOBALS['strAppendCodes'] = "附加代�?";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "自动维护程�?在上个�?时没有被执行，请检查你的设置。";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "自动维护程�?已�?�?�动，但是他没有被触�?�，自动程�?被触�?�当". MAX_PRODUCT_NAME ."�?�布广告时，为性能考虑，你最好设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>自动维护</a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "自动维护程�?已�?被�?用，所以当". MAX_PRODUCT_NAME ."�?�布广告时，自动维护程�?�?会被广告所触�?�，为了性能考虑，你必需设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>计划维护</a>。当然，如果你�?设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>计划维护</a>的�?，你<i>必需</i><a href='account-settings-maintenance.php'>开�?�自动维护程�?</a>以确�? ". MAX_PRODUCT_NAME ." �?行正常. ";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "自动维护程�?已�?�?�动，但是他没有被触�?�，自动程�?被触�?�当". MAX_PRODUCT_NAME ."�?�布广告时，为性能考虑，你最好设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>自动维护</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "自动维护程�?已�?被�?用。为�?�?". MAX_PRODUCT_NAME ."能够正常�?行，请设定<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>计划维护任务</a>或<a href='account-settings-maintenance.php'>�?新开�?�自动维护程�?</a>。为性能考虑，你最好设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>自动维护</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "计划维护�?行正常";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "自动维护程�?�?行正常";
$GLOBALS['strAutoMantenaceEnabled'] = "自动维护程�?任然开�?�。为性能考虑，你最好<a href='account-settings-maintenance.php'>关闭自动维护</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "自动维护程�?已被�?用";
$GLOBALS['strAutoMaintenanceEnabled'] = "自动维护程�?已�?开�?�。为性能考虑，你最好<a href='account-settings-maintenance.php'>关闭自动维护</a>.";
$GLOBALS['strCheckACLs'] = "检查ACL";
$GLOBALS['strScheduledMaintenance'] = "计划维护任务似乎正常�?行中。";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "自动维护程�?已�?开�?�，但是他没有被触�?�。请注�?自动维护程�?�?�有在广告被访问时�?会被触�?�。";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "为性能考虑，请设置<a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>计划维护任务</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "自动维护程�?已�?�?�用，将会�?个�?时进行一次维护。";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "自动维护程�?已�?被�?用，但是一个维护任务正在�?行中。为确定". MAX_PRODUCT_NAME ."�?行正常你必须设置<a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>计划维护任务</a>或<a href='settings-admin.php'>开�?�自动维护程�?</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "自动维护程�?已�?被�?用，所以当". MAX_PRODUCT_NAME ."�?�布广告时，维护程�?将�?会被触�?�，如果你没有计划去�?行<a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>计划维护程�?</a>,你必须 <a href='settings-admin.php'>开�?�自动维护程�?</a>以�?�?". MAX_PRODUCT_NAME ." 正常�?行。";
$GLOBALS['strAllBannerChannelCompiled'] = "所有的广告/频�?��?制已�?被�?新设置。";
$GLOBALS['strBannerChannelResult'] = "广告/频�?��?制结果";
$GLOBALS['strChannelCompiledLimitationsValid'] = "所有的频�?��?制设置正常";
$GLOBALS['strBannerCompiledLimitationsValid'] = "所有的广告�?制设置正常";
$GLOBALS['strErrorsFound'] = "找到错误";
$GLOBALS['strRepairCompiledLimitations'] = "有些�?制设置有误，你�?�以点击按钮以修�?这些问题<br />";
$GLOBALS['strRecompile'] = "�?算";
$GLOBALS['strAppendCodesDesc'] = "在�?些环境下广告引擎在�?�布附属代�?跟踪信�?�时会�?一致，有以下链接确认附属代�?。";
$GLOBALS['strCheckAppendCodes'] = "检查附属代�?";
$GLOBALS['strAppendCodesRecompiled'] = "所有附属代�?已�?被�?设";
$GLOBALS['strAppendCodesResult'] = "附属代�?�?设结果";
$GLOBALS['strAppendCodesValid'] = "所有的跟踪附属代�?正常";
$GLOBALS['strRepairAppenedCodes'] = "有些附属代�?有误，你�?�以点击按钮以修�?这些问题";
$GLOBALS['strScheduledMaintenanceNotRun'] = "计划维护程�?在上个�?时中并没有�?行，这�?味�?�你�?�能没有设置正确";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "在�?些环境下广告�?�布引擎会�?�?��?广告�?�和频�?�的ACL，请点击下�?�的链接�?�验�?数�?�库中的ACL";
$GLOBALS['strServerCommunicationError'] = "<b>与更新�?务器的通信超时，因此".MAX_PRODUCT_NAME." 无法检查此时是�?�有�?�用的新版本。请�?�?��?试。</b>";
?>