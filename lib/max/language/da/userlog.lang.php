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
$GLOBALS['strMaintenance'] = "Vedligholdelse";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "Slettet";
$GLOBALS['strInserted'] = "indsat";
$GLOBALS['strUpdated'] = "opdateret";
$GLOBALS['strDelete'] = "Slet";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "Filtre";
$GLOBALS['strAdvertiser'] = "Annoncør";
$GLOBALS['strPublisher'] = "Webside";
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strZone'] = "Zone";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "Aktion";
$GLOBALS['strParameter'] = "Parametre";
$GLOBALS['strValue'] = "Værdi";
$GLOBALS['strReturnAuditTrail'] = "Tilbage til Handlings Log";
$GLOBALS['strAuditTrail'] = "Handlings Log";
$GLOBALS['strMaintenanceLog'] = "Vedligeholdelses log";
$GLOBALS['strAuditResultsNotFound'] = "Ingen handlinger fundet, der matcher valgte kriterier";
$GLOBALS['strCollectedAllEvents'] = "Alle handlinger";
$GLOBALS['strClear'] = "Ryd";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Kampagne deaktiveret";
