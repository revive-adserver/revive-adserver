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
$GLOBALS['strDeliveryEngine'] = "Enjin Penghantaran";
$GLOBALS['strMaintenance'] = "Baikpulih";
$GLOBALS['strAdministrator'] = "Pentadbir";

// Audit
$GLOBALS['strDeleted'] = "Padam";
$GLOBALS['strDelete'] = "Padam";
$GLOBALS['strZone'] = "Tiada";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
