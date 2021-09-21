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
$GLOBALS['strMaintenance'] = "Vedligholdelse";

// Audit
$GLOBALS['strDeleted'] = "Slettet";
$GLOBALS['strInserted'] = "indsat";
$GLOBALS['strUpdated'] = "opdateret";
$GLOBALS['strDelete'] = "Slet";
$GLOBALS['strFilters'] = "Filtre";
$GLOBALS['strAdvertiser'] = "Annoncør";
$GLOBALS['strPublisher'] = "Webside";
$GLOBALS['strCampaign'] = "Kampagne";
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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Kampagne deaktiveret";
