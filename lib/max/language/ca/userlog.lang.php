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
$GLOBALS['strMaintenance'] = "Manteniment";
$GLOBALS['strAdministrator'] = "Administrador/a";

// Audit
$GLOBALS['strDeleted'] = "s'ha suprimit";
$GLOBALS['strInserted'] = "s'ha inserit";
$GLOBALS['strUpdated'] = "s'ha actualitzat";
$GLOBALS['strFilters'] = "Filtres";
$GLOBALS['strType'] = "Tipus";
$GLOBALS['strParameter'] = "Paràmetre";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
