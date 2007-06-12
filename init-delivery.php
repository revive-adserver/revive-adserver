<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * @package    MaxDelivery
 * @author     Chris Nutting <chris.nutting@openads.org>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 *
 * A file to set up the environment for the Openads delivery engine.
 *
 * Both opcode and PHP by itself slow things down when we require many
 * files. Therefore we gave up a little bit of maintainability in
 * order to speed up a delivery:
 * - We are not using classes (if possible) in delivery
 * - We have to use as few as possible includes and add new code into
 *   existing files
 */

/**
 * Main part of script where data is initialized for delivery
 */
require_once 'init-delivery-parse.php';
require_once 'variables.php';

setupDeliveryConfigVariables();
$conf = $GLOBALS['_MAX']['CONF'];

// Set the log file
if ($conf['debug']['logfile']) {
    @ini_set('error_log', MAX_PATH . '/var/' . $conf['debug']['logfile']);
}

// Disable all notices and warnings, as some PAN code still
// generates PHP warnings in places
if ($conf['debug']['production']) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
} else {
    // show all errors when developing
    error_reporting(E_ALL);
}

require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

// Set the viewer's remote information used in logging
// and delivery limitation evaluation
MAX_remotehostProxyLookup();
MAX_remotehostReverseLookup();
MAX_remotehostSetClientInfo();
MAX_remotehostSetGeoInfo();

// Set common delivery parameters in the global scope
MAX_commonInitVariables();

// Unpack the packed capping cookies
MAX_cookieUnpackCapping();

?>
