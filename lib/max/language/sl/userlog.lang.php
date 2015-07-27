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
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Objava o aktivaciji kampanje {id} se pošlje preko e-pošte";
