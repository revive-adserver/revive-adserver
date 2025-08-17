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
$GLOBALS['strAdministrator'] = "Skrbnik";

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
$GLOBALS['strZone'] = "Cona";
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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Poročilo za oglaševalca {id} je bilo poslano po e-pošti";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Kampanja {id} aktivirana";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Avtomatsko čiščenje podatkovne baze";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistika sestavljena";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Obvestilo o deaktivaciji kampanje {id} je bilo poslano po e-pošti";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampanja {id} deaktivirana";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioriteta preračunana";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Poročilo za spletno stran {id} je bilo poslano po e-pošti";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Opozorilo o deaktivaciji kampanje {id} je bilo poslano po e-pošti";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Obvestilo o aktivaciji kampanje {id} je bilo poslano po e-pošti";
