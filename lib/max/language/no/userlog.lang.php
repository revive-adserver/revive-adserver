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
$GLOBALS['strDeliveryEngine'] = "";
$GLOBALS['strMaintenance'] = "Vedlikehold";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "slettet";
$GLOBALS['strInserted'] = "satt inn";
$GLOBALS['strUpdated'] = "oppdatert";
$GLOBALS['strDelete'] = "Slett";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "Filter";
$GLOBALS['strAdvertiser'] = "Annonsør";
$GLOBALS['strPublisher'] = "Nettside";
$GLOBALS['strCampaign'] = "Kampanje";
$GLOBALS['strZone'] = "Ingen";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "Handling";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Verdi";
$GLOBALS['strReturnAuditTrail'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strMaintenanceLog'] = "Vedlikeholdslogg";
$GLOBALS['strAuditResultsNotFound'] = "Ingen hendelser funnet som matcher valgt kriterium";
$GLOBALS['strCollectedAllEvents'] = "Alle hendelser";
$GLOBALS['strClear'] = "Tøm";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampanje {id} deaktivert";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "";
