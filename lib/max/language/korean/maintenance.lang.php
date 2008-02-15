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
$GLOBALS['strChooseSection']			= "���� ����";


// Priority
$GLOBALS['strRecalculatePriority']		= "�켱��' �ٽ� ���";
$GLOBALS['strHighPriorityCampaigns']		= "��: �켱��' ķ����";
$GLOBALS['strAdViewsAssigned']			= "�Ҵ�� AdViews";
$GLOBALS['strLowPriorityCampaigns']		= "��: �켱��' ķ����";
$GLOBALS['strPredictedAdViews']			= "���� AdViews";
$GLOBALS['strPriorityDaysRunning']		= "���� ����ġ�� ����8�� {days}�� d�� �����ֽ4ϴ�.";
$GLOBALS['strPriorityBasedLastWeek']		= "���ֿ� ������ �����͸� ���� ���� ����� ���. ";
$GLOBALS['strPriorityBasedLastDays']		= "�ֱ� ��ĥ���� �����͸� ���� ���� ����� ���. ";
$GLOBALS['strPriorityBasedYesterday']		= "��f �����͸� ����8�� ���� ����� ���. ";
$GLOBALS['strPriorityNoData']			= "There isn't enough data available to make a reliable prediction about the number of impressions this adserver will generate today. Priority assignments will be based on real time statistics only. ";
$GLOBALS['strPriorityEnoughAdViews']		= "There should be enough AdViews to fully satisfy the target all high priority campaigns. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "It isn't clear wether there will be enough AdViews served today to satisfy the target all high priority campaigns. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "��� ĳ�� �ٽ� ���";
$GLOBALS['strBannerCacheExplaination']		= "
	The banner cache contains a copy of the HTML code which is used to display the banner. By using a banner cache it is possible to speed
	up the delivery of banners because the HTML code doesn't need to be generated every time a banner is being delivered. Because the
	banner cache contains hard coded URLs to the location of ".$phpAds_productname." and its banners, the cache needs to be updated
	everytime ".$phpAds_productname." is moved to another location on the webserver.
";


// Cache
$GLOBALS['strCache']			= "���/�� ĳ��";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strRebuildDeliveryCache']			= "���/�� ĳ�� �ٽ� ���";
$GLOBALS['strDeliveryCacheExplaination']		= "
	���/�� ĳ��(delivery cache)�� ��ʸ� ��� ����ϱ� '�� ����ϴ� ����̴�.
	The cache contains a copy of all the banners
	which are linked to the zone which saves a number of database queries when the banners are actually delivered to the user. The cache
	is usually rebuild everytime a change is made to the zone or one of it's banners, it is possible the cache will become outdated. Because
	of this the cache will automatically rebuild every hour, but it is also possible to rebuild the cache manually.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	���� ���/�� ĳ�ø� �����ϱ� '�� ��/ �޸𸮸� ����ϰ� �ֽ4ϴ�. ";
$GLOBALS['strDeliveryCacheDatabase']		= "
  ���� ���/�� ĳ�ø� �����ϱ� '�� �����ͺ��̽��� ����ϰ� �ֽ4ϴ�. ";


// Storage
$GLOBALS['strStorage']				= "���念��";
$GLOBALS['strMoveToDirectory']			= "�����ͺ��̽��� ����� �̹��� ���͸��� �ű��";
$GLOBALS['strStorageExplaination']		= "
	���� ��ʷ� ����ϴ� �̹���� �����ͺ��̽� �Ǵ� ���͸��� ����Ǿ� �ֽ4ϴ�. �̹��� ���͸��� ������ ��쿡�� �����ͺ��̽��� ���� ���ϸ� ����8�ν� �ӵ��� ����ų �� �ֽ4ϴ�.";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	You have enabled the <i>compact statistics</i>, but your old statistics are still in verbose format. 
	Do you want to convert your verbose statistics to the new compact format?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "����Ʈ�� �ϻ����Դϴ�. ��� ��ٷ��ֽʽÿ�...";
$GLOBALS['strAvailableUpdates']			= "�̿��� �� �ִ� ����Ʈ";
$GLOBALS['strDownloadZip']			= "�ٿ�ε�(.zip)";
$GLOBALS['strDownloadGZip']			= "�ٿ�ε�(.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname."�� �� ����; �̿��� �� �ֽ4ϴ�.\\n\\n�� ����Ʈ�� ���� �ڼ��� d���� ���ڽ4ϱ�?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname."�� �� ����; �̿��� �� �ֽ4ϴ�.\\n\\n�� ����: �ϳ� �Ǵ� �� �̻��� ���� ��d; �����ϰ� ��8�Ƿ� �������� ���� ��׷��̵��� ��; ���մϴ�.";

$GLOBALS['strUpdateServerDown']			= "
    Due to an unknown reason it isn't possible to retrieve <br />
	information about possible updates. Please try again later.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	���� ������� ".$phpAds_productname."�� ����: �ֽ��Դϴ�. ���� �̿��� �� �ִ� ����Ʈ�� ��4ϴ�.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>A new version of ".$phpAds_productname." is available.</b><br /> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of ".$phpAds_productname." which you are currently using might 
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Because the XML extention isn't available on your server, ".$phpAds_productname." is not
    able to check if a newer version is available.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	You are currently running ".$phpAds_productname." ".$phpAds_version_readable.". 
	If you want to know if there is a newer version available, please take a look at our website.
";

$GLOBALS['strClickToVisitWebsite']		= "
	Click here to visit our website
";


// Stats conversion
$GLOBALS['strConverting']			= "��ȯ��";
$GLOBALS['strConvertingStats']			= "��踦 ��ȯ���Դϴ�...";
$GLOBALS['strConvertStats']			= "��� ��ȯ";
$GLOBALS['strConvertAdViews']			= "AdViews ��ȯ,";
$GLOBALS['strConvertAdClicks']			= "AdClicks ��ȯ...";
$GLOBALS['strConvertNothing']			= "��ȯ�� ���� ��4ϴ�...";
$GLOBALS['strConvertFinished']			= "�Ϸ�...";

$GLOBALS['strConvertExplaination']		= "
	You are currently using the compact format to store your statistics, but there are <br />
	still some statistics in verbose format. As long as the verbose statistics aren't  <br />
	converted to compact format they will not be used while viewing these pages.  <br />
	Before converting your statistics, make a backup of the database!  <br />
	Do you want to convert your verbose statistics to the new compact format? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	All remaining verbose statistics are now being converted to the compact format. <br />
	Depending on how many impressions are stored in verbose format this may take a  <br />
	couple of minutes. Please wait until the conversion is finished before you visit other <br />
	pages. Below you will see a log of all modification made to the database. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	The conversion of the remaining verbose statistics was succesful and the data <br />
	should now be usable again. Below you will see a log of all modification made <br />
	to the database.<br />
";


?>