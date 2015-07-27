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
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Adatbázis automatikus tisztítása";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Adatbázis automatikus tisztítása";
