<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * A script to call the TestRunner class, based on the $_GET parameters
 * passed via the web client, as well as perform timing of the tests,
 * etc.
 *
 * @package    Max
 * @subpackage SimulationSuite
 * @author
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
