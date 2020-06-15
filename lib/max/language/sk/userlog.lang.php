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
$GLOBALS['strDeliveryEngine'] = "Delivery Engine";
$GLOBALS['strMaintenance'] = "Údržba";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "Zmazať";
$GLOBALS['strInserted'] = "inserted";
$GLOBALS['strUpdated'] = "updated";
$GLOBALS['strDelete'] = "Zmazať";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "Filters";
$GLOBALS['strAdvertiser'] = "Inzerent";
$GLOBALS['strPublisher'] = "Webstránka";
$GLOBALS['strCampaign'] = "Kampaň";
$GLOBALS['strZone'] = "Oblasť";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "Akcia";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Value";
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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Activation notification for campaign {id} send by email";
