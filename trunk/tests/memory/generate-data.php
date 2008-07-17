<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
