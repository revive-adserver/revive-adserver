<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: config.php 6285 2006-12-13 10:48:48Z andrzej.swedrzynski@m3.net $
*/

/**
 * The configuration file for the test suite.
 *
 * @package    Max
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

// Define the different environment configurations
define('NO_DB',          0);
define('DB_NO_TABLES',   2);
define('DB_WITH_TABLES', 3);
define('DB_WITH_DATA',   4);

// The directories where tests can be found, to help
// reduce filesystem parsing time
$GLOBALS['_MAX']['TEST']['directories'] =
    array(
        'lib/max',
        'plugins',
        'tests'
    );

// Project path - helpful for testing external projects
// which integrate with Max code
define('MAX_PROJECT_PATH', MAX_PATH);

// Define the available root-level test groups
$GLOBALS['_MAX']['TEST']['groups'] = array(
    0 => 'unit',
    1 => 'integration',
    2 => 'visualisation'
);

/*
+---------------------------------------------------------------------------+
| UNIT TESTING CONFIGURATION ITEMS                                          |
+---------------------------------------------------------------------------+
*/

// The test type name
$type = $GLOBALS['_MAX']['TEST']['groups'][0];

// Define the directory that tests should be stored in
// (e.g. "tests", "tests/unit", etc.).
define($type . '_TEST_STORE', 'tests/unit');

// The different "layers" that can be tested, defined in terms of
// layer test codes (ie. the test files for the layer will be
// xxxxx.code.test.php), and the layer names and database
// requirements for the test(s) in that layer
$GLOBALS['_MAX']['TEST'][$type . '_layers'] =
    array(
        'core'  => array('Core Classes',                        DB_NO_TABLES),
        'tbl'   => array('Table Creation Layer (DB)',           DB_NO_TABLES),
        'dal'   => array('Data Access Layer (DB)',              DB_WITH_TABLES),
        'del'   => array('Delivery Engine',                     NO_DB),
        'dl'    => array('Delivery Limitations',                NO_DB),
        'ent'   => array('Entities',                            NO_DB),
        'fct'   => array('Forecast',                            NO_DB),
        'mtc'   => array('Maintenance Engine',                  NO_DB),
        'mts'   => array('Maintenance Statistics Engine',       NO_DB),
        'mtsdb' => array('Maintenance Statistics Engine (DB)',  DB_NO_TABLES),
        'mtp'   => array('Maintenance Priority Engine',         NO_DB),
        'mtf'   => array('Maintenance Forecasting Engine',      NO_DB),
        'mtfdb' => array('Maintenance Forecasting Engine (DB)', DB_NO_TABLES),
        'plg'   => array('Plugins',                             DB_WITH_TABLES), // Required for Site:Channel plugin test, because the DAL is being used and it currently can not be mocked.
        'admin' => array('Administrative Interface',            NO_DB),
        'sdh'   => array('Simple Data Handling',                NO_DB),
        'mol'   => array('Max Other Libraries',                 NO_DB)
    );

/*
+---------------------------------------------------------------------------+
| INTEGRATION TESTING CONFIGURATION ITEMS                                   |
+---------------------------------------------------------------------------+
*/

// The test type name
$type = $GLOBALS['_MAX']['TEST']['groups'][1];

// Define the directory that tests should be stored in
// (e.g. "tests", "tests/unit", etc.).
define($type . '_TEST_STORE', 'tests/integration');

// The different "layers" that can be tested, defined in terms of
// layer test codes (ie. the test files for the layer will be
// xxxxx.code.test.php), and the layer names and database
// requirements for the test(s) in that layer
$GLOBALS['_MAX']['TEST'][$type . '_layers'] =
    array(
        'mts' => array('Maintenance Statistics Engine (DB)',   DB_NO_TABLES),
        'mtp' => array('Maintenance Priority Engine (DB)',     DB_WITH_DATA),
        'mtf' => array('Maintenance Forecasting Engine (DB)',  DB_WITH_TABLES),
        'del' => array('Delivery Engine (DB)', DB_WITH_DATA),
    );

/*
+---------------------------------------------------------------------------+
| VISUALISATION TESTING CONFIGURATION ITEMS                                 |
+---------------------------------------------------------------------------+
*/

// The test type name
$type = $GLOBALS['_MAX']['TEST']['groups'][2];

// Define the directory that tests should be stored in
// (e.g. "tests", "tests/unit", etc.).
define($type . '_TEST_STORE', 'tests/visualisation');

// The different "layers" that can be tested, defined in terms of
// layer test codes (ie. the test files for the layer will be
// xxxxx.code.test.php), and the layer names and database
// requirements for the test(s) in that layer
$GLOBALS['_MAX']['TEST'][$type . '_layers'] =
    array(
        'mtp'   => array('Maintenance Priority Engine',      NO_DB),
        'mtpdb' => array('Maintenance Priority Engine (DB)', DB_WITH_TABLES)
    );

?>
