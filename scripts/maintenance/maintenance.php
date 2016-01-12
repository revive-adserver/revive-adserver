#!/usr/bin/php -q
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

/**
 * A script file to run the Maintenance Statistics Engine and the
 * Maintenance Priority Engine processes.
 *
 * @package    OpenXMaintenance
 * @subpackage Tools
 */

// Set the current path
// Done this way so that it works in CLI PHP
$path = dirname(__FILE__);

// Require the timezone class, and get the system timezone,
// storing in a global variable
global $serverTimezone;
require_once $path . '/../../lib/OX/Admin/Timezones.php';
$serverTimezone = OX_Admin_Timezones::getTimezone();

// Require the initialisation file
require_once $path . '/../../init.php';

// Set longer time out, and ignore user abort
if (!ini_get('safe_mode')) {
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

// Required files
require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';

require_once OX_PATH . '/lib/OX.php';
require_once LIB_PATH . '/Maintenance.php';

$oMaint = new OX_Maintenance();
$oMaint->run();

// Update scheduled maintenance last run record
$oMaint->updateLastRun(true);

?>