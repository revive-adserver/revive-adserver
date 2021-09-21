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
$GLOBALS['strDeliveryEngine'] = "전달유지 엔진";
$GLOBALS['strMaintenance'] = "유지보수";
$GLOBALS['strAdministrator'] = "관리자";

// Audit
$GLOBALS['strDeleted'] = "삭제";
$GLOBALS['strDelete'] = "삭제";
$GLOBALS['strAdvertiser'] = "광고주";
$GLOBALS['strPublisher'] = "웹사이트";
$GLOBALS['strCampaign'] = "캠페인";
$GLOBALS['strZone'] = "광고영역";
$GLOBALS['strAction'] = "작업";
$GLOBALS['strValue'] = "값";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "데이터베이스 자동 정리";
