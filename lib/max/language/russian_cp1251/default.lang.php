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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft']  = "left";
$GLOBALS['phpAds_CharSet'] = "windows-1251";


// Set translation strings
$GLOBALS['strHome'] = "������� ��������";
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['strMySQLError'] = "������ MySQL:";
$GLOBALS['strAdminstration'] = "�����������������";
$GLOBALS['strAddClient'] = "�������� �������";
$GLOBALS['strAddClient_Key']            = "�������� <u>�</u>����� �������";
$GLOBALS['strModifyClient'] = "�������� �������";
$GLOBALS['strDeleteClient'] = "������� �������";
$GLOBALS['strViewClientStats'] = "���������� ���������� �������";
$GLOBALS['strClientName'] = "������";
$GLOBALS['strContact'] = "�������";
$GLOBALS['strEMail'] = "EMail";
$GLOBALS['strImpressions'] =
$GLOBALS['strViews'] = "�������";
$GLOBALS['strClicks'] = "������";
$GLOBALS['strTotalViews'] = "����� �������";
$GLOBALS['strTotalClicks'] = "����� ������";
$GLOBALS['strCTR'] = "��������� �����/������ (CTR)";
$GLOBALS['strTotalClients'] = "����� ��������";
$GLOBALS['strActiveClients'] = "�������� ��������";
$GLOBALS['strActiveBanners'] = "�������� ��������";
$GLOBALS['strLogout'] = "�����";
$GLOBALS['strCreditStats'] = "���������� ��������";
$GLOBALS['strViewCredits'] = "������� �� �������";   
$GLOBALS['strClickCredits'] = "������� �� ������";
$GLOBALS['strPrevious'] = "����������";
$GLOBALS['strPrevious_Key']                     = "<u>�</u>���������";
$GLOBALS['strNext'] = "���������";
$GLOBALS['strNext_Key']                                 = "<u>C</u>��������";
$GLOBALS['strNone'] = "���";
$GLOBALS['strImpressionsPurchased'] = 
$GLOBALS['strViewsPurchased'] = "������� �������";
$GLOBALS['strClicksPurchased'] = "������� ������";
$GLOBALS['strDaysPurchased'] = "������� ����";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "��������� ���� ���� ��� ���� ����!";
$GLOBALS['strTextBelow'] = "����� ��� ���������";
$GLOBALS['strSubmit'] = "��������� ������";
$GLOBALS['strUsername'] = "�����";
$GLOBALS['strPassword'] = "������";
$GLOBALS['strBannerAdmin'] = "�������������� ������� ���";
$GLOBALS['strNoBanners'] = "��� ��������";
$GLOBALS['strBanner'] = "������";
$GLOBALS['strCurrentBanner'] = "������� ������";
$GLOBALS['strDelete'] = "�������";
$GLOBALS['strAddBanner'] = "�������� ����� ������";
$GLOBALS['strAddBanner_Key']                    = "�������� <u>�</u>���� ������";
$GLOBALS['strModifyBanner'] = "�������� ������";
$GLOBALS['strURL'] = "URL (� http://)";
$GLOBALS['strKeyword'] = "�������� ����� (��������� � �������)";
$GLOBALS['strWeight'] = "���";
$GLOBALS['strAlt'] = "Alt-T����";
$GLOBALS['strAccessDenied'] = "������ �������";
$GLOBALS['strPasswordWrong'] = "������ ������ �������";
$GLOBALS['strNotAdmin'] = "��������, � ��� ��� ���� �������";
$GLOBALS['strClientAdded'] = "������ ��������.";
$GLOBALS['strClientModified'] = "������ ������.";
$GLOBALS['strClientDeleted'] = "������ ������.";
$GLOBALS['strBannerAdmin'] = "����������������� ��������";
$GLOBALS['strBannerAdded'] = "������ ��������.";
$GLOBALS['strBannerModified'] = "������ ������.";
$GLOBALS['strBannerDeleted'] = "������ �����";
$GLOBALS['strBannerChanged'] = "������ ������";
$GLOBALS['strStats'] = "����������";
$GLOBALS['strDailyStats'] = "���������� �� ����";
$GLOBALS['strDetailStats'] = "��������� ����������";
$GLOBALS['strCreditStats'] = "���������� �� ��������";
$GLOBALS['strActive'] = "�������";
$GLOBALS['strActivate'] = "������������";
$GLOBALS['strDeActivate'] = "��������������";
$GLOBALS['strAuthentification'] = "������";
$GLOBALS['strGo'] = "����!";
$GLOBALS['strLinkedTo'] = "������";
$GLOBALS['strBannerID'] = "ID �������";
$GLOBALS['strClientID'] = "ID �������";
$GLOBALS['strMailSubject'] = "���� � �������";
$GLOBALS['strMailSubjectDeleted'] = "���������������� �������";
$GLOBALS['strMailHeader'] = "������� {contact},\n";
$GLOBALS['strMailBannerStats'] = "����� �� ������ ���������� ������� {clientname}:";
$GLOBALS['strMailFooter'] = "� ���������� �����������,\n   {adminfullname}";
$GLOBALS['strLogMailSent'] = "[phpAds] ���������� ������� ����������.";
$GLOBALS['strLogErrorClients'] = "[phpAds] ������ ������� � ���� ������ ���������� � ��������.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] ������ ������� � �� ��������.";
$GLOBALS['strLogErrorViews'] = "[phpAds] ������ ������� � �� �������.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] ������ ������� � �� ������.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] ������ ����������� �������.";
$GLOBALS['strRatio'] = "������� ��������������";
$GLOBALS['strChooseBanner'] = "�������� ��� �������.";
$GLOBALS['strMySQLBanner'] = "������ � ������ ���������� ���������� � ���� ������ �� �������";
$GLOBALS['strWebBanner'] = "������ � ������ ���������� ����������� � �������� �� ���-�������";
$GLOBALS['strURLBanner'] = "������ ����� ���-�� � ��������";
$GLOBALS['strHTMLBanner'] = "��������� ������";
$GLOBALS['strNewBannerFile'] = "���� ������� �� �����";
$GLOBALS['strNewBannerURL'] = "URL ������� (� http://)";
$GLOBALS['strWidth'] = "������";
$GLOBALS['strHeight'] = "������";
$GLOBALS['strTotalViews7Days'] = "����� ������� �� ������";
$GLOBALS['strTotalClicks7Days'] = "����� ������ �� ������";
$GLOBALS['strAvgViews7Days'] = "� ������� ������� �� ������";
$GLOBALS['strAvgClicks7Days'] = "� ������� ������ �� ������";
$GLOBALS['strClientIP'] = "IP �������";
$GLOBALS['strUserAgent'] = "regexp ������ User-agent";
$GLOBALS['strWeekDay'] = "���� ������ (0 - 6) ((� �����������))";
$GLOBALS['strDomain'] = "����� (��� ����� � ������)";
$GLOBALS['strSource'] = "��������";
$GLOBALS['strTime'] = "�����";
$GLOBALS['strAllow'] = "������ ������ ���";
$GLOBALS['strDeny'] = "������ ������ ���";
$GLOBALS['strResetStats'] = "�������� ����������";
$GLOBALS['strExpiration'] = "��������";
$GLOBALS['strNoExpiration'] = "���� �������� �� ����������";
$GLOBALS['strDaysLeft'] = "�������� ����";
$GLOBALS['strEstimated'] = "����� �������������� ��";
$GLOBALS['strConfirm'] = "�� ������� ?";
$GLOBALS['strBannerNoStats'] = "��� ���������� ��� ����� �������!";
$GLOBALS['strWeek'] = "������";
$GLOBALS['strWeeklyStats'] = "������������ ����������";
$GLOBALS['strWeekDay'] = "���� ������";
$GLOBALS['strDate'] = "����";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("��","��","��","��","��","��","��");
$GLOBALS['strShowWeeks'] = "����. ����� ������������ ������";
$GLOBALS['strAll'] = "���";
$GLOBALS['strAvg'] = "�������";
$GLOBALS['strHourly'] = "����������/������ �� �����";
$GLOBALS['strTotal'] = "�����";
$GLOBALS['strUnlimited'] = "�� ����������";
$GLOBALS['strUp'] = "�����";
$GLOBALS['strDown'] = "����";
$GLOBALS['strSave'] = "���������";
$GLOBALS['strSaved'] = "��� ��������!";
$GLOBALS['strDeleted'] = "��� ������!";  
$GLOBALS['strMovedUp'] = "��� ��������� ����";
$GLOBALS['strMovedDown'] = "��� ��������� ����";
$GLOBALS['strUpdated'] = "��� ��������";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strPreferences'] = "������������";
$GLOBALS['strAllowClientModifyInfo'] = "��������� ����� ������������ ������������� ����������� ���������� ������";
$GLOBALS['strAllowClientModifyBanner'] = "��������� ����� ������������ �������������� ����������� �������";
$GLOBALS['strAllowClientAddBanner'] = "��������� ����� ������������ ��������� ����� �������";
$GLOBALS['strLanguage'] = "����";
$GLOBALS['strDefault'] = "�� ���������";
$GLOBALS['strErrorViews'] = "�� ������ ������ ����� ������� ��� ������� '�� ����������' !";
$GLOBALS['strErrorNegViews'] = "������������� ����� ������� �� ���������";
$GLOBALS['strErrorClicks'] =  "�� ������ ������ ����� ������ ��� ������� '�� ����������' !";
$GLOBALS['strErrorNegClicks'] = "������������� ����� ������ �� ���������";
$GLOBALS['strErrorDays'] = "�� ������ ������ ����� ���� ��� ������� '�� ����������' !";
$GLOBALS['strErrorNegDays'] = "������������� ����� ���� �� ���������";
$GLOBALS['strTrackerImage'] = "�������� ��������:";

// New strings for version 2
$GLOBALS['strNavigation'] 				= "���������";
$GLOBALS['strShortcuts'] 				= "����������";
$GLOBALS['strDescription'] 				= "��������";
$GLOBALS['strClients'] 					= "�������";
$GLOBALS['strID']				 		= "ID";
$GLOBALS['strOverall'] 					= "�����";
$GLOBALS['strTotalBanners'] 			= "����� ��������";
$GLOBALS['strToday'] 					= "�������";
$GLOBALS['strThisWeek'] 				= "�� ��� ������";
$GLOBALS['strThisMonth'] 				= "�� ���� �����";
$GLOBALS['strBasicInformation'] 		= "�������� ����������";
$GLOBALS['strContractInformation'] 		= "����������� ����������";
$GLOBALS['strLoginInformation'] 		= "���������� � ������";
$GLOBALS['strPermissions'] 				= "�������";
$GLOBALS['strGeneralSettings']			= "����� ���������";
$GLOBALS['strSaveChanges']		 		= "��������� ���������";
$GLOBALS['strCompact']					= "���������";
$GLOBALS['strVerbose']					= "��������";
$GLOBALS['strOrderBy']					= "������������� ��";
$GLOBALS['strShowAllBanners']	 		= "�������� ��� �������";
$GLOBALS['strShowBannersNoAdClicks']	= "�������� ������� ��� ������";
$GLOBALS['strShowBannersNoAdViews']		= "�������� ������� ��� ����������";
$GLOBALS['strShowAllClients'] 			= "�������� ���� ��������";
$GLOBALS['strShowClientsActive'] 		= "�������� �������� � ��������� ���������";
$GLOBALS['strShowClientsInactive']		= "�������� �������� � ����������� ���������";
$GLOBALS['strSize']						= "������";

$GLOBALS['strMonth'] 					= array("������","�������","����","������","���","����","����", "������", "��������", "�������", "������", "�������");
$GLOBALS['strDontExpire']				= "�� �������������� ����� ������� �� ����������� ��������� ����";
$GLOBALS['strActivateNow'] 				= "���������� ������������ ����� �������";
$GLOBALS['strExpirationDate']			= "���� �����������";
$GLOBALS['strActivationDate']			= "���� ���������";

$GLOBALS['strMailClientDeactivated'] 	= "���� ������� ��� ���������, ��� ���";
$GLOBALS['strMailNothingLeft'] 			= "���� �� �� ������ ���������� ��������� ������� �� ����� �����, ����������, ��������� � ����. �� ����� ���� ����� ������� ���.";
$GLOBALS['strClientDeactivated']		= "������ ������ � ��������� ����� �������������, ��� ���";
$GLOBALS['strBeforeActivate']			= "���� ��������� ��� �� ����������";
$GLOBALS['strAfterExpire']				= "���� ���������� ���� �����������";
$GLOBALS['strNoMoreClicks']				= "��� ������������� ����� ������������";
$GLOBALS['strNoMoreViews']				= "��� ������������� ��������� ������������";

$GLOBALS['strBanners'] 					= "�������";
$GLOBALS['strCampaigns']				= "��������";
$GLOBALS['strCampaign']					= "��������";
$GLOBALS['strModifyCampaign']			= "������������� ��������";
$GLOBALS['strName']						= "���";
$GLOBALS['strBannersWithoutCampaign']	= "������� ��� ��������";
$GLOBALS['strMoveToNewCampaign']		= "������� � ����� ��������";
$GLOBALS['strCreateNewCampaign']		= "������� ����� ��������";
$GLOBALS['strEditCampaign']				= "������������� ��������";
$GLOBALS['strAddCampaign']                      = "�������� ����� ��������";
$GLOBALS['strAddCampaign_Key']          = "�������� <u>�</u>���� ��������";

$GLOBALS['strEdit']						= "�������������";
$GLOBALS['strCreate']					= "�������";
$GLOBALS['strUntitled']					= "��� ��������";

$GLOBALS['strTotalCampaigns'] 			= "����� ��������";
$GLOBALS['strActiveCampaigns'] 			= "�������� ��������";

$GLOBALS['strLinkedTo']					= "������� �";
$GLOBALS['strSendAdvertisingReport']	= "�������� ��������� ����� �� e-mail";
$GLOBALS['strNoDaysBetweenReports']		= "���������� ���� ����� ��������";
$GLOBALS['strSendDeactivationWarning']  = "�������� ��������������, ����� �������� ������������������";

$GLOBALS['strWarnClientTxt']			= "���������� ������� ��� ���������� ��� ����� �������� ����� ������ ������ {limit}. ";
$GLOBALS['strImpressionsClicksLow']		=
$GLOBALS['strViewsClicksLow']			= "��������� ���������/������� �������� � �����";

$GLOBALS['strDays']						= "����";
$GLOBALS['strHistory']					= "�������";
$GLOBALS['strAverage']					= "� �������";
$GLOBALS['strDuplicateClientName']		= "��������� ��� ������������ ��� ����������, ���������� ������� ������ ���.";
$GLOBALS['strAllowClientDisableBanner'] = "��������� ����� ������������ �������������� ��� �������";
$GLOBALS['strAllowClientActivateBanner'] = "��������� ����� ������������ ������������ ��� �������";

$GLOBALS['strGenerateBannercode']		= "������������� ��������� ���";
$GLOBALS['strChooseInvocationType']		= "����������, �������� ��� ������ �������";
$GLOBALS['strGenerate']					= "�������������";
$GLOBALS['strParameters']				= "���������";
$GLOBALS['strUniqueidentifier']			= "���������� �������������";
$GLOBALS['strFrameSize']				= "������ ������";
$GLOBALS['strBannercode']				= "��������� ���";

$GLOBALS['strSearch']					= "<u>�</u>����";
$GLOBALS['strNoMatchesFound']			= "������ �� �������";

$GLOBALS['strNoViewLoggedInInterval']   = "�� ������ ������� ������ �� ���� ���������������� ����������";
$GLOBALS['strNoClickLoggedInInterval']  = "�� ������ ������� ������ �� ���� ���������������� �������";
$GLOBALS['strMailReportPeriod']			= "���� ����� �������� � ���� ���������� � {startdate} �� {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "���� ����� �������� � ���� ��� ���������� ������ �� {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "��� ���������� ��� ���� ��������";
$GLOBALS['strFrom']						= "�";
$GLOBALS['strTo']						= "��";
$GLOBALS['strMaintenance']				= "������������";
$GLOBALS['strCampaignStats']			= "���������� �� ���������";
$GLOBALS['strClientStats']				= "���������� �� ��������";
$GLOBALS['strErrorOccurred']			= "��������� ������";
$GLOBALS['strAdReportSent']				= "����� � ������� ������";

$GLOBALS['strAutoChangeHTML']			= "�������� HTML ��� �������� ������";

$GLOBALS['strZones']					= "����";
$GLOBALS['strAddZone']					= "������� ����";
$GLOBALS['strModifyZone']				= "������������� ����";
$GLOBALS['strAddNewZone']				= "�������� ����� ����";
$GLOBALS['strAddNewZone_Key']                   = "�������� <u>�</u>���� ����";

$GLOBALS['strOverview']					= "���������";
$GLOBALS['strEqualTo']					= "�����";
$GLOBALS['strDifferentFrom']			= "���������� ��";
$GLOBALS['strAND']						= "�";  // logical operator
$GLOBALS['strOR']						= "���"; // logical operator
$GLOBALS['strOnlyDisplayWhen']			= "���������� ���� ������ ������ �����:";

$GLOBALS['strStatusText']				= "�������� �������";

$GLOBALS['strConfirmDeleteClient'] 		= "�� ������������� ������ ������� ����� �������?";
$GLOBALS['strConfirmDeleteCampaign']	= "�� ������������� ������ ������� ��� ��������?";
$GLOBALS['strConfirmDeleteBanner']		= "�� ������������� ������ ������� ���� ������?";
$GLOBALS['strConfirmDeleteZone']		= "�� ������������� ������ ������� ��� ����?";
$GLOBALS['strConfirmDeleteAffiliate']	= "�� ������������� ������ ������� ����� ��������?";

$GLOBALS['strConfirmResetStats']		= "�� ������������� ������ �������� ��� ����������?";
$GLOBALS['strConfirmResetCampaignStats']= "�� ������������� ������ �������� ���������� ��� ���� ��������?";
$GLOBALS['strConfirmResetClientStats']	= "�� ������������� ������ �������� ���������� ��� ����� �������?";
$GLOBALS['strConfirmResetBannerStats']	= "�� ������������� ������ �������� ���������� ��� ����� �������?";

$GLOBALS['strClientsAndCampaigns']		= "������� � ��������";
$GLOBALS['strCampaignOverview']			= "����� ��������";
$GLOBALS['strReports']					= "������";
$GLOBALS['strShowBanner']				= "�������� ������";

$GLOBALS['strIncludedBanners']			= "��������� �������";
$GLOBALS['strProbability']				= "�����������";
$GLOBALS['strInvocationcode']			= "��� ������";
$GLOBALS['strSelectZoneType']			= "����������, �������� ��� ����� ��������";
$GLOBALS['strBannerSelection']			= "����� ��������";
$GLOBALS['strInteractive']				= "�������������";
$GLOBALS['strRawQueryString']			= "������ ������� '��� ����'";

$GLOBALS['strBannerWeight']				= "��� �������";
$GLOBALS['strCampaignWeight']			= "��� ��������";

$GLOBALS['strZoneCacheOn']				= "����������� ��� ��������";
$GLOBALS['strZoneCacheOff']				= "����������� ��� ���������";
$GLOBALS['strCachedZones']				= "�������������� ����";
$GLOBALS['strSizeOfCache']				= "������ ����";
$GLOBALS['strAverageAge']				= "������� ����� ���������� � ����";
$GLOBALS['strRebuildZoneCache']			= "��������� ��� ��� ������";
$GLOBALS['strKiloByte']					= "KB";
$GLOBALS['strSeconds']					= "������";
$GLOBALS['strExpired']					= "��������";

$GLOBALS['strModifyBannerAcl'] 			= "���������� ������";
$GLOBALS['strACL'] 						= "�����";
$GLOBALS['strNoMoveUp'] 				= "�� ���� ����������� ������ ��� ����";
$GLOBALS['strACLAdd'] 					= "�������� ����� �����������";
$GLOBALS['strACLAdd_Key']                               = "�������� <u>�</u>���� �����������";
$GLOBALS['strNoLimitations']			= "����������� ���";

$GLOBALS['strLinkedZones']				= "��������� ����";
$GLOBALS['strNoZonesToLink']			= "���, � ������� ����� ���� ������� ������ ������, ���";
$GLOBALS['strNoZones']					= "������ �� ���������� �� ����� ����";
$GLOBALS['strNoClients']				= "����� �� ���������� �� ������ �������";
$GLOBALS['strNoStats']					= "������ �� �������� ������� ����������";
$GLOBALS['strNoAffiliates']				= "������ �� ��������� �� ���� ��������";

$GLOBALS['strCustom']					= "�������������";

$GLOBALS['strSettings'] 				= "���������";

$GLOBALS['strAffiliates']				= "��������";
$GLOBALS['strAffiliatesAndZones']		= "�������� � ����";
$GLOBALS['strAddAffiliate']				= "������� ��������";
$GLOBALS['strModifyAffiliate']			= "������������� ��������";
$GLOBALS['strAddNewAffiliate']			= "�������� ������ ��������";
$GLOBALS['strAddNewAffiliate_Key']                      = "�������� <u>�</u>����� ��������";

$GLOBALS['strCheckAllNone']				= "�������� �� / ������";

$GLOBALS['strExpandAll']                        = "<u>�</u>������� ��";
$GLOBALS['strCollapseAll']                      = "<u>�</u>������ ��";


$GLOBALS['strAllowAffiliateModifyInfo'] = "��������� ����� ������������ ������������� ���� ������������ ����������";
$GLOBALS['strAllowAffiliateModifyZones'] = "��������� ����� ������������ ������������� ��� ����������� ����";
$GLOBALS['strAllowAffiliateLinkBanners'] = "��������� ����� ������������ ��������� ������� � ��� ������������ ������";
$GLOBALS['strAllowAffiliateAddZone'] = "��������� ����� ������������ ���������� ����� ����";
$GLOBALS['strAllowAffiliateDeleteZone'] = "��������� ����� ������������ ������� ������������ ����";

$GLOBALS['strPriority']					= "���������";
$GLOBALS['strHighPriority']				= "���������� ������� � ���� �������� � ������� �����������.<br>
										   ���� �� ����������� ��� �����, phpAdsNew ����� �������� ������������ 
										   ���������� ���������� ���������� �� ����� ���.";
$GLOBALS['strLowPriority']				= "���������� ������� � ���� �������� � ������ �����������.<br>
										   ��� �������� ������������� ��� ������ ���������� ����������, ������� 
										   �� ������������ ������������������� ����������.";
$GLOBALS['strTargetLimitAdviews']		= "���������� ���������� ������� ��";
$GLOBALS['strTargetPerDay']				= "� ����.";
$GLOBALS['strRecalculatePriority']		= "����������� ����������";

$GLOBALS['strProperties']				= "���������";
$GLOBALS['strAffiliateProperties']		= "�������� ��������";
$GLOBALS['strBannerOverview']			= "��������� �������";
$GLOBALS['strBannerProperties']			= "��������� �������";
$GLOBALS['strCampaignProperties']		= "��������� ��������";
$GLOBALS['strClientProperties']			= "��������� �������";
$GLOBALS['strZoneOverview']				= "��������� ����";
$GLOBALS['strZoneProperties']			= "��������� ����";
$GLOBALS['strAffiliateOverview']		= "��������� ��������";
$GLOBALS['strLinkedBannersOverview']	= "��������� ��������� ��������";

$GLOBALS['strGlobalHistory']			= "����� �������";
$GLOBALS['strBannerHistory']			= "������� ��������";
$GLOBALS['strCampaignHistory']			= "������� ��������";
$GLOBALS['strClientHistory']			= "������� ��������";
$GLOBALS['strAffiliateHistory']			= "������� ���������";
$GLOBALS['strZoneHistory']				= "������� ���";
$GLOBALS['strLinkedBannerHistory']		= "������� ��������� ��������";

$GLOBALS['strMoveTo']					= "����������� �";
$GLOBALS['strDuplicate']				= "�����������";

$GLOBALS['strMainSettings']				= "������� ���������";
$GLOBALS['strAdminSettings']			= "���������������� ���������";

$GLOBALS['strApplyLimitationsTo']		= "��������� ����������� �";
$GLOBALS['strWholeCampaign']			= "���� ��������";
$GLOBALS['strZonesWithoutAffiliate']	= "����� ��� ��������";
$GLOBALS['strMoveToNewAffiliate']		= "����������� � ������ ��������";

$GLOBALS['strNoBannersToLink']			= "������ ��� ��������, ������� ����� �� ���� ��������� � ���� ����";
$GLOBALS['strNoLinkedBanners']			= "������ ��� ��������, ������� ��������� � ���� ����";

$GLOBALS['strAdviewsLimit']				= "����� �������";

$GLOBALS['strTotalThisPeriod']			= "����� �� ���� ������";
$GLOBALS['strAverageThisPeriod']		= "� ������� �� ���� ������";
$GLOBALS['strLast7Days']				= "��������� 7 ����";
$GLOBALS['strDistribution']				= "�������������";
$GLOBALS['strOther']					= "������";
$GLOBALS['strUnknown']					= "�����������";

$GLOBALS['strWelcomeTo']				= "����� ���������� �";
$GLOBALS['strEnterUsername']			= "������� ��� ����� � ������ ��� ����� � �������";

$GLOBALS['strBannerNetwork']			= "��������� ����";
$GLOBALS['strMoreInformation']			= "���. ����������...";
$GLOBALS['strChooseNetwork']			= "�������� ��������� ����, ������� �� ������ ������������";
$GLOBALS['strRichMedia']				= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "����������� �����";
$GLOBALS['strYes']						= "��";
$GLOBALS['strNo']						= "���";
$GLOBALS['strUploadOrKeep']				= "������ ��������� ���<br>��������� ��������: ��� ������ <br>��������� ������?";
$GLOBALS['strCheckSWF']					= "��������� ������� ������ �������������� ������ ������ Flash-������";
$GLOBALS['strURL2']						= "URL";
$GLOBALS['strTarget']					= "Target";
$GLOBALS['strConvert']					= "�������������";
$GLOBALS['strCancel']					= "��������";

$GLOBALS['strConvertSWFLinks']			= "������������� Flash-�����";
$GLOBALS['strHardcodedLinks']                   = "Ƹ���� �������������� ������";
$GLOBALS['strConvertSWF']				= "<br>Flash-����, ������� �� ������ ��� ���������, �������� ������ �������������� URL-�. phpAdsNew �� ������ ".
										  "����������� ����� ��� ����� �������, ���� �� �� ������������ ��� ".
										  "�����. ���� �� ������� ������ ���� URL ������ ����� Flash-�����. ".
										  "���� �� ������ �� �������������, �������� �� <b>�������������</b>, � ��������� ������ ".
										  "<b>��������</b>.<br><br>".
										  "��������: ���� �� �������� �� <b>�������������</b>, Flash-����, ".
									  	  "������� �� ������ ��� ���������, ����� ��������� �������. <br>����������, ��������� ��������� ����� ".
										  "��������� �����. ��� ����������� �� ����, ����� ������� Flash ��� ������ ���� ������, ������������ ".
										  "���� ��������� Flash 4 (��� ������) ������������� ��� ����������� �����������.<br><br>";

$GLOBALS['strCompressSWF']                      = "����� SWF-���� ��� ��������� �������� (������� ��������� Flash 6 �������)";
$GLOBALS['strOverwriteSource']          = "������������ �������� ���������";

$GLOBALS['strSourceStats']				= "���������� �� ���������";
$GLOBALS['strSelectSource']				= "�������� ��������, ������� �� ������ �����������:";
$GLOBALS['strSizeDistribution']         = "������������� �� �������";
$GLOBALS['strCountryDistribution']      = "������������� �� ������";
$GLOBALS['strEffectivity']                      = "�������������";


$GLOBALS['strDelimiter']                        = "�����������";
$GLOBALS['strMiscellaneous']            = "������";


$GLOBALS['strErrorUploadSecurity']              = "���������� ��������� �������� � �������������, �������� �����������!";
$GLOBALS['strErrorUploadBasedir']               = "����������� ���� ����������, ��������, � ���������� �������� safe_mode ��� ����������� open_basedir";
$GLOBALS['strErrorUploadUnknown']               = "�� ���� �������� ������ � ������������ ����� �� ����������� �������. ����������, ��������� ��������� PHP!";
$GLOBALS['strErrorStoreLocal']                  = "�� ����� ������� ���������� ������� � ��������� �������� ��������� ������. ��������, ��� ��������� ��������� �������� ���� � ���������� ��������";
$GLOBALS['strErrorStoreFTP']                    = "�� ����� ������� �������� ������� �� FTP-������ ��������� ������. ��� ����� ���� ��-�� ����, ��� ������ ����������, ��� ��-�� ������������ ��������� ��� ����������";

// Zone probability
$GLOBALS['strZoneProbListChain']                = "��� �������, ��������� � ��������� �����, ����� ������� ���������. ���� ������ ���, ������� ����� ������������:";
$GLOBALS['strZoneProbNullPri']                  = "��� �������, ��������� � ���� �����, ����� ������� ���������";

// Hosts
$GLOBALS['strHosts']                            = "�����";
$GLOBALS['strTopHosts']                         = "������ �����";
$GLOBALS['strTopCountries']             = "������ ������";
$GLOBALS['strRecentHosts']                      = "������� ��������������� �����";

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']                     = 'h';
$GLOBALS['keyUp']                       = 'u';
$GLOBALS['keyNextItem']         = '.';
$GLOBALS['keyPreviousItem']     = ',';
$GLOBALS['keyList']                     = 'l';

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']           = '�';
$GLOBALS['keyCollapseAll']      = '�';
$GLOBALS['keyExpandAll']        = '�';
$GLOBALS['keyAddNew']           = '�';
$GLOBALS['keyNext']                     = '�';
$GLOBALS['keyPrevious']         = '�';


?>
