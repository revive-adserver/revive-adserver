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
$GLOBALS['strMaintenance'] = "Vedlikehold";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "slettet";
$GLOBALS['strInserted'] = "satt inn";
$GLOBALS['strUpdated'] = "oppdatert";
$GLOBALS['strDelete'] = "Slett";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "Filter";
$GLOBALS['strAdvertiser'] = "Annonsør";
$GLOBALS['strPublisher'] = "Nettside";
$GLOBALS['strCampaign'] = "Kampanje";
$GLOBALS['strZone'] = "Ingen";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "Handling";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Verdi";
$GLOBALS['strReturnAuditTrail'] = "Return to Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strMaintenanceLog'] = "Vedlikeholdslogg";
$GLOBALS['strAuditResultsNotFound'] = "Ingen hendelser funnet som matcher valgt kriterium";
$GLOBALS['strCollectedAllEvents'] = "Alle hendelser";
$GLOBALS['strClear'] = "Tøm";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Report for advertiser {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campaign {id} activated";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto clean of database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistics compiled";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Deactivation notification for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampanje {id} deaktivert";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priority recalculated";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Report for website {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Deactivation warning for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Activation notification for campaign {id} send by email";
