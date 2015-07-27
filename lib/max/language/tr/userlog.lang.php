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
$GLOBALS['strDeliveryEngine'] = "Teslimat Motoru";
$GLOBALS['strMaintenance'] = "Bakım";
$GLOBALS['strAdministrator'] = "Yönetici";

// Audit
$GLOBALS['strDeleted'] = "Sil";
$GLOBALS['strDelete'] = "Sil";
$GLOBALS['strAdvertiser'] = "Reklamveren";
$GLOBALS['strPublisher'] = "Web sitesi";
$GLOBALS['strCampaign'] = "Kampanya";
$GLOBALS['strZone'] = "Alan";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strAction'] = "Eylem";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Veritabanını otomatik temizle";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Veritabanını otomatik temizle";
