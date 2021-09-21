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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Amaran penyahaktifan untuk kempen {id} dihantar melalui emel";
