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
$GLOBALS['strInserted'] = "inserted";
$GLOBALS['strUpdated'] = "updated";
$GLOBALS['strDelete'] = "Sil";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "Filtreler";
$GLOBALS['strAdvertiser'] = "Reklamveren";
$GLOBALS['strPublisher'] = "Web sitesi";
$GLOBALS['strCampaign'] = "Kampanya";
$GLOBALS['strZone'] = "Alan";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strAction'] = "Eylem";
$GLOBALS['strParameter'] = "Değişkenler";
$GLOBALS['strValue'] = "Değer";
$GLOBALS['strReturnAuditTrail'] = "Return to Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strMaintenanceLog'] = "Maintenance log";
$GLOBALS['strAuditResultsNotFound'] = "Seçilen kriterlere uyan etkinlik bulunamadı";
$GLOBALS['strCollectedAllEvents'] = "Tüm etkinlikler";
$GLOBALS['strClear'] = "Clear";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Report for advertiser {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "{id} kampanyası etkinleştirildi";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto clean of database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistics compiled";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Deactivation notification for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campaign {id} deactivated";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priority recalculated";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Report for website {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Deactivation warning for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Veritabanını otomatik temizle";
