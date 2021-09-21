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
$GLOBALS['strDeliveryEngine'] = "Pristatymo variklis";
$GLOBALS['strMaintenance'] = "Aptarnavimas";
$GLOBALS['strAdministrator'] = "Administratorius";

// Audit
$GLOBALS['strDeleted'] = "ištrintas";
$GLOBALS['strInserted'] = "įterptas";
$GLOBALS['strUpdated'] = "atnaujintas";
$GLOBALS['strDelete'] = "Ištrinti";
$GLOBALS['strHas'] = "turi";
$GLOBALS['strFilters'] = "Filtrai";
$GLOBALS['strAdvertiser'] = "Reklamos skelbėjas";
$GLOBALS['strPublisher'] = "Internetinis puslapis";
$GLOBALS['strCampaign'] = "Kampanija";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Tipas";
$GLOBALS['strAction'] = "Veiksmas";
$GLOBALS['strParameter'] = "Parametrai";
$GLOBALS['strValue'] = "Vertė";
$GLOBALS['strReturnAuditTrail'] = "Grįžti prie Audit Trail";
$GLOBALS['strMaintenanceLog'] = "techninio aptarnavimo registras";
$GLOBALS['strAuditResultsNotFound'] = "Jokių įvykių pagal įvestus kriterijus nerasta";
$GLOBALS['strCollectedAllEvents'] = "Visi įvykiai";
$GLOBALS['strClear'] = "Ištrinti";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Aktyvacijos pranešimas apie kampaniją {id} išsiųstas el. paštu";
