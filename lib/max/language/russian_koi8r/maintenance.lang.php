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
$GLOBALS['strChooseSection']			= "�������� ������";


// Priority
$GLOBALS['strRecalculatePriority']		= "����������� ����������";
$GLOBALS['strHighPriorityCampaigns']		= "�������� � ������� �����������";
$GLOBALS['strAdViewsAssigned']			= "�������� ����������";
$GLOBALS['strLowPriorityCampaigns']		= "�������� � ������ �����������";
$GLOBALS['strPredictedAdViews']			= "����������� ����������";
$GLOBALS['strPriorityDaysRunning']		= "������ �������� {days} ���� ����������, �� ������� ".$phpAds_productname." ����� ���������� ���� ������������. ";
$GLOBALS['strPriorityBasedLastWeek']		= "������������ �������� �� ������ �� ���� � ������� ������. ";
$GLOBALS['strPriorityBasedYesterday']		= "������������ �������� �� ������ �� �����. ";
$GLOBALS['strPriorityNoData']			= "������������ ������ ��� ��ģ����� ������������ ���������� �������, ������� ������ ������ ����������� �������. ���������� ���������� ����� ������������ �� ����������, ���������� � �������� �������. ";
$GLOBALS['strPriorityEnoughAdViews']		= "������ ���� ���������� ������� ��� �������������� ���������� ���� ������������������ ��������. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "����������, ����� �� ������� ������������� ���������� ������� ��� �������������� ���������� ���� ����������������� ��������. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "��������� ��� �������� ������";
$GLOBALS['strBannerCacheExplaination']		= "
	��� �������� �������� ����� HTML-����, ������������� ��� ������ �������. ������������� ���� ��������� ��������
	�������� ��������, ��������� HTML-��� �� ����� ������������ ��� ������� ������ �������. ���������
	��� �������� ֣���� �������������� ������ �� ������������ ".$phpAds_productname." � ����� ��������, ��� ����� �������������
	��� ������ ����������� ".$phpAds_productname." �� ����������.
";


// Zone cache
$GLOBALS['strAge']				= "����";
$GLOBALS['strCache']                    = "��� ��������";
$GLOBALS['strRebuildDeliveryCache']                     = "�������� ��� ��������";
$GLOBALS['strDeliveryCacheExplaination']                = "
        ��� �������� ������������ ��� ��������� �������� ��������. ��� �������� ����� ���� ��������,
        ����������� � ����/ ��� �������� ��������� �������� � ���� ������ � ������ ������������ ������ ������� ������������. ���
        ������ ����������� ����� ������� ��������� � ���� ��� ����� �� ����������� � ��� ��������, ��, ��������, �� ����� ����������. �������
        ��� ����� ����������� ������������� ������ ���, ��� ����� ���� �����̣� �������.
";
$GLOBALS['strDeliveryCacheSharedMem']           = "
        ��� �������� ���� �������� ������������ ����������� ������.
";
$GLOBALS['strDeliveryCacheDatabase']            = "
        ��� �������� ���� �������� ������������ ���� ������.
";


// Storage
$GLOBALS['strStorage']				= "��������";
$GLOBALS['strMoveToDirectory']			= "����������� �������� �� ���� ������ � �������";
$GLOBALS['strStorageExplaination']		= "
	��������, ������������ ���������� ���������, �������� � ���� ������ ��� � ��������. ���� �� ������ ������� �������� 
	� �������� �� �����, �������� �� ���� ������ ����������, � ��� �����ģ� � ���������.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	�� �������� <i>���������� ����������</i>, �� ���� ������ ���������� �ӣ �ݣ � ����������� �������. 
	������ ������������� ���� ����������� ���������� � ����� ���������� ������?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "������ ����������. ����������, ���������...";
$GLOBALS['strAvailableUpdates']			= "��������� ����������";
$GLOBALS['strDownloadZip']			= "������� (.zip)";
$GLOBALS['strDownloadGZip']			= "������� (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "�������� ����� ������ ".$phpAds_productname."                               \\n\\n������ ������ ������ \\n�� ���� ����������?";
$GLOBALS['strUpdateAlertSecurity']		= "�������� ����� ������ ".$phpAds_productname."                               \\n\\n������������� ���������� ���������� \\n��� ����� ������, ��� ��� ��� \\n������ �������� ���� ��� ��������� �����������, ����������� � ������������.";

$GLOBALS['strUpdateServerDown']			= "
    �� ����������� ������� ���������� �������� ���������� <br />
	� ��������� �����������. ����������, ����������� �������.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	���� ������ ".$phpAds_productname." �� ������� ����������. ������� ���������� � ��������� ����� ���.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>�������� ����� ������ ".$phpAds_productname."</b><br /> ������������� ���������� ��� ����������,
	��������� ��� ����� ��������� ��������� ������������ �������� � �������� ����� ����������������. �� ��������������
	����������� �� ���������� ���������� � ������������, ����ޣ��� � ����������������� �����.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>������������ ������������� ���������� ��� ���������� ��� ����� ������, ��������� ��� �������� ���������
	�����������, ��������� � �������������.</b> ������ ".$phpAds_productname.", ������� �� ������ �����������, ����� ���� 
	���������� ������̣���� ������, �, ��������, �� ���������. �� ��������������
	����������� �� ���������� ���������� � ������������, ����ޣ��� � ����������������� �����.
";

$GLOBALS['strNotAbleToCheck']                   = "
        <b>��������� ������ ��������� XML �� ���������� �� ����� �������, ".$phpAds_productname." �� �����
    ��������� ������� ����� ������ ������.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']  = "
        �� ������ ����������� ".$phpAds_productname." ".$phpAds_version_readable.". 
        ���� �� ������ ������, ��� �� ����� ����� ������, �������� ��� �������.
";

$GLOBALS['strClickToVisitWebsite']              = "
        ������� �����, ����� �������� ��� �������
";


// Stats conversion
$GLOBALS['strConverting']			= "��������������";
$GLOBALS['strConvertingStats']			= "��������������� ����������...";
$GLOBALS['strConvertStats']			= "������������� ����������";
$GLOBALS['strConvertAdViews']			= "������ �������������,";
$GLOBALS['strConvertAdClicks']			= "����� �������������...";
$GLOBALS['strConvertNothing']			= "������ ���������������...";
$GLOBALS['strConvertFinished']			= "���������...";

$GLOBALS['strConvertExplaination']		= "
	�� ������ ����������� ���������� ������ �������� ����� ����������, �� � ��� �ӣ ��� ���� <br />
	��������� ������ � ����������� �������. �� ��� ��� ���� ����������� ���������� �� �����  <br />
	������������� � ���������� ������, ��� �� ����� �������������� ��� ��������� ���� �������.  <br />
	����� ��������������� ����������, �������� ��������� ����� ���� ������!  <br />
	�� ������ ������������� ���� ����������� ���������� � ����� ���������� ������? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	��� ���������� ����������� ���������� ������ ������������� � ���������� ������. <br />
	� ����������� �� ����, ������� ������� ��������� � ����������� �������, ��� ����� ������  <br />
	��������� �����. ����������, ��������� ��������� ��������������, ������ ��� �� �����ģ�� �� ������ <br />
	��������pages. ���� �� ������� ������ ���� ���������, �����ף������ � ���� ������. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	�������������� ������������ ����������� ���������� ���� �������� � ��� ������ <br />
	������ ���� ������ ��������. ���� �� ������ ������� ������ ���� ���������, <br />
	�������ģ���� � ���� ������.<br />
";


?>
