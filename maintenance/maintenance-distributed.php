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

// Set time limit and send headers to prevent client timeout
set_time_limit(600);
flush();

// Prevent output
ob_start();

// Run maintenance
// Done this way so that it works in CLI PHP
$path = dirname(__FILE__);
require $path . '/../scripts/maintenance/maintenance-distributed.php';

// Get and clean output buffer
$buffer = ob_get_clean();

// Flush output buffer, stripping the
echo preg_replace('/^#!.*\n/', '', $buffer);
