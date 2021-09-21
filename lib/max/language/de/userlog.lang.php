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
$GLOBALS['strDeliveryEngine'] = "Bannerauslieferung (Programm)";
$GLOBALS['strMaintenance'] = "Wartung (Programm)";
$GLOBALS['strAdministrator'] = "Administration (Programm)";

// Audit
$GLOBALS['strDeleted'] = "gelöscht";
$GLOBALS['strInserted'] = "eingefügt";
$GLOBALS['strUpdated'] = "geändert";
$GLOBALS['strDelete'] = "Löschen";
$GLOBALS['strHas'] = "hat";
$GLOBALS['strFilters'] = "Filter";
$GLOBALS['strAdvertiser'] = "Werbetreibender";
$GLOBALS['strPublisher'] = "Webseite";
$GLOBALS['strCampaign'] = "Kampagne";
$GLOBALS['strZone'] = "Verborgene Zone";
$GLOBALS['strType'] = "Art";
$GLOBALS['strAction'] = "Aktion";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Wert";
$GLOBALS['strReturnAuditTrail'] = "Zurück zum Prüfprotokoll";
$GLOBALS['strAuditTrail'] = "Prüfprotokoll";
$GLOBALS['strMaintenanceLog'] = "Wartungsprotokoll";
$GLOBALS['strAuditResultsNotFound'] = "Keine Ereignisse mit den ausgewählten Suchkriterien gefunden";
$GLOBALS['strCollectedAllEvents'] = "Alle Ereignisse";
$GLOBALS['strClear'] = "Leeren";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Kampagne {id} deaktiviert";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Benachrichtigungsmail über die Deaktivierung der Kampagne {id} versandt";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampagne {id} deaktiviert";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priorität neu berechnet";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Auswertung für die Webseite {id} per eMail versand";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Versand einer eMail-Warnung wegen der Deaktivierung der Kampagne {id}";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Benachrichtigungsmail über die Aktivierung der Kampagne {id} versendet";
