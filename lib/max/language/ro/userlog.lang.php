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
$GLOBALS['strDeliveryEngine'] = "Motor de Livrare";
$GLOBALS['strMaintenance'] = "Întreţinere";

// Audit
$GLOBALS['strDeleted'] = "şters";
$GLOBALS['strInserted'] = "adăugat";
$GLOBALS['strUpdated'] = "actualizat";
$GLOBALS['strDelete'] = "Şterge";
$GLOBALS['strHas'] = "are";
$GLOBALS['strFilters'] = "Filtre";
$GLOBALS['strCampaign'] = "Campanie";
$GLOBALS['strZone'] = "Zonă";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strAction'] = "Acţiune";
$GLOBALS['strParameter'] = "Parametru";
$GLOBALS['strValue'] = "Valoare";
$GLOBALS['strReturnAuditTrail'] = "Întoarcere la Urmărirea Bilanţului";
$GLOBALS['strAuditTrail'] = "Urmărirea Bilanţului";
$GLOBALS['strMaintenanceLog'] = "Jurnal întreţinere";
$GLOBALS['strAuditResultsNotFound'] = "Nu a fost găsit nici un eveniment care să corespundă criteriilor selectate.";
$GLOBALS['strCollectedAllEvents'] = "Toate evenimentele";
$GLOBALS['strClear'] = "Curăţă";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
