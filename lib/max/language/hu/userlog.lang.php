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
$GLOBALS['strDeliveryEngine'] = "Kiszolgáló motor";
$GLOBALS['strMaintenance'] = "Karbantartás";
$GLOBALS['strAdministrator'] = "Adminisztrátor";

// Audit
$GLOBALS['strDeleted'] = "Töröl";
$GLOBALS['strUpdated'] = "frissítve";
$GLOBALS['strDelete'] = "Törlés";
$GLOBALS['strFilters'] = "Szűrők";
$GLOBALS['strAdvertiser'] = "Hirdető";
$GLOBALS['strPublisher'] = "Weboldal";
$GLOBALS['strCampaign'] = "Kampány";
$GLOBALS['strZone'] = "Zóna";
$GLOBALS['strType'] = "Típus";
$GLOBALS['strAction'] = "Művelet";
$GLOBALS['strParameter'] = "Paraméter";
$GLOBALS['strValue'] = "Érték";
$GLOBALS['strCollectedAllEvents'] = "Összes esemény";
$GLOBALS['strClear'] = "Töröl";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Adatbázis automatikus tisztítása";
