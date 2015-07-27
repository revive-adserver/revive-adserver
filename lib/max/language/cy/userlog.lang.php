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
$GLOBALS['strMaintenance'] = "Cynnal";

// Audit
$GLOBALS['strDeleted'] = "Dileu";
$GLOBALS['strDelete'] = "Dileu";
$GLOBALS['strAdvertiser'] = "Hysbysebwr";
$GLOBALS['strPublisher'] = "Gwefan";
$GLOBALS['strCampaign'] = "Ymgyrch";
$GLOBALS['strZone'] = "Ardal";
$GLOBALS['strType'] = "Math";
$GLOBALS['strAction'] = "Gweithred";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Dad-ysgogwyd ymgyrch {id}";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Dad-ysgogwyd ymgyrch {id}";
