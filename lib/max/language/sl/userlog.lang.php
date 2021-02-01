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
$GLOBALS['strDeliveryEngine'] = "Orodje za dostavo";
$GLOBALS['strMaintenance'] = "Vzdrževanje";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "izbrisano";
$GLOBALS['strInserted'] = "vstavljeno";
$GLOBALS['strUpdated'] = "posodobljeno";
$GLOBALS['strDelete'] = "Izbriši";
$GLOBALS['strHas'] = "ima";
$GLOBALS['strFilters'] = "Filtri";
$GLOBALS['strAdvertiser'] = "Oglaševalec";
$GLOBALS['strPublisher'] = "Spletna stran";
$GLOBALS['strCampaign'] = "Kampanja";
$GLOBALS['strZone'] = "Področje";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strAction'] = "Dejanje";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Vrednost";
$GLOBALS['strReturnAuditTrail'] = "Vrnitev na Pregledno pot";
$GLOBALS['strAuditTrail'] = "Pregledna pot (audit trail)";
$GLOBALS['strMaintenanceLog'] = "Vzdrževalna beležka";
$GLOBALS['strAuditResultsNotFound'] = "Po izbranih kriterijih ni bilo mogoče najti zadetkov";
$GLOBALS['strCollectedAllEvents'] = "Vsi dogodki";
$GLOBALS['strClear'] = "Počisti";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
