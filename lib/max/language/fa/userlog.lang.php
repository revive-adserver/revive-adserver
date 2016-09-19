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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "اخطار فعال شدن برای کمپین {id}  فرستادن از طریق ایمیل";
