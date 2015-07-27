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
$GLOBALS['strDelete'] = "حذف";
$GLOBALS['strAdvertiser'] = "المعلن";
$GLOBALS['strPublisher'] = "الموقع";
$GLOBALS['strCampaign'] = "الحملة الإعلانية";
$GLOBALS['strZone'] = "المنطقة";
$GLOBALS['strType'] = "النوع";
$GLOBALS['strAction'] = "الفعل";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
