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
$GLOBALS['strDelete'] = "Smazat";
$GLOBALS['strAdvertiser'] = "Inzerent";
$GLOBALS['strCampaign'] = "Skrytá kampaň";
$GLOBALS['strZone'] = "Zóna";
$GLOBALS['strAction'] = "Akce";
$GLOBALS['strValue'] = "Hodnota";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Výstraha na deaktivaci kampaně {id} odesláno e-mailem";
