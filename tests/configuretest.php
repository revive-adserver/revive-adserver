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

require_once('init.php');
require_once(MAX_PATH . '/tests/testClasses/CCConfigWriter.php');
require_once(MAX_PATH . '/tests/testClasses/MDB2ConfigWriter.php');

/**
 * This script configures test according to parameters passed on the command line.
 */

if ($_SERVER['argc'] != 11) {
    echo "The program expects 10 arguments!";
    exit(1);
}

$type = $_SERVER['argv'][1];
$host = $_SERVER['argv'][2];
$port = $_SERVER['argv'][3];
$username = $_SERVER['argv'][4];
$password = $_SERVER['argv'][5];
$name = strtolower($_SERVER['argv'][6]);
$tableType = $_SERVER['argv'][7];
$auditEnabled = $_SERVER['argv'][8];
$loadBalancingEnabled = $_SERVER['argv'][9];
$loadBalancingName = $_SERVER['argv'][10];

$ccConfigWriter = new CCConfigWriter();
$ccConfigWriter->configureTest($type, $host, $port, $username, $password, $name, $tableType, $auditEnabled, $loadBalancingEnabled, $loadBalancingName);

//MDB2 tests disabled
//$mdb2ConfigWriter = new MDB2ConfigWriter();
//$mdb2ConfigWriter->configureTest($type, $host, $port, $username, $password, $name, $tableType);

?>
