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
$GLOBALS['strInserted'] = "";
$GLOBALS['strUpdated'] = "";
$GLOBALS['strDelete'] = "Padam";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "";
$GLOBALS['strAdvertiser'] = "";
$GLOBALS['strPublisher'] = "";
$GLOBALS['strCampaign'] = "";
$GLOBALS['strZone'] = "Tiada";
$GLOBALS['strType'] = "";
$GLOBALS['strAction'] = "";
$GLOBALS['strParameter'] = "";
$GLOBALS['strValue'] = "";
$GLOBALS['strReturnAuditTrail'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strMaintenanceLog'] = "";
$GLOBALS['strAuditResultsNotFound'] = "";
$GLOBALS['strCollectedAllEvents'] = "";
$GLOBALS['strClear'] = "";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
