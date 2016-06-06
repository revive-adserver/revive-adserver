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

// Set translation strings
$GLOBALS['strDeliveryEngine'] = "موتور تحویل";
$GLOBALS['strMaintenance'] = "نگهدار&#1740;";
$GLOBALS['strAdministrator'] = "مدیریت";

// Audit
$GLOBALS['strDeleted'] = "حذف";
$GLOBALS['strDelete'] = "حذ�?";
$GLOBALS['strAdvertiser'] = "آگهی دهنده";
$GLOBALS['strPublisher'] = "ناشر";
$GLOBALS['strCampaign'] = "داخلی";
$GLOBALS['strZone'] = "ناحیه";
$GLOBALS['strAction'] = "اقدام";
$GLOBALS['strValue'] = "قیمت";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "غیر فعال کردن هشدارها برای campaign {id} و ارسال توسط ایمیل";
