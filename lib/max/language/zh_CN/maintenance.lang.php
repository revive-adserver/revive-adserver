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
$GLOBALS['strBannerCacheExplaination']		= "广告数据库缓存的作用是加速广告的投放<br />
该缓存需要在以下情况下更新：
    <ul>
        <li>您升级了" . MAX_PRODUCT_NAME . "</li>
        <li>您将" . MAX_PRODUCT_NAME . "迁移到一个新的服务器上</li>
    </ul>";


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

$GLOBALS['strNoNewVersionAvailable']		= "您".MAX_PRODUCT_NAME."的版本已是最新的。";

$GLOBALS['strNewVersionAvailable']		= " <b>".MAX_PRODUCT_NAME."的新版本已经发布。</b><br /> 由于修改一些已知的问题及增加了一些新功能。所以建议您安装这个更新。如果您希望进一步了解相关细心，请参阅文件中的相关文档。
";

$GLOBALS['strSecurityUpdate']			= "<b>由于涉及若干个安全更新，所以强烈建议您升级。</b> 
您现在的".MAX_PRODUCT_NAME."版本，可能因为攻击而变得不可靠。如果希望了解进一步的信息，请参阅文件中的相关文档。";

$GLOBALS['strNotAbleToCheck']			= " <b>由于您服务器上没有XML引申，所以".MAX_PRODUCT_NAME."无法查找是否有新的更新提供。</b>";

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
$GLOBALS['strBannerCacheErrorsFound'] = "在数据库中检查广告缓存时发现错误, 请手工修正这些错误, 否则这些广告无法工作";
$GLOBALS['strBannerCacheOK'] = "没有发现错误. 存放在数据库中的广告缓存已是最新的.";
$GLOBALS['strBannerCacheDifferencesFound'] = "经查, 广告数据库缓存不是最新的, 请点击这里来自动更新缓存";
$GLOBALS['strBannerCacheRebuildButton'] = "重构";
$GLOBALS['strUpdateAlert'] = "".MAX_PRODUCT_NAME." 新版本已发布。                 \n\n您希望了解更多关于新版本的信息吗？?";
$GLOBALS['strUpdateAlertSecurity'] = "".MAX_PRODUCT_NAME." 新版本已发布。                 \n\n由于提供了很多安全方面的修改? 所以强烈建议您更新到新版本。";
$GLOBALS['strBannerCacheFixed'] = "成功完成广告数据库缓存重构, 数据库缓存已经更新.";
?>