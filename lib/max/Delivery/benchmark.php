<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
 * @subpackage benchmark
 * @author     Chris Nutting <chris@m3.net>
 */

/**
 * If benchmarking is enabled, then start the benchmark
 */
function MAX_benchmarkStart()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($conf['debug']['benchmark']) {
        include_once 'Benchmark/Timer.php';
        $timer = new Benchmark_Timer();
        $timer->start();
        $GLOBALS['timer'] = $timer;
    }
}

/**
 * If benchmarking is enabled, then stop the benchmark
 * and log the results
 */
function MAX_benchmarkStop()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($conf['debug']['benchmark']) {
        require_once MAX_PATH . '/lib/max/Delivery/log.php';
        $timer = $GLOBALS['timer'];
        $timer->stop();
        MAX_Delivery_log_logBenchmark(basename($_SERVER['PHP_SELF']), $_SERVER['QUERY_STRING'], $timer->timeElapsed());
    }
}

/**
 * Get the amount of bytes of memory usage at this particular moment.
 *
 * @return int|string The total number of bytes that this PHP process is currently using.
 *                    or a string containing the HTML to display "No value"
 */
function MAX_benchmarkGetMemoryUsage()
{
    if (function_exists('memory_get_usage')) {
        return memory_get_usage();
    } elseif ( strpos( strtolower($_SERVER["OS"]), 'windows') !== false) {
        // Windows workaround
        $output = array();
        exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);
        return substr($output[5], strpos($output[5], ':') + 1);
    } else {
        return '<b style="color: red;">no value</b>';
    }
}

?>
