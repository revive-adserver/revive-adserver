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
 * A File based cache store plugin for delivery cache - delivery functions
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStore
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */

/**
 * Make sure that the custom path is used if set
 */
if (!empty($GLOBALS['_MAX']['CONF']['oxCacheFile']['cachePath'])) {
    $GLOBALS['OA_Delivery_Cache']['path'] = trim($GLOBALS['_MAX']['CONF']['oxCacheFile']['cachePath']).'/';
} else {
    $GLOBALS['OA_Delivery_Cache']['path'] = MAX_PATH.'/var/cache/';
}

/**
 * Function to fetch a cache entry
 *
 * @param string $filename The name of file where cache entry is stored
 * @return mixed False on error, or array the cache content
 */
function Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheRetrieve($filename) 
{
    $cache_complete = false;
    $cache_contents = '';

    // We are assuming that most of the time cache will exists
    $ok = @include($GLOBALS['OA_Delivery_Cache']['path'].$filename);

    if ($ok && $cache_complete == true) {
        return $cache_contents;
    }

    return false;
}

/**
 * A function to store content a cache entry.
 *
 * @param string $filename The filename where cache entry is stored
 * @param array $cache_contents  The cache content
 * @return bool True if the entry was succesfully stored
 */
function Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore($filename, $cache_contents)
{    
    if (!is_writable($GLOBALS['OA_Delivery_Cache']['path'])) {
        return false;
    }

    $filename = $GLOBALS['OA_Delivery_Cache']['path'].$filename;

    $cache_literal  = "<"."?php\n\n";
    $cache_literal .= "$"."cache_contents   = ".var_export($cache_contents, true).";\n\n";
    $cache_literal .= "$"."cache_complete   = true;\n\n";
    $cache_literal .= "?".">";

    // Write cache to a temp file, then rename it, overwritng the old cache
    // On *nix systems this should guarantee atomicity
    $tmp_filename = tempnam($GLOBALS['OA_Delivery_Cache']['path'], $GLOBALS['OA_Delivery_Cache']['prefix'].'tmp_');
    if ($fp = @fopen($tmp_filename, 'wb')) {
        @fwrite ($fp, $cache_literal, strlen($cache_literal));
        @fclose ($fp);

        if (!@rename($tmp_filename, $filename)) {
            // On some systems rename() doesn't overwrite destination
            @unlink($filename);
            if (!@rename($tmp_filename, $filename)) {
                // Make sure that no temporary file is left over
                // if the destination is not writable
                @unlink($tmp_filename);
            }
        }
        if (PHP_SAPI == 'cli') {
            // If delivery cache is used during maintenance with php-cli,
            // most likely the user running it is not the webserver user.
            // Chmod 777 to prevent issues when the webserver tries to
            // access the file
            @chmod($filename, 0777);
        }
        return true;
    }
    return false;
}

?>
