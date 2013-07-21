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
