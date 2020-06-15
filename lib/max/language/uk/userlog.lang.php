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
$GLOBALS['strDeliveryEngine'] = "Движок доставки";
$GLOBALS['strMaintenance'] = "Обслуговування";
$GLOBALS['strAdministrator'] = "Администратор";

// Audit
$GLOBALS['strDeleted'] = "Видалити";
$GLOBALS['strInserted'] = "inserted";
$GLOBALS['strUpdated'] = "updated";
$GLOBALS['strDelete'] = "Видалити";
$GLOBALS['strHas'] = "содержит";
$GLOBALS['strFilters'] = "Filters";
$GLOBALS['strAdvertiser'] = "Клієнт";
$GLOBALS['strPublisher'] = "Вебсайт";
$GLOBALS['strCampaign'] = "Кампанія";
$GLOBALS['strZone'] = "Зона";
$GLOBALS['strType'] = "Тип";
$GLOBALS['strAction'] = "Дія";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Значение";
$GLOBALS['strReturnAuditTrail'] = "Return to Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strMaintenanceLog'] = "Maintenance log";
$GLOBALS['strAuditResultsNotFound'] = "No events found matching the selected criteria";
$GLOBALS['strCollectedAllEvents'] = "All events";
$GLOBALS['strClear'] = "Clear";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
