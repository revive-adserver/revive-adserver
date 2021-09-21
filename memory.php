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
 * @package    Revive Adserver
 *
 * A file of memory-related functions, that are used as part of the UI system's
 * pre-initialisation "pre-check.php" file, and also as part of the delivery
 * engine, maintenance engine, etc.
 */
/**
 * Returns the minimum required amount of memory required for operation.
 *
 * @param strting $limit An optional limitation level, to have a memory limit OTHER than
 *                       the default UI/delivery engine memory limit returned. If used,
 *                       one of:
 *                          - "cache"       - The limit used for generating XML caches
 *                          - "plugin"      - The limit used for installing pluings
 *                          - "maintenance" - The limit used for the maintenance engine
 * @return integer The required minimum amount of memory (in bytes).
 */
function OX_getMinimumRequiredMemory($limit = null)
{
    if ($limit == 'maintenance') {
        return 134217728; // 128MB in bytes (128 * 1048576)
    }
    return 134217728; // 128MB in bytes (128 * 1048576)
}
/**
 * Get the PHP memory_limit value in bytes.
 *
 * @return integer The memory_limit value set in PHP, in bytes
 *                 (or -1, if no limit).
 */
function OX_getMemoryLimitSizeInBytes()
{
    $phpMemoryLimit = ini_get('memory_limit');
    if (empty($phpMemoryLimit) || $phpMemoryLimit == -1) {
        // No memory limit
        return -1;
    }
    $aSize = [
        'G' => 1073741824,
        'M' => 1048576,
        'K' => 1024
    ];
    $phpMemoryLimitInBytes = $phpMemoryLimit;
    foreach ($aSize as $type => $multiplier) {
        $pos = strpos($phpMemoryLimit, $type);
        if (!$pos) {
            $pos = strpos($phpMemoryLimit, strtolower($type));
        }
        if ($pos) {
            $phpMemoryLimitInBytes = substr($phpMemoryLimit, 0, $pos) * $multiplier;
        }
    }
    return $phpMemoryLimitInBytes;
}
/**
 * Test if the memory_limit can be changed.
 *
 * @return boolean True if the memory_limit can be changed, false otherwise.
 */
function OX_checkMemoryCanBeSet()
{
    $phpMemoryLimitInBytes = OX_getMemoryLimitSizeInBytes();
    // Unlimited memory, no need to check if it can be set
    if ($phpMemoryLimitInBytes == -1) {
        return true;
    }
    OX_increaseMemoryLimit($phpMemoryLimitInBytes + 1);
    $newPhpMemoryLimitInBytes = OX_getMemoryLimitSizeInBytes();
    $memoryCanBeSet = ($phpMemoryLimitInBytes != $newPhpMemoryLimitInBytes);

    // Restore previous limit
    @ini_set('memory_limit', $phpMemoryLimitInBytes);
    return $memoryCanBeSet;
}
/**
 * Increase the PHP memory_limit value to the supplied size, if required.
 *
 * @param integer $setMemory The memory_limit that should be set (in bytes).
 * @return boolean True if the memory_limit was already greater than the value
 *                 supplied, or if the attempt to set a larger memory_limit was
 *                 successful; false otherwise.
 */
function OX_increaseMemoryLimit($setMemory)
{
    $phpMemoryLimitInBytes = OX_getMemoryLimitSizeInBytes();
    if ($phpMemoryLimitInBytes == -1) {
        // Memory is unlimited
        return true;
    }
    return !($setMemory > $phpMemoryLimitInBytes && @ini_set('memory_limit', $setMemory) === false);
}
