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
$GLOBALS['strMaintenance'] = "Vedligholdelse";
$GLOBALS['strAdministrator'] = "";

// Audit
$GLOBALS['strDeleted'] = "Slettet";
$GLOBALS['strInserted'] = "indsat";
$GLOBALS['strUpdated'] = "opdateret";
$GLOBALS['strDelete'] = "Slet";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "Filtre";
$GLOBALS['strAdvertiser'] = "Annoncør";
$GLOBALS['strPublisher'] = "Webside";
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strZone'] = "";
$GLOBALS['strType'] = "";
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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Kampagne deaktiveret";
