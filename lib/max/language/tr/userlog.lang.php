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
$GLOBALS['strFilters'] = "Filtreler";
$GLOBALS['strAdvertiser'] = "Reklamveren";
$GLOBALS['strPublisher'] = "Web sitesi";
$GLOBALS['strCampaign'] = "Kampanya";
$GLOBALS['strZone'] = "Alan";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strAction'] = "Eylem";
$GLOBALS['strParameter'] = "Değişkenler";
$GLOBALS['strValue'] = "Değer";
$GLOBALS['strAuditResultsNotFound'] = "Seçilen kriterlere uyan etkinlik bulunamadı";
$GLOBALS['strCollectedAllEvents'] = "Tüm etkinlikler";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "{id} kampanyası etkinleştirildi";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Veritabanını otomatik temizle";
