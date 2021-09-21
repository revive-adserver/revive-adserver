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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Dad-ysgogwyd ymgyrch {id}";
