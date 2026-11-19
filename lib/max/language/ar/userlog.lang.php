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
$GLOBALS['strDeliveryEngine'] = "نظام التوزيع";
$GLOBALS['strMaintenance'] = "الصيانة";
$GLOBALS['strAdministrator'] = "المدير";

// Audit
$GLOBALS['strDeleted'] = "حذف";
$GLOBALS['strInserted'] = "أضاف";
$GLOBALS['strUpdated'] = "عدّل";
$GLOBALS['strDelete'] = "حذف";
$GLOBALS['strHas'] = "قد";
$GLOBALS['strFilters'] = "عوامل التصفية";
$GLOBALS['strAdvertiser'] = "المعلن";
$GLOBALS['strPublisher'] = "الموقع";
$GLOBALS['strCampaign'] = "الحملة الإعلانية";
$GLOBALS['strZone'] = "المنطقة";
$GLOBALS['strType'] = "النوع";
$GLOBALS['strAction'] = "الفعل";
$GLOBALS['strParameter'] = "المعامل";
$GLOBALS['strValue'] = "القيمة";
$GLOBALS['strReturnAuditTrail'] = "العودة إلى سجل التدقيق";
$GLOBALS['strAuditTrail'] = "سجل التدقيق";
$GLOBALS['strMaintenanceLog'] = "سجل الصيانة";
$GLOBALS['strAuditResultsNotFound'] = "لا توجد أحداث تطابق المعايير المحددة";
$GLOBALS['strCollectedAllEvents'] = "جميع الأحداث";
$GLOBALS['strClear'] = "مسح";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "إرسال تقرير المعلن {id} بالبريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "تفعيل الحملة {id}";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "التنظيف التلقائي لقاعدة البيانات";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "تجميع الإحصائيات";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "إرسال إشعار تعطيل الحملة {id} بالبريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "تعطيل الحملة {id}";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "إعادة حساب الأهمية";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "إرسال تقرير الموقع {id} بالبريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "إرسال تحذير بقرب تعطيل الحملة {id} بالبريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "إرسال إشعار تفعيل الحملة {id} بالبريد الإلكتروني";
