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
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStore
 */

/**
 * Function to fetch a cache entry
 *
 * @param string $filename The name of file where cache entry is stored
 * @return mixed False on error, or array the cache content
 */
function Plugin_deliveryCacheStore_Delivery_cacheRetrieve($filename)
{
    // Return false as there is no delivery cache store plugin
    return false;
}

/**
 * A function to store content a cache entry.
 *
 * @param string $filename The filename where cache entry is stored
 * @param array $cache_contents  The cache content
 * @return bool True if the entry was succesfully stored
 */
function Plugin_deliveryCacheStore_Delivery_cacheStore($filename, $cache_contents)
{
    // Return false as there is no delivery cache store plugin
    return false;
}
