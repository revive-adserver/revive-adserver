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
$GLOBALS['strValue'] = "القيمة";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "تعطيل التنبيهات للحملة رقم {id} المرسلة عبر البريد الإلكتروني";
