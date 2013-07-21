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
 * A script file to run the Maintenance Priority Engine.
 */

// Send headers to the client before proceeding
flush();

// Prevent output
ob_start();

// Run maintenance
// Done this way so that it works in CLI PHP
$path = dirname(__FILE__);
require_once $path . '/../../init.php';

// Set longer time out, and ignore user abort
if (!ini_get('safe_mode')) {
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

OA_Maintenance_Priority::run();

// Get and clean output buffer
$buffer = ob_get_clean();

// Flush output buffer, stripping the
echo preg_replace('/^#!.*\n/', '', $buffer);

?>
