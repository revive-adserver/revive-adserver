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
$GLOBALS['strDeliveryEngine'] = "Mesin Penyampaian";
$GLOBALS['strMaintenance'] = "Pemeliharaan";

// Audit
$GLOBALS['strDeleted'] = "Hapus";
$GLOBALS['strDelete'] = "Hapus";
$GLOBALS['strAdvertiser'] = "Pemasang Iklan";
$GLOBALS['strPublisher'] = "Penerbit";
$GLOBALS['strCampaign'] = "Kampanye";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Jenis";
$GLOBALS['strAction'] = "Aksi";
$GLOBALS['strValue'] = "Nilai";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Pembersihan database secara otomatis.";
