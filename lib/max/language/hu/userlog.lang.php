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
$GLOBALS['strDelete'] = "Töröl";
$GLOBALS['strAdvertiser'] = "Hirdető";
$GLOBALS['strCampaign'] = "Kampány";
$GLOBALS['strZone'] = "Nincs";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Adatbázis automatikus tisztítása";
