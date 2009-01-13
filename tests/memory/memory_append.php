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
 * Script check the memory footprint and automatically creates a report file
 * which contains the biggest memory usage per all executed scripts
 */

$mem = memory_get_usage(true);

$filename = basename($_SERVER["SCRIPT_NAME"]);

if (!defined('MAX_PATH')) {
    // make sure this script is executed only inside Openads
    exit;
}
$memoryLock = MAX_PATH . '/var/MEMORY_LOCK';
if (file_exists($memoryLock)) { exit; }
touch($memoryLock);

$aLog = file($memoryLog = MAX_PATH . '/var/memory.'.phpversion().'.log');
if (!$aLog) {
    $aLog = array();
}
$newLine = $mem."\t".$filename."\n";

$found = false;
foreach ($aLog as $lineNum => $line) {
    if (strpos($line, $filename) !== false) {
        $oldMem = array_shift(explode("\t", $line));
        if ($mem > $oldMem) {
            $aLog[$lineNum] = $newLine;
        }
        $found = true;
        break;
    }
}
if (!$found) {
    $aLog[] = $newLine;
}

// Slightly more useful sorting mechanism
natsort($aLog);
$aLog = array_reverse($aLog, true);

if (!function_exists('file_put_contents')) {
    function file_put_contents($n,$d) {
      $f=@fopen($n,"w");
      if (!$f) {
        return false;
      } else {
        fwrite($f,$d);
        fclose($f);
        return true;
      }
    }
}

if (!file_put_contents($memoryLog, implode('', $aLog))) {
    echo 'Error while saving file: '.$memoryLog;
}

unlink($memoryLock);
?>
