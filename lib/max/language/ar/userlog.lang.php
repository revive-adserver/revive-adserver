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
$GLOBALS['strInserted'] = "";
$GLOBALS['strUpdated'] = "";
$GLOBALS['strDelete'] = "حذف";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "";
$GLOBALS['strAdvertiser'] = "المعلن";
$GLOBALS['strPublisher'] = "الموقع";
$GLOBALS['strCampaign'] = "الحملة الإعلانية";
$GLOBALS['strZone'] = "المنطقة";
$GLOBALS['strType'] = "النوع";
$GLOBALS['strAction'] = "الفعل";
$GLOBALS['strParameter'] = "";
$GLOBALS['strValue'] = "القيمة";
$GLOBALS['strReturnAuditTrail'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strMaintenanceLog'] = "";
$GLOBALS['strAuditResultsNotFound'] = "";
$GLOBALS['strCollectedAllEvents'] = "";
$GLOBALS['strClear'] = "";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
