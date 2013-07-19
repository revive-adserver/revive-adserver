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
 * A script file to generata data for memory stress testing
 */

// Require the initialisation file
// Done differently from elsewhere so that it works in CLI MacOS X
$path = dirname(__FILE__);
require_once $path . '/../../init.php';

if ($argc >= 3) {
    $howManyRecords = intval($argv[2]);
    // by default generate 5 banners per each campaign
    $howManyBanners = isset($argv[3]) ? intval($argv[3]) : 5;
} else {
    echo "Usage: php generate-data.php host records [banners]\n";
    echo "\nExample:\n";
    echo "# generate-data localhost 100\n";
    exit(1);
}

// Required files
require_once 'TestData.php';
$dummy = new Memory_TestData();
$dummy->generate($howManyRecords, $howManyBanners);

?>
