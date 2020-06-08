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
$GLOBALS['strMaintenance'] = "نگهداری";
$GLOBALS['strAdministrator'] = "ادمین";

// Audit
$GLOBALS['strDeleted'] = "حذف شذه";
$GLOBALS['strInserted'] = "وارد شده";
$GLOBALS['strUpdated'] = "بروز شده";
$GLOBALS['strDelete'] = "حذف";
$GLOBALS['strHas'] = "داشتن";
$GLOBALS['strFilters'] = "فیلتر ها";
$GLOBALS['strAdvertiser'] = "مبلغ";
$GLOBALS['strPublisher'] = "وب سایت";
$GLOBALS['strCampaign'] = "کمپین";
$GLOBALS['strZone'] = "منطقه";
$GLOBALS['strType'] = "نوع";
$GLOBALS['strAction'] = "اقدام";
$GLOBALS['strParameter'] = "پارامتر";
$GLOBALS['strValue'] = "مقدار";
$GLOBALS['strReturnAuditTrail'] = "بازگشت به حسابرسی نوین";
$GLOBALS['strAuditTrail'] = "حسابرسی نوین";
$GLOBALS['strMaintenanceLog'] = "ورود به سیستم تعمیر و نگهداری";
$GLOBALS['strAuditResultsNotFound'] = "واقعه ای که با ضوابط انتخاب شده مچ شود یافت نشد";
$GLOBALS['strCollectedAllEvents'] = "تمام وقایع";
$GLOBALS['strClear'] = "پاک کردن";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Report for advertiser {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campaign {id} activated";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto clean of database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistics compiled";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Deactivation notification for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campaign {id} deactivated";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priority recalculated";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Report for website {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Deactivation warning for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "اخطار فعال شدن برای کمپین {id}  فرستادن از طریق ایمیل";
