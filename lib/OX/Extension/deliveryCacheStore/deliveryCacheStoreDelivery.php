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
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryCacheStore
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org> 
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
?>
