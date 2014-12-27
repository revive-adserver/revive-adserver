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
 * A script to call the TestRunner class, based on the $_GET parameters
 * passed via the web client, as well as perform timing of the tests,
 * etc.
 *
 * @package    Max
 * @subpackage SimulationSuite
 */

require_once 'init.php';

// simulation fakes an arrival installation in case target system has them installed
// maintenance will detect that arrivals are installed and attempt plugin maintenance
// tables are created in the common.sql
// faking the conf vars here
$GLOBALS['_MAX']['CONF']['table']['data_raw_ad_arrival']='data_raw_ad_arrival';
$GLOBALS['_MAX']['CONF']['table']['data_intermediate_ad_arrival']='data_intermediate_ad_arrival';
$GLOBALS['_MAX']['CONF']['table']['data_summary_ad_arrival_hourly']='data_summary_ad_arrival_hourly';

$start = microtime();

// Set longer time out
if (!ini_get('safe_mode'))
{
    $conf = $GLOBALS['_MAX']['CONF'];
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
}

//$file = $_GET['file'];
//$dir  = $_GET['dir'];
$simClass = basename($file, '.php');
require_once $dir.'/'.$file;
$obj = new $simClass();
$obj->profileOn = $conf['simdb']['profile'];
$obj->run();

$execSecs = get_execution_time($start);
include TPL_PATH.'/execution_time.html';

?>
