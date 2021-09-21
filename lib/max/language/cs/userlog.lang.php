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
$GLOBALS['strDeliveryEngine'] = "Doručovací engine";
$GLOBALS['strMaintenance'] = "Správa";
$GLOBALS['strAdministrator'] = "Administrátor";

// Audit
$GLOBALS['strDeleted'] = "Smazat";
$GLOBALS['strInserted'] = "vloženo";
$GLOBALS['strUpdated'] = "aktualizováno";
$GLOBALS['strDelete'] = "Smazat";
$GLOBALS['strFilters'] = "Filtry";
$GLOBALS['strAdvertiser'] = "Inzerent";
$GLOBALS['strPublisher'] = "Webová stránka";
$GLOBALS['strCampaign'] = "Kampaň";
$GLOBALS['strZone'] = "Zóna";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strAction'] = "Akce";
$GLOBALS['strParameter'] = "Parametry";
$GLOBALS['strValue'] = "Hodnota";
$GLOBALS['strReturnAuditTrail'] = "Návrat do auditu";
$GLOBALS['strAuditResultsNotFound'] = "Nebyly nalezeny žádné události odpovídající na vybraná kritéria";
$GLOBALS['strCollectedAllEvents'] = "Všechny události";
$GLOBALS['strClear'] = "Vyčistit";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Report pro inzerenta {id} poslat emailem";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Kampaň {id} aktivována";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Upozornění na deaktivaci kampaně {id} poslat emailem";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampaň {id} deaktivována";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priorita přepočítána";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Reporty pro web {id} poslat emailem";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Upozornění o deaktivaci kampaně {id} poslat emailem";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
